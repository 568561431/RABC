<?php
namespace Home\Controller;
class IndexController extends CommonController{
    public function index(){
        $ch=new \Memcache();
        $ch->connect('127.0.0.1',11211);  
        $content = $this->fetch();
        $ch->set('index',$content,0,3600);
        echo $ch->get('index');
    }
    public function goodsList(){
        $this->display();
    }
    public function detail(){
        //查询商品的简单介绍
        $goods_id = I('get.goods_id');
        $goods_model = D('Goods');
        $goods_info = $goods_model->find($goods_id);
        $this->assign('goods_info',$goods_info);


        $sql = "SELECT c.cate_name FROM sp_goods g LEFT JOIN sp_cate c ON g.goods_cateid=
c.cate_id WHERE goods_id = $goods_id";
        $cate_info = D()->query($sql);
        $this->assign('cate_info',$cate_info);


        //查询商品属性
        $sql = "select a.attr_name,g.ga_vals from sp_goodsattr g left join sp_attribute a on a.attr_id=g.ga_attrid where ga_goodsid = $goods_id";
        $goods_attr = M()->query($sql);
        $this->assign('goods_attr',$goods_attr);
        //根据goods_id读取相册信息
        $pic_list = D('Goodspic')->where('pic_goodsid='.$goods_id)->select();
        $this->assign('pic_list',$pic_list);
        //根据goods_id查单选
        $attr_list = D("Attribute")
            ->alias('a')
            ->field('a.attr_name,g.ga_vals')
            ->join('LEFT JOIN sp_goodsattr g ON a.attr_id=g.ga_attrid')
            ->where("a.attr_type='单选' AND g.ga_goodsid=$goods_id")
            ->select();
        //将ga_vals拆成数组
        foreach ($attr_list as $key=>$value){
           $attr_list[$key]['ga_vals'] = explode(',',$value['ga_vals']);
        }
        $this->assign('attr_list',$attr_list);
        $this->display();
    }


    public function search(){
        $key = I('get.name');
        $goods_model = D('Goods');
        $goods_list = $goods_model
            ->where("goods_name like '%$key%' or goods_keyword like '%$key%' or goods_description like '%$key%'")
            ->select();
        $this->assign('goods_list',$goods_list);
        $this->display('goodsList');
    }



    public function getGoodsByCateid(){
        $level = I('get.level');
        $cate_id = I('get.cate_id');
        if($level == 2){
            $sql = "SELECT * FROM sp_goods WHERE goods_cateid=$cate_id";
        }elseif ($level == 1){
            $sql = "SELECT * FROM sp_goods WHERE goods_cateid IN 
                    (SELECT cate_id FROM sp_cate WHERE cate_pid=$cate_id)";
        }elseif ($level == 0){
            $sql = "SELECT * FROM sp_goods WHERE goods_cateid IN
            (SELECT cate_id FROM sp_cate WHERE cate_pid IN
            (SELECT cate_id FROM sp_cate WHERE cate_pid=$cate_id)
            )";
        }
        $goods_list = M()->query($sql);
        $this->assign('goods_list',$goods_list);
        $this->display('goodsList');
    }

    public function outLogin(){
        session('memid',null);
        session('memname',null);
        $this->redirect('index');
    }
}