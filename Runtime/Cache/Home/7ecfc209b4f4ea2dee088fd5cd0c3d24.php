<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>京西商城</title>
    <link rel="stylesheet" href="/Public/Home/style/base.css" type="text/css">
    <link rel="stylesheet" href="/Public/Home/style/global.css" type="text/css">
    <link rel="stylesheet" href="/Public/Home/style/header.css" type="text/css">
    <link rel="stylesheet" href="/Public/Home/style/index.css" type="text/css">
    <link rel="stylesheet" href="/Public/Home/style/bottomnav.css" type="text/css">
    <link rel="stylesheet" href="/Public/Home/style/footer.css" type="text/css">

    <script type="text/javascript" src="/Public/Home/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/Public/Home/js/header.js"></script>
    <script type="text/javascript" src="/Public/Home/js/index.js"></script>
</head>
<body>
<!-- 顶部导航 start -->
<div class="topnav">
    <div class="topnav_bd w1210 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <ul>
                <li>您好，<font color="#ee82ee"><?php echo (session('memname')); ?></font> 欢迎来到京西！
                    <?php if(!$_SESSION['memid']): ?>[<a href="<?php echo U('Member/login');?>">登录</a>] 
                    [<a href="register.html">免费注册</a>] 
                    <?php else: ?> 
                    [<a href="<?php echo U('Index/outLogin');?>">退出登录</a>]<?php endif; ?>
                </li>
                <li class="line">|</li>
                <li>我的订单</li>
                <li class="line">|</li>
                <li>客户服务</li>
                <?php if($_SESSION['memid']): ?><li></li><?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!-- 头部 start -->
