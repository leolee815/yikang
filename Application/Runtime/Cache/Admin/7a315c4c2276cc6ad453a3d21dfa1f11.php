<?php if (!defined('THINK_PATH')) exit();?> <div class="row">
        <div class="col-md-12">
                <form id="AppOrderTuihuo" action="" method="post" class="form-horizontal"
                                                  data-bv-message=""
                                                  data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                                                  data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                                                  data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                   <input type="hidden" name="id" value="<?php echo ($cache["id"]); ?>">     
                   
                   <div class="form-group">
                        <label class="col-lg-3 control-label">申请退货时间</label>
                        <div class="col-lg-7">
                        	<input type="text" class="form-control" value="<?php echo (date("Y-m-d H:i:s",$cache["tuihuosqtime"])); ?>" readonly>
                        </div>
                   </div>
                   <div class="form-group">
                        <label class="col-lg-3 control-label">退货金额<sup>*</sup></label>
                        <div class="col-lg-7">
                        	<input id="AppOrderTuihuoPrice" type="text" class="form-control" name="tuihuoprice" value="<?php echo ($cache["tuihuoprice"]); ?>" placeholder="输入退货金额">
                        </div>
                   </div>
                   <div class="form-group">
                        <label class="col-lg-3 control-label">退货快递公司<sup>*</sup></label>
                        <div class="col-lg-7">
                        	<input id="AppOrderTuihuoKd" type="text" class="form-control" name="tuihuokd" value="<?php echo ($cache["tuihuokd"]); ?>" placeholder="输入退货快递">
                        </div>
                   </div>
                  <div class="form-group">
                        <label class="col-lg-3 control-label">退货快递单号<sup>*</sup></label>
                        <div class="col-lg-7">
                        	<input id="AppOrderTuihuoKdNum" type="text" class="form-control" name="tuihuokdnum" value="<?php echo ($cache["tuihuokdnum"]); ?>" placeholder="输入退货快递单号">
                        </div>
                   </div>
                   <div class="form-group">
                        <label class="col-lg-3 control-label">退货客服<sup>*</sup></label>
                        <div class="col-lg-7">
                        	<input id="AppOrderTuihuoAdmin" type="text" class="form-control" name="tuihuoadmin" value="<?php echo ($cache["tuihuoadmin"]); ?>" placeholder="输入客服名称">
                        </div>
                   </div>
                   <div class="form-group">
                        <label class="col-lg-3 control-label">退货说明<sup>*</sup></label>
                        <div class="col-lg-7">
                        	<textarea id="AppOrderTuihuoMsg" class="form-control" name="tuihuomsg" rows="5" ><?php echo ($cache["tuihuomsg"]); ?></textarea>
                        </div>
                   </div>
               </form>
        </div>
</div>