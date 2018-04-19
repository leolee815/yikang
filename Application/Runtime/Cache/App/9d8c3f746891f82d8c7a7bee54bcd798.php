<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
	<head>
		<title>分销商登录页面</title>
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
		<script type="text/javascript" src="/Public/App/js/jquery-2.1.4.js"></script>
		<script type="text/javascript" src="/Public/App/js/jquery-weui.min.js"></script>
	</head>
	<body>
		<div class="weui-cells weui-cells_form">
			<div class="weui-cell">
			    <div class="weui-cell__hd"><label class="weui-label">手机号码</label></div>
			    <div class="weui-cell__bd">
			      <input id="mobile" class="weui-input" type="tel" placeholder="请输入手机号码" value="">
			  </div>
			</div>
			<div class="weui-cell">
			    <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
			    <div class="weui-cell__bd">
			      <input id="password" class="weui-input" type="password" placeholder="请输入密码" value="">
			  </div>
			</div>
		</div>
		<div class="weui-btn-area">
	      	<a class="weui-btn weui-btn_primary" href="javascript:" id="login_btn">登录</a>
	    </div>
	    <script>
			$('#login_btn').click(function(){
				var mobile = $('#mobile').val();
				var password = $('#password').val();
				var re = /^(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])\d{8}$/;
				if(mobile==''){
					$.toptip('请输入手机号码', 'error');
					return false;
				}
				if (re.test(mobile)==false) {
					$.toptip('手机号码格式不正确', 'error');
					return false;
				}
				if (password=='') {
					$.toptip('请输入密码', 'error');
					return false;
				}
			    $.ajax({
					type:'post',
					data:{'mobile':mobile,'password':password},
					url:"<?php echo U('Dc/login');?>",
					dataType:'json',
					success:function(e){
						if(e.status == 1){
							$.toast(e.info,function(){
								window.location.href= "<?php echo U('App/Dc/index');?>";
							});
						}else{
							$.toast(e.info, "forbidden");
							return false;
						}
					},
					error:function(){
					    $.toast("通讯失败！", "forbidden");
						return false;
					}
				});	
			});
		</script>
		<script type="text/javascript" src="/Public/App/js/fastclick.js"></script>
		<script type="text/javascript">
		 $(function() {
			  FastClick.attach(document.body);
		 });
		</script>
	</body>
</html>