<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017/7/11
 * Time: 23:33
 */

namespace Admin\Controller;


use Think\Controller;

class CommonController extends Controller
{
    function _initialize(){
        if(!session("?id")){
            $this->error('请先登录',U('Index/login'),3);
        }
        if(session('roleid') != 1){
            $now_path = CONTROLLER_NAME.'-'.ACTION_NAME;
            $roleid = session('roleid');
            $role_model = D('Role');
            $role_info = $role_model->field('role_auth_path')->find($roleid);
            $role_auth_path = $role_info['role_auth_path'];
            $role_auth_path = 'Main-left,Main-top,Main-main,Main-index,'.$role_auth_path;
            $role_auth_path = explode(',',$role_auth_path);
            if(!in_array($now_path,$role_auth_path)){
                $this->error('你无权访问该模块',U('Index/login'),3);
            }
        }
    }
}