<div class="header w1210 bc mt15">
    <!-- 头部上半部分 start 包括 logo、搜索、用户中心和购物车结算 -->
    <div class="logo w1210">
        <h1 class="fl"><a href="index.html"><img src="/Public/Home/images/logo.png" alt="京西商城"></a></h1>
        <!-- 头部搜索 start -->
        <div class="search fl">
            <div class="search_form">
                <div class="form_left fl"></div>
                <form action="<?php echo U('search');?>" name="serarch" method="get" class="fl">
                    <input name="name" type="text" class="txt" value="请输入商品关键字" /><input type="submit" class="btn" value="搜索" />
                </form>
                <div class="form_right fl"></div>
            </div>

            <div style="clear:both;"></div>

            <div class="hot_search">
                <strong>热门搜索:</strong>
                <a href="">D-Link无线路由</a>
                <a href="">休闲男鞋</a>
                <a href="">TCL空调</a>
                <a href="">耐克篮球鞋</a>
            </div>
        </div>
        <!-- 头部搜索 end -->

        <!-- 用户中心 start-->
        <div class="user fl">
            <dl>
                <dt>
                    <em></em>
                    <a href="">用户中心</a>
                    <b></b>
                </dt>
                <dd>
                    <div class="prompt">
                        您好，请<a href="">登录</a>
                    </div>
                    <div class="uclist mt10">
                        <ul class="list1 fl">
                            <li><a href="">用户信息></a></li>
                            <li><a href="<?php echo U('Order/order');?>">我的订单></a></li>
                            <li><a href="">收货地址></a></li>
                            <li><a href="">我的收藏></a></li>
                        </ul>

                        <ul class="fl">
                            <li><a href="">我的留言></a></li>
                            <li><a href="">我的红包></a></li>
                            <li><a href="">我的评论></a></li>
                            <li><a href="">资金管理></a></li>
                        </ul>

                    </div>
                    <div style="clear:both;"></div>
                    <div class="viewlist mt10">
                        <h3>最近浏览的商品：</h3>
                        <ul>
                            <li><a href=""><img src="/Public/Home/images/view_list1.jpg" alt="" /></a></li>
                            <li><a href=""><img src="/Public/Home/images/view_list2.jpg" alt="" /></a></li>
                            <li><a href=""><img src="/Public/Home/images/view_list3.jpg" alt="" /></a></li>
                        </ul>
                    </div>
                </dd>
            </dl>
        </div>
        <!-- 用户中心 end-->

        <!-- 购物车 start -->
        <div class="cart fl">
            <dl>
                <dt>
                    <a href="<?php echo U('Cart/flow','goods_id='.$goods_info[goods_id]);?>">去购物车结算</a>
                    <b></b>
                </dt>
                <dd>
                    <div class="prompt">
                        <?php if(!isset($cart_list)): ?>购物车中还没有商品，赶紧选购吧！
                        <?php else: ?>
                        <?php if(!empty($cart_list)): ?>您的购物车有:
                            <?php if(is_array($cart_list)): foreach($cart_list as $key=>$v): ?><span><font color="red"><?php echo ($v["goods_name"]); ?>&nbsp;&nbsp;&nbsp;</font></span><?php endforeach; endif; ?>
                            <?php else: ?>
                            购物车中还没有商品，赶紧选购吧！<?php endif; endif; ?>
                    </div>
                </dd>
            </dl>
        </div>
        <!-- 购物车 end -->
    </div>
    <!-- 头部上半部分 end -->

    <div style="clear:both;"></div>

    <!-- 导航条部分 start -->
    <div class="nav w1210 bc mt10">
        <!--  商品分类部分 start-->
            <?php if($ac == 'Index-index' ): ?><div class="category fl"> <!-- 非首页，需要添加cat1类 -->
                <div class="cat_hd">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
                <h2>全部商品分类</h2>
                <em></em>
            </div>
            <?php else: ?>
                <div class="category fl cat1"> <!-- 非首页，需要添加cat1类 -->
                <div class="cat_hd off">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，并将cat_bd设置为不显示，鼠标滑过时展开菜单则将off类换成on类 -->
                    <h2>全部商品分类</h2>
                    <em></em>
                </div><?php endif; ?>
            <?php if($ac == 'Index-index' ): ?><div class="cat_bd">
            <?php else: ?>
                <div class="cat_bd none"><?php endif; ?>
                <?php if(is_array($cateA)): foreach($cateA as $key=>$value): ?><div class="cat item1">
                    <h3><a href="<?php echo U('getGoodsByCateid','cate_id='.$value[cate_id].'&level='.$value[level]);?>"><?php echo ($value[cate_name]); ?></a> <b></b></h3>
                    <?php if($ac == 'Index-index' ): ?><div class="cat_detail">
                        <?php else: ?>
                        <div class="cat_detail none"><?php endif; ?>
                    <?php if(is_array($cateB)): foreach($cateB as $key=>$vo): if($vo["cate_pid"] == $value["cate_id"] ): ?><dl class="dl_1st">
                            <dt><a href="<?php echo U('getGoodsByCateid','cate_id='.$vo[cate_id].'&level='.$vo[level]);?>"><?php echo ($vo["cate_name"]); ?></a></dt>
                            <dd>
                                <?php if(is_array($cateC)): foreach($cateC as $key=>$v): if($v["cate_pid"] == $vo["cate_id"] ): ?><a href="<?php echo U('getGoodsByCateid','cate_id='.$v[cate_id].'&level='.$v[level]);?>"><?php echo ($v["cate_name"]); ?></a><?php endif; endforeach; endif; ?>
                            </dd>
                        </dl><?php endif; endforeach; endif; ?>
                    </div>
                </div><?php endforeach; endif; ?>
            </div>

        </div>
        <!--  商品分类部分 end-->

        <div class="navitems fl">
            <ul class="fl">
                <li class="current"><a href="">首页</a></li>
                <li><a href="">电脑频道</a></li>
                <li><a href="">家用电器</a></li>
                <li><a href="">品牌大全</a></li>
                <li><a href="">团购</a></li>
                <li><a href="">积分商城</a></li>
                <li><a href="">夺宝奇兵</a></li>
            </ul>
            <div class="right_corner fl"></div>
        </div>
    </div>
    <!-- 导航条部分 end -->
</div>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>填写核对订单信息</title>
	<link rel="stylesheet" href="/Public/Home/style/base.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/global.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/header.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/fillin.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/footer.css" type="text/css">

	<script type="text/javascript" src="/Public/Home/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="/Public/Home/js/cart2.js"></script>

</head>
<body>
<!-- 顶部导航 start -->
<div class="topnav">
	<div class="topnav_bd w990 bc">
		<div class="topnav_left">

		</div>
		<div class="topnav_right fr">
			<ul>
				<li>您好，欢迎来到京西！[<a href="login.html">登录</a>] [<a href="register.html">免费注册</a>] </li>
				<li class="line">|</li>
				<li>我的订单</li>
				<li class="line">|</li>
				<li>客户服务</li>

			</ul>
		</div>
	</div>
</div>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!-- 页面头部 start -->
<div class="header w990 bc mt15">
	<div class="logo w990">
		<h2 class="fl"><a href="index.html"><img src="/Public/Home/images/logo.png" alt="京西商城"></a></h2>
		<div class="flow fr flow2">
			<ul>
				<li>1.我的购物车</li>
				<li class="cur">2.填写核对订单信息</li>
				<li>3.成功提交订单</li>
			</ul>
		</div>
	</div>
</div>
<!-- 页面头部 end -->

<div style="clear:both;"></div>
	<!-- 主体部分 start -->
