<?php if (!defined('THINK_PATH')) exit();?><div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header bg-blue">
                <i class="widget-icon fa fa-arrow-down"></i>
                <span class="widget-caption">预设分销商会员列表</span>
                <div class="widget-buttons">
                    <a href="#" data-toggle="maximize">
                        <i class="fa fa-expand"></i>
                    </a>
                    <a href="#" data-toggle="collapse">
                        <i class="fa fa-minus"></i>
                    </a>
                    <a href="#" data-toggle="dispose">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="widget-body">
                <div class="table-toolbar">
                    <div class="pull-right">
                        <form id="App-search">
                            <label style="margin-bottom: 0px;">
                                <input name="search" type="search" class="form-control input-sm" placeholder="手机号" value="<?php echo ($search); ?>">
                            </label>
                            <a href="<?php echo U('Admin/Vip/vipList/');?>" class="btn btn-success" data-loader="App-loader" data-loadername="预设分销商列表" data-search="App-search">
                                <i class="fa fa-search"></i>搜索
                            </a>
                        </form>
                    </div>
                </div>
                <table id="App-table" class="table table-bordered table-hover">
                    <thead class="bordered-darkorange">
                        <tr role="row">
                            <th width="80px">ID</th>
                            <th width="100px">绑定会员ID</th>
                            <th width="100px">绑定手机号码</th>
                            <th width="100px">openid</th>
                            <th width="150px">注册时间</th>
                            <th width="150px">生成时间</th>
                            <th width="60px">状态</th>
                            <th width="">推广二维码</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($cache)): $i = 0; $__LIST__ = $cache;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="item<?php echo ($vo["id"]); ?>">
                                <td class=" sorting_1"><?php echo ($vo["id"]); ?></td>
                                <td class=" "><?php echo ($vo["vipid"]); ?></td>
                                <td class=" "><?php echo ($vo["mobile"]); ?></td>
                                <td class=" "><?php echo ($vo["openid"]); ?></td>
                                <td class=" "><?php if(($vo["regtime"]) != "0"): echo (date('Y-m-d H:i:s',$vo["regtime"])); endif; ?></td>
                                <td class=" "><?php echo (date('Y-m-d H:i:s',$vo["ctime"])); ?></td>
                                <td class="center"><?php if(($vo["is_reg"]) == "1"): ?><span style="color:green">已绑定</span><?php else: ?><span style="color:red;">未绑定</span><?php endif; ?></td>
                                <td class="center "><?php if(($vo["qrcode"]) != ""): ?><a href="<?php echo ($_SESSION["SHOP"]["set"]["url"]); echo ($vo["qrcode"]); ?>" target="_blank">点击打开二维码</a><?php endif; ?></td>  
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
                <div class="row DTTTFooter">
                    <?php echo ($page); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--面包屑导航封装-->
<div id="tmpbread" style="display: none;"><?php echo ($breadhtml); ?></div>
<script type="text/javascript">
setBread($('#tmpbread').html());
</script>
<!--/面包屑导航封装-->