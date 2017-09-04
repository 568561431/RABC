<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017/7/12
 * Time: 13:31
 */

namespace Admin\Model;


use Think\Model;

class GoodspicModel extends Model
{
    function insertPic($goods_id,$files){
        $result = array();
        $rootPath = C("UPLOAD_IMG")['rootPath'];
        foreach($files as $value){
            $img = new \Think\Image();
            $ori = $rootPath.$value['savepath'].$value['savename'];
            $img->open($ori);
            $img->thumb(800,800,2);
            $big = $rootPath.$value['savepath'].'big_'.$value['savename'];
            $img->save($big);

            $img->thumb(350,350,2);
            $mid = $rootPath.$value['savepath'].'mid_'.$value['savename'];
            $img->save($mid);

            $img->thumb(50,50,2);
            $sma = $rootPath.$value['savepath'].'sma_'.$value['savename'];
            $img->save($sma);

            $result[] = array(
                'pic_goodsid' => $goods_id,
                'pic_ori' => $ori,
                'pic_big' => $big,
                'pic_mid' => $mid,
                'pic_sma' => $sma,
            );
        }
        return $this->addAll($result);
    }
}