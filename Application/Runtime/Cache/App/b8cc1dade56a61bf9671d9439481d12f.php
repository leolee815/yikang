<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <title>地址管理</title>
    <meta charset="utf-8" />
    <!--页面优化-->
    <meta name="MobileOptimized" content="320">
    <!--默认宽度320-->
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
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
</head>

<body class="back1">
    <div class="ovflw back2">
        <ul class="achos-ul ovflw">
            <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="ovflw border-b1">
                    <a href="<?php echo U('App/Vip/addressSet',array('id'=>$vo['id']));?>" class="ovflw vipaddress" data-id="<?php echo ($vo["id"]); ?>">
                        <h3 class="ads-h3"><?php echo ($vo["name"]); ?>&nbsp;&nbsp;<?php echo ($vo["mobile"]); ?><span style="float:right;border:1px solid red;color:white;border-radius:3px;background-color:red;padding: 2px 15px;margin:0 5px;"><i class="iconfont">&#xe645</i>选择</span></h3>
                        <p class="ads-p"><?php echo ($vo["address"]); ?></p>
                    </a>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
    <div class="insert1"></div>
    <div class="dtl-ft ovflw">
        <div class=" fl dtl-icon dtl-bck ovflw">
            <a href="<?php echo U('App/Vip/index');?>" id="addressback">
                <i class="iconfont">&#xe679</i>
            </a>
        </div>
        <a href="<?php echo U('App/Vip/addressSet');?>" class="fr ads-btn fonts9 back3">新增地址</a>
    </div>
    <script type="text/javascript">
    //拦截选择地址
    var vipaddress = $('.vipaddress');
    var addressback = $('#addressback');
    var orderurl = "<?php echo ($_SESSION['WAP']['orderURL']); ?>";
    $(vipaddress).on('click', function() {
        var id = $(this).data('id');
        if (orderurl) {
            var tourl = orderurl + '/vipadd/' + id;
            window.location.href = tourl;
            return false;
        }
    });
    //拦截地址返回
    $(addressback).on('click', function() {
        if (orderurl) {
            var tourl = orderurl;
            window.location.href = tourl;
            return false;
        }
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