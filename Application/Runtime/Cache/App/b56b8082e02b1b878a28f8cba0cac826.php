<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

<head>
    <title><?php echo ($_SESSION['WAP']['shopset']['name']); ?></title>
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
    <link rel="stylesheet" href="/Public/App/css/style.css?v=20170503" />
    <!--组件依赖js begin-->
    <script src="/Public/App/js/zepto.min.js"></script>
    <script src="/Public/App/js/fx.js"></script>
    <script src="/Public/App/js/fx_methods.js"></script>
	
    <script type="text/javascript" src="/Public/App/gmu/iscroll.js"></script>
    <script type="text/javascript" src="/Public/App/gmu/gmu.min.js"></script>
    <script type="text/javascript" src="/Public/App/gmu/widget.js"></script>
    <script type="text/javascript" src="/Public/App/gmu/navigator.js"></script>
    <script type="text/javascript" src="/Public/App/gmu/scrollable.js"></script>
    <!--组件依赖js end-->
    <!--轮播js begin-->
    <script src="/Public/App/js/tool.js"></script>
    <script src="/Public/App/js/swipe.js"></script>
	
    <style>
    <style> .pp-follow {
        padding: 0.2em 0px;
        width: 100%;
        background: #e4dcd1;
        display: block;
    }
    
    .p-fopic {
        margin-left: 1%;
        float: left;
        width: 12.5%;
        border-radius: 3px;
        margin-top: 2%;
    }
    
    .p-focon {
        float: left;
        margin-left: 2%;
        width: 60%;
        color: #000000;
        font-size: 0.9em;
        line-height: 3.2em;
    }
    
    .p-fofo {
        margin-top: 1.5%;
        margin-left: 1%;
        float: left;
        width: 22.5%;
        color: #fff;
        font-size: 0.9em;
        text-align: center;
        line-height: 2.5em;
        background: #df0e11;
        border-radius: 0.3em;
    }
    
    .p-fofo a,
    .p-fofo a:visited {
        color: #fff;
        font-size: 0.9em;
        text-align: center;
        line-height: 2.5em;
    }
    
    .clear {
        clear: both;
    }
    
    .showImg-div {
        height: 160px;
    }
    
    .showImg {
        width: 100%;
        overflow: hidden;
    }
    
    #wrap {
        width: 100%
    }
    .secondNav{width: 100%;display: none;background: #99CCCC;}
    .secondNav ul{overflow: hidden;padding-top: 10px;}
    .secondNav ul li{float: left;margin-bottom: 10px;margin-left: 20px;text-align: center}
    .secondNav ul li p{margin-top: 5px}
    .secondNav ul li a:link{color: #fff}
    .secondNav ul li a:visited{color: #fff}
    </style>
</head>

<body class="index">
    <div id="tmpshare" style="display: none;">
        <img src="<?php echo ($_SESSION['WAP']['shopset']['sharepic']); ?>">
    </div>
    <div class="zbb_index">
        <header class="ui-banner">
            <div id="slider" class="swipe">
                <ul class="swipe-wrap">
                    <?php if(is_array($indexalbum)): foreach($indexalbum as $key=>$vo): ?><li>
                            <a href="<?php echo ($vo["url"]); ?>"><img src="<?php echo ($vo["imgurl"]); ?>"></a>
                        </li><?php endforeach; endif; ?>
                </ul>
                <div id="slider_on">
                    <ul>
                        <?php if(is_array($indexalbum)): foreach($indexalbum as $key=>$vo): ?><li></li><?php endforeach; endif; ?>
                    </ul>
                </div>
            </div>
        </header>
        <div class="index-lst">
            <div class="lst-tt"><span class="color11 lst-mr">扫描二维码</span>&nbsp;<span class="color2 fonts2"></span></div>
            <ul class="lst-ul">
            	<li><img src="/Upload/img/2016-08-18/57b51845130de.jpg" width="100%"></li>
            </ul>          
       	</div>
        <!-- 每日 -->
        <div class="index-lst">
        	<div class="lst-tt"><span class="color11 lst-mr">视频介绍</span></div>
           	<div class="video">
					<iframe frameborder="0" width="100%" height="200" src="http://v.qq.com/iframe/player.html?vid=p0012xllcv7&tiny=0&auto=0" allowfullscreen></iframe>
            </div>
         </div>
         <div class="index-lst">
        	<div class="lst-tt"><span class="color11 lst-mr">操作介绍</span></div>
           	<div class="video">
					<iframe frameborder="0" width="100%" height="200" src="http://v.qq.com/iframe/player.html?vid=a0322qzz7zj&tiny=0&auto=0" allowfullscreen></iframe>
            </div>
         </div>
         <?php if(is_array($group)): foreach($group as $key=>$vo): ?><div class="index-lst">
            <div class="lst-tt"><span class="color11 lst-mr"><?php echo ($vo["name"]); ?></span>&nbsp;<span class="color2 fonts2"><?php echo ($vo["summary"]); ?></span></div>
            <ul class="lst-ul">
            	<li><img src="<?php echo ($vo["indexpic"]); ?>" width="100%"></li>
            	<!-- 
                <?php if(is_array($mrtj)): $i = 0; $__LIST__ = $mrtj;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                        <a href="<?php echo U('App/Shop/goods',array('sid'=>0,'id'=>$vo['id'],'ppid'=>$_SESSION['WAP']['vipid']));?>"><img src="<?php echo ($vo["imgurl"]); ?>">
                            <p><span><?php echo ($vo["name"]); ?></span><span class="fr color3 "><em class="fonts2">￥</em><em class="fonts1"><?php echo ($vo["price"]); ?></em>&nbsp;<span class="plist-xp fonts3">￥<?php echo ($vo["oprice"]); ?></span></span>
                            </p>
                        </a>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                 -->
            </ul>          
       	</div><?php endforeach; endif; ?>
          <!-- 最新文章-->
	   <div class="topic-list">
	        <div class="lst-tt"><span class="color11 lst-mr">最新文章</span></div>
	        	<?php if(is_array($artical)): $i = 0; $__LIST__ = $artical;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="imgtext-h clearfix">
		              <a href="<?php echo U('App/Artical/index',array('id'=>$vo['id']));?>" class="img-left"><img alt="<?php echo ($vo["title"]); ?>" src="<?php echo ($vo["listpic"]["imgurl"]); ?>"></a>
		              <div class="text-right">
		                  <h3><a target="_blank" href="<?php echo U('App/Artical/index',array('id'=>$vo['id']));?>"><?php echo ($vo["title"]); ?></a></h3>
		                  <p class="date"><?php echo ($vo["time"]); ?></p>
		                  <p class="intro"><?php echo (msubstr($vo["sub"],0,18,'utf-8',true)); ?><a href="<?php echo U('App/Artical/index',array('id'=>$vo['id']));?>">阅读全文</a></p>
		              </div>
		         </div><?php endforeach; endif; else: echo "" ;endif; ?>
	       </div>
        <!-- 底部导航 -->
        		<div class="insert1"></div>
		<div class="ui-nav">
			<ul class="ui-navul ovflw">
				<li><a href="<?php echo U('App/Shop/index');?>" id="fthome"><span class="iconfont">&#xe6b8</span><p class="ui-navtt">首页</p></a></li>
				<li><a href="<?php echo U('App/Shop/category',array('type'=>0));?>" id="ftcategory"><span class="iconfont">&#xe6cd;</span><p class="ui-navtt">商品</p></a></li>
				<li><a href="<?php echo U('App/Shop/basket',array('sid'=>0,'lasturl'=>$footlasturl));?>" id="ftbasket"><span class="iconfont">&#xe6af</span><p class="ui-navtt">购物车</p></a></li>
				<li><a href="<?php echo U('App/Vip/index');?>" id="ftvip"><span class="iconfont">&#xe686</span><p class="ui-navtt">个人中心</p></a></li>
			</ul>
		</div>
		<script type="text/javascript">
			 var actname="<?php echo ($actname); ?>";
			 $('#'+actname).css('color','#19a5f3');
		</script>
    </div>
    <!-- 导航栏滚动时锁定在屏幕上方-->
    <script type="text/javascript" src="/Public/App/js/menuFixed.js"></script>
    <script type="text/javascript">
    $('.ui-navul').children().eq(0).find('a').css('color', '#19a5f3');
    //轮播
    $(function() {
        $('#slider').mBanner('slider');
    });
    //导航栏滚动
    $('#nav').navigator();
    //导航栏滚动时锁定在屏幕上方
    window.onload = function() {
        menuFixed('wrap');
    }
    </script>
	<script type="text/javascript">
    $("#nav ul li").tap(function(){
      var t = $(this).index();
      for(var i=0;i<$("#nav ul li").length;++i){
        if(i == t){
          $(".secondNav").eq(i).fadeToggle(900);
        }
        else{
          $(".secondNav").eq(i).hide();
        }
      }
    })
    </script>

    <!--新版分享特效-->
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script>
    //var share_url = "<?php echo ($_SESSION['WAP']['shopset']['url']); ?>/App/Shop/index/ppid/<?php echo ($_SESSION['WAP']['vipid']); ?>/";
    var share_url = "http://<?php echo ($_SERVER['HTTP_HOST']); ?>/App/Shop/index/ppid/<?php echo ($_SESSION['WAP']['vipid']); ?>/";
    var share_title = "<?php echo ($_SESSION['WAP']['shopset']['name']); ?>";
    var share_content = "<?php echo ($_SESSION['SET']['wxsummary']); ?>";
    var share_img = "<?php echo ($_SESSION['WAP']['shopset']['url']); echo ($_SESSION['WAP']['shopset']['sharepic']); ?>";

    wx.config({
        debug: false,
        appId: "<?php echo ($jsapi['appId']); ?>",
        timestamp: "<?php echo ($jsapi['timestamp']); ?>",
        nonceStr: "<?php echo ($jsapi['nonceStr']); ?>",
        signature: "<?php echo ($jsapi['signature']); ?>",
        jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'hideMenuItems',
            'showMenuItems',
            'hideAllNonBaseMenuItem',
            'showAllNonBaseMenuItem',
            //      'translateVoice',
            //      'startRecord',
            //      'stopRecord',
            //      'onRecordEnd',
            //      'playVoice',
            //      'pauseVoice',
            //      'stopVoice',
            //      'uploadVoice',
            //      'downloadVoice',
            //      'chooseImage',
            //      'previewImage',
            //      'uploadImage',
            //      'downloadImage',
            //      'getNetworkType',
            //      'openLocation',
            //      'getLocation',
            //      'hideOptionMenu',
            //      'showOptionMenu',
            //      'closeWindow',
            //      'scanQRCode',
            //      'chooseWXPay',
            //      'openProductSpecificView',
            //      'addCard',
            //      'chooseCard',
            //      'openCard'
        ]
    });

    wx.ready(function() {
        //开启菜单
        wx.showOptionMenu();
        //隐藏菜单
        //wx.hideOptionMenu();
        //分享给朋友
        wx.onMenuShareAppMessage({
            title: share_title,
            desc: share_content,
            link: share_url,
            imgUrl: share_img,
            trigger: function(res) {
                //alert('用户点击发送给朋友');
            },
            success: function(res) {
                //alert('已分享');
            },
            cancel: function(res) {
                //alert('已取消');
            },
            fail: function(res) {
                //alert(JSON.stringify(res));
            }
        });
        //分享到朋友圈
        wx.onMenuShareTimeline({
            title: share_title,
            link: share_url,
            imgUrl: share_img,
            trigger: function(res) {
                //alert('用户点击分享到朋友圈');
            },
            success: function(res) {
                //alert('已分享');
            },
            cancel: function(res) {
                //alert('已取消');
            },
            fail: function(res) {
                //alert(JSON.stringify(res));
            }
        });
        //分享到QQ
        wx.onMenuShareQQ({
            title: share_title,
            desc: share_content,
            link: share_url,
            imgUrl: share_img,
            trigger: function(res) {
                //alert('用户点击分享到QQ');
            },
            complete: function(res) {
                //alert(JSON.stringify(res));
            },
            success: function(res) {
                //alert('已分享');
            },
            cancel: function(res) {
                //alert('已取消');
            },
            fail: function(res) {
                //alert(JSON.stringify(res));
            }
        });
    });
    </script>
	
</body>

</html>