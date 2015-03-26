<?php if (!defined('THINK_PATH')) exit();?><html>
    <head>
        <meta charset="UTF-8">
        <title>Freelog - 自由的轻博客</title>
        <script src="/Public/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="/Public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <link href="/Public/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        
    <link rel="stylesheet" type="text/css" href="/Public/bower_components/uploadify/uploadify.css"/>
    <script src="/Public/bower_components/uploadify/jquery.uploadify.js" type="text/javascript"></script>

        <link rel="stylesheet" href="/Public/css/blog.css">
        <script type="text/javascript">
        var is_login = 1;
        </script>
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
    <h1 class="blog-title">发布视频</h1>
</div>

            <div class="row">
                <form class="post">
                <div class="col-sm-8 blog-main">
                    
    <div class="modal fade" id="video" tabindex="-1" role="dialog" aria-labelledby="videolLabel" aria-hidden="true" data-backdrop="static">
    </div>
    <div class="modal fade" id="player" tabindex="-1" role="dialog" aria-labelledby="videolLabel" aria-hidden="true" data-backdrop="static">
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    </div>
    <div class="hide" id="loading_tpl">
        <div class="modal-dialog wt400">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">正从网上获取视频真实地址：</h4>
                </div>
                <div class="modal-body">
                    正在解析中...
                    <div class="progress progress-striped active">
                        <div class="progress-bar" style="width: 1%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="blog-post" id="video">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-btn">
                    <div class="form-controls">
    <input type="file" id="upload_file" style="width:44px">
    <input type="hidden" name="cover_id" id="cover_id_file_upload" />
</div>
<script type="text/javascript">
    <?php if(isset($record)): ?>var no_pic =  '<?php echo (get_cover($record["cover_id"],"path")); ?>' || '/Public/images/no-cover.png';
    <?php else: ?>
    var no_pic =  '/Public/images/no-cover.png';<?php endif; ?>
    var uploadify_swf = '/Public/bower_components/uploadify/uploadify.swf';
    //上传图片
    /* 初始化上传插件 */
    $(function(){
        $("#upload_file").uploadify({
            "width"           : 70||200,
            "height"          : 34||150,
            "buttonImage"     : '/Public/images/video_up_btn.png',
            "multi": false,
            "swf"             : uploadify_swf,
            "fileObjName"     : "file",
            "buttonText"      : "上传",
            'buttonClass'     : "btn_upload",
            "formData": {
                'session_id': '<?php echo session_id();?>',
                'ajax': 1,
                'model': 'file',
                'field': 'file',
            },
            "uploader"        : "<?php echo U('Upload/ajaxUpload');?>",
            "removeCompleted": true,
            "removeTimeout"   : 1,
            "fileSizeLimit": '100MB',
            "fileTypeDesc": 'video files',
            "fileTypeExts"    : '*.mp4',
            "onFallback" : function() {
                notify("未检测到兼容版本的Flash");
            },
            "onUploadSuccess" : uploadVideo,
            "onUploadError": function(file, errorCode, errorMsg, errorString) {
                var msg = '<a title="' + errorString + '">上传失败<a/>';
                notifyr(msg);
            }
        });
    });

    function uploadMusic(file, data){
        console.log(data);
        var data = $.parseJSON(data);
        var src = '';
        if(data.status){
            var index = $('#music_list .item').length;
            var item = [
                '<li class="item">',
                    '<input name="content['+index+'][id]" type="hidden" value="'+data.id+'" class="hide-data">',
                    '<input name="content['+index+'][path]" value="'+data.name+'" class="form-control hide-data" readonly> ',
                    '<input name="content['+index+'][title]" class="form-control hide-data" placeholder="标题">',
                '</li>'
            ];
            $('#music_list').append(item.join(''));
        } else {
            notify(data.info);
        }
    }

    function uploadPicture(file, data){
        console.log(data);
        var data = $.parseJSON(data);
        var src = '';
        if(data.status){
            $("#cover_id_file_upload").val(data.id);
            src = data.url || '' + data.path;
            $("#upload_file").uploadify('settings', 'buttonImage', src);
        } else {
            notify(data.info);
        }
    }

    function uploadVideo(file, data){
        console.log(data);
        var data = $.parseJSON(data);
        if(undefined != data.status && data.status){
            $('#ajaxReturn').load('/Post/afterUpload', function(){
                $(this).find('[name="content[video_id]"]').val(data.id);
                var src = data.url || '' + data.path;
                $(this).find('[name="content[video_url]"]').val(src);

                $("#cover_upload").uploadify({
                    "height"          : 150,
                    "swf"             : uploadify_swf,
                    "fileObjName"     : "cover_upload",
                    "buttonText"      : "视频封面",
                    "buttonImage"     : no_pic,
                    "queueSizeLimit" : 1,
                    "uploader"        : "<?php echo U('/Upload/ajaxUpload');?>",
                    "width"           : 200,
                    "formData"        : {
                        'session_id':'<?php echo session_id();?>',
                        'ajax': 1,
                        'model': 'Picture',
                        'field': 'cover_upload',
                    },
                    "removeTimeout"   : 1,
                    "fileTypeExts"    : "*.jpg; *.png; *.gif;",
                    "onFallback" : function() {
                        alert('未检测到兼容版本的Flash.');
                    },
                    "onUploadSuccess" : uploadPicture
                });
                function uploadPicture(file, data){
                    console.log(data)
                    var data = $.parseJSON(data);
                    if (data.status){
                        var src = data.url || '' + data.path;
                        $('#ajaxReturn').find('[name=cover]').val(src);
                        $("#cover_upload").uploadify('settings', 'buttonImage', src);
                    } else {
                        alert(data.info);
                    }
                };

            });
        }else{
            notify('上传失败');
        }
    }
