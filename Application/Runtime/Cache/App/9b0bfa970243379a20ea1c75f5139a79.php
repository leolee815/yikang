<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <title>关于我们</title>
    <meta charset="utf-8" />
    <!--页面优化-->
    <meta name="MobileOptimized" content="320">
    <!--默认宽度320-->
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
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

    <style type="text/css" src="/Public/App/css/style.css"></style>

    <script type="text/javascript" src="/Public/App/js/zepto.min.js"></script>
    <style type="text/css">
    #map {
        width: 100%;
        height: 300px;
    }
    #track {
    	display:block;
        font-size: 0.8em;
        text-align: center;
        padding-top: 0.2em;
        padding-bottom: 0.2em;
        border-radius:20px 20px 0px 0px;
        background-color: rgb(90,178,226);
    }
    #track p,a{
        color: red;
    }
    #contract {
    	display:block;
        font-size: 0.8em;
        text-align: center;
        padding-top: 0.2em;
        padding-bottom: 0.2em;
        border-radius:0px 0px 20px 20px;
        background-color: rgb(90,178,226);
    }
    #contract p,a{
        color: red;
    }
    </style>
</head>

<body>
    <div id="content">
        <?php echo (htmlspecialchars_decode($shop["content"])); ?>
    </div>
    <div id="contract">
        <p><a href="tel:<?php echo ($shop["phone"]); ?>">联系我们：<?php echo ($shop["name"]); ?></a></p>
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