<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
	<head>
		<title>分销商绑定页面</title>
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
		<link rel="stylesheet" href="/Public/App/css/style.css" />
		<script type="text/javascript" src="/Public/App/js/zepto.min.js"></script>
        <script type="text/javascript" src="/Public/App/gmu/gmu.min.js"></script>
        <script type="text/javascript" src="/Public/App/gmu/app-basegmu.js"></script>
        <style type="text/css">
         .qrcode h2{background-color: #008cd6;line-height: 44px;color: #FFFFFF;text-align:center;margin-bottom:10px;}
         .qrcode img{display: block;max-width:128px;margin:0 auto;}
        </style>
	</head>
	<body class="reg">
		<div class="reg-hd" style="margin-top: 32px;"></div>
		<div class="reg-c">
			<div class="reg-frm">
				<div class="reg-input">
					<span class="icons iconfont fl">&#xe6c3</span>
					<input type="text" class="inputs fl" placeholder="预设用户ID" id="vipid"/>
				</div>
				<div class="reg-input">
					<span class="icons iconfont fl">&#xe652</span>
					<input type="tel" class="inputs fl" placeholder="手机号码" id="mobile"/>
				</div>
			</div>
			<a href="javascript:void(0)" class="reg-btn text-c">马上绑定</a>
		</div>
		<div class="qrcode" style="display:none;">
			<h2>您的专属推广二维码</h2>
			<img src="/Public/Admin/img/loading.gif">
			<!-- <img src="/QRcode/promotion/employeeowv5gs2oqwHPz1UCXLm84MYsrGMs.jpg"> -->
		</div>
	</body>
</html>
<script>
    $('.reg-btn').click(function(){
    	var vipid = $('#vipid').val();
		var mobile = $('#mobile').val();
		var re = /^1\d{10}$/;
		if (re.test(mobile)==false) {
			zbb_msg("手机号不正确！");
			return;
		}
		if (vipid=='') {
			zbb_msg("请输入预设用户ID！");
			return;
		}
	    $.ajax({
			type:'post',
			data:{'vipid':vipid,'mobile':mobile},
			url:"<?php echo U('demo/reg');?>",
			dataType:'json',
			success:function(e){
				if(e.status == 1){
					zbb_alert(e.msg,function(){
						//$(".reg-hd").hide();
						//$(".reg-c").hide();
						//$(".qrcode").show();
						//$(".qrcode img").css('max-width','100%');
						//$(".qrcode img").attr("src",e.qrcode);
						this.close();
						window.location.href="<?php echo U('/App/Shop/index');?>";
					});
				}else{
					zbb_alert(e.msg);
					return false;
				}
				
			},
			error:function(){
			    zbb_alert('通讯失败！');
				return false;
			}
		});	
		return false;
	});
</script>