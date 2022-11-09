<?php

namespace app\admin\model;

use think\Model;

class Meettinghospital extends Model
{

    protected $pk = 'id';
    protected $autoWriteTimestamp = 'add_time'; //时间字段类型

    public function getHospital($num = 10, $ids = '')
    {

        $param = [];
        $where = '';
        if ($ids != "") {
            $where = 'meettingid = ('.$ids.')';
            $param['meettingid'] = $ids;
        }
        $hospital = $this->alias('a')
            ->where($where)
            ->field('h.code,h.name,h.quality,h.level,h.province,h.city,h.area,h.address,h.development,h.divided,h.hostname,a.id')
            ->join('hospital h', 'h.id = a.hospitalid', 'LEFT')
            ->order('id', 'DESC')
            ->paginate($num, false, ['query' => $param]);

        $li_hospital = $this->order('id', 'DESC')->select();

        $page = $hospital->render();// 获取分页显示

        // $t =  db('Meetting')->getLastsql();
        // var_dump($t);
        if ($hospital) {
            return ['code' => 1, 'data' => $hospital, 'msg' => '数据查询成功', 'page' => $page, 'li_hospital' => $li_hospital];
        } else {
            return ['code' => 2, 'data' => '', 'msg' => '暂无数据', 'page' => '', 'li_hospital' => $li_hospital];
        }

    }

    public function getHospitalByName($hname)
    {
        if ($hname) {
            $param["name"] = $hname;
            $hospital = $this->where($param)->find();
            if ($hospital) {
                $hospital = $hospital->toArray();
                return $hospital;
            }
        }
        return '';
    }

}
