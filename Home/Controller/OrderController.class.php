<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017/7/19
 * Time: 17:19
 */

namespace Home\Controller;


use Think\Controller;

class OrderController extends Controller
{
    function order(){

        if(!session('?memid')){
//            echo 1,session('memid');die;
            $ac = array(
                'tc' => CONTROLLER_NAME,
                'ta' => ACTION_NAME,
            );
            $this->error('请先登录',U('Member/login',$ac),3);
//            $this->display('Member/login');
        }else{
            $sql = "SELECT o.order_number,m.mem_name,o.order_price,
o.order_addtime,o.order_status FROM sp_order_goods og 
LEFT JOIN SP_order o ON  og.og_orderid=o.order_id LEFT JOIN
 sp_member m ON m.mem_id=o.order_memid WHERE m.mem_id =".session('memid');
            $og_goodslogo = D('OrderGoods')->field('og_goodslogo')->where('og_memid='.session('memid'))->find();
            $og_goodslogo = $og_goodslogo['og_goodslogo'];
            $og_goodslogo = explode(',',$og_goodslogo);
            $this->assign('og_goodslogo',$og_goodslogo);
            $order_list = D()->query($sql);
            $this->assign('order_list',$order_list);
            $this->display('order');
        }
    }
}
