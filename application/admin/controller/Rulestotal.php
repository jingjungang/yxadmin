<?php

namespace app\admin\controller;
header("Content-Type: text/html;charset=utf-8");


class Rulestotal extends AdminBase
{

    public function RulestotalList()
    {
        $data = $_POST;
        $where = [];
        if (!empty($data)){
            $uid = $data['uid'];
            $mdate = $data['mdate'];
            if($uid){
                $where['employeeid'] = $uid;
                $this->assign('user_id', $uid);
            }
            if($mdate){
                $where['mdate'] = $mdate;
                $this->assign('mdate', $mdate);
            }
        }
        $li_meetting = db('rulesrecord')
            ->alias('a')
            ->join('user u', 'u.user_id=a.employeeid', 'left')
            ->field('a.*,u.user_nicename as uname')
            ->where($where)
            ->paginate();
        if ($li_meetting) {
            $page = $li_meetting->render();// 获取分页显示
        }
        $li_user = db('user')->field('user_id,user_nicename')->select();
        $this->assign('li_user', $li_user);
        $this->assign('page', $page);
        $this->assign('data', $li_meetting);

        //yx_meettingrecordtype
        $result = db('meettingrecordtype')->select();
        $this->assign('li_totals', $result);
        $sum_meetting = 0;
        $sum_score = 0;
        if($result){
            foreach($result as $item){
                $sum_meetting = $sum_meetting+ $item['num'];
                $sum_score = $sum_score+ $item['scores'];
            }
        }
        $this->assign('sum_meetting', $sum_meetting);
        $this->assign('sum_score', $sum_score);

        return $this->fetch();
    }
}