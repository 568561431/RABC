<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017/7/6
 * Time: 20:36
 */
namespace Admin\Controller;
class ManagerController extends CommonController
{
    function addManager(){
        $this->display();
    }
    function managerList(){
        $manager_model = D('Manager');
        $pageno = I('get.p',1);
        $pagesize = 5;
        $result = $manager_model->page($pageno,$pagesize)->select();
        $this->assign('result',$result);
        $count = $manager_model->count();
        $page = new \Think\Page($count,$pagesize);
        $show = $page->show();
        $this->assign('show',$show);
        $this->display();
    }
    function addOk(){
        $manager_model = D('Manager');
        $form_data = $manager_model->create('',1);
        if(!$form_data){
            echo $manager_model->getError();
        }else{
            $form_data['manager_passwd'] = salt($form_data['manager_passwd'],$form_data['manager_salt']);
            $result = $manager_model->add($form_data);
            if($result){
                $this->success('添加成功',U('managerList'),3);
            }else{
                $this->error('添加失败',U('addManager'),3);
            }
        }
    }

    public function delManager(){
        session(null);
        $this->redirect('Index/login');
    }
}