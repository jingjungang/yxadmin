<?php

namespace app\admin\controller;
header("Content-Type: text/html;charset=utf-8");

use PHPExcel_IOFactory;
use think\Exception;
use think\Cache;

class Hospital extends AdminBase
{
    public $transaction;

    public function __construct()
    {
        parent::__construct();
        $this->transaction = db('Hospital');
    }

    public function HospitalList()
    {
        $param['status'] = 1;
        if (request()->isPost()) {
            $this->assign("keywords", input('param.keywords', ''));
            $this->assign("status", input('param.status', $param['status']));
        }

        $data = model('Hospital')->getHospital(10);
        $this->assign("data", $data['data']);
        $this->assign("page", $data['page']);

        return $this->fetch();
    }

    // 新增
    public function addHospital()
    {
        if (request()->isPost()) {
            $data = $_POST;
            try {

                $this->transaction->startTrans(); // 开启事务
                $result = $this->transaction->insert($data);
                if ($result) {
                    $infos['code'] = 1;
                    $infos['msg'] = '添加成功';
                } else {
                    $infos['code'] = 0;
                    $infos['msg'] = '添加失败';
                }
            } catch (Exception $e) {
                $this->transaction->rollback(); // 事务回滚
                $infos['code'] = 0;
                $infos['msg'] = $e->getMessage();
            }
            $this->transaction->commit(); // 关闭事务
            return $infos;
        } else {
            $li = db('hospital')->field('id,name,code')->select();
            $this->assign("hospital", $li);
            return $this->fetch();
        }
    }

    // 删除
    public function delHospital()
    {
        $id = $_POST['id'];
        $this->transaction->startTrans(); // 开启事务
        $infos['code'] = 1;
        try {
            $data['status'] = 2;
            $result = $this->transaction->where('id', $id)->update($data);
            if ($result) {
                $infos['code'] = 1;
                $infos['msg'] = '操作成功';
            } else {
                $infos['code'] = 0;
                $infos['msg'] = '操作失败';
            }
        } catch (Exception $e) {
            $this->transaction->rollback(); // 事务回滚
            $infos['code'] = 0;
            $infos['msg'] = $e->getMessage();
        }

        return $infos;

    }


    //编辑
    public function editHospital()
    {
        if (!request()->isPost()) {
            $id = input("param.id", '');
            $result = $this->transaction->where('id', $id)->find();
            $this->assign('li', $result);

            $li = db('hospital')->where('id <> ' . $id)->field('id,name,code')->select();
            $this->assign("hospital", $li);

            return $this->fetch();
        } else {
            $data = $_POST;
            try {
                $result = $this->transaction->where('id', $data['id'])->update($data);
                if ($result) {
                    $infos['code'] = 1;
                    $infos['msg'] = '操作成功';
                } else {
                    $infos['code'] = 0;
                    $infos['msg'] = '操作失败';
                }
            } catch (Exception $e) {
                $this->transaction->rollback(); // 事务回滚
                $infos['code'] = 0;
                $infos['msg'] = $e->getMessage();
            }
            return $infos;
        }
    }

    //关联会议
    public function innerMeettings()
    {

        $meettingid = input("param.id");
        $params['a.name'] = $meettingid;
        $result = db('meettingHospital')->alias('a')
            ->join('meetting m', 'm.id = a.meettingid', 'left')
            ->where($params)
            ->field('m.*')
            ->order('m.id', 'DESC')
            ->paginate(10, false, ['query' => $params]);
        $t = db('meettingHospital')->getLastSql();
        if ($result) {
            $page = $result->render();// 获取分页显示
            $this->assign("li_meetting", $result);
            $this->assign("page", $page);
        }

        return $this->fetch();
    }

    //批量导入
    public function importExcel()
    {
        if (!request()->isPost()) {
            return $this->fetch();
        } else {
            $this->importExc(1);
        }

    }

    //批量更新 updateExcel
    public function updateExcel()
    {
        if (!request()->isPost()) {
            return $this->fetch();
        } else {
            $this->importExc(2);
        }

    }

