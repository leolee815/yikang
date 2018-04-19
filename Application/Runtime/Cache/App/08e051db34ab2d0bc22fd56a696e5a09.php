<?php if (!defined('THINK_PATH')) exit();?><div class="weui-tab__bd-item weui-tab__bd-item--active" id="list">
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