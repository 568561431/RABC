<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/Public/Common/Ueditor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="/Public/Common/Ueditor/third-party/jquery.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/Common/Ueditor/umeditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/Common/Ueditor/umeditor.min.js"></script>
    <script src="/Public/Common/laydate/laydate.js"></script>
    <script type="text/javascript" src="/Public/Common/Ueditor/lang/zh-cn/zh-cn.js"></script>
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
        <form action="" method="post" enctype="multipart/form-data">
            <ul class="forminfo">
                <li>
                    <label>商品名称</label>
                    <input name="name" placeholder="请输入商品名称" type="text" class="dfinput" /><i>名称不能超过30个字符</i>
                </li>
                <li>
                    <label>商品价格</label>
                    <input name="price" placeholder="请输入商品价格" type="text" class="dfinput" /><i></i>
                </li>
                <li>
                    <label>会员价格</label>
                    <input name="vip_price" placeholder="请输入会员价格" type="text" class="dfinput" /><i></i>
                </li>
                <li>
                    <label>商品数量</label>
                    <input name="num" placeholder="请输入商品数量" type="text" class="dfinput" />
                </li>
                <li>
                    <label>商品logo</label>
                    <input name="logo" placeholder="请输入商品logo" type="file" class="" />
                </li>

                <li>
                    <label>商品重量</label>
                    <input name="weight" placeholder="请输入商品重量" type="text" class="dfinput" />
                </li>
                <li>
                    <label>一级分类</label>
                    <select name="" id="level1" class="dfinput" onchange="getCate(this.value,2)">
                        <option value="0">--请选择--</option>
                        <?php if(is_array($cate_list)): foreach($cate_list as $key=>$vo): ?><option value="<?php echo ($vo["cate_id"]); ?>"><?php echo ($vo["cate_name"]); ?></option><?php endforeach; endif; ?>
                    </select>
                    <i></i>
                </li>
                <li>
                    <label>二级分类</label>
                    <select name="" id="level2" class="dfinput" onchange="getCate(this.value,3)">
                        <option value="0">--请选择--</option>
                    </select>
                    <i></i>
                </li>
                <li>
                    <label>三级分类</label>
                    <select name="cateid" id="level3" class="dfinput">
                        <option value="0">--请选择--</option>
                    </select>
                    <i></i>
                </li>
                <li>
                    <label>商品状态</label>
                    <cite>
                        <input name="isdel" type="radio" value="上架" checked="checked" />上架&nbsp;&nbsp;&nbsp;&nbsp;
                        <input name="isdel" type="radio" value="下架" />下架
                    </cite>
                </li>
                <li>
                    <label>开售日期</label>
                    <input name="saletime" placeholder="请输入日期" class="laydate-icon" onclick="laydate()">
                </li>
                <li>
                    <label>商品描述</label>
                    <textarea name="introduce"  id="myEditor" placeholder="请输入商品描述" cols="" rows="" class="textinput"></textarea>
                </li>
                <li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" type="submit" class="btn" value="确认保存" />
                </li>
            </ul>
        </form>
    </div>
</body>
</html>
<script type="text/javascript">
    var um = UM.getEditor('myEditor',
            {
                initialFrameWidth:500,
                initialFrameHeight:200
            });
</script>
<script language="JavaScript" src="/Public/Admin/js/jquery.js"></script>
<script>
    $("#level3").change(function(){
        _this = $(this);
        var data = $(this).val();
        $.ajax({
            'url':"<?php echo U('Attribute/getAttr');?>",
            'data':{'cate_id':data},
            'type':'get',
            'cache':false,
            'dataType':'json',
            'success':function (msg){
                $('.newTag').remove();
                $.each(msg,function (index,el){
                    if(el.attr_type == '手填'){
                        str = "<li class='newTag'><label><a href='javascript:;' class='add'>[+]</a>"+el.attr_name+"</label><input name='vals["+el.attr_id+"][]' placeholder='请输入商品属性' type='text'class='dfinput' /><i></i></li>";
                    }else{
                        option = '';
                        arr = el.attr_value.split(',');
                        for(i = 0 ; i < arr.length ; i++){
                            option += "<option value="+arr[i]+">"+arr[i]+"</option>";
                        }
                        str = "<li class='newTag'><label><a href='javascript:;' class='add'>[+]</a>"+el.attr_name+"</label><select name='vals["+el.attr_id+"][]' class='dfinput'><option value=''>--请选择--</option>"+option+"</select><i></i></li>";
                    }
                    _this.after(str);
                })
            }

        })
    })
    function getCate(data,level){
//        alert(level);
        $.post('<?php echo U('getCate');?>',{'cate_id':data},function (msg) {
            var tmp = "#level"+level;
            $(tmp).parent().next().children('select').html('<option value="0">--请选择--</option>');
            $(tmp).html(msg);
//            alert(msg)
        })
    }
    $('.add').live('click',function () {
        $(this).text('[-]');
        $(this).attr('class','jian');
        var li = $(this).parent().parent().clone();
        $(this).parent().parent().after(li);
        $(this).text('[+]');
        $(this).attr('class','add');
    })
    $('.jian').live('click',function () {
        $(this).parent().parent().remove();
    })
    //    $(document).on('click','.add',function () {
    //        var li = $(this).parent().parent().clone();
    //        //将现有的加删除  在创建一个减  添加到level中
    //        //找到加好标签删除掉
    //        li.find('a').remove();
    //        //创建减号标签
    //        str = "<a href='javascript:;' class='add'>[-]</a>";
    //        li.find('label').prepend(str);
    //        $(this).parents(li).after(li);
    //    })
</script>