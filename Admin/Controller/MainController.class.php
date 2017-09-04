<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017/7/2
 * Time: 21:26
 */
namespace Admin\Controller;
class MainController extends CommonController
{
    public function index()
    {
        $this->display();
    }
    public function top()
    {
        $this->display();
    }
    public function left()
    {
        $roleid = session('roleid');
        $role_model = D('Role');
        $auth_model = D('Auth');
        if($roleid == 1){
            $authA = $auth_model
                ->where('auth_pid=0 and auth_show=1')
                ->select();
            $authB = $auth_model
                ->where('auth_pid!=0 and auth_show=1')
                ->select();
        }else{
            $role_info = $role_model->find($roleid);
            $role_auth_ids = $role_info['role_auth_ids'];
            $authA = $auth_model
                ->where("auth_id in($role_auth_ids) and auth_pid=0 and auth_show=1")
                ->select();
            $authB = $auth_model
                ->where("auth_id in($role_auth_ids) and auth_pid!=0 and auth_show=1")
                ->select();
        }
        $this->assign('authB',$authB);
        $this->assign('authA',$authA);
        $this->display();
    }
    public function main()
    {
        $manager_id = session('id');
        $manager_info = D('Manager')->find($manager_id);
        $this->assign('manager_info',$manager_info);
        $this->display();
    }
    public function _empty()
    {
        $this->display();
    }
}