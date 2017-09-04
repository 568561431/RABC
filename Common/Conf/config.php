<?php
return array(
    'DEFAULT_FILTER' => 'filterXSS',
    'UPLOAD_IMG' => array(
        'maxSize' => 3000000,
        'rootPath' => './Uploads/',
        'exts' => array('jpg','png','gif'),
    ),
//    'SHOW_PAGE_TRACE' => true,
	//'配置项'=>'配置值'
    'DB_TYPE' => 'mysql',       //数据库类型
    'DB_HOST' => 'localhost',   //服务器地址
    'DB_NAME' => 'shop',        //数据库名字
    'DB_USER' => 'root',        //用户名
    'DB_PWD'  =>  '123456',     //密码
    'DB_PORT'   => '3306',      //端口号
    'DB_PREFIX' => 'sp_',       //数据库表前缀
    //数据表前缀是必须有的,并且要使用_来结束
    'TMPL_PARSE_STRING' => array(
        '__ADMIN__' => '/Public/Admin',
        '__HOME__'  => '/Public/Home',
        '__ADMINCSS__' => '/Public/Admin/css',
        '__ADMINJS__'  => '/Public/Admin/js',
        '__ADMINIMG__' => '/Public/Admin/images',

        '__HOMECSS__' => '/Public/Home/style',
        '__HOMEJS__'  => '/Public/Home/js',
        '__HOMEIMG__' => '/Public/Home/images',
    ),
    'URL_MODEL' => 2,
);