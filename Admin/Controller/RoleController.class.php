<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017/7/11
 * Time: 21:18
 */

namespace Admin\Controller;



class RoleController extends CommonController
{
    function roleList(){
        $role_model = D('Role');
        $role_list = $role_model->select();
        $this->assign('role_list',$role_list);
        $this->display();
    }
    function distribute(){
        $role_model = D('Role');
        $auth_model = D('Auth');
        if(IS_POST){
            $ids = I("post.auth_id");
            $roleid = I('post.roleid');
            $ids = implode(',',$ids);
            $auth_list = $auth_model->where("auth_id in($ids)")->select();
            $role_auth_path = '';
            foreach ($auth_list as $value) {
                if ($value['auth_c'] != '') {
                    $role_auth_path .= $value['auth_c'] . '-' . $value['auth_a'] . ',';
                }
            }
            $role_auth_path = rtrim($role_auth_path,',');
            $arr = array(
                'role_auth_ids' => $ids,
                'role_id' => $roleid,
                'role_auth_path' =>$role_auth_path,
            );
            if($role_model->save($arr)){
                $this->success('分配权限成功',U('roleList'),3);
            }else{
                $this->error('分配权限失败');
            }
        }else{
            $roleid = I('get.role_id');
            $role_info = $role_model->find($roleid);
            $this->assign('role_info',$role_info);
            $authA = $auth_model->where('auth_pid=0')->select();
            $authB = $auth_model->where('auth_pid!=0')->select();
            $this->assign( array(
                    'authA' => $authA,
                    'authB' => $authB,
                )
            );
            $this->display();
        }
    }
}