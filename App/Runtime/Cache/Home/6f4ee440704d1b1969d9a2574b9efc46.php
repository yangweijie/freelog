<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>ueditor demo</title>
</head>
<body>
    <!-- 加载编辑器的容器 -->
    <script id="container" name="content" type="text/plain">这里写你的初始化内容</script>
    <!-- 配置文件 -->
    <script type="text/javascript" src="/Public/static/ueditor/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/Public/static/ueditor/ueditor.all.js"></script>
    <script src="/Public/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">

    $(function(){
        var ue = UE.getEditor('container',{
            serverUrl :'<?php echo U('Home/Upload/ueditor');?>',
            toolbars: [['bold','underline','strikethrough','justifyleft', 'justifycenter', 'justifyright','insertorderedlist', 'insertunorderedlist','blockquote','insertimage','link', 'unlink','pagebreak', 'source', 'insertcode','help', 'fullscreen']]
        });
    })
    </script>
</body>
</html>