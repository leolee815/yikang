<?php if (!defined('THINK_PATH')) exit(); if(is_array($cache)): $i = 0; $__LIST__ = $cache;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="imgwp" data-id = "<?php echo ($vo["id"]); ?>" data-check = "0" onclick="checkupload(this);">
		<img src="/Upload/<?php echo ($vo["savepath"]); echo ($vo["savename"]); ?>" />
		<div class="cover"></div>
	</div><?php endforeach; endif; else: echo "" ;endif; ?>