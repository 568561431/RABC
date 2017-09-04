<?php
namespace Admin\Model;
use Think\Model;

class ManagerModel extends Model
{
    protected $pk = 'manager_id';
    //字段缓存
    protected $fields = array(
        'manager_id','manager_name','manager_passwd','manager_status',
        'manager_salt','manager_ctime','manager_login',
    );
    //字段映射
    protected $_map = array(
        'name' => 'manager_name',
        'password' => 'manager_passwd',
        'status' => 'manager_status',
    );
    //自动验证
    protected $_validate = array(
        array('manager_name','require','用户名不能为空',1,'regex',3),
        array('manager_name','','帐号名称已经存在！',0,'unique',1),
        array('manager_passwd','password','密码必须是字母下滑线数字组成的6-12位',1,'regex',3),
        array('repwd','manager_passwd','两次的密码输入不一致',1,'confirm',3),
        array('manager_status',array('启用','禁用'),'请输入正确的范围',1,'in',3),
    );
    //自动完成
    protected $_auto = array(
        array('manager_salt','makeSalt',1,'function'),
        array('manager_login','time',3,'function'),
        array('manager_ctime','time',1,'function'),
    );
    public function checkLogin($username,$pwd){
        $result = $this->where("manager_name='$username'")->find();
        $pwd = salt($pwd,$result['manager_salt']);
        if(empty($result)){
            return false;
        }
        if($result['manager_status']!='启用'){
            return false;
        }
        if($pwd==$result['manager_passwd']){
            $arr = array(
            'manager_id' => $result['manager_id'],
            'manager_login' => time()
            );
            $this->save($arr);
            session('id',$result['manager_id']);
            session('username',$username);
            session('roleid',$result['manager_roleid']);
            return true;
        }else{
            return false;
        }
    }
}