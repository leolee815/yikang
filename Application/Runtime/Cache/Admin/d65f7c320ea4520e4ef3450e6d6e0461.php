<?php if (!defined('THINK_PATH')) exit();?> <div class="row">
        <div class="col-md-12">
                <form id="AppOrderChange" action="" method="post" class="form-horizontal"
                                                  data-bv-message=""
                                                  data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                                                  data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                                                  data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                   <input type="hidden" name="id" value="<?php echo ($cache["id"]); ?>">                  
                   <div class="form-group">
                        <label class="col-lg-3 control-label">支付价格<sup>*</sup></label>
                        <div class="col-lg-7">
                        	<input id="AppOrderChangePrice" type="text" class="form-control" name="payprice" value="<?php echo ($cache["payprice"]); ?>">
                        </div>
                   </div>
                   <div class="form-group">
                        <label class="col-lg-3 control-label">改价客服<sup>*</sup></label>
                        <div class="col-lg-7">
                        	<input id="AppOrderChangeAdmin" type="text" class="form-control" name="changeadmin" value="<?php echo ($cache["changeadmin"]); ?>" placeholder="输入改价客服名称">
                        </div>
                   </div>
                   <div class="form-group">
                        <label class="col-lg-3 control-label">改价说明<sup>*</sup></label>
                        <div class="col-lg-7">
                        	<textarea id="AppOrderChangeMsg" class="form-control" name="changemsg" rows="5" ><?php echo ($cache["changemsg"]); ?></textarea>
                        </div>
                   </div>
               </form>
        </div>
</div>