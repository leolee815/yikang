<?php if (!defined('THINK_PATH')) exit();?><script src="/Public/Admin/js/datetime/moment.js"></script>
<script src="/Public/Admin/js/datetime/daterangepicker.js"></script>
<div class="row">
	<div class="col-xs-12 col-md-12">
		<div class="widget">
			<div class="widget-header bg-blue">
				<i class="widget-icon fa fa-arrow-down"></i>
				<span class="widget-caption">商城订单</span>
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
								<input name="keyword" type="search" class="form-control input-sm" placeholder="分销商ID/分销商电话/分销商姓名" value="<?php echo ($keyword); ?>" style="width:220px">
							</label>
							<label style="margin-bottom: 0px;">
								<input name="name" type="search" class="form-control input-sm" placeholder="订单号/收货电话" value="<?php echo ($name); ?>">
							</label>
							<label style="margin-bottom: 0px;width:200px;">
                             	<div class="input-group input-group-sm">
                             	<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control input-sm" id="date" name="date" placeholder="日期范围"  value="<?php echo ($date); ?>">
                            	</div>
                            </label>  
                            <input type="hidden" name="status" value="<?php echo ($status); ?>">
							<a href="<?php echo U('Admin/Employee/orderCenter/');?>" class="btn btn-success" data-loader="App-loader" data-loadername="商城订单" data-search="App-search">
								<i class="fa fa-search"></i>搜索
							</a>
						</form>
					</div><div style="height:40px"></div>
				</div>

				<table id="App-table" class="table table-bordered table-hover">
					<thead class="bordered-darkorange">
						<tr role="row">
						
							<th>ID</th>
							<th>会员ID</th>
							<th>订单号</th>
							<?php if(empty($status)): ?><th>订单状态</th><?php endif; ?>
							<th width="120">订单商品</th>
							<th>订单总额</th>
							<th>预设分销商ID</th>
							<th>收货姓名</th>
							<th>收货电话</th>
							<th>收货地址</th>							
							<!--<th>邮费合计</th>-->
							<th>支付金额</th>
							<th>支付方式</th>
							<th>支付时间</th>
							<th>创建时间</th>
							<!--<th>代金卷</th>-->

						</tr>
					</thead>
					<tbody>
						<?php if(is_array($cache)): $i = 0; $__LIST__ = $cache;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="item<?php echo ($vo["id"]); ?>">

								<td class=" sorting_1"><?php echo ($vo["id"]); ?></td>
								<td class=" "><?php echo ($vo["vipid"]); ?></td>
								<td class=" "><?php echo ($vo["oid"]); ?></td>
								<?php if(empty($status)): ?><td class=" "><?php switch($vo["status"]): case "0": ?>已取消<?php break;?>
					<?php case "1": ?>未付款<?php break;?>
					<?php case "2": ?>已付款<?php break;?>
					<?php case "3": ?>已发货<?php break;?>
					<?php case "4": ?>退货中<?php break;?>
					<?php case "5": ?>已完成<?php break;?>
					<?php case "6": ?>已关闭<?php break;?>
					<?php case "7": ?>已退货<?php break; endswitch;?></td><?php endif; ?>
								<td class=" ">
								 <?php if(is_array($vo["items"])): $i = 0; $__LIST__ = $vo["items"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vt): $mod = ($i % 2 );++$i; echo str_replace('恒压咽鼓管吹张器','',$vt['name']);?>X<?php echo ($vt["num"]); ?>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
								</td>
								<td class=" "><?php echo ($vo["totalprice"]); ?></td>
								<td class=" "><?php if(($vo["fxsid"]) == "0"): ?>无<?php else: echo ($vo["fxsid"]); endif; ?></td>
								<td class=" "><?php echo ($vo["vipname"]); ?></td>
								<td class=" "><?php echo ($vo["vipmobile"]); ?></td>
								<td class=" "><?php echo ($vo["vipaddress"]); ?></td>
								<!--<td class=" "><?php echo ($vo["yf"]); ?></td>-->
								<td class=" "><?php echo ($vo["payprice"]); ?></td>
								<td class=" "><?php switch($vo["paytype"]): case "money": ?>余额<?php break;?>
									<?php case "alipaywap": ?>支付宝WAP<?php break;?>
									<?php case "wxpay": ?>微信支付<?php break; endswitch;?></td>
								<td class=" "><?php if(!empty($vo["paytime"])): echo (date('Y/m/d H:i',$vo["paytime"])); else: ?>未支付<?php endif; ?></td>
								<td class=" "><?php echo (date('Y/m/d H:i',$vo["ctime"])); ?></td>
								<!--<td class=" "><?php if(($vo["djqid"]) != ""): echo ($vo["djqid"]); else: ?>未使用<?php endif; ?></td>-->
								
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
<!--全选特效封装/全部删除-->
<script type="text/javascript">
	//全选
	var checkall=$('#App-table .App-checkall');
	var checks=$('#App-table .App-check');
	var trs=$('#App-table tbody tr');
	$(checkall).on('click',function(){
		if($(this).is(":checked")){			
			$(checks).prop("checked","checked");
		}else{
			$(checks).removeAttr("checked");
		}		
	});
	$(trs).on('click',function(){
		var c=$(this).find("input[type=checkbox]");
		if($(c).is(":checked")){
			$(c).removeAttr("checked");
		}else{
			$(c).prop("checked","checked");
		}		
	});
	
	//批量发货
	$('#App-fhok').on('click',function(){
		var checks=$(".App-check:checked");
		var chk='';
		$(checks).each(function(){
			chk+=$(this).val()+',';
		});
		if(!chk){
			$.App.alert('danger','请选择要提现的项目！');
			return false;
		}
		var toajax="<?php echo U('Admin/Shop/orderDeliverAll');?>"+"/id/"+chk;
		var funok=function(){
			var callok=function(){
				//成功删除后刷新
				$('#refresh-toggler').trigger('click');
				return false;
			};
			var callerr=function(){
				//拦截错误
				return false;
			};
			$.App.ajax('post',toajax,'nodata',callok,callerr);
		}						
		$.App.confirm("确认要批量完成发货吗？此操作不可逆转！",funok);
	});
	//全删
	$('#App-delall').on('click',function(){
		var checks=$(".App-check:checked");
		var chk='';
		$(checks).each(function(){
			chk+=$(this).val()+',';
		});
		if(!chk){
			$.App.alert('danger','请选择要删除的项目！');
			return false;
		}
		var toajax="<?php echo U('Admin/Shop/orderDel');?>"+"/id/"+chk;
		var callok=function(){
			//主框架可以直接模拟点击刷新按钮
			//$('#refresh-toggler').trigger('click');
			$(AppLoaderReloader).trigger('click');
			return false;
		};
		var callerr=function(){
			//拦截错误
			return false;
		};
		$.App.ajax('post',toajax,'nodata',callok,callerr);
	});
