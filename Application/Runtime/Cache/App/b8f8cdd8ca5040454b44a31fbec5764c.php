<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<title>申请提现</title>
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
        <style>
            .viptx-btn {
                background: #ccc;
                color: #FFFFFF;
                line-height: 20px;
                padding: 6px 15px;
                border-radius: 3px;
                margin: 3px;    
                text-align: center;
				font-size:14px;
            }
            .wx-btn{background: red;}
        </style>
	</head>
	<body class="back1">
		<form action="" method="post" id="AppForm">
		<p class="add-hd color6">申请提现</p>
		<p class="add-hd color6">您的余额：<span id='txvm' class="color3"><?php echo ($vip["money"]); ?></span>&nbsp;元</p>
		<p class="add-hd color6">每笔至少提现：<span id='txtop' class="color3"><?php echo ($_SESSION['WAP']['vipset']['tx_money']); ?></span>元&nbsp;</p>
		<p class="add-hd color6 weixin">每笔最多提现：<span id="txtop" class="color3">200</span>元&nbsp;(微信红包限制)</p>

        <p class="add-hd color6">提现方式：
            <span class="wx-btn viptx-btn" style="background: red;">微信提现</span>
            <span class="yh-btn viptx-btn" style="background: rgb(204, 204, 204);">银行提现</span>
        </p>
		<div class="add-ads back2">
			<ul class="add-uls">
			    <li class="border-b1 ovflw"><span class="fl">提现金额</span><input type="text" name="txprice" value="<?php echo ($_SESSION['vipset']['tx_money']); ?>" placeholder="请输入提现金额" id="txprice"></li>
                <li class="border-b1 ovflw"><span class="fl">姓名</span><input type="text" name="txname" value="<?php echo ($vip["txname"]); ?>" placeholder="请输入姓名" id="txname"></li>
                <li class="border-b1 ovflw"><span class="fl">电话</span><input type="text" name="txmobile" value="<?php echo ($vip["txmobile"]); ?>" placeholder="请输入联系电话" id="txmobile"></li>
			    
				<li class="border-b1 ovflw yinhang" style="display: none;">
				    <span class="fl">开户银行</span><input type="text" name="txyh" value="<?php echo ($vip["txyh"]); ?>" placeholder="如“中国工商银行”"  id="txyh"/>
				</li>
				<li class="border-b1 ovflw yinhang" style="display: none;">
				    <span class="fl">所属分行</span><input type="text" name="txfh" value="<?php echo ($vip["txfh"]); ?>" placeholder="如“广州黄埔支行”"  id="txfh"/>
				</li>
				<li class="border-b1 ovflw yinhang" style="display: none;">
				    <span class="fl">开户行所在地</span><input type="text" name="txszd" value="<?php echo ($vip["txszd"]); ?>" placeholder="如“广东省，广州市”"  id="txszd"/>
				</li>
				<li class="border-b1 ovflw yinhang" style="display: none;">
				    <span class="fl">银行卡号</span><input type="text" name="txcard" value="<?php echo ($vip["txcard"]); ?>" placeholder="请输入银行卡号"  id="txcard"/>
				</li>
			</ul>			
		</div>
		    <p class="add-tips color3 fonts2 zx">微信提现：把提现的金额发“现金红包”给您！(推荐)</p>
            <p class="add-tips color3 fonts2 zx">银行提现：请在“个人中心”绑定提现资料，完善银行信息！</p>
		</form>
		<div class="insert1"></div>
		<div class="dtl-ft ovflw">
				<div class=" fl dtl-icon dtl-bck ovflw">
					<a href="<?php echo U('App/Vip/index');?>">
						<i class="iconfont">&#xe679</i>
					</a>
				</div>
				<a href="#" class="fr ads-btn fonts9 back3">保存</a>
		</div>
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
<script>
	$('.ads-btn').click(function(){
		var txvm=Number($('#txvm').html());
		var txtop=Number($('#txtop').html());
		var txprice=Number($('#txprice').val());
		if(!txprice){
			App_gmuMsg('请填写提现金额！');
			return false;
		}
		if(txprice>txvm){
			App_gmuMsg('提现金额不能大于会员帐户余额！');
			return false;
		}
		if(txprice<txtop){
			App_gmuMsg('提现金额不能小于最低提现金额！');
			return false;
		}
		if (txprice>200) {
            App_gmuMsg('提现金额不可超过200元');
            return false;
        }
		if(!$('#txname').val()){
			App_gmuMsg('请填写提现姓名！');
			return false;
		}
		if(!$('#txmobile').val()){
			App_gmuMsg('请填写提现手机！');
			return false;
		}
// 		if(!$('#txyh').val()){
// 			App_gmuMsg('请填写开户银行！');
// 			return false;
// 		}
// 		if(!$('#txfh').val()){
// 			App_gmuMsg('请填写开户银行分行！没有请填写总行!');
// 			return false;
// 		}
// 		if(!$('#txszd').val()){
// 			App_gmuMsg('请填写提现所在地！');
// 			return false;
// 		}
// 		if(!$('#txcard').val()){
// 			App_gmuMsg('请填写提现银行卡号！');
// 			return false;
// 		}
		$('#AppForm').submit();
	})
	$('.wx-btn').click(function(){
        $(this).css('background','red');
        $('.yh-btn').css('background','#ccc');
        $('.yinhang').hide();
        $('.weixin').show();
    });
    $('.yh-btn').click(function(){
        $(this).css('background','red');
        $('.wx-btn').css('background','#ccc');
        $('.yinhang').show();
        $('.weixin').hide();
    }); 
</script>