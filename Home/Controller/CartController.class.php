<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017/7/15
 * Time: 15:06
 */

namespace Home\Controller;


use Think\Controller;
use Think\Cart;

class CartController extends Controller
{
    function aaa(){
        $str = cookie('cart');
        dump(unserialize($str));
    }
    function addCart(){
        //接收前台发送的数据,按照cart表的字段保存,方便add操作
        $goods_info = array(
            'cart_goodsid' => I('post.id'),
            'cart_num' => I('post.num'),
            'cart_attr' => I('post.attr'),
        );
        //实例化cart.class.php类,根据是否存在session来实例化更底层的mysql或者cookie类
        $cart = new Cart();
        //调用addcart方法,将数据写入购物车
        $add_result = $cart->addCart($goods_info);
        if($add_result){
            //如果成功读取cart表中当前用户购物车的总数量和总价格;
            //返回值是数组，一个是总数量一个是总价格
            echo json_encode($cart->getPriceNumber());
        }else{
            echo 2;
        }
    }
    public function flow(){
        $cart = new Cart();
        $cart_list = $cart->getCartList();
        $pn = $cart->getPriceNumber();
        $this->assign('cart_list',$cart_list);
        $this->assign('price',$pn['price']);
        $this->display();
    }
    public function delCart(){
        $cart_id = I('get.cart_id');
        $cart = new Cart();
        $del_result = $cart->delCart($cart_id);
        if($del_result){
            echo 1;
        }
    }
    public function save_cart(){
        $cart_id = I('get.cart_id');
        $num = I('get.num');
        $goods_id = I('get.goods_id');
        $save_arr = array(
            'cart_id' => $cart_id,
            'cart_num' => $num,
            'goods_id' =>$goods_id,
        );
        $goods_info = M('Goods')
        ->field('goods_num')
        ->where('goods_id='.$goods_id)
        ->find();
        $cart = new Cart();
        /*$goods_info = M('Goods')->field('goods_num,goods_price')->find(15);
        echo json_encode($goods_info);
        return;*/
        if($goods_info['goods_num'] >= $num)
        {
            $save_result = $cart->save_cart($save_arr);
            if($save_result>=0){
                $pn = $cart->getPriceNumber();
                $cart_info = $cart->getCartInfo($cart_id);
                $save_result = array(
                    'total_price' => $cart_info['total_price'],
                    'price' => $pn['price'],
                );
                echo json_encode($save_result);
            }else{
                echo 2;
            }
        }else{
            $cart->save_cart($save_arr);
            $cart_info = $cart->getCartInfo($cart_id);
            $pn = $cart->getPriceNumber();
            $goods_num = $goods_info['goods_num'];
            echo json_encode(['goods_num'=>$goods_num,'a'=>3,'total_price' => $cart_info['total_price'],'price' => $pn['price']]);
        }
        
    }



    public function flow2(){
        if(session('?memid')){
            $cart = new Cart();
            $cart_list = $cart->getCartList();
            $pn = $cart->getPriceNumber();
            $this->assign('cart_list',$cart_list);
            $this->assign('pn',$pn);
            $this->assign('cart_list',$cart_list);
            $this->display();
        }else{
            $ac = array(
                'tc' => CONTROLLER_NAME,
                'ta' => ACTION_NAME,
            );
            $this->error('请先登录',U('Member/login',$ac),3);
        }
    }


    function flow3(){
        $order_model = D('Order');
        $form_data = $order_model->create();

        $cart = new Cart();
        $pn = $cart->getPriceNumber();
        //补充数据
        $form_data['order_number'] = 'syphp59'.date('YmdHis').rand(10000000,99999999);
        $form_data['order_memid'] = session('memid');
        $form_data['order_price'] = $pn['price'];
        $form_data['order_addtime'] = time();
        $form_data['order_updtime'] = time();
        $add_result = $order_model->add($form_data);
        if($add_result){
            //如果正常写入，将cart表中的数据写入到order_goods表中，再删除cart表中的数据
            $cart_list = $cart->getCartList();
            $order_result = [];
            foreach($cart_list as $key=>$value){
                $order_result['og_memid'] = session('memid');
                $order_result['og_orderid'] = $add_result;
                $order_result['og_goodsid'] .= $value['goods_id'].',';
                //$order_result['og_goodsname'] = $value['goods_name'];
                //$order_result['og_goodsprice'] = $value['goods_price'];
                $order_result['og_price'] = $value['total_price'];
                //$order_result['og_number'] = $value['cart_num'];
                //$order_result['og_attr'] = $value['cart_attr'];
                $order_result['og_goodslogo'] .= $value['goods_small_logo'].',';
            }
            $order_result['og_goodsid'] = rtrim($order_result['og_goodsid'],',');
            $order_result['og_goodslogo']  = rtrim($order_result['og_goodslogo'],',');
            D('OrderGoods')->add($order_result);
            //删除购物车数据
            D('Cart')->where('cart_memid='.session('memid'))->delete();

            $form = "<form name='mainForm' action='/Public/Common/alipay/alipayapi.php' method='post'>
            <input type='text' name='WIDout_trade_no' id='out_trade_no'value='{$form_data['order_number']}'>
            <input type='text' name='WIDsubject' value='{$form_data['order_number']}'>
            <input type='text' name='WIDtotal_fee' value='0.01'>
            <input type='text' name='WIDbody' value='即时到账测试'>
            </form>
            <script type='text/javascript'>
            function submit_form(){
                document.mainForm.submit();
            }
            submit_form();
            </script>";
            echo $form;
        }else{
            //报加入订单表失败
        }
    }
    function flow4(){
        //修改订单状态
        //1. 接收订单号
        $order_number = I('get.number');
        //2. 修改order表中order_status和order_updtime
        $t = time();
        $sql = "update sp_order set order_status='已支付',order_updtime=$t where 
                    order_number='$order_number'";
        D()->execute($sql);
        $this->display();
    }
}