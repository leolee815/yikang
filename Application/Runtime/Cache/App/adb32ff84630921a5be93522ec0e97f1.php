<?php if (!defined('THINK_PATH')) exit(); if(is_array($cache)): $i = 0; $__LIST__ = $cache;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="weui-cells weui_cells_checkbox pd_lr10">
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