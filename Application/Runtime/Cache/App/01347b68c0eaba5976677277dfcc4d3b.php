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
		<style type="text/css">
		.weui-media-box_appmsg .weui-media-box__hd{width:80px;}
		.weui-media-box__thumb{border-radius: 0;height: 70px;}
		</style>
	</head>
	<body>
	<div class="weui-tab">
			<div class="weui-navbar">
		         <div class="weui-navbar__item">
		                <a href="<?php echo U('App/Dc/index');?>">我的业绩</a>
		         </div>
		         <div class="weui-navbar__item">
		                <a href="<?php echo U('App/Dc/subordinate');?>">下级会员</a>
		         </div>
		         <div class="weui-navbar__item weui-bar__item_on">
		                <a href="<?php echo U('App/Dc/orderlist');?>">订单列表</a>
		         </div>
		</div> 
		<div class="weui-tab__bd">
        	<div class="weui-tab__bd-item weui-tab__bd-item--active" id="list">
        	<?php if(empty($cache)): ?><div class="weui-loadmore weui-loadmore_line">
				  <span class="weui-loadmore__tips">暂无订单</span>
					</div>
	         <?php else: ?>
        		<?php if(is_array($cache)): $i = 0; $__LIST__ = $cache;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="weui-cells">
						<div class="weui-cell">
			                <div class="weui-cell__bd">
			                    <p>订单编号：<?php echo ($vo["oid"]); ?></p>
			                </div>
			                <div class="weui-cell__ft color3">
			                </div>
			            </div>
			            <?php if(is_array($vo["items"])): $i = 0; $__LIST__ = $vo["items"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vt): $mod = ($i % 2 );++$i;?><a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg bz_wrap">
		                    <div class="weui-media-box__hd">
		                        <img class="weui-media-box__thumb" src="<?php echo ($vt["pic"]); ?>" alt="" onerror="this.src='/Public/App/img/nopic.jpg'">
		                    </div>
		                    <div class="weui-media-box__bd fz_14">
		                        <p><?php echo ($vt["name"]); ?></p>
		                        <?php if(!empty($vt["skuattr"])): ?><p><?php echo ($vt["skuattr"]); ?></p><?php endif; ?>
		                    </div>
		                    <div class=" ovflw ">
                                <p><i class="color3">￥<?php echo ($vt["price"]); ?></i></p>
                                <p class="text_r fonts85">X<?php echo ($vt["num"]); ?></p>
                            </div>
		                </a><?php endforeach; endif; else: echo "" ;endif; ?>
		                <div class="weui-cell fz_14">
			                <div class="weui-cell__bd">
			                    <p>会员昵称：<?php echo ($vo["nickname"]); ?></p>
			                </div>
			                <div class="weui-cell__ft">推荐人：<?php echo ($vo["pname"]); ?></div>
			            </div>
		                 <div class="weui-cell fz_14">
			                <div class="weui-cell__bd">
			                    <p>收货人：<?php echo ($vo["vipname"]); ?></p>
			                </div>
			                <div class="weui-cell__ft">下单时间：<?php echo (date("Y-m-d H:i:s",$vo["ctime"])); ?></div>
			            </div>
		                <div class="weui-cell fz_14">
			                <div class="weui-cell__bd">
			                    <p>共<i><?php echo ($vo["totalnum"]); ?></i>件商品</p>
			                </div>
			                <div class="weui-cell__ft">合计：￥<i><?php echo ($vo["payprice"]); ?></i></div>
			            </div>
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
				<?php if(($datamore) == "1"): ?><div class="weui-loadmore" id="infinite">
				  <i class="weui-loading"></i>
				  <span class="weui-loadmore__tips">正在加载</span>
				</div><?php endif; endif; ?>
        </div>
      </div>
    </div>         
<script type="text/javascript">
if($("#infinite")[0]) {
	var p = 1;
	var loading = false;
	$(document.body).infinite().on("infinite", function() {
	  if(loading) return;
	  loading = true;
	  p=p+1;
	  param ="?p="+p;  
      $.get("<?php echo U('App/Ajax/orderList');?>"+param,function(data){  
    	   if(data.status==1) {
    		   if(data.info) {	    			   
                   $("#list").append(data.info);
    			   loading = false;
                   if(data.more==0) {	            			  
                	   $(document.body).destroyInfinite();
                   }
    	   	   } 
        	   $('#infinite').hide();
    	   }
       })  
	});
}
</script>
<script type="text/javascript" src="/Public/App/js/fastclick.js"></script>
<script type="text/javascript">
 $(function() {
	  FastClick.attach(document.body);
 });
</script>
	</body>
</html>