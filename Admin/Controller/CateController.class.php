<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017/7/3
 * Time: 19:52
 */
namespace Admin\Controller;
class CateController extends CommonController {
    public function editCate(){
        $cate_model = D('Cate');
        $cate_id = I('get.cate_id');
        $result = $cate_model->find($cate_id);
        $results = $cate_model->select();
        $results = getTree($results);
        $this->assign('results',$results);
        $this->assign('result',$result);
        $this->display();
    }
    public function updateCate(){
        $cate_model = D('Cate');
        $form_data = $cate_model->create('',2);
        //dump($form_data);
        $result = $cate_model->save($form_data);
        if($result){
            $this->success('修改成功',U('cateList'),3);
        }else{
            $cate_id = I('post.cate_id');
            $this->error('修改失败',U('editCate',"cate_id=$cate_id"),3);
        }
    }
    public function cateList(){
        $cate_model = D('Cate');
        $cate_list = $cate_model
            ->alias('c1')
            ->field('c1.cate_id,c1.cate_name,c2.cate_name pname, c1.cate_pid')
            ->join('left join sp_cate c2 on c1.cate_pid=c2.cate_id')
            ->select();
        $cate_list = getTree($cate_list);
        $this->assign('cate_list',$cate_list);
        $this->display();
    }
    public function addCate()
    {
        $cate_model = D('cate');
        if(IS_POST)
        {
            $pid = I('post.cate_pid');
            $cate_count = D('cate')->where('cate_pid=0')->count();
            if($cate_count>=12){
                if($pid == 0){
                    $this->error('不能再添加一级分类了');
                }
            }
            $arr['cate_name'] = I('post.cate_name');
            $arr['cate_pid'] = I('post.cate_pid');

            $add_result = $cate_model->add($arr);
            if($add_result){
                $this->success('添加成功',U('cateList'),3);
            }else{
                $this->error('添加失败',U('addCate'),3);
            }
        }else
        {
            $cate_list = $cate_model->select();
            $cate_list = getTree($cate_list);
            /*$cate_result = array();
            foreach($cate_list as $key=>$value){
                if($value['level'] == 1){
                    $cate_result[$key] = $value;
                }
            }
            $cate_list = $cate_result;*/
            $this->assign('cate_list',$cate_list);
            $this->display();
        }
    }
    public function delCate(){
        $cate_model = D('cate');
        $id = $_GET['cate_id'];
        $result = $cate_model->where("cate_pid=$id")->find();
        if(empty($result)){
            $delete_result = $cate_model->delete($id);
            if($delete_result){
                $this->success('删除成功',U('cateList'),3);
            }else{
                $this->error('删除失败',U('cateList'),3);
            }
        }else{
            $this->error('请先删除子类',U('cateList'),3);
        }

    }

    public function _empty()
    {
        echo '没有这个方法';
    }
}
