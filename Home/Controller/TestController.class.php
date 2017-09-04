<?php
namespace Home\Controller;
use Think\Controller;
class TestController extends Controller{
	function session(){
		// session('name','itcast');
		ini_set('session.cookie_lifetime', 60); //设置时间 
		//ini_get('session.cookie_lifetime');//得到ini中设定值 

		// session(array('name'=>'session_id','expire'=>3600));
		echo session('name');
	}
}