<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017/7/11
 * Time: 20:48
 */

namespace Admin\Controller;



class AuthController extends CommonController
{
    public function authList(){
        $auth_model = D('Auth');
        $auth_list = $auth_model->select();
        $auth_list = getAuthTree($auth_list);
        $this->assign('auth_list',$auth_list);
        $this->display();
    }
    function addAuth(){
        $auth_model = D('Auth');
        if(IS_POST){
            $form_data = $auth_model->create();
            if($auth_model->add($form_data)){
                $this->success('添加权限成功',U('authList'),3);
            }else{
                $this->error('添加权限失败');
            }
        }else{
            $auth_list = $auth_model->where('auth_pid=0')->select();
            $this->assign('auth_list',$auth_list);
            $this->display();
        }
    }
}