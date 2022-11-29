<?php

namespace app\admin\model;

use think\Model;

class Rules extends Model
{

    protected $pk = 'id';
    protected $autoWriteTimestamp = 'datetime'; //时间字段类型
    protected $createTime = 'addtime';    // 指定自动写入的时间戳字段名

    public function getRules($num = 10)
    {
        $Rules = Rules::alias('a')->field('a.*')
            ->order('id', 'DESC')
            ->paginate($num, false);
        $page = $Rules->render();// 获取分页显示
        if ($Rules) {
            return ['code' => 1, 'data' => $Rules, 'msg' => '数据查询成功', 'page' => $page];
        } else {
            return ['code' => 2, 'data' => '', 'msg' => '暂无数据', 'page' => ''];
        }

    }

    public function addRules($input)
    {
        if (request()->isPost()) {
            if ($input['handle_type'] == 'add') {

                // 过滤post数组中的非数据表字段数据
                $save = $this->allowField(true)->save($input);
                if ($save) {
                    return json(['code' => 1, 'msg' => '保存成功']);
                } else {
                    return json(['code' => 2, 'msg' => '保存失败']);
                }
            } else {
                return json(['code' => 4, 'msg' => '非法数据']);
            }
        } else {
            return json(['code' => 5, 'msg' => '非法请求']);
        }
    }


    public function delRules($RulesId)
    {
        $del = $this->where('id=' . $RulesId)->setField('status', 2); //删除状态改为1
        if ($del) {
            return json(['code' => 1, 'msg' => '禁用成功']);
        } else {
            return json(['code' => 0, 'msg' => '禁用失败']);
        }
    }

    public function updateRules($input)
    {
        if (request()->isPost()) {
            if ($input['handle_type'] == 'update') {
                $save = $this->allowField(true)->save($input, array('id'=>$input['Rules_id']));
                if ($save) {
                    return json(['code' => 1, 'msg' => '保存成功']);
                } else {
                    return json(['code' => 2, 'msg' => '保存失败']);
                }
            } else {
                return json(['code' => 4, 'msg' => '非法数据']);
            }
        } else {
            return json(['code' => 5, 'msg' => '非法请求']);
        }
    }

}
