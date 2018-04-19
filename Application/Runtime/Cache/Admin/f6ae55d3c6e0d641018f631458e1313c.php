<?php if (!defined('THINK_PATH')) exit();?><!--百度编辑器-->
<script type="text/javascript" charset="utf-8" src="/Public/Admin/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/ueditor/ueditor.all.min.js"></script>
<div class="page-title">
    <h1>
        文章管理
    </h1>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="widget-container fluid-height clearfix">
            <div class="widget-content padded">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="widget-container fluid-height" style="box-shadow: 0 0px 0px rgba(0, 0, 0, 0);">
                            <div class="tab-content padded" id="my-tab-content">
                                <div class="tab-pane active">
                                    <p>

                                    <form action="<?php echo U('Admin/Artical/addArtical');?>" id="myForm" method="post"
                                          onsubmit="return false;" class="form-horizontal">
                                        <div class="form-group">
                                            <label class="control-label col-md-2">标题</label>

                                            <div class="col-md-7">
                                                <input class="form-control" placeholder="" value="<?php echo ($artical["title"]); ?>"
                                                       name="title" type="text">
                                                <input class="form-control" name="id" value="0" placeholder=""
                                                       type="hidden">
                                            </div>
                                        </div>
					                    <div class="form-group">
					                        <label class="col-lg-2 control-label">首页列表图片</label>
					                        <div class="col-lg-4">
					                            <div class="input-group input-group-sm">
					                                <input type="text" class="form-control" name="listpic" value="<?php echo ($artical["listpic"]); ?>" id="App-listpic" placeholder="尺寸：260*115px">
					                                <span class="input-group-btn">
					                                <button class="btn btn-default shiny" type="button" onclick="appImgviewer('App-listpic')"><i class="fa fa-camera-retro"></i>预览</button><button class="btn btn-default shiny" type="button" onclick="appImguploader('App-listpic',false)"><i class="glyphicon glyphicon-picture"></i>上传</button>
					                            </span>
					                            </div>
					                        </div>
					                    </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-2">作者</label>

                                            <div class="col-md-7">
                                                <input class="form-control" placeholder="" value="<?php echo ($artical["author"]); ?>"
                                                       name="author" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-2">简介</label>

                                            <div class="col-md-7">
                                                <input class="form-control" placeholder="" value="<?php echo ($artical["sub"]); ?>"
                                                       name="sub" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-2">浏览量</label>

                                            <div class="col-md-7">
                                                <input class="form-control" placeholder="" value="<?php echo ($artical["visiter"]); ?>"
                                                       name="visiter" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-2">内容</label>

                                            <div class="col-md-7">
                                                <!--style给定宽度可以影响编辑器的最终宽度-->
                                                <input type="hidden">
                                                <script type="text/plain" id="J-ueditor"
                                                        style="width: 600px;height:380px;position:relative"><?php echo (htmlspecialchars_decode($artical["content"])); ?>
                                                </script>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-2"></label>

                                            <div class="col-md-7">
                                                <button class="btn btn-primary" type="submit">提交</button>
                                                <button class="btn btn-default-outline">取消</button>
                                            </div>
                                        </div>
                                    </form>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    UE.getEditor('J-ueditor', {
        textarea: 'content' //提交字段名，必须填写，数据库必须有此字段
    });
</script>
<script>
    if ('<?php echo ($artical); ?>') {
        $('input[name="id"]').val('<?php echo ($artical["id"]); ?>');
    }

    $('#myForm').bootstrapValidator({
        submitHandler: function(validator, form, submitButton) {
            var tourl = "<?php echo U('Admin/Artical/addArtical');?>";
            var data = $('#myForm').serialize();
            $.App.ajax('post', tourl, data, null);
            return false;
        },
    });
</script>