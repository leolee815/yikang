<?php if (!defined('THINK_PATH')) exit();?><div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header bg-blue">
                <i class="widget-icon fa fa-arrow-down"></i>
                <span class="widget-caption">会员列表</span>
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
                                <input name="search" type="search" class="form-control input-sm" placeholder="会员昵称或者手机号">
                            </label>
                            <a href="<?php echo U('Admin/Employee/vipCenter/');?>" class="btn btn-success" data-loader="App-loader" data-loadername="会员列表" data-search="App-search">
                                <i class="fa fa-search"></i>搜索
                            </a>
                        </form>
                    </div>
                    <div style="height:50px"></div>
                </div>
                <table id="App-table" class="table table-bordered table-hover">
                    <thead class="bordered-darkorange">
                        <tr role="row">
                            <th>ID</th>
                            <th>层级</th>
                            <th>昵称</th>
                            <th>下线人数</th>
                            <th>手机号</th>
                            <th>姓名</th>
                            <th>分销等级</th>
                            <th>下级订单总额</th>
							<th>下级订单量</th>
                            <th>注册时间</th>
                            <th>最后访问</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($cache)): $i = 0; $__LIST__ = $cache;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="item<?php echo ($vo["id"]); ?>">
                                <td><?php echo ($vo["id"]); ?></td>
                                <td><?php echo ($vo["plv"]); ?></td>
                                <td><?php echo ($vo["nickname"]); ?></td>
                                <td><?php echo ($vo["total_xxlink"]); ?></td>
                                <td><?php echo ($vo["mobile"]); ?></td>
                                <td><?php echo ($vo["name"]); ?></td>
                                <td><?php echo ($vo["fxname"]); ?></td>
                                <td><?php echo ($vo["achievement"]); ?></td>
								<td><?php echo ($vo["totalnum"]); ?></td>
                                <td><?php echo (date('Y-m-d',$vo["ctime"])); ?></td>
                                <td><?php echo (date('Y-m-d',$vo["cctime"])); ?></td>
                               	<td class="center">
                               		<a href="<?php echo U('Admin/Employee/vipSet/',array('id'=>$vo['id']));?>" class="btn btn-success btn-xs" data-loader="App-loader" data-loadername="会员编辑"><i class="fa fa-edit"></i> 编辑</a>&nbsp;&nbsp;
                                    <a href="<?php echo U('Admin/Employee/vipSubordinate/',array('id'=>$vo['id']));?>" class="btn btn-sky btn-xs" data-loader="App-loader" data-loadername="下级会员明细"><i class="glyphicon glyphicon-eye-open"></i> 下级会员明细</a>
                                 </td>
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