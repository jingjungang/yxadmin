<?php

namespace app\admin\model;

use think\Model;
use app\admin\controller\Upload;

class Hospital extends Model
{

    protected $pk = 'id';

    public function getHospital($num = 10)
    {
        $keywords = input('param.keywords', '');
        $status = input('param.status');

        $where= '1=1 ';
        $param = [];
        if($status == 0){ 
            if($keywords !=''){
                $param['name'] = $keywords;
                $where .= " and name like" . "'%" . $keywords . "%'";
            }
            
        }else{
            $param['status'] = $status;
            if ($keywords) {
                $param['name'] = $keywords;
                $where .= " and name like" . "'%" . $keywords . "%'" . " and status =".$status;
            }else{
                $where .= " and status =".$status;
            }
        }


        $Hospital = Hospital::alias('a')->field('a.*')
            ->where($where)
            ->order('id', 'DESC')
            ->paginate($num, false, ['query' => $param]);

        $page = $Hospital->render();// 获取分页显示


        if ($Hospital) {

            return ['code' => 1, 'data' => $Hospital, 'msg' => '数据查询成功', 'page' => $page];

        } else {

            return ['code' => 2, 'data' => '', 'msg' => '暂无数据', 'page' => ''];
        }

    }

    public function deleteHospital($id)
    {

        $result = $this->where('id=' . $id)->setField('status', 3); //删除状态改为3

        if ($result) {

            return json(['code' => 1, 'msg' => '删除成功']);

        } else {

            return json(['code' => 0, 'msg' => '删除失败']);
        }
    }


    public function updateHospital($input)
    {

        $save = $this->allowField(true)->save($input, $input['id']);

        if ($save) {
            return ['code' => 1, 'msg' => '保存成功'];
        } else {
            return ['code' => 2, 'msg' => '保存失败'];
        }

    }


}
