<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017/7/14
 * Time: 14:34
 */

namespace Home\Controller;


use Think\Controller;

class CommonController extends Controller
{
    protected function _initialize(){
            //获取当前访问控制器方法字符串
            $ac = CONTROLLER_NAME.'-'.ACTION_NAME;
            $this->assign('ac',$ac);
            $cate_model = D('Cate');
            $cate_list = $cate_model->select();
            $cate_list = getTree($cate_list);
            //根据level=0,1,2将数组拆成3个数组
            $cateA = array();
            $cateB = array();
            $cateC = array();
            foreach($cate_list as $value){
                if($value['level'] == 0){
                    $cateA[] = $value;
                }elseif ($value['level'] == 1){
                    $cateB[] = $value;
                }elseif ($value['level'] == 2){
                    $cateC[] = $value;
                }
            }
        $this->assign('cateA',$cateA);
        $this->assign('cateB',$cateB);
        $this->assign('cateC',$cateC);
        if(session('?memid')){
            $cart_list =
                D("Cart")
                    ->alias('c')
                    ->field('g.goods_name')
                    ->join('sp_goods g on c.cart_goodsid=g.goods_id')
                    ->where('cart_memid='.session('memid'))
                    ->select();
        }else{
            $str = cookie('cart');
            $cart = unserialize($str);
            foreach ($cart as $value){
                foreach($value as $k=>$v){
                    if($k == 'cart_goodsid'){
                        $cart_list = D('Goods')->field('goods_name')->where('goods_id='.$v)->select();
                    }
                }
            }
        }
    }
}