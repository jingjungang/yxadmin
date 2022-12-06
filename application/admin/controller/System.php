<?php

namespace app\admin\controller;

use think\Exception;
use think\Db;
use think\exception\PDOException;
use app\common\util\PasswordHash;

class System extends AdminBase
{

    public function systemSetup()
    {
        return $this->fetch();
    }


    /**
     * 系统日志
     * @param $flag 1当月 2所有
     * @return mixed
     */
    public function systemLog()
    {
        $flag = 1; //1表示只读1个月的
        $data = $_POST;
        $currentdate = Date('Y-m', time()); //当前年月
        if ($data) {
            $currentdate = $data['mdate']; //指定年月
        }
        $tables = $this->getTables();
        foreach ($tables as $li) {
            $arr[] = $li['table_name'];
        }
        $dir = ROOT_PATH . 'runtime\log\\';
        if ($flag == 1) { //读取1个月的日志
            $mdate = str_replace('-', '', $currentdate);
            $filepath = $dir . $mdate;
            $li = $this->readLog($filepath, $arr);
        } else { //读取所有日志
            $data = $this->getDirFileName();
            $li = [];
            foreach ($data as $item) {
                if ($item != '.' && $item != '..') {
                    $filepath = $dir . $item;
                    if (count($li) > 0) {
                        $temp = $this->readLog($filepath, $arr);
                        if ($temp) {
                            $li = array_merge($li, $temp);
                        }
                    } else {
                        $li = $this->readLog($filepath, $arr);
                    }
                }
            }
        }
//        $li->paginate();
//        $page = $li->render();// 获取分页显示
        $this->assign('data', $li);
        $this->assign('currentdate', $currentdate);

        return $this->fetch();
    }

    /**
     * 读取日志文件
     * @param $fileN 文件路径
     * @param $tables 表名list
     * @return array
     */
    public function readLog($fileN, $tables)
    {
        for ($i = 1; $i < 32; $i++) {
            if ($i < 10) {
                $filename = $fileN . '\0' . $i . '.log';
            } else {
                $filename = $fileN . '\\' . $i . '.log';
            }
            try {
                if (file_exists($filename)) {
                    $handle = fopen($filename, "r");
                } else {
                    continue;
                }
            } catch (Exception $e) {
                continue;
            }
            $temp = '';
            $path = '';
            $flag = 1;
            $index = 0;
            while (!feof($handle)) {
                $buffer = fgets($handle, 4096);
                $data = trim($buffer);
                if ($data != '---------------------------------------------------------------') {
                    if ($flag == 1) {
                        $temp = substr($data, 1, strrpos($data, "+") - 1);
                        $temp = str_replace('T', ' ', $temp);
                        $path = substr($data, strrpos($data, "admin") - 1);
                        $flag = 2;
                    }
                    foreach ($tables as $table) {
                        if (strpos($data, $table)) {
                            $str = str_replace('[ sql ] [ SQL ]', '', $data);
                            $str = substr($str, 0, strrpos($str, "["));
                            if (strpos($data, 'SELECT')) {
                                $arr[$index]['name'] = '查询';
                                $arr[$index]['time'] = $temp;
                                $arr[$index]['path'] = $path;
                            } else if (strpos($data, 'UPDATE')) {
                                $arr[$index]['name'] = '更新';
                                $arr[$index]['time'] = $temp;
                                $arr[$index]['path'] = $path;
                            } else if (strpos($data, 'DELETE')) {
                                $arr[$index]['name'] = '删除';
                                $arr[$index]['time'] = $temp;
                                $arr[$index]['path'] = $path;
                            } else if (strpos($data, 'INSERT')) {
                                $arr[$index]['name'] = '新增';
                                $arr[$index]['time'] = $temp;
                                $arr[$index]['path'] = $path;
                            } else if (strpos($data, 'SHOW')) {
                                $arr[$index]['name'] = '展示';
                                $arr[$index]['time'] = $temp;
                                $arr[$index]['path'] = $path;
                            } else {
                                $arr[$index]['name'] = '其他';
                            }
                            $arr[$index]['sql'] = $str;
                            $arr[$index]['table'] = $table;
                            $index = $index + 1;
                        }
                    }
                } else {
                    $flag = 1;
                }
            }
        }
        try {
            fclose($handle);
        }catch(Exception $e){
            
        }
        return $arr;
    }

