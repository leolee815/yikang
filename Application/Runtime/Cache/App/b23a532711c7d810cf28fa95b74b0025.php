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
		.weui-media-box__thumb{width:60px;height:60px;}
		</style>
	</head>
	<body>
	<div class="weui-tab">
			<div class="weui-navbar">
		         <div class="weui-navbar__item">
		                <a href="<?php echo U('App/Dc/index');?>">我的业绩</a>
		         </div>
		         <div class="weui-navbar__item weui-bar__item_on">
		                <a href="<?php echo U('App/Dc/subordinate');?>">下级会员</a>
		         </div>
		         <div class="weui-navbar__item">
		                <a href="<?php echo U('App/Dc/orderlist');?>">订单列表</a>
		         </div>
		</div> 
		<div class="weui-tab__bd">
        <div class="weui-tab__bd-item weui-tab__bd-item--active">
         <div class="goods_list cell tj_p" id="list">
         <?php if(empty($cache)): ?><div class="weui-loadmore weui-loadmore_line">
				  <span class="weui-loadmore__tips">暂无下级会员</span>
				</div>
         <?php else: ?>
         	<?php if(is_array($cache)): $i = 0; $__LIST__ = $cache;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="weui-cells weui_cells_checkbox pd_lr10">
              	   <div class="weui-cells_access mg_0 w_100">                  
                            <div class="weui-media-box_appmsg weui_cell_primary w_100">
                            	<div class="weui-cell c_float w_20">
		                        	<img class="weui-media-box__thumb" src="<?php echo ($vo["headimgurl"]); ?>" onerror="this.src='/Public/App/img/default.jpg'">
		                    	</div>
		                    	<div class=" c_float w_80 userinfo">
	                               <p class="color_gray fz_14">微信昵称： <?php echo ($vo["nickname"]); ?></p>
	                               <p class="color_gray fz_14">订单数：<?php echo ($vo["total_num"]); ?></p>
	                               <p class="color_gray fz_14">成交额：<?php echo ($vo["total_buy"]); ?></p>
	                               <p class="color_gray fz_14">注册时间：<?php echo (date("Y-m-d H:i:s",$vo["ctime"])); ?></p>
                               </div>
                            </div>                       
                          </div>
                   </label>
               </div><?php endforeach; endif; else: echo "" ;endif; ?>
        		<?php if(($datamore) == "1"): ?><div class="weui-loadmore" id="infinite">
				  <i class="weui-loading"></i>
				  <span class="weui-loadmore__tips">正在加载</span>
				</div><?php endif; endif; ?>
           </div>
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
      $.get("<?php echo U('App/Ajax/subordinateList');?>"+param,function(data){  
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