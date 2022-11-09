<?php

namespace app\admin\model;

use think\Model;
use app\admin\controller\Upload;

class Meettingsale extends Model
{

    protected $pk = 'id';
    protected $autoWriteTimestamp = 'add_time'; //时间字段类型

    public function getMeettings($num = 10, $pam)
    {

        $keywords = input('param.keywords', '');
        

        $where = "1=1";
        $param = [];
        
        if ($keywords) {
            $param['keywords'] = $keywords;
            $where .= " and name like" . "'%" . $keywords . "%'" . " and status <> 3";
        } else {
            $where .= " and status <> 3";
        }

        $meettings = Meettingsale::alias('a')->field('u.user_nicename,a.*')
            ->where($where)
            ->join('user u', 'u.user_id = a.uid', 'LEFT')
            ->order('id', 'DESC')
            ->paginate($num, false, ['query' => $param]);
        

        $page = $meettings->render();// 获取分页显示


        if ($meettings) {

            return ['code' => 1, 'data' => $meettings, 'msg' => '数据查询成功', 'page' => $page];

        } else {

            return ['code' => 2, 'data' => '', 'msg' => '暂无数据', 'page' => ''];
        }

    }

    public function saveMeetting($param)
    {

        $result = $this->allowField(true)->save($param);
        return $result;
    }

    public function delMeetting($meetting_id)
    {

        $del = $this->where('id=' . $meetting_id)->setField('status', 3); //删除状态改为3

        if ($del) {

            return json(['code' => 1, 'msg' => '删除完成']);

        } else {
            $t = $this->getLastsql();
            return json(['code' => 0, 'msg' => '删除错误']);
        }
    }

    public function updateMeetting($input)
    {

        $save = $this->allowField(true)->save($input, $input['id']);

        if ($save) {
            return ['code' => 1, 'msg' => '保存成功'];
        } else {
            return ['code' => 2, 'msg' => '保存失败'];
        }

    }


    public function getMeetting($Id)
    {
        if($Id){
            $Meetting = $this->where("id=" . $Id)->find();
            if ($Meetting) {
                $Meetting = $Meetting->toArray();
                return $Meetting;
            } else {
                return '';
            }
        }else{
            return '';
        }

    }

}
