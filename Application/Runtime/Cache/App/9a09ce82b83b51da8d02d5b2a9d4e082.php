<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
	<head>
		<title>分销商中心</title>
	    <meta charset="utf-8" />
		<!--页面优化-->
		<meta name="MobileOptimized" content="320">
		<!--默认宽度320-->
		<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
		<!--viewport 等比 不缩放-->
		<meta http-equiv="cleartype" content="on">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<!--删除苹果菜单-->
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<!--默认颜色-->
		<meta name="apple-mobile-web-app-title" content="yes">
		<meta name="apple-touch-fullscreen" content="yes">
		<!--加载全部后 显示-->
		<meta content="telephone=no" name="format-detection" />
		<!--不识别电话-->
		<meta content="email=no" name="format-detection" />
		<link rel="stylesheet" href="/Public/App/css/weui.min.css" />
		<link rel="stylesheet" href="/Public/App/css/jquery-weui.min.css" />
		<link rel="stylesheet" href="/Public/App/css/dc.css" />
		<script type="text/javascript" src="/Public/App/js/jquery-2.1.4.js"></script>
		<script type="text/javascript" src="/Public/App/js/jquery-weui.min.js"></script>
	</head>
	<body>
	<div class="weui-tab">
			<div class="weui-navbar">
		         <div class="weui-navbar__item weui-bar__item_on">
		                <a href="<?php echo U('App/Dc/index');?>">我的业绩</a>
		         </div>
		         <div class="weui-navbar__item">
		                <a href="<?php echo U('App/Dc/subordinate');?>">下级会员</a>
		         </div>
		         <div class="weui-navbar__item">
		                <a href="<?php echo U('App/Dc/orderlist');?>">订单列表</a>
		         </div>
		</div> 
		<div class="weui-tab__bd">
        <div class="weui-tab__bd-item weui-tab__bd-item--active">
	      <div class="weui-cell welcome"><p>您好，<i class="color3"><?php if(($vip["name"]) != ""): echo ($vip["name"]); else: echo ($vip["mobile"]); endif; ?></i>，欢迎来到逸康商城分销商中心！</p></div>
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <p>下线人数</p>
            </div>
            <div class="weui-cell__ft"><?php echo ($vipCount); ?></div>
          </div>
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <p>下线订单数</p>
            </div>
            <div class="weui-cell__ft"><?php echo ($orderCount); ?></div>
          </div>
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <p>下线订单总额</p>
            </div>
            <div class="weui-cell__ft"><?php echo ($orderPrice); ?>元</div>
          </div>
          <div class="logout">
          	<a href="<?php echo U('App/Dc/logout');?>" class="weui-btn weui-btn_primary">安全退出</a>
          </div>
        </div>
      </div>
    </div>         
<script>

</script>
<script type="text/javascript" src="/Public/App/js/fastclick.js"></script>
<script type="text/javascript">
 $(function() {
	  FastClick.attach(document.body);
 });
</script>
	</body>
</html>