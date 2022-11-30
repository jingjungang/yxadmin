<?php

namespace app\admin\model;

use think\Model;

class Customerrelation extends Model
{

    protected $pk = 'id';

    public function getCustomerrelation($num = 10)
    {
        $keywords = input('param.keywords', '');
        $status = input('param.status');

        $where = '1=1 ';
        $param = [];
        $param['a.flag'] = 0;
        if ($status == 0) {
            if ($keywords != '') {
                $param['a.dates'] = $keywords;
                $where .= " and a.dates like" . "'%" . $keywords . "%' and a.flag=0";
            }else{
                $where .= ' and a.flag=0';
            }

        } else {
            $param['a.status'] = $status;
            if ($keywords) {
                $param['a.dates'] = $keywords;
                $where .= " and a.dates like" . "'%" . $keywords . "%'" . " and a.status =" . $status .' and a.flag=0';
            } else {
                $where .= " and a.status =" . $status.' and a.flag=0';
            }
        }


        $Customerrelation = Customerrelation::alias('a')
            ->field('a.*,c.name as customer,c.id as cid,h.name as hospital,h.id as hid,e.user_nicename as employee,e.user_id as eid')
            ->join('customer c', 'c.id = a.cid', 'left')
            ->join('hospital h', 'h.id = a.hid', 'left')
            ->join('user e', 'e.user_id = a.employeeid', 'left')
            ->where($where)
            ->order('a.id', 'DESC')
            ->paginate($num, false, ['query' => $param]);

        $page = $Customerrelation->render();// 获取分页显示


        if ($Customerrelation) {

            return ['code' => 1, 'data' => $Customerrelation, 'msg' => '数据查询成功', 'page' => $page];

        } else {

            return ['code' => 2, 'data' => '', 'msg' => '暂无数据', 'page' => ''];
        }

    }

}
