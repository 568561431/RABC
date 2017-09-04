<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017/7/9
 * Time: 14:51
 */

namespace Admin\Controller;

class GoodsController extends CommonController
{
    function goodsList(){
            $goods_model = D('Goods');
            $pageno = I('get.p',1);
            $pagesize = 5;
            $goods_list = $goods_model
            ->alias('g')
            ->field('g.*,c.cate_name pname')
            ->page($pageno,$pagesize)
            ->join('left join sp_cate c on g.goods_cateid=c.cate_id')
            ->select();
            $this->assign('goods_list',$goods_list);
            $count = $goods_model->count();
            $page = new \Think\Page($count,$pagesize);
            $show = $page->show();
            $this->assign('show',$show);
            $content = $this->display();

    }
    function addGoods(){
        if(IS_POST){
            $goods_model = D('goods');
            $arr = $goods_model->uploadLogo();
            $form_data = $goods_model->create();
            if(!$form_data){
                echo $this->error($goods_model->getError());
            }else{
                $form_data['goods_logo'] = $arr['logo_path'];
                $form_data['goods_small_logo'] = $arr['small_logo_path'];
                $form_data['goods_saletime'] = strtotime($form_data['goods_saletime']);
                $add_result = $goods_model->add($form_data);
                if($add_result){
                    //收集商品属性数据,写入goodsattr表
                    $attr = I('post.vals');
                    $arr = array();
                    //循环post提交的vals 写入到goodsattr表的数组
                    foreach ($attr as $key=>$value){
                        $arr[] = array(
                            'ga_goodsid' => $add_result,
                            'ga_attrid' => $key,
                            'ga_vals' => implode(',',$value),
                        );
                    }
                    $attr_model = D('Goodsattr');
                    $attr_model->addAll($arr);
                    //如果不填参数 默认回调到上次执行的控制器方法  1秒后跳转
                    $this->success('添加商品成功',U('goodsList'),3);
                }else{
                    $this->error('添加商品失败');
                }
            }
        }else{
            $cate_model = D('Cate');
            $cate_list = $cate_model->where('cate_pid=0')->select();
            $this->assign('cate_list',$cate_list);
            $this->display();
        }
    }
    public function getCate(){
        $cate_id = I('post.cate_id');
        $cate_model = D('Cate');
        $cate_list = $cate_model->where("cate_pid=$cate_id")->select();
        $result = '<option>--请选择--</option>';
        foreach($cate_list as $value){
            $result .= "<option value='{$value['cate_id']}'>{$value['cate_name']}</option>";
        }
        echo $result;
    }
    public function photos(){
        if(IS_POST){
            $goods_id = I("post.goods_id");
            $config = C('UPLOAD_IMG');
            $uploader = new \Think\Upload($config);
            $upload_result = $uploader->upload();
            if(!$upload_result){
                $this->error($uploader->getError(),U('goodsList'),3);
            }else{
                $result = D('Goodspic')->insertPic($goods_id,$upload_result);
                if($result){
                    $this->success('批量添加成功',U('goodsList'),3);
                }else{
                    $this->error('批量添加失败',U('photos','goods_id='.$goods_id),3);
                }
            }
        }else{
            $goods_id = I('get.goods_id');
            $goods_model = D('Goods');
            $goods_info = $goods_model->find($goods_id);
            $this->assign('goods_info',$goods_info);

            $pic_model = D('Goodspic');
            $pic_list = $pic_model->where("pic_goodsid=$goods_id")->select();
            $this->assign('pic_list',$pic_list);
            $this->display();
        }
    }
    public function delPic(){
        $pic_id = I('post.pic_id');
        $pic_model = D('goodspic');
        $pic_info = $pic_model->find($pic_id);
        if($pic_model->delete($pic_id)){
            unlink($pic_info['pic_ori']);
            unlink($pic_info['pic_big']);
            unlink($pic_info['pic_mid']);
            unlink($pic_info['pic_sma']);
            echo 1;
        }else{
            echo 2;
        }
    }
    public function modifyGoods(){
        if(IS_POST){
            $goods_model = D('Goods');
            $goods_id = I('post.goods_id');
            $form_data = $goods_model->create();
            if(!$form_data){
                echo $this->error($goods_model->getError());
            }else{
                $form_data['goods_saletime'] = strtotime($form_data['goods_saletime']);
                if($_FILES['logo']['error'] == 0){
                    $arr = $goods_model->uploadLogo();
                    $form_data['goods_logo'] = $arr['logo_path'];
                    $form_data['goods_small_logo'] = $arr['small_logo_path'];
                    $goods_info = $goods_model->find($goods_id);
                    unlink($goods_info['goods_logo']);
                    unlink($goods_info['goods_small_logo']);
                }
                $save_result = $goods_model->save($form_data);
                if($save_result>=0){
                    $this->success('修改成功',U('goodsList'),3);
                }else{
                    $this->error('修改失败',U('modifyGoods',"goods_id=$goods_id"),3);
                }
            }
        }else{
            $cate_model = D('Cate');
            $cate_list = $cate_model->where('cate_pid=0')->select();
            $this->assign('cate_list',$cate_list);
            $goods_id = I('get.goods_id');
            $goods_info = D('Goods')->find($goods_id);
            $this->assign('goods_info',$goods_info);
            $this->display();
        }
    }

    //删除商品
    public function delGoods(){
        $goods_id = I('get.goods_id');
        $goods_model = D('Goods');
        $del_goods_result = $goods_model->delGoods($goods_id);
        if($del_goods_result){
            $this->success('删除成功',U('goodsList'),3);
        }else{
            $this->error('删除失败');
        }
    }


    //批量删除
    public function delAll(){
        $ids = I('get.ids');
        $ids = rtrim($ids,',');
        $del_result = D("Goods")->delGoods($ids);
        if($del_result){
            echo 1;
            // $this->success('删除成功',U('goodsList'),3);
        }else{
            echo 2;
            // $this->error("删除失败",U('goodsList'),3);
        }
    }
}