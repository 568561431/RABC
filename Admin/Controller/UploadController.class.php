<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017/7/19
 * Time: 9:08
 */

namespace Admin\Controller;


use Think\Controller;


class UploadController extends Controller
{
    public function index(){
        if(IS_POST){
            if($_FILES['myphoto']['error'] == 0){
                $config = array(
                    'rootPath' => './Uploads/',
                    'exts' => array('jpg', 'png', 'gif'),
                    'maxSize' => 300000,
                );
                $uploader = new \Think\Upload($config);
                $upload_result = $uploader->upload();
//                dump($upload_result);
            }
        }else{
            $this->display();
        }
    }
}