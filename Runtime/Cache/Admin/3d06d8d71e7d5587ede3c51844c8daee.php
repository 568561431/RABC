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
        <div class="formtitle"><span>商品相册</span></div>
        管理<span style="color:red;font-size: 20px; "><?php echo ($goods_info["goods_name"]); ?></span>的相册
        <li style="border: 1px solid grey;margin-bottom: 20px;">
            <?php if(is_array($pic_list)): foreach($pic_list as $key=>$vo): ?><span>
                    <img src="<?php echo (ltrim($vo["pic_mid"],'.')); ?>" width="200">
                    <a href="javascript:;" class="delPic" data="<?php echo ($vo["pic_id"]); ?>">[-]</a>
                </span><?php endforeach; endif; ?>
        </li>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="goods_id" value="<?php echo ($goods_info["goods_id"]); ?>">
            <ul class="forminfo">
                <li>
                    <label>商品图片[<a href="javascript:;" class="add">+</a>]</label>
                    <input name="goods_pic[]" type="file" />
                </li>
                <li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" type="button" class="btn" value="确认保存" />
                </li>
            </ul>
        </form>
    </div>
</body>
<script type="text/javascript">
$(function(){
    $('#btnSubmit').on('click',function(){
        $('form').submit();
    });
    $('.add').click(function(){
        var li = '<li><label>商品图片[<a href="javascript:;" class="minus">-</a>]</label><input name="goods_pic[]" type="file" /></li>';
        $(this).parent().parent().after(li);
    })
    $('.minus').live('click',function(){
        $(this).parent().parent().remove();
    })
    $('.delPic').click(function(){
        _this = $(this);
        var pic_id = $(this).attr('data');
        $.get("<?php echo U('delPic');?>",{'pic_id':pic_id},function(msg){
            if(msg == 1){
                _this.parent().remove();
            }else{
                alert('删除失败!');
            }
        })
    })
});
</script>
</html>