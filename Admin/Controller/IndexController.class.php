<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function login(){
        if(IS_POST){
            $username = I('post.username');
            $pwd = I('post.password');
            $code = I('post.code');
            $verify = new \Think\Verify();
            if(!$verify->check($code)){
                $this->error('输入的验证码有误',U('login'),3);
            }
            $manager_model = D('Manager');
            if($manager_model->checkLogin($username,$pwd)){
                $this->success('登录成功',U('Main/index'),3);
            }else{
                $this->error('登录失败',U('login'),3);
            }
        }else{
            $this->display();
        }
    }
    public function verify(){
        $config = array(
            'useCurve'  =>  false,            // 是否画混淆曲线
            'useNoise'  =>  false,            // 是否添加杂点
            'fontSize'  =>  15,              // 验证码字体大小(px)
            'fontttf'   =>  '4.ttf',          // 验证码字体，不设置随机获取
        );
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }
    public function _empty()
    {
        echo '没有这个方法';
    }
}