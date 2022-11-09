<?php

namespace app\admin\model;

use think\Model;

class Meettingprocess extends Model
{

    protected $pk = 'id';
    protected $autoWriteTimestamp = 'addtime'; //时间字段类型

    public function getProcess($num = 10, $ids = '')
    {


        $where = "1=1";
        $param = [];
        if ($ids != "") {
            $where .= " and mid in (" . $ids . ")";
            $param['mid'] = explode(',', $ids);
        }
        $Process = $this->where($where)
            ->order('id', 'DESC')
            ->paginate($num, false, ['query' => $param]);

        $li_Process = $this->order('id', 'DESC')->select();

        $page = $Process->render();// 获取分页显示

        // $t =  db('Meetting')->getLastsql();
        // var_dump($t);
        if ($Process) {
            return ['code' => 1, 'data' => $Process, 'msg' => '数据查询成功', 'page' => $page, 'li_Process' => $li_Process];
        } else {
            return ['code' => 2, 'data' => '', 'msg' => '暂无数据', 'page' => '', 'li_Process' => $li_Process];
        }

    }

}
