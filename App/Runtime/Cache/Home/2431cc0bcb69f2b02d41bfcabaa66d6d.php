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
        <link rel="stylesheet" href="/Public/bower_components/jqnotifybar/css/jquery.notifyBar.css">
        <script type="text/javascript" src="/Public/bower_components/jqnotifybar/jquery.notifyBar.js"></script>

        <script src="/Public/bower_components/jquery.tagsinput/jquery.tagsinput.js"></script>
        <link rel="stylesheet" href="/Public/bower_components/jquery.tagsinput/jquery.tagsinput.css" />

        <script type="text/javascript" src="/Public/static/ueditor/ueditor.config.js"></script>
        <!-- 编辑器源码文件 -->
        <script type="text/javascript" src="/Public/static/ueditor/ueditor.all.js"></script>
        <!-- 实例化编辑器 -->
        <!-- Your site ends -->
        
    </head>

    <body>
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
    <h1 class="blog-title">发布图片</h1>
</div>

            <div class="row">
                <form class="post">
                <div class="col-sm-8 blog-main">
                    
    <div class="blog-post" id="picture">
        <div class="form-group">
            <div id="uploader">
    <p>您的浏览器不支持Flash或HTML5。</p>
</div>

<script type="text/javascript">
// Initialize the widget when the DOM is ready
$(function() {
    $("#uploader").plupload({
        // General settings
        runtimes : 'html5,flash,html4',
        url : "<?php echo U('Home/Upload/plupload','action=uploadimage');?>",
        file_data_name  : "upfile",
        // Maximum file size
        max_file_size : '2mb',
        max_file_count: '40',

        // chunk_size: '1mb',

        // Resize images on clientside if we can
        resize : {
            width : 200,
            height : 200,
            quality : 90,
            crop: true // crop to exact dimensions
        },

        // Specify what files to browse for
        filters : [
            {title : "Image files", extensions : "jpg,gif,png,jpeg"},
        ],

        // Rename files by clicking on their titles
        rename: true,

        // Sort files
        sortable: true,

        // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
        dragdrop: true,

        // Views to activate
        views: {
            list: false,
            thumbs: true, // Show thumbs
            active: 'thumbs'
        },

        // Flash settings
        flash_swf_url : '/plupload/js/Moxie.swf'

        // Silverlight settings
    });
});
</script>
        </div>
        <div class="form-group">
            <label for="content">描述</label>
            <textarea name="description" id="description" cols="30" rows="15" class="form-control hide-data"></textarea>
<!-- 实例化编辑器 -->
<script type="text/javascript">
$(function(){
	var ue_description = UE.getEditor('description',{
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
		initialFrameHeight: 112,
		minFrameHeight: 112,
		autoHeightEnabled: false
	});
})
</script>
        </div>
        <div class="form-group">
            <input type="hidden" name="type" value="<?php echo ($type); ?>" class="hide-data">
            <button class="btn btn-default pull-left">取消</button>
            <button type="button" class="btn btn-primary pull-right ajax-post no-refresh" hide-data="true" target-form="post" href="/api.php/post">保存</button>
        </div>
    </div><!-- /.blog-post -->
    <script type="text/javascript">
    $(function(){

    })
    </script>

                </div><!-- /.blog-main -->

                <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
                    
                        <div class="sidebar-module sidebar-module-inset">
                            <h4>选项</h4>
                            <form>
                                <div class="form-group">
                                    <label for="title">发布时间</label>
                                    <select name="create_time_choose" class="form-control hide-data" id="create_time_choose">
                                        <option value="now">现在发布</option>
                                        <option value="choose">定时发布</option>
                                    </select>
                                </div>
                                <div class="form-group input-group hidden">
                                    <input type="datetime" name="deadline" class="form-control hide-data" id="deadline">
                                    <span class="input-group-addon glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                </div>

                                <div class="form-group">
                                    <textarea name="tags" id="tags" placeholder="添加标签，用逗号或回车分割" class="form-control hide-data" style="height:90px"></textarea>
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
                </form>
            </div><!-- /.row -->

        </div><!-- /.container -->

        <footer class="blog-footer">
            <p>Blog template built for <a href="http://getbootstrap.com">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
            <p>
                <a href="#">Back to top</a>
            </p>
        </footer>
        
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/flick/jquery-ui.css" type="text/css" />
<link rel="stylesheet" href="/Public/bower_components/plupload/js/jquery.ui.plupload/css/jquery.ui.plupload.css" type="text/css" />

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

<!-- production -->
<script type="text/javascript" src="/Public/bower_components/plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="/Public/bower_components/plupload/js/jquery.ui.plupload/jquery.ui.plupload.js"></script>
<script type="text/javascript" src="/Public/bower_components/plupload/js/i18n/zh_CN.js"></script>

    </body>
</html>