</script>
<!--/全选特效封装-->


<!--订单特效-->
<script type="text/javascript">
//发货快递
var btnfhkd=$('.orderfhkd');
	$(btnfhkd).on('click',function(){
			var id=$(this).data('id');
			$.ajax({
					type:"post",
					url:"<?php echo U('Admin/Shop/orderFhkd');?>",
					data:{'id':id},
					dataType: "json",
					//beforeSend:$.App.loading(),
					success:function(mb){
						//$.App.loading();
						bootbox.dialog({
	                	message: mb,
	                	title: "填写发货快递",
	                	className: "modal-darkorange",
	                	buttons: {
	                		   success: {
			                        label: "确定",
			                        className: "btn-blue",
			                        callback: function () {
			                        	var dtfhkd=$('#AppOrderFahuokd').val();
			                        	var dtfhkdnum=$('#AppOrderFahuokdnum').val();
			                        	if(!dtfhkd || !dtfhkdnum){
			                        		alert('请完整填写必添字段!');
			                        		return false;
			                        	}
			                        	var dt=$('#AppOrderFhkd').serialize();
			                        	$.ajax({
			                        		type:"post",
			                        		url:"<?php echo U('Admin/Shop/orderFhkdSave');?>",
			                        		data:dt,
			                        		dataType:"json",
			                        		async:false,
			                        		success:function(info){
			                        			if(info['status']){
			                        				$.App.alert('success',info['msg']);
			                        				$('#App-reloader').trigger('click');
			                        			}else{
			                        				$.App.alert('danger',info['msg']);
			                        			}
			                        			return false;
			                        		},
			                        		error:function(xhr){
												$.App.alert('danger','通讯失败！请重试！');
												return false;
											}
			                        	});
			                        }
			                   },
			                    "取消": {
			                        className: "btn-danger",
			                        callback: function () { }
			                    }
		                	}
		            	});
					},
					error:function(xhr){
						$.App.alert('danger','通讯失败！请重试！');
					}
			});
		return false;
	});
	
	//订单改价
	var btnchange=$('.orderchange');
	$(btnchange).on('click',function(){
			var id=$(this).data('id');
			$.ajax({
					type:"post",
					url:"<?php echo U('Admin/Shop/orderChange');?>",
					data:{'id':id},
					dataType: "json",
					//beforeSend:$.App.loading(),
					success:function(mb){
						//$.App.loading();
						bootbox.dialog({
	                	message: mb,
	                	title: "订单改价",
	                	className: "modal-darkorange",
	                	buttons: {
	                		   success: {
			                        label: "确定",
			                        className: "btn-blue",
			                        callback: function () {
			                        	var dtprice=$('#AppOrderChangePrice').val();
			                        	var dtadmin=$('#AppOrderChangeAdmin').val();
			                        	var dtmsg=$('#AppOrderChangeMsg').val();
			                        	if(!dtprice || !dtadmin || !dtmsg){
			                        		alert('请完整填写必添字段!');
			                        		return false;
			                        	}
			                        	var dt=$('#AppOrderChange').serialize();
			                        	$.ajax({
			                        		type:"post",
			                        		url:"<?php echo U('Admin/Shop/orderChangeSave');?>",
			                        		data:dt,
			                        		dataType:"json",
			                        		async:false,
			                        		success:function(info){
			                        			if(info['status']){
			                        				$.App.alert('success',info['msg']);
			                        				$('#App-reloader').trigger('click');
			                        			}else{
			                        				$.App.alert('danger',info['msg']);
			                        			}
			                        			return false;
			                        		},
			                        		error:function(xhr){
												$.App.alert('danger','通讯失败！请重试！');
												return false;
											}
			                        	});
			                        }
			                   },
			                    "取消": {
			                        className: "btn-danger",
			                        callback: function () { }
			                    }
		                	}
		            	});
					},
					error:function(xhr){
						$.App.alert('danger','通讯失败！请重试！');
					}
			});
		return false;
	});
	
	//订单关闭
	var btnclose=$('.orderclose');
	$(btnclose).on('click',function(){
			var id=$(this).data('id');
			$.ajax({
					type:"post",
					url:"<?php echo U('Admin/Shop/orderClose');?>",
					data:{'id':id},
					dataType: "json",
					//beforeSend:$.App.loading(),
					success:function(mb){
						//$.App.loading();
						bootbox.dialog({
	                	message: mb,
	                	title: "订单关闭",
	                	className: "modal-darkorange",
	                	buttons: {
	                		   success: {
			                        label: "确定",
			                        className: "btn-blue",
			                        callback: function () {
			                        	var dtadmin=$('#AppOrderCloseAdmin').val();
			                        	var dtmsg=$('#AppOrderCloseMsg').val();
			                        	if(!dtadmin || !dtmsg){
			                        		alert('请完整填写必添字段!');
			                        		return false;
			                        	}
			                        	var dt=$('#AppOrderClose').serialize();
			                        	$.ajax({
			                        		type:"post",
			                        		url:"<?php echo U('Admin/Shop/orderCloseSave');?>",
			                        		data:dt,
			                        		dataType:"json",
			                        		async:false,
			                        		success:function(info){
			                        			if(info['status']){
			                        				$.App.alert('success',info['msg']);
			                        				$('#App-reloader').trigger('click');
			                        			}else{
			                        				$.App.alert('danger',info['msg']);
			                        			}
			                        			return false;
			                        		},
			                        		error:function(xhr){
												$.App.alert('danger','通讯失败！请重试！');
												return false;
											}
			                        	});
			                        }
			                   },
			                    "取消": {
			                        className: "btn-danger",
			                        callback: function () { }
			                    }
		                	}
		            	});
					},
					error:function(xhr){
						$.App.alert('danger','通讯失败！请重试！');
					}
			});
		return false;
	});
	
	//订单发货
	var btndeliver=$('.orderdeliver');
	$(btndeliver).on('click',function(){
		var id=$(this).data('id');
		$.ajax({
			type:"post",
			url:"<?php echo U('Admin/Shop/orderDeliver');?>",
			async:false,
			data:{'id':id},
			success:function(info){
			    if(info['status']){
			           $.App.alert('success',info['msg']);
			           $('#App-reloader').trigger('click');
			    }else{
			           $.App.alert('danger',info['msg']);
			         }
			         return false;
			   },
			error:function(xhr){
				$.App.alert('danger','通讯失败！请重试！');
				return false;
			}
		});
	});
	
	//退货特效
	var btnchange=$('.ordertuihuo');
	$(btnchange).on('click',function(){
			var id=$(this).data('id');
			$.ajax({
					type:"post",
					url:"<?php echo U('Admin/Shop/orderTuihuo');?>",
					data:{'id':id},
					dataType: "json",
					//beforeSend:$.App.loading(),
					success:function(mb){
						//$.App.loading();
						bootbox.dialog({
	                	message: mb,
	                	title: "订单退货",
	                	className: "modal-darkorange",
	                	buttons: {
	                		   success: {
			                        label: "确定",
			                        className: "btn-blue",
			                        callback: function () {
			                        	var dtprice=$('#AppOrderTuihuoPrice').val();
			                        	var dtadmin=$('#AppOrderTuihuoAdmin').val();
			                        	var dtmsg=$('#AppOrderTuihuoMsg').val();
			                        	if(!dtprice || !dtadmin || !dtmsg){
			                        		alert('请完整填写必添字段!');
			                        		return false;
			                        	}
			                        	var dt=$('#AppOrderTuihuo').serialize();
			                        	$.ajax({
			                        		type:"post",
			                        		url:"<?php echo U('Admin/Shop/orderTuihuoSave');?>",
			                        		data:dt,
			                        		dataType:"json",
			                        		async:false,
			                        		success:function(info){
			                        			if(info['status']){
			                        				$.App.alert('success',info['msg']);
			                        				$('#App-reloader').trigger('click');
			                        			}else{
			                        				$.App.alert('danger',info['msg']);
			                        			}
			                        			return false;
			                        		},
			                        		error:function(xhr){
												$.App.alert('danger','通讯失败！请重试！');
												return false;
											}
			                        	});
			                        }
			                   },
			                    "取消": {
			                        className: "btn-danger",
			                        callback: function () { }
			                    }
		                	}
		            	});
					},
					error:function(xhr){
						$.App.alert('danger','通讯失败！请重试！');
					}
			});
		return false;
	});
	
	//订单完成
	var btnsuccess=$('.ordersuccess');
	$(btnsuccess).on('click',function(){
		var id=$(this).data('id');
		$.ajax({
			type:"post",
			url:"<?php echo U('Admin/Shop/ordersuccess');?>",
			async:false,
			data:{'id':id},
			success:function(info){
			    if(info['status']){
			           $.App.alert('success',info['msg']);
			           $('#App-reloader').trigger('click');
			    }else{
			           $.App.alert('danger',info['msg']);
			         }
			         return false;
			   },
			error:function(xhr){
				$.App.alert('danger','通讯失败！请重试！');
				return false;
			}
		});
	});
	
	//导出订单
	$('#exportOrder').on('click',function(){
		var checks=$(".App-check:checked");
		var chk='';
		$(checks).each(function(){
			chk+=$(this).val()+',';
		});
		window.open("<?php echo U('Admin/Shop/orderExport');?>/status/<?php echo ($status); ?>/id/"+chk);
	})
	$('#date').daterangepicker();
</script>