    /**
     * 获取数据库所有表名称
     * @return array|mixed
     */
    public function getTables()
    {
        //创建SQL语句字符串
        $sql = "SELECT table_name FROM information_schema.TABLES WHERE table_schema = ( SELECT DATABASE () )";

        //执行插入操作
        $affected = Db::query($sql);

        //判断是否执行成功
        if ($affected) {
            return $affected;
        } else {
            return array();
        }

    }

    /**
     * 返回文件名数组列表
     * @return array
     */
    public function getDirFileName()
    {
        $dir = ROOT_PATH . 'runtime/log';
        $data = scandir($dir);
        return $data;
    }

    /**
     * 修改密码
     * @return \think\response\Json
     */
    public function fixPassword()
    {
        $data = $_POST;
        $result['code'] = 1;
        $result['msg'] = '修改完成';
        $user_id = session('user_id');
        $userInfos = db('user')->where("user_id ='" . $user_id . "'")->field('user_pass,user_id')->find();

        $hasher = new PasswordHash(8, true);
        $chekcPass = $hasher->CheckPassword($data['old_pass'], $userInfos['user_pass']);
        if (!$chekcPass) {
            $result = ['code' => 2, 'msg' => '原密码不正确'];
        }

        $now_pass = $data['now_pass'];
        $now_pass = $hasher->HashPassword($now_pass);
        try {
            $res = db('user')->where("user_id ='" . $user_id . "'")->update(['user_pass' => $now_pass]);
        } catch (PDOException $e) {
            $result['code'] = 0;
            $result['msg'] = $e->getMessage();
        } catch (Exception $e) {
            $result['code'] = 0;
            $result['msg'] = $e->getMessage();
        }
        if (!$res) {
            $result['code'] = 0;
            $result['msg'] = '修改失败';
        }
        return json($result);
    }


    public function fontIcon()
    {


        return $this->fetch();
    }

    public function glyphIcon()
    {


        return $this->fetch();
    }

    public function navMenu()
    {

        $menus = model('IndexMenu')->getAllmenus();

        $this->assign("menus", $menus);
        return $this->fetch();
    }

    public function addMenu()
    {
        $input = input();

        $info = model('IndexMenu')->addMenu($input);

        return $info;
    }

    public function delMenu()
    {
        $menuId = input('param.menuId');

        $info = model('IndexMenu')->delMenu($menuId);

        return $info;

    }

    public function editMenu()
    {

        $input = input();

        $info = model('IndexMenu')->editMenu($input);

        return $info;
    }

    public function getMenu()
    {

        $menuId = input('param.menu_id');

        $info = model('IndexMenu')->getMenu($menuId);

        return $info;
    }

    public function getTopMenus()
    {

        $menus = model('IndexMenu')->getTopMenus();

        return $menus;
    }


    /**
    * 修改头像
    */
    public function fixpic(){
        $mod = db('user');
        $mod->startTrans(); // 开启事务
        try{
            $data = $this->uploadToDB('File','avatar','image');
            $param['image'] = $data['image'];
            $result = $mod->where('user_id',session('user_id'))->update($param);
            if($result){
                $infos['code'] = 1;
                $infos['msg'] = '保存成功';
            }else{
                $infos['code'] = 0;
                $infos['msg'] = '保存失败';
            }
        }catch(Exception $e){
            $this->transaction->rollback(); // 事务回滚
            $infos['code'] = 0;
            $infos['msg'] = $e->getMessage();
        }
        $mod->commit(); // 关闭事务
        return $infos;
    }
}
