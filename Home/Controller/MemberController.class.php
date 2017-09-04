<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017/7/14
 * Time: 15:19
 */

namespace Home\Controller;


use Think\Controller;

class MemberController extends Controller
{
    function register(){
        $this->display();
    }
    function login(){
        //echo 1;die;
        if(IS_POST){

            $verify = new \Think\Verify();
            $member_model = D('Member');
            $username = I('post.username');
            $pwd = I('post.password');
            $checkcode = I('post.checkcode');
            $result = $member_model->where("mem_name='$username'")->find();
            if(!$verify->check($checkcode)){
                $this->error('验证码有误');
            }else if(empty($result)){
                $this->error('账号不对,请重新输入');
            }else if($result['mem_passwd']!=$pwd){
                $this->error("密码不对,请重新输入");
            }else{
                $tc = I('get.tc','Index');
                $ta = I('get.ta','index');
                session('memid',$result['mem_id']);

                session('memname',$result['mem_name']);

                $str = cookie('cart');
                $cart_list = unserialize($str);
                $result = array();
                foreach($cart_list as $key=>$value){
                    unset($value['cart_id']);
                    rtrim($value['cart_attr']);
                    $value['cart_memid'] = session('memid');
                    $result[$key] = $value;
                }
                $cart_model = D('Cart');
                $cart_model->addAll($result);

                $this->success('登录成功',U($tc.'/'.$ta),3);
            }
        }else{
            $this->display();
        }
    }
    function verify(){
        $config = array(
            'fontSize'  =>  15,              // 验证码字体大小(px)
            'useCurve'  =>  false,            // 是否画混淆曲线
            'useNoise'  =>  false,            // 是否添加杂点
            'fontttf'   =>  '4.ttf',              // 验证码字体，不设置随机获取
        );
        $verify = new \Think\Verify($config);
        $verify->entry();
    }
}