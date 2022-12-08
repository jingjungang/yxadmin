<?php
//  各模块菜单栏以及权限配置
// +----------------------------------------------------------------------
// | Author: liu
// +----------------------------------------------------------------------
$menu = array(

    "admin" => array(
        array(
            'name' => '会议管理',
            'controller' => 'admin/Order',
            'icon' => 'fa-commenting-o',
            'child' => array(

                array(
                    'name' => '学术会议',

                    'action' => 'admin/Meettingxs/meettingList',

                    "auth" => array(
                        array("name" => '添加', 'action' => "admin/Meettingxs/addMeetting"),
                        array("name" => '删除', 'action' => "admin/Meettingxs/delMeetting"),
                        array("name" => '修改', 'action' => "admin/Meettingxs/updateMeetting"),
                    )
                ),
                array(
                    'name' => '销售会议',

                    'action' => 'admin/Meettingsale/meettingList',

                    "auth" => array(
                        array("name" => '添加', 'action' => "admin/Meettingsale/addMeetting"),
                        array("name" => '删除', 'action' => "admin/Meettingsale/delMeetting"),
                        array("name" => '修改', 'action' => "admin/Meettingsale/updateMeetting"),
                    )
                )
            )

        ),

        array(
            'name' => '客户管理',
            'controller' => 'admin/Order',
            'icon' => 'fa-user',
            'child' => array(

                array(
                    'name' => '客户名单',

                    'action' => 'admin/Customer/CustomerList',

                    "auth" => array(
                        array("name" => '添加', 'action' => "admin/Customer/addCustomer"),
                        array("name" => '删除', 'action' => "admin/Customer/delCustomer"),
                        array("name" => '修改', 'action' => "admin/Customer/updateCustomer"),
                    )
                ),
                array(
                    'name' => '医院名单',

                    'action' => 'admin/Hospital/HospitalList',

                    "auth" => array(
                        array("name" => '添加', 'action' => "admin/Hospital/addCustomer"),
                        array("name" => '删除', 'action' => "admin/Hospital/delCustomer"),
                        array("name" => '修改', 'action' => "admin/Hospital/updateCustomer"),
                    )
                ),
                array(
                    'name' => '客情维护',

                    'action' => 'admin/Customerrelation/CustomerrelationList',

                    "auth" => array(
                        array("name" => '添加', 'action' => "admin/Customerrelation/addCustomerrelation"),
                        array("name" => '删除', 'action' => "admin/Customerrelation/delCustomerrelation"),
                        array("name" => '修改', 'action' => "admin/Customerrelation/updateCustomerrelation"),
                    )
                )

            )

        ),

        array(
            'name' => '积分管理',
            'controller' => 'admin/rules',
            'icon' => 'fa-edit',
            'child' => array(

                array(
                    'name' => '积分规则',

                    'action' => 'admin/rules/RulesList',

                    "auth" => array(
                        array("name" => '添加', 'action' => "admin/rules/addRules"),
                        array("name" => '删除', 'action' => "admin/rules/delRules"),
                        array("name" => '修改', 'action' => "admin/rules/updateRules"),
                    )
                ),
                array(
                    'name' => '积分记录',
                    'action' => 'admin/rulesrecord/RulesrecordList'
                ),
                array(
                    'name' => '积分统计',
                    'action' => 'admin/rulestotal/rulestotalList'
                )

            )

        ),
        array(
            'name' => '用户管理',
            'controller' => 'admin/User',
            'icon' => 'fa-user',
            'child' => array(

                array(
                    'name' => '用户列表',

                    'action' => 'admin/User/userList',

                    "auth" => array(
                        array("name" => '添加', 'action' => "admin/User/addUser"),
                        array("name" => '删除', 'action' => "admin/User/delUser"),
                        array("name" => '修改', 'action' => "admin/User/updateUser"),
                    )
                ),

                array(
                    'name' => '角色管理',

                    'action' => 'admin/Role/roleList',

                    "auth" => array(
                        array("name" => '添加', 'action' => "admin/Role/addRoleAuth"),
                        array("name" => '删除', 'action' => "admin/Role/delRole"),
                        array("name" => '修改', 'action' => "admin/Role/updateRoleAuth"),
                    )
                ),

            )

        ),


        array(
            'name' => '系统设置',
            'controller' => 'admin/System',
            'icon' => 'fa-gear',
            'child' => array(
                array(
                    'name' => '首页菜单',

                    'action' => 'admin/System/navMenu',

                    "auth" => array(
                        array("name" => '添加', 'action' => "admin/System/addMenu"),
                        array("name" => '删除', 'action' => "admin/System/delMenu"),
                        array("name" => '编辑', 'action' => "admin/System/editMenu"),
                    )
                ),

                array(
                    'name' => '系统日志',

                    'action' => 'admin/System/systemLog',

                    "auth" => array(
                        array("name" => '添加', 'action' => "admin/System/addLog"),
                        array("name" => '删除', 'action' => "admin/System/delLog")
                    )
                )
            )

        ),
    )

);