<form action="<?php echo U('flow3');?>" method="post">
	<div class="fillin w990 bc mt15">
		<div class="fillin_hd">
			<h2>填写并核对订单信息</h2>
		</div>

		<div class="fillin_bd">
			<!-- 收货人信息  start-->
			<div class="address">
				<h3>收货人信息 </h3>
				<div class="address_info">
					<p><input type="radio" name="order_cgnid" value="1" checked="checked" />猥琐的刘老师 北京市 昌平区 建材城西路金燕龙办公楼一层 13555555555</p>
					<p><input type="radio" name="order_cgnid" value="2"  />猥琐的刘老师 湖北省 武汉市  武昌 关山光谷软件园1号201 13333333333 </p>
				</div>


			</div>
			<!-- 收货人信息  end-->

			<!-- 配送方式 start -->
			<div class="delivery">
				<h3>送货方式 </h3>
				<div class="delivery_info">
					<p><input type="radio" name="order_shfs" value="顺丰" checked="checked" />顺丰</p>
					<p><input type="radio" name="order_shfs" value="中通" />中通</p>
					<p><input type="radio" name="order_shfs" value="韵达" />韵达</p>
				</div>


			</div>
			<!-- 配送方式 end -->

			<!-- 支付方式  start-->
			<div class="pay">
				<h3>支付方式 </h3>
				<div class="pay_info">
					<table>
						<tr class="cur">
							<td class="col1"><input type="radio" name="order_pay" value="支付宝" checked="checked" />支付宝</td>
							<td class="col2">阿里集团的在线支付方式</td>
						</tr>
						<tr>
							<td class="col1"><input type="radio" name="order_pay" value="微信支付" />微信支付</td>
							<td class="col2">腾讯极端的在线支付方式</td>
						</tr>
						<tr>
							<td class="col1"><input type="radio" name="order_pay" value="银行卡" />银行卡</td>
							<td class="col2">使用银联卡支付</td>
						</tr>
					</table>
				</div>


			</div>
			<!-- 支付方式  end-->

			<!-- 发票信息 start-->
			<div class="receipt">
				<h3>发票信息 <a href="javascript:;" id="receipt_modify">[修改]</a></h3>
				<div class="receipt_info">
					<p>个人发票</p>
					<p>内容：明细</p>
				</div>

				<div class="receipt_select none">

					<ul>
						<li>
							<label for="">发票抬头：</label>
							<input type="radio" name="order_fp_type" value="个人" checked="checked" class="personal" />个人
							<input type="radio" name="order_fp_type" value="单位" class="company"/>单位
							<input type="text" name="order_fp_company" class="txt company_input" disabled="disabled" />
						</li>
						<li>
							<label for="">发票内容：</label>
							<input type="radio" name="order_fp_content" value="明细" checked="checked" />明细
							<input type="radio" name="order_fp_content" value="办公用品" />办公用品
							<input type="radio" name="order_fp_content" value="体育休闲" />体育休闲
							<input type="radio" name="order_fp_content" value="耗材" />耗材
						</li>
					</ul>

				</div>
			</div>
			<!-- 发票信息 end-->

			<!-- 商品清单 start -->
			<div class="goods">
				<h3>商品清单</h3>
				<table>
					<thead>
					<tr>
						<th class="col1">商品</th>
						<th class="col2">规格</th>
						<th class="col3">价格</th>
						<th class="col4">数量</th>
						<th class="col5">小计</th>
					</tr>
					</thead>
					<tbody>
					<?php if(is_array($cart_list)): foreach($cart_list as $key=>$vo): ?><tr>
							<td class="col1"><a href=""><img src="<?php echo (ltrim($vo["goods_small_logo"],'.')); ?>" alt="" /></a>  <strong><a href=""><?php echo ($vo["goods_name"]); ?></a></strong></td>
							<td class="col2"> <p><?php echo ($vo["cart_attr"]); ?></p> </td>
							<td class="col3">￥<?php echo ($vo["goods_price"]); ?></td>
							<td class="col4"> <?php echo ($vo["cart_num"]); ?></td>
							<td class="col5"><span>￥<?php echo ($vo["total_price"]); ?></span></td>
						</tr><?php endforeach; endif; ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5">
								<ul>
									<li>
										<span><?php echo ($pn["number"]); ?> 件商品，总商品金额：</span>
										<em>￥<?php echo ($pn["price"]); ?></em>
									</li>
									<li>
										<span>返现：</span>
										<em>-￥240.00</em>
									</li>
									<li>
										<span>运费：</span>
										<em>￥10.00</em>
									</li>
									<li>
										<span>应付总额：</span>
										<em>￥<?php echo ($pn["price"]); ?></em>
									</li>
								</ul>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<!-- 商品清单 end -->
		
		</div>

		<div class="fillin_ft">
			<a href="javascript:;" id='submit'><span>提交订单</span></a>
			<p>应付总额：<strong>￥<?php echo ($pn["price"]); ?></strong></p>
		</div>
