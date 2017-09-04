<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017/7/10
 * Time: 10:43
 */

namespace Admin\Model;


use Think\Model;
use Think\Upload;
use Think\Image;

class GoodsModel extends Model
{
    protected $pk = 'goods_id';
    protected $fields = array(
        'goods_id','goods_name','goods_price','goods_vip_price','goods_num',
        'goods_weight','goods_cateid','goods_brandid','goods_introduce',
        'goods_logo','goods_small_logo','goods_saletime','goods_addtime',
        'goods_uptime','goods_isdel',
    );
    protected $_map = array(
        'name' => 'goods_name',
        'price' => 'goods_price',
        'vip_price' => 'goods_vip_price',
        'num' => 'goods_num',
        'logo' => 'goods_logo',
        'weight' => 'goods_weight',
        'cateid' => 'goods_cateid',
        'isdel' => 'goods_isdel',
        'saletime' => 'goods_saletime',
        'introduce' => 'goods_introduce',
    );
    protected $_validate = array(
        array('goods_name','require','商品名必填',1,'regex',3),
        array('goods_name','','商品名称已经存在！',0,'unique',1),
        array('goods_price','double','价格必填数字',1,'regex',3),
        array('goods_vip_price','double','价格必填数字',1,'regex',3),
        array('goods_num','number','库存必填数字',1,'regex',3),
        array('goods_weight','number','商品重量必填数字',1,'regex',3),
        array('goods_isdel',array('上架','下架'),'非法数据',1,'in',3),
        array('goods_saletime','date','开售时间格式必须为xxxx-xx-xx',1,'regex',3),
    );
    protected $_auto = array(
        array('goods_addtime','time',3,'function'),
        array('goods_uptime','time',3,'function'),
    );
    public function uploadLogo(){
        //定义上传logo图片的保存路径
        $logo_path = '';
        //缩略图路径
        $small_logo_path = '';
        //处理文件上传
        if($_FILES['logo']['error'] == 0){
            //上传成功去实例化upload类,执行文件上传操作
            //自定义文件上传的配置项
            $config = array(
                'maxSize' => 3000000,
                'exts' => array('jpg','png','gif'),
                'rootPath' => './Uploads/',
            );
            $uploader = new Upload($config);
            $upload_result = $uploader->upload();
            if(!$upload_result){
                echo $this->error($uploader->getError());
            }else{
                //拼接logo路径
                $logo_path = $config['rootPath'].$upload_result['logo']['savepath']
                    .$upload_result['logo']['savename'];
                $img = new Image();
                $img->open($logo_path);
                $img->thumb(50,50);
                $small_logo_path = $config['rootPath'].$upload_result['logo']['savepath']
                    .'thumb_'.$upload_result['logo']['savename'];
                $img->save($small_logo_path);
            }
        }
        return $arr = array('logo_path'=>$logo_path, 'small_logo_path'=>$small_logo_path);
    }



    public function delGoods($goods_id)
    {
        //$goods_info = $goods_model->find($goods_id);
        $sql = "select * from sp_goods where goods_id in ($goods_id)";
        $goods_list = D()->query($sql);
        foreach($goods_list as $key=>$value){
            unlink($goods_list[$key]['goods_logo']);
            unlink($goods_list[$key]['goods_small_logo']);
        }
//        $del_goods = $goods_model->delete($goods_id);
        $sql = "delete from sp_goods where goods_id in ($goods_id)";
        $del_goods = D()->execute($sql);
        if ($del_goods) {
            //实例化goodspic表删除对应的相册管理
            //$goods_pic_list = $goods_pic_model->where('pic_goodsid=' . $goods_id)->select();
            $sql = "select * from sp_goodspic where pic_goodsid in ($goods_id)";
            $goods_pic_list = D()->query($sql);
            foreach ($goods_pic_list as $key => $value) {
                unlink($goods_pic_list[$key]['pic_ori']);
                unlink($goods_pic_list[$key]['pic_big']);
                unlink($goods_pic_list[$key]['pic_sma']);
                unlink($goods_pic_list[$key]['pic_mid']);
            }
            //$goods_pic_model->where('pic_goodsid=' . $goods_id)->delete();
            //D('Goodsattr')->where('ga_goodsid=' . $goods_id)->delete();
            $sql = "delete from sp_goodspic where pic_goodsid in ($goods_id)";
            D()->execute($sql);
            $sql = "delete from sp_goodsattr where ga_goodsid in ($goods_id)";
            D()->execute($sql);
        }
        return $del_goods;
    }
}