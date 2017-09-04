<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/Public/Admin/js/jquery.js"></script>
</head>

<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">表单</a></li>
        </ul>
    </div>
    <div class="formbody">
        <div class="formtitle"><span>基本信息</span></div>
        <form action="<?php echo U('addOk');?>" method="post">
            <ul class="forminfo">
                <li>
                    <label>用户名称</label>
                    <input name="name" placeholder="请输入用户名称" type="text" class="dfinput" /><i></i></li>
                <li>
                    <label>用户密码</label>
                    <input name="password" placeholder="请输入用户密码" type="password" class="dfinput" /><i></i></li>
                <li>
                    <label>确认密码</label>
                    <input name="repwd" placeholder="请再次输入用户密码" type="password" class="dfinput" />
                </li>
                <li>
                    <label>用户状态</label><br>
                    <input type="radio" name="status" value="启用" id="">启用
                    <input type="radio" name="status" value="禁用" id="">禁用
                </li>
                <li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" type="button" class="btn" value="确认保存" />
                </li>
            </ul>
        </form>
    </div>
</body>

</html>
<script>
    $(function()
    {
        $("#btnSubmit").click(function()
        {
            $('form').submit();
        })
    })
</script>