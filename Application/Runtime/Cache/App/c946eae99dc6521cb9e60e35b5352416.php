<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <title>订单确认</title>
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
	    <!--组件依赖js begin-->
	    <script src="/Public/App/js/zepto.min.js"></script>
	    <!--组件依赖js end-->		
		<script type="text/javascript" src="/Public/App/gmu/gmu.min.js"></script>
        <script type="text/javascript" src="/Public/App/gmu/app-basegmu.js"></script>
    

</head>
<body class="back1 color6">
		<form action="" method="post" id="orderform">
		<div class="ads-hd back2 ovflw">
			<input type="hidden" name="sid" value="<?php echo ($sid); ?>">
			<input type="hidden" name="paytype" value="wxpay" id="paytype">
			<input type="hidden" name="vipid" value="<?php echo ($_SESSION['WAP']['vip']['id']); ?>" id="ordervip">
			<input type="hidden" name="vipopenid" value="<?php echo ($_SESSION['WAP']['vip']['openid']); ?>">
			<!--<input type="hidden" name="vipxqid" value="<?php echo ($vip["xqid"]); ?>">
			<input type="hidden" name="vipxqname" value="<?php echo ($vip["xqname"]); ?>">-->
			<input type="hidden" name="totalnum" value="<?php echo ($totalnum); ?>">
			<input type="hidden" name="totalprice" value="<?php echo ($totalprice); ?>">
			<textarea name="items" style="display: none;"><?php echo ($allitems); ?></textarea>
		</div>
		<!-- 商品明细  -->
		<div class="ads-lst border-t1 border-b1 ovflw mr-b back2">
			<p class="ads-tt border-b1">商品明细</p>
			<?php if(is_array($cache)): foreach($cache as $key=>$vo): ?><div class="ads_orinfo ads_padding3 ovflw border-b1">
						<div class="ads_orinfol ovflw fl">
							<div class="ads_or_img fl">
								<!-- 图片大小为147*101 -->
								<img src="<?php echo ($vo["pic"]); ?>"/>
							</div>
							<h3><?php echo ($vo["name"]); ?></h3>
							<p class="color3 fonts2"><?php echo ($vo["skuattr"]); ?></p>
						</div>
						<div class="ads_orprice ovflw ">
							<p ><em class="fonts85">￥</em><em class="fonts18"><?php echo ($vo["price"]); ?></em></p>
							<p class="ads_ornum fonts85">X<?php echo ($vo["num"]); ?></p>
						</div>
					</div><?php endforeach; endif; ?>
			<p class="border-b1 ads_ortt3 fonts85">&nbsp;邮费政策：<?php if(($isyf) == "1"): if(($yf) == "0"): ?>全场包邮<?php else: ?>全场定邮<?php echo ($yf); ?>元，订单满<?php echo ($yftop); ?>元包邮。<?php endif; else: ?>全场包邮<?php endif; ?></p>
			<p class="border-b1 ads_ortt3 fonts85 ads"><input type="text" name="msg" class="ads_orinput" placeholder="给卖家留言"/></p>
			<p class=" ads_ortt3 fonts85 ovflw"><span class="fr ">共<?php echo ($totalnum); ?>件商品&nbsp;&nbsp;&nbsp;&nbsp;商品：<em class="fonts18 color3">￥<b class="totalprice"><?php echo ($totalprice); ?></b></em>&nbsp;&nbsp;&nbsp;&nbsp;邮费：<em class="fonts18 color3">￥<b><?php echo ($yf); ?></b></em></span></p>
		</div>
		<!-- 支付方式 -->
		<div class="ads-lst border-t1 border-b1 ovflw mr-b back2">
			<p class="ads-tt border-b1">支付方式</p>
					<div class="ads_pay ovflw" data-paytype = "wxpay" data-disable="0">
						<span class="iconfont fl ads_pay_lineh dtl_mar1" style="color:#ff3000;">&#xe656</span>
						<div class="ads_orimg fl dtl_mar1">
							<img src="/Public/App/img/wxpay.jpg" />
						</div>
						<p class="ads_pay_lineh">微信安全支付</p>
					</div>
		</div>
		<div class="ads-lst border-t1 border-b1 ovflw mr-b back2">
			<p class="ads-tt border-b1">收货地址</p>
			<div class="add-ads back2">
				<ul class="add-ul">
					<li class="border-b1 ovflw"><span class="fl">地址详情</span><input type="text" name="vipaddress" value="<?php echo ($vip["address"]); ?>" id="address" placeholder='请务必填写完整的省市区'></li>
					<li class="border-b1 ovflw"><span class="fl">收货人</span><input type="text" name="vipname" value="<?php echo ($vip["name"]); ?>" id="name"></li>
					<li class="ovflw"><span class="fl">手机号码</span><input type="text" name="vipmobile" value="<?php echo ($vip["mobile"]); ?>" id="mobile"></li>
				</ul>			
			</div>
		</div>
		</form>
		<div class="insert1"></div>
		<div class="dtl-ft ovflw">
				<div class=" fl dtl-icon dtl-bck ovflw">
					<a href="<?php echo ($basketurl); ?>">
						<i class="iconfont">&#xe679</i>
					</a>
				</div>
				<a href="#" class="fr ads-btn fonts9 back3" id="orderconfirm">确认</a>
				<span class="fr ads-sum"><em class="fonts9">商品:</em><em class="fonts1">￥<b class="totalprice"><?php echo ($totalprice); ?></b></em>&nbsp;&nbsp;&nbsp;&nbsp;邮费:<em class="fonts18 color3">￥<b><?php echo ($yf); ?></b></em></span>
		</div>
		<script type="text/javascript">
			var sid="<?php echo ($sid); ?>";
			var lasturlencode="<?php echo ($lasturlencode); ?>";
			var paytype=$('#paytype');
			$('#changeaddress').on('click',function(){
				var tourl="<?php echo U('App/Shop/orderAddress',array('sid'=>$sid,'lasturl'=>$lasturlencode));?>";
				window.location.href=tourl;
			});
			$('.ads_pay').click(function(){
				var isdis=$(this).data('disable');
				if(isdis==0){
					var sp=$('.ads_pay span');
					$(sp).css('color',' #cfcfcf');
					$(this).find('span').css('color',' #ff3000');
					$(paytype).val($(this).data('paytype'));
				}else{
					App_gmuMsg('请使用其它方式！');
				}
			});
			$('#orderconfirm').on('click',function(){
				/*
				if(!$('#ordervip').val()){
					App_gmuMsg('请选择收货地址！');
					return false;
				}*/
				if(!$('#paytype').val()){
					App_gmuMsg('请选择支付方式！');
					return false;
				}
				if(!$('#address').val()){
					App_gmuMsg('请填写收货地址！');
					return false;
				}
				if(!$('#name').val()){
					App_gmuMsg('请填写收货人姓名！');
					return false;
				}
				var mobile=$('#mobile').val();
				if(!mobile){
					App_gmuMsg('请填写手机号码！');
					return false;
				}
				var re = /^1\d{10}$/;
				if (re.test(mobile)==false) {
					App_gmuMsg("手机号码格式不正确！");
					return false;
				}
				var okfun=function(){$('#orderform').submit();}
				okfun();				
			});
		</script>
		<!--通用分享-->
		<script type="text/javascript">
	function onBridgeReady(){
 		WeixinJSBridge.call('hideOptionMenu');
	}

	if (typeof WeixinJSBridge == "undefined"){
	    if( document.addEventListener ){
	        document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
	    }else if (document.attachEvent){
	        document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
	        document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
	    }
	}else{
	    onBridgeReady();
	}	
</script>

	</body>
</html>