</script>

                </div>
                <input type="text" name="url" class="form-control" id="exampleInputAmount" placeholder="请输入来自优酷/土豆/酷六/56/搜狐/新浪视频网站的播放页面地址,注意不是FLASH地址" title="请输入来自优酷/土豆/酷六/56/搜狐/新浪视频网站的播放页面地址,注意不是FLASH地址">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default" data-loading-text="正在解析中..." action="<?php echo U('Post/parseVideo');?>" id="search_form">解析<i class="glyphicon glyphicon-search ml4"></i></button>
                </div>
            </div>
        </div>

        <div id="ajaxReturn" class="form-inline"></div>

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
            <input type="hidden" name="id" value="<?php echo ((isset($id) && ($id !== ""))?($id):0); ?>" class="hide-data">
            <input type="hidden" name="type" value="<?php echo ($type); ?>" class="hide-data">
            <button class="btn btn-default pull-left">取消</button>
            <button type="button" class="btn btn-primary pull-right ajax-post no-refresh" hide-data="true" target-form="post" href="/api.php/post">保存</button>
        </div>
    </div><!-- /.blog-post -->
    <script type="text/javascript">
    $(function(){
        //解析
        $('#search_form').on('click',function() {
            if (!is_login) {
                notify('请先登录');
                return false;
            }

            var url = $(this).attr('action');
            var $search = $(this).closest('.form-group').find('[name=url]');
            console.log($search);
            var search = $search.val();
            console.log(search);
            search = $.trim(search);
            if (search == '')
                return false;

            $('#myModal').html($('#loading_tpl').html());
            var bar = $('#myModal .progress-bar');
            var process = setInterval(function() {
                bar.width(function(n, c) {
                    return c + 10;
                });
            }, 1000);
            // search = convert_url(search);
            var $btn = $(this);
            $btn.button('loading');

            $('#myModal').modal('show');
            $.ajax({
                url: url,
                type: 'post',
                data: {url: search},
                success: function(data) {
                    clearInterval(process);
                    bar.width('670');
                    if (data.status){
                        $('#myModal').modal('hide');
                        $('#ajaxReturn').html(data.tpl);
                    }else{
                        $('#myModal .modal-body').html(data.info);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#myModal .modal-body').html('网络出错了');
                },
                complete: function(XMLHttpRequest, textStatus) {
                    $btn.button('reset');
                }
            });
            return false;
        });
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
        
    </body>
</html>