</form>
	<!-- 主体部分 end -->

	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
	<div class="footer w1210 bc mt15">
		<p class="links">
			<a href="">关于我们</a> |
			<a href="">联系我们</a> |
			<a href="">人才招聘</a> |
			<a href="">商家入驻</a> |
			<a href="">千寻网</a> |
			<a href="">奢侈品网</a> |
			<a href="">广告服务</a> |
			<a href="">移动终端</a> |
			<a href="">友情链接</a> |
			<a href="">销售联盟</a> |
			<a href="">京西论坛</a>
		</p>
		<p class="copyright">
			 © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号 
		</p>
		<p class="auth">
			<a href=""><img src="/Public/Home/images/xin.png" alt="" /></a>
			<a href=""><img src="/Public/Home/images/kexin.jpg" alt="" /></a>
			<a href=""><img src="/Public/Home/images/police.jpg" alt="" /></a>
			<a href=""><img src="/Public/Home/images/beian.gif" alt="" /></a>
		</p>
	</div>
	<!-- 底部版权 end -->
</body>
</html>
<script>
	$('#submit').click(function(){
		$('form').submit();
	})
</script>
<!-- 底部导航 start -->
<div class="bottomnav w1210 bc mt10">
    <div class="bnav1">
        <h3><b></b> <em>购物指南</em></h3>
        <ul>
            <li><a href="">购物流程</a></li>
            <li><a href="">会员介绍</a></li>
            <li><a href="">团购/机票/充值/点卡</a></li>
            <li><a href="">常见问题</a></li>
            <li><a href="">大家电</a></li>
            <li><a href="">联系客服</a></li>
        </ul>
    </div>

    <div class="bnav2">
        <h3><b></b> <em>配送方式</em></h3>
        <ul>
            <li><a href="">上门自提</a></li>
            <li><a href="">快速运输</a></li>
            <li><a href="">特快专递（EMS）</a></li>
            <li><a href="">如何送礼</a></li>
            <li><a href="">海外购物</a></li>
        </ul>
    </div>


    <div class="bnav3">
        <h3><b></b> <em>支付方式</em></h3>
        <ul>
            <li><a href="">货到付款</a></li>
            <li><a href="">在线支付</a></li>
            <li><a href="">分期付款</a></li>
            <li><a href="">邮局汇款</a></li>
            <li><a href="">公司转账</a></li>
        </ul>
    </div>

    <div class="bnav4">
        <h3><b></b> <em>售后服务</em></h3>
        <ul>
            <li><a href="">退换货政策</a></li>
            <li><a href="">退换货流程</a></li>
            <li><a href="">价格保护</a></li>
            <li><a href="">退款说明</a></li>
            <li><a href="">返修/退换货</a></li>
            <li><a href="">退款申请</a></li>
        </ul>
    </div>

    <div class="bnav5">
        <h3><b></b> <em>特色服务</em></h3>
        <ul>
            <li><a href="">夺宝岛</a></li>
            <li><a href="">DIY装机</a></li>
            <li><a href="">延保服务</a></li>
            <li><a href="">家电下乡</a></li>
            <li><a href="">京东礼品卡</a></li>
            <li><a href="">能效补贴</a></li>
        </ul>
    </div>
</div>
<!-- 底部导航 end -->

<div style="clear:both;"></div>
<!-- 底部版权 start -->
<div class="footer w1210 bc mt10">
    <p class="links">
        <a href="">关于我们</a> |
        <a href="">联系我们</a> |
        <a href="">人才招聘</a> |
        <a href="">商家入驻</a> |
        <a href="">千寻网</a> |
        <a href="">奢侈品网</a> |
        <a href="">广告服务</a> |
        <a href="">移动终端</a> |
        <a href="">友情链接</a> |
        <a href="">销售联盟</a> |
        <a href="">京西论坛</a>
    </p>
    <p class="copyright">
        © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号
    </p>
    <p class="auth">
        <a href=""><img src="/Public/Home/images/xin.png" alt="" /></a>
        <a href=""><img src="/Public/Home/images/kexin.jpg" alt="" /></a>
        <a href=""><img src="/Public/Home/images/police.jpg" alt="" /></a>
        <a href=""><img src="/Public/Home/images/beian.gif" alt="" /></a>
    </p>
</div>
<!-- 底部版权 end -->

</body>
</html>