<?php if (!defined('THINK_PATH')) exit();?><html>
    <head>
        <meta charset="UTF-8">
        <title>Freelog - 自由的轻博客</title>
        <script src="/Public/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="/Public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/Public/css/blog.css">
        <script type="text/javascript" src="/Public/js/common.js"></script>
        <link rel="stylesheet" href="/Public/bower_components/smalot-bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
        <script type="text/javascript" src="/Public/bower_components/smalot-bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="/Public/bower_components/smalot-bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>

        <script src="/Public/bower_components/jquery.tagsinput/jquery.tagsinput.js"></script>
        <link rel="stylesheet" href="/Public/bower_components/jquery.tagsinput/jquery.tagsinput.css" />
        <!-- Your site ends -->
        
	<link rel="stylesheet" href="/Public/bower_components/smalot-bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
    <script type="text/javascript" src="/Public/bower_components/smalot-bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="/Public/bower_components/smalot-bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>

    <script src="/Public/bower_components/jquery.tagsinput/jquery.tagsinput.js"></script>
	<link rel="stylesheet" href="/Public/bower_components/jquery.tagsinput/jquery.tagsinput.css" />

    </head>

    <body>
        <div class="message success" id="top-alert">
            <button type="button" class="close">&times;</button>
            <ul><li>插件已经被禁用</li></ul>
        </div>
        <div class="blog-masthead">
            <div class="container">
                <nav class="blog-nav">
                    <a class="blog-nav-item active" href="#">Home</a>
                    <a class="blog-nav-item" href="#">New features</a>
                    <a class="blog-nav-item" href="#">Press</a>
                    <a class="blog-nav-item" href="#">New hires</a>
                    <a class="blog-nav-item" href="#">About</a>
                </nav>
            </div>
        </div>

        <div class="container">
            
<div class="blog-header">
    <h1 class="blog-title">发布文字</h1>
</div>

            <div class="row">
                <div class="col-sm-8 blog-main">
                    
    <div class="blog-post">
        <form>
            <div class="form-group">
                <label for="title">标题 <span class="optional">(可不填)</span></label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="form-group">
                <label for="content">内容</label>
                <script id="content" name="content" type="text/plain"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
$(function(){
	var ue_content = UE.getEditor('content',{
		serverUrl :'<?php echo U('Home/Upload/ueditor');?>',
		toolbars: [
			[
				'bold', 'underline', 'strikethrough', '|',
				'justifyleft', 'justifycenter', 'justifyright', '|',
				'insertorderedlist', 'insertunorderedlist','blockquote', '|',
				'insertimage','link', 'unlink', '|',
				'pagebreak', 'source', 'insertcode','|',
				'help','fullscreen'
			]
		],
		elementPathEnabled : false,
		initialFrameHeight: 286,
		initialFrameHeight: 286
	});
})
</script>
            </div>
            <button class="btn btn-default pull-left">取消</button>
            <button type="submit" class="btn btn-primary pull-right">保存</button>
        </form>
    </div><!-- /.blog-post -->
    <script type="text/javascript">
    $(function(){
    	updateAlert('asd');
    })
    </script>

                </div><!-- /.blog-main -->

                <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
                    
                        <div class="sidebar-module sidebar-module-inset">
                            <h4>选项</h4>
                            <form>
                                <div class="form-group">
                                    <label for="title">发布时间</label>
                                    <select name="create_time_choose" class="form-control" id="create_time_choose">
                                        <option value="now">现在发布</option>
                                        <option value="choose">定时发布</option>
                                    </select>
                                </div>
                                <div class="input-group hidden">
                                    <input type="datetime" name="deadline" class="form-control" id="deadline">
                                    <span class="input-group-addon glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                </div>

                                <div class="form-group">
                                    <textarea name="tags" id="tags" placeholder="添加标签，用逗号或回车分割" class="form-control" style="height:90px"></textarea>
                                </div>
                            </form>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                //发布时间切换
                                $('#create_time_choose').on('change', function(){
                                    var choosen = this.value;
                                    if('choose' == choosen)
                                        $('#deadline').parent().removeClass('hidden');
                                    else
                                        $('#deadline').parent().addClass('hidden');
                                });

                                //定时使用支持 日期 小时 分钟选择
                                $('#deadline').datetimepicker({
                                    format: 'yyyy-mm-dd hh:ii',
                                    autoclose: true,
                                    language: 'zh-CN'
                                });

                                //标签
                                $('#tags').tagsInput({
                                    'height':'90px',
                                    'width':'211px',
                                    'defaultText': '添加标签'
                                });

                            })
                        </script>
                    
                </div><!-- /.blog-sidebar -->

            </div><!-- /.row -->

        </div><!-- /.container -->

        <footer class="blog-footer">
            <p>Blog template built for <a href="http://getbootstrap.com">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
            <p>
                <a href="#">Back to top</a>
            </p>
        </footer>
        
    <script type="text/javascript" src="/Public/static/ueditor/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/Public/static/ueditor/ueditor.all.js"></script>
    <!-- 实例化编辑器 -->

    </body>
</html>