<?php

namespace app\admin\controller;
header("Content-Type: text/html;charset=utf-8");


class Rulesrecord extends AdminBase
{

    public function RulesrecordList()
    {

        $data = model('Rulesrecord')->getRulesrecord(10);
        $this->assign("data", $data['data']);
        $this->assign("page", $data['page']);

        return $this->fetch('rulesrecord_list');
    }
}