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
        <form action="" method="post">
            <ul class="forminfo">
                <li>
                    <label>属性名称</label>
                    <input name="attr_name" placeholder="请输入属性名称" type="text" class="dfinput" /></li>
                <li>
                    <label>所属一级分类</label>
                    <select id="level1" class="dfinput" onchange="getCate(this.value, 2)">
                        <option value="0">--请选择--</option>
                        <?php if(is_array($cate_list)): foreach($cate_list as $key=>$vo): ?><option value="<?php echo ($vo["cate_id"]); ?>"><?php echo ($vo["cate_name"]); ?></option><?php endforeach; endif; ?>
                    </select>
                    <i></i>
                </li>
                <li>
                    <label>所属二级分类</label>
                    <select id="level2" class="dfinput" onchange="getCate(this.value, 3)">
                        <option value="0">--请选择--</option>
                    </select>
                    <i></i>
                </li>
                <li>
                    <label>所属三级分类</label>
                    <select id="level3" name="attr_cateid" class="dfinput">
                        <option value="0">--请选择--</option>
                    </select>
                    <i></i>
                </li>

                <li>
                	<label>属性类型</label>
                	<cite>
                		<input name="attr_type" type="radio" value="手填" checked="checked" />手填&nbsp;&nbsp;&nbsp;&nbsp;
                		<input name="attr_type" type="radio" value="单选" />单选
                	</cite>
                </li>
                <li>
                    <label>属性值</label>
                    <textarea name="attr_value" placeholder="请输入属性值，多值使用  , 进行分割" cols="" rows="" class="textinput"></textarea>
                </li>
                <li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" type="submit" class="btn" value="确认保存" />
                </li>
            </ul>
        </form>
    </div>
<script type="text/javascript">
    function getCate(data,level) {
        $.post('<?php echo U('getCate');?>',{'cate_id':data},function (msg) {
            var tmp = '#level'+level;
            $(tmp).empty();
            $(tmp).parent().next().children('select').html('<option>--请选择--</option>');
            msg = '<option>--请选择--</option>'+msg;
            $(tmp).append(msg);
        })
    }
</script>
</body>

</html>