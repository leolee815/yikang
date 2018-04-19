<?php if (!defined('THINK_PATH')) exit();?><div class="row">
    <div class="col-xs-12 col-xs-12">
        <div class="widget radius-bordered">
            <div class="widget-header bg-blue">
                <i class="widget-icon fa fa-arrow-down"></i>
                <span class="widget-caption">会员编辑</span>
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
                <form id="AppForm" action="" method="post" class="form-horizontal" data-bv-message="" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                    <input type="hidden" name="id" value="<?php echo ($cache["id"]); ?>">
                    <div class="form-title">
                        <a href="<?php echo U('Admin/Employee/vipCenter/');?>" class="btn btn-primary" data-loader="App-loader" data-loadername="会员列表">
                            <i class="fa fa-mail-reply"></i>返回
                        </a>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">ID</label>
                        <div class="col-lg-4">
                            <input type="text"class="form-control" disabled="disabled" value="<?php echo ($cache["id"]); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">真实姓名</label>
                        <div class="col-lg-4">
                            <input type="text" name="name" class="form-control"  value="<?php echo ($cache["name"]); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">真实手机</label>
                        <div class="col-lg-4">
                            <input type="text" name="mobile" class="form-control"  value="<?php echo ($cache["mobile"]); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">登录密码</label>
                        <div class="col-lg-4">
                            <input type="password" name="password" class="form-control"  value="" placeholder="不修改请留空">
                        </div>
                    </div>                 
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-4">
                            <button class="btn btn-primary btn-lg" type="submit">保存</button>&nbsp;&nbsp;&nbsp;&nbsp;
                            <button class="btn btn-palegreen btn-lg" type="reset">重填</button>
                        </div>
                    </div>
                </form>
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
<!--表单验证与提交封装-->
<script type="text/javascript">
$('#AppForm').bootstrapValidator({
    submitHandler: function(validator, form, submitButton) {
        var lid = '';
        var checks = $('.label-check');
        $(checks).each(function() {
            if ($(this).is(":checked")) {
                lid += $(this).val() + ',';
            }
        });
        $('#lid').val(lid);
        var tourl = "<?php echo U('Admin/Employee/vipSet');?>";
        var data = $('#AppForm').serialize();
        $.App.ajax('post', tourl, data, null);
        return false;
    },
});
</script>
<!--/表单验证与提交封装-->