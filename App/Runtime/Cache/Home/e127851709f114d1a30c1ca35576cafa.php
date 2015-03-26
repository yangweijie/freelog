<?php if (!defined('THINK_PATH')) exit(); if(($type) == "upload"): ?><div class="form-group">
	<label for="title">标题</label>
    <div class="controls">
        <input type="hidden" name="content[cover]" value="<?php echo ((isset($img) && ($img !== ""))?($img):""); ?>" class="hide-data">
        <input type="hidden" name="content[video_id]" value="<?php echo ((isset($video_id) && ($video_id !== ""))?($video_id):""); ?>" required title="请先上传视频" class="hide-data">
        <input type="hidden" name="content[video_url]" value="<?php echo ((isset($video_url) && ($video_url !== ""))?($video_url):""); ?>" class="hide-data">
        <input type="text" name="title" placeholder="标题" required title="请填写视频的标题" value="<?php echo ((isset($title) && ($title !== ""))?($title):""); ?>" class="form-control w392 mr20 hide-data">
        <input type="file" name="cover_upload" id="cover_upload">
    </div>
</div>
<div class="form-group">
    <label class="control-label" for="desp">尺寸</label>
    <div class="controls">
        <input class="input-xs form-control hide-data" type="text" name="content[width]" placeholder="宽度" required title="请填写视频的宽度" value="640">
        X
        <input class="input-xs form-control hide-data" type="text" name="content[height]" placeholder="高度" required title="请填写视频的高度" value="480">
    </div>
</div>
<div class="form-group">
    <label class="control-label" for="desp">播放</label>
    <div class="controls">
        <label class="checkbox inline">
            <input type="checkbox" value="1" name="content[auto]" class="form-control hide-data"> 自动播放
        </label>
        <label class="checkbox inline">
            <input type="checkbox" value="1" name="content[circle]" class="form-control hide-data"> 循环播放
        </label>
        <label class="checkbox inline">
            <input type="checkbox" value="1" name="content[preload]" class="form-control hide-data"> 预加载
        </label>
    </div>
</div>
<?php else: ?>
<div class="form-group">
	<label for="title">标题</label>
    <div class="controls">
        <input type="hidden" name="content[cover]" value="<?php echo ($img); ?>" class="hide-data">
        <input type="hidden" name="content[video_id]" value="<?php echo ($video_id); ?>" class="hide-data">
        <input type="hidden" name="content[video_url]" value="<?php echo ($video_url); ?>" class="hide-data">
        <input type="text" name="title" placeholder="标题" required title="请填写视频的标题" value="<?php echo ($title); ?>" class="form-control hide-data w392 mr20">
        <img src="<?php echo ($img); ?>" alt="" width="200">
    </div>
</div>
<div class="form-group">
    <label class="control-label mb20" for="desp">尺寸</label>
    <div class="controls">
        <input class="input-xs form-control hide-data" type="text" name="content[width]" placeholder="宽度" required title="请填写视频的宽度" value="640">
        X
        <input class="input-xs form-control hide-data" type="text" name="content[height]" placeholder="高度" required title="请填写视频的高度" value="480">
    </div>
</div><?php endif; ?>