    public function importExc($flag)
    {

        $param = input();
        $root = './upload/hospital/'; //存放Excel目录
        require('../vendor/PHPExcel/PHPExcel.php'); //工具包位置

        if (!empty($_FILES['excel']['name'])) {
            $fileName = $_FILES['excel']['name'];    //得到文件全名
            $dotArray = explode('.', $fileName);    //把文件名安.区分，拆分成数组
            $type = end($dotArray);
            if ($type != "xls" && $type != "xlsx") {
                $ret['res'] = "0";
                $ret['msg'] = "不是Excel文件，请重新上传!";
                $this->error('不是Excel文件，请重新上传!', '/admin/Hospital/importExcel', 1);
            }

            //取数组最后一个元素，得到文件类型
            $uploaddir = iconv("UTF-8", "GBK", $root . date('Ymd') . '/');
            if (!file_exists($uploaddir)) {
                mkdir($uploaddir, 0777, true);

            }

            $path = $uploaddir . md5(uniqid(rand())) . '.' . $type; //产生随机文件名
            //$path = "images/".$fileName; //客户端上传的文件名；
            //下面必须是tmp_name 因为是从临时文件夹中移动
            move_uploaded_file($_FILES['excel']['tmp_name'], $path); //从服务器临时文件拷贝到相应的文件夹下

            $file_path = $path;
            if (!file_exists($path)) {
                $ret['res'] = "0";
                $ret['msg'] = "上传文件丢失!" . $_FILES['excel']['error'];
                $this->error("上传文件丢失!" . $_FILES['excel']['error'], '/admin/Hospital/importExcel', 1);
            }

            //文件的扩展名
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if ($ext == 'xlsx') {
                $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                $objPHPExcel = $objReader->load($file_path, 'utf-8');
            } elseif ($ext == 'xls') {
                $objReader = PHPExcel_IOFactory::createReader('Excel5');
                $objPHPExcel = $objReader->load($file_path, 'utf-8');
            }

            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumn = $sheet->getHighestColumn(); // 取得总列数
            $ar = array();
            $i = 0;
            $importRows = 0;
            $li = [];

            for ($j = 2; $j <= $highestRow; $j++) {
                $importRows++;
                $data['code'] = (string)$objPHPExcel->getActiveSheet()->getCell("B$j")->getValue();
                $data['name'] = (string)$objPHPExcel->getActiveSheet()->getCell("C$j")->getValue();
                $data['othername'] = (string)$objPHPExcel->getActiveSheet()->getCell("D$j")->getValue();
                $data['quality'] = (string)$objPHPExcel->getActiveSheet()->getCell("E$j")->getValue();
                $data['level'] = (string)$objPHPExcel->getActiveSheet()->getCell("F$j")->getValue();
                $data['province'] = (string)$objPHPExcel->getActiveSheet()->getCell("G$j")->getValue();
                $data['city'] = (string)$objPHPExcel->getActiveSheet()->getCell("H$j")->getValue();
                $data['area'] = (string)$objPHPExcel->getActiveSheet()->getCell("I$j")->getValue();
                $data['address'] = (string)$objPHPExcel->getActiveSheet()->getCell("J$j")->getValue();
                $data['development'] = (string)$objPHPExcel->getActiveSheet()->getCell("K$j")->getValue();
                $data['divided'] = (string)$objPHPExcel->getActiveSheet()->getCell("L$j")->getValue();
                $data['hostname'] = (string)$objPHPExcel->getActiveSheet()->getCell("M$j")->getValue();
                $data['details'] = (string)$objPHPExcel->getActiveSheet()->getCell("N$j")->getValue();
                $data['add_time'] = date('Y-m-d H:i:s');
                if ($flag == 1) {
                    //插入
                    $ret['mdata'] = db('hospital')->insert($data);
                } else {
                    //更新
                    $code = $data['code']; //根据code去查询
                    $res = db('hospital')->where('code', $code)->find();
                    if ($res) {
                        $id = $res['id'];
                        $ret['mdata'] = db('hospital')->where('id', $id)->update($data);
                    } else {
                        $ret['mdata'] = db('hospital')->insert($data);
                    }
                }


                if ($ret['mdata'] && !is_Bool($ret['mdata'])) {
                    $ar[$i] = $ret['mdata'];
                    $i++;
                } else {
                    $li[] = $i;
                }
            }
            if ($i > 0) {
                print_r('导入完成，共导入' . $importRows . '行数据');
                if (count($li) > 0) {
                    print_r('错误行数：' . $li);
                } else {
                    $this->success("上传文件完成!", '/admin/Hospital/HospitalList', 1);
                }
            }

        } else {
            $ret['res'] = "0";
            $ret['msg'] = "上传文件失败!";
            $this->error("上传文件丢失!", '/admin/Hospital/importExcel', 1);
            //return json_encode($ret);
        }

    }

    // 医生
    public function doctorlist()
    {
        $hid = input("param.id");
        $modle = db('doctor');
        $field = "id,name,case sex when 1 then '男' else '女' end as sex,title,depart,phone";
        $result = $modle->where('hid', $hid)->field($field)->select();
        $t = $modle->getLastSql();
        if ($result) {
            $this->assign('data', $result);
        }
        return $this->fetch();
    }

}