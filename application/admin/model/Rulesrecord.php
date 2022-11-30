<?php

namespace app\admin\model;

use think\exception\DbException;
use think\Model;

class Rulesrecord extends Model
{

    protected $pk = 'id';
    protected $autoWriteTimestamp = 'datetime'; //时间字段类型
    protected $createTime = 'addtime';    // 指定自动写入的时间戳字段名

    public function getRulesrecord($num = 10)
    {
        $Rules = Rulesrecord::alias('a')->field('a.*,u.user_nicename as uname')
            ->join('user u','a.employeeid=u.user_id','left')
            ->order('a.id', 'DESC')
            ->paginate($num, false);
        $page = $Rules->render();// 获取分页显示
        if ($Rules) {
            return ['code' => 1, 'data' => $Rules, 'msg' => '数据查询成功', 'page' => $page];
        } else {
            return ['code' => 2, 'data' => '', 'msg' => '暂无数据', 'page' => ''];
        }

    }

}
