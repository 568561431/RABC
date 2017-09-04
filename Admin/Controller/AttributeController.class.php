<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017/7/13
 * Time: 8:34
 */

namespace Admin\Controller;


class AttributeController extends CommonController
{
    function addAttr(){
        $cate_model = D('Cate');
        $attr_model = D('Attribute');
        if(IS_POST){
            $form_data = $attr_model->create();
            $form_data['attr_value'] = str_replace('，',',',$form_data['attr_value']);
            if($attr_model->add($form_data)){
                $this->success('添加属性成功',U('attrList'));
            }else{
                $this->error('添加属性失败');
            }
        }else{
            $cate_list = $cate_model->where('cate_pid=0')->select();
            $this->assign('cate_list',$cate_list);
            $this->display();
        }
    }
    function getCate(){
        $cate_id = I('post.cate_id');
        $cate_model = D('cate');
        $cate_list = $cate_model->where("cate_pid=$cate_id")->select();
        $result = '';
        foreach($cate_list as $value){
            $result .= "<option value='{$value['cate_id']}'>{$value['cate_name']}</option>";
        }
        echo $result;
    }
    public function attrList(){
        $attr_model = D('Attribute');
        $attr_list = $attr_model
            ->alias(a)
            ->field('a.*,c.cate_name')
            ->join('sp_cate c on a.attr_cateid=c.cate_id')
            ->select();
        $this->assign('attr_list',$attr_list);
        $this->display();
    }
    public function getAttr(){
        $cate_id = I('get.cate_id');
        $attr_list = D('Attribute')->where("attr_cateid=$cate_id")->select();
        echo json_encode($attr_list);
    }
}