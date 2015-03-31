-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-03-31 06:24:52
-- 服务器版本： 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `freelog`
--

-- --------------------------------------------------------

--
-- 表的结构 `fl_comment`
--

CREATE TABLE IF NOT EXISTS `fl_comment` (
`id` int(11) unsigned NOT NULL COMMENT '主键',
  `post_id` int(11) unsigned NOT NULL COMMENT '日志id',
  `content` text NOT NULL COMMENT '评论内容',
  `member_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员id',
  `reply_comment_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '回复评论id',
  `create_at` datetime DEFAULT NULL COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论id' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `fl_config`
--

CREATE TABLE IF NOT EXISTS `fl_config` (
`id` int(10) unsigned NOT NULL COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置说明',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '配置值',
  `remark` varchar(100) NOT NULL COMMENT '配置说明',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `value` longtext NOT NULL COMMENT '配置值',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=55 ;

--
-- 转存表中的数据 `fl_config`
--

INSERT INTO `fl_config` (`id`, `name`, `type`, `title`, `group`, `extra`, `remark`, `create_time`, `update_time`, `status`, `value`, `sort`) VALUES
(1, 'WEB_SITE_TITLE', 1, '网站标题', 1, '', '网站标题前台显示标题', 1378898976, 1379235274, 1, '基于thinkphp3.2的轻型博客', 8),
(2, 'WEB_SITE_DESCRIPTION', 2, '网站描述', 1, '', '网站搜索引擎描述', 1378898976, 1379235841, 1, '每个tper 新手该学习使用的博客，\r\n集成onethink里插件扩展机制的博客，\r\n可以换肤的博客，\r\n前台模板代码合理的博客。\r\n', 9),
(3, 'WEB_SITE_KEYWORD', 2, '网站关键字', 1, '', '网站搜索引擎关键字', 1378898976, 1381390100, 1, 'ThinkPHP,OneThink,OneBlog,Bootstrap2', 10),
(4, 'WEB_SITE_CLOSE', 4, '关闭站点', 1, '0:关闭,1:开启', '站点关闭后其他用户不能访问，管理员可以正常访问', 1378898976, 1379235296, 1, '1', 14),
(9, 'CONFIG_TYPE_LIST', 3, '配置类型列表', 4, '', '主要用于数据解析和页面表单的生成', 1378898976, 1379235348, 1, '0:数字\r\n1:字符\r\n2:文本\r\n3:数组\r\n4:枚举', 26),
(10, 'WEB_SITE_ICP', 1, '网站备案号', 1, '', '设置在网站底部显示的备案号，如“沪ICP备12007941号-2', 1378900335, 1379235859, 1, '沪ICP备12007941号-2', 27),
(13, 'COLOR_STYLE', 4, '后台色系', 1, 'typecho_color:仿typecho', '后台颜色风格', 1379122533, 1392212877, 1, 'typecho_color', 28),
(20, 'CONFIG_GROUP_LIST', 3, '配置分组', 4, '', '配置分组', 1379228036, 1403913187, 1, '1:基本\r\n4:站点框架\r\n5:个人设置', 22),
(21, 'HOOKS_TYPE', 3, '钩子的类型', 4, '', '类型 1-用于扩展显示内容，2-用于扩展业务处理', 1379313397, 1379313407, 1, '1:视图\r\n2:控制器', 24),
(54, 'WEB_SITE_NAME', 1, '站点名称', 1, '', '用于底部或者介绍站点名称的地方', 1403913312, 1403913312, 1, 'OneBlog', 0),
(25, 'LIST_ROWS', 0, '后台每页记录数', 5, '', '后台数据每页显示记录数', 1379503896, 1392017862, 1, '10', 30),
(27, 'CODEMIRROR_THEME', 4, '预览插件的CodeMirror主题', 1, '3024-day:3024 day\r\n3024-night:3024 night\r\nambiance:ambiance\r\nbase16-dark:base16 dark\r\nbase16-light:base16 light\r\nblackboard:blackboard\r\ncobalt:cobalt\r\neclipse:eclipse\r\nelegant:elegant\r\nerlang-dark:erlang-dark\r\nlesser-dark:lesser-dark\r\nmidnight:midnight', '详情见CodeMirror官网', 1379814385, 1390906341, 1, 'ambiance', 19),
(30, 'DATA_BACKUP_COMPRESS', 4, '数据库备份文件是否启用压缩', 4, '0:不压缩\r\n1:启用压缩', '压缩备份文件需要PHP环境支持gzopen,gzwrite函数', 1381713345, 1381729544, 1, '1', 23),
(33, 'ALLOW_VISIT', 3, '不受限控制器方法', 4, '', '', 1386644047, 1403913198, 1, '0:article/draftbox\r\n1:article/mydocument\r\n2:Category/tree\r\n3:Index/verify\r\n4:file/upload\r\n5:file/download\r\n6:user/updatePassword\r\n7:user/updateNickname\r\n8:user/submitPassword\r\n9:user/submitNickname\r\n10:file/uploadpicture', 25),
(34, 'DENY_VISIT', 3, '超管专限控制器方法', 4, '', '仅超级管理员可访问的控制器方法', 1386644141, 1403913177, 1, '0:Addons/addhook\r\n1:Addons/edithook\r\n2:Addons/delhook\r\n3:Addons/updateHook\r\n4:Admin/getMenus\r\n5:Admin/recordList\r\n6:AuthManager/updateRules\r\n7:AuthManager/tree', 13),
(36, 'ADMIN_ALLOW_IP', 2, '后台允许访问IP', 4, '', '多个用逗号分隔，如果不配置表示不限制IP访问', 1387165454, 1387165553, 1, '', 35),
(37, 'SHOW_PAGE_TRACE', 4, '是否显示页面Trace', 4, '0:关闭\r\n1:开启', '是否显示页面Trace信息', 1387165685, 1390274668, 1, '1', 33),
(41, 'FRONT_THEME', 0, '前台主题', 5, '', '前台主题配置，覆盖系统文件', 1392108077, 1403911179, 1, 'red', 2),
(40, 'FEEDFULLTEXT', 0, '聚合全文输出', 1, '0:仅输出摘要,1:全文输出', '如果你不希望在聚合中输出文章全文,请使用仅输出摘要选项.\r\n摘要的文字来自description字段，此字段无内容就截取前200个字符.', 1391997436, 1403911161, 1, '1', 1),
(42, 'PICTURE_UPLOAD_DRIVER', 4, '图片上传驱动类型', 4, 'Bcs:Bae-云环境\r\nSae:Sae-Storage\r\nLocal:Local-本地\r\nFtp:Ftp空间\r\nUpyun:有拍云', '需要配置相应的UPLOAD_{driver}_CONFIG 配置 放可使用，不然默认Local本地', 1393073505, 1393073505, 1, 'Local', 3),
(43, 'UPLOAD_BCS_CONFIG', 3, 'Bae上传配置', 4, '', '', 1393073559, 1393073559, 1, 'AccessKey:3321f2709bffb9b7af32982b1bb3179f\r\nSecretKey:67485cd6f033ffaa0c4872c9936f8207\r\nbucket:jaylab\r\nrename:0', 4),
(44, 'UPLOAD_SAE_CONFIG', 3, 'Sae上传配置', 4, '', 'sae Domain 配了 用domain ，没配用上传方法的第一个目录', 1393073998, 1393073998, 1, 'domain:123', 5),
(45, 'UPLOAD_QINIU_CONFIG', 3, '七牛上传配置', 4, '', '', 1393074989, 1393074989, 1, 'accessKey:ODsglZwwjRJNZHAu7vtcEf-zgIxdQAY-QqVrZD\r\nsecrectKey:Z9-RahGtXhKeTUYy9WCnLbQ98ZuZ_paiaoBjByKv\r\nbucket:onethinktest\r\ndomain:onethinktest.u.qiniudn.com\r\ntimeout:3600', 6),
(46, 'VERSION', 1, '站点版本', 4, '', '当前博客的版本', 1397351001, 1397956042, 1, '1.00beta', 7);

-- --------------------------------------------------------

--
-- 表的结构 `fl_file`
--

CREATE TABLE IF NOT EXISTS `fl_file` (
`id` int(10) unsigned NOT NULL COMMENT '文件ID',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '原始文件名',
  `savename` char(20) NOT NULL DEFAULT '' COMMENT '保存名称',
  `savepath` char(30) NOT NULL DEFAULT '' COMMENT '文件保存路径',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '全路径',
  `ext` char(5) NOT NULL DEFAULT '' COMMENT '文件后缀',
  `mime` char(40) NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `location` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '文件保存位置',
  `url` varchar(255) DEFAULT '' COMMENT '远程链接',
  `create_time` int(10) unsigned NOT NULL COMMENT '上传时间'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文件表' AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `fl_file`
--

INSERT INTO `fl_file` (`id`, `name`, `savename`, `savepath`, `path`, `ext`, `mime`, `size`, `md5`, `sha1`, `location`, `url`, `create_time`) VALUES
(8, 'front4.mp4', '551357d99024b.mp4', '2015-03-26/', '/Uploads/file/2015-03-26/551357d99024b.mp4', 'mp4', 'video/mp4', 11860114, '987780a2790351a968a5d08de6ed0a6b', '83b597d84628790301e6aeb307709fb940ef0e96', 0, '', 1427331033),
(5, '杰伦婚礼进行曲.MP3', '5512db7a5cb89.MP3', '2015-03-25/', '/Uploads/file/2015-03-25/5512db7a5cb89.MP3', 'MP3', 'audio/mpeg', 3091467, 'f84b0cc4781a754ebd12e3f83d801c37', 'bb19cdd31fc2bc54be048d02e7b40105f3588d2f', 0, '', 1427299194),
(6, 'Music of Wedding by Jay  320K.', '5513533dd0296.MP3', '2015-03-26/', '/Uploads/file/2015-03-26/5513533dd0296.MP3', 'MP3', 'audio/mpeg', 5152423, '65e52b74fad9e55df62ab4cfb57b92c2', 'c9f55f613f2a9560c21655891e86e80d14cdac83', 0, '', 1427329853),
(7, 'Nick Carter - Just one kiss [m', '55135341616cf.mp3', '2015-03-26/', '/Uploads/file/2015-03-26/55135341616cf.mp3', 'mp3', 'application/octet-stream', 3408500, '5a8416eba5280826d411e7d9b6a22fe0', '176baa35992d7758442f20ab3491d3b356327b62', 0, '', 1427329857);

-- --------------------------------------------------------

--
-- 表的结构 `fl_member`
--

CREATE TABLE IF NOT EXISTS `fl_member` (
`id` int(11) unsigned NOT NULL COMMENT '主键',
  `email` varchar(320) NOT NULL DEFAULT '' COMMENT '邮箱',
  `email_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 激活 0 未激活',
  `domain` varchar(32) NOT NULL DEFAULT '' COMMENT '域名',
  `nickname` varchar(64) NOT NULL DEFAULT '' COMMENT '昵称',
  `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '性别 1-男 0-女',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `pwd` char(64) NOT NULL DEFAULT '' COMMENT '加密后的密码',
  `settings` text NOT NULL COMMENT '配置序列化字段',
  `avatar` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '头像图片id',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '-1 删除 0禁用 1 有效',
  `create_at` datetime DEFAULT NULL COMMENT '创建时间',
  `update_at` datetime DEFAULT NULL COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `fl_message`
--

CREATE TABLE IF NOT EXISTS `fl_message` (
`id` int(11) unsigned NOT NULL COMMENT '主键',
  `content` varchar(2048) NOT NULL COMMENT '消息',
  `member_id` int(11) unsigned NOT NULL COMMENT '所有者id',
  `from_member_id` int(11) NOT NULL DEFAULT '0' COMMENT '消息来源用户 0 系统 大于0是member_id',
  `is_read` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否已读 0 未读 1 已读',
  `create_at` datetime DEFAULT NULL COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='消息表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `fl_picture`
--

CREATE TABLE IF NOT EXISTS `fl_picture` (
`id` int(10) unsigned NOT NULL COMMENT '主键id自增',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '路径',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片链接',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `fl_picture`
--

INSERT INTO `fl_picture` (`id`, `path`, `url`, `md5`, `sha1`, `status`, `create_time`) VALUES
(1, '/Uploads/picture/2015-03-25/551207caea358.png', '', 'c6163cd6da9b5eba31b786d665adaa59', '6387466b674532a48d2f6d340fe2378ec750c49d', 1, 1427245002);

-- --------------------------------------------------------

--
-- 表的结构 `fl_post`
--

CREATE TABLE IF NOT EXISTS `fl_post` (
`id` int(11) unsigned NOT NULL COMMENT '主键',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `description` text COMMENT '描述',
  `member_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id 0-为官方发布的',
  `type` enum('text','picture','music','video','single') NOT NULL DEFAULT 'text' COMMENT '日志类型',
  `deadline` datetime DEFAULT NULL COMMENT '截止日期 用于定时发布',
  `tags` text COMMENT '标签',
  `views` int(11) unsigned NOT NULL COMMENT '浏览数',
  `comments` int(11) unsigned NOT NULL COMMENT '评论数',
  `content` text NOT NULL COMMENT '内容',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT 'status -1删除 0-草稿 1-正常',
  `create_at` datetime NOT NULL COMMENT '创建时间',
  `update_at` datetime DEFAULT NULL COMMENT '更新时间'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='日志表' AUTO_INCREMENT=49 ;

--
-- 转存表中的数据 `fl_post`
--

INSERT INTO `fl_post` (`id`, `title`, `description`, `member_id`, `type`, `deadline`, `tags`, `views`, `comments`, `content`, `status`, `create_at`, `update_at`) VALUES
(46, 'jobdeer官方介绍', '&lt;p&gt;Jobdeer 竞鹿官方介绍视频&lt;/p&gt;', 0, 'video', '2015-03-26 08:51:26', '视频', 9, 0, '{"cover":"","video_id":"8","video_url":"\\/Uploads\\/file\\/2015-03-26\\/551357d99024b.mp4","width":"640","height":"480","preload":"1"}', 1, '2015-03-26 08:51:26', '2015-03-26 08:51:26'),
(45, '', '&lt;p&gt;杰伦婚礼进行曲合集&lt;/p&gt;', 0, 'music', '2015-03-26 08:31:41', '音乐', 23, 0, '[{"id":"6","path":"Music of Wedding by Jay  320K.MP3","title":"Jay - Music of Wedding"},{"id":"7","path":"Nick Carter - Just one kiss [mqms2].mp3","title":"Nick Carter - Just one kiss"}]', 1, '2015-03-26 08:31:41', '2015-03-26 08:31:41'),
(44, 'Hello,World', NULL, 0, 'text', '2015-03-26 08:01:46', '博文', 2, 0, '&lt;p&gt;欢迎来到freelog&lt;/p&gt;', 1, '2015-03-26 08:01:46', '2015-03-26 08:01:46'),
(43, '', '', 0, 'music', '2015-03-26 00:17:04', '', 10, 0, '[{"id":"5","path":"\\u6770\\u4f26\\u5a5a\\u793c\\u8fdb\\u884c\\u66f2.MP3","title":"婚礼进行曲 "}]', 1, '2015-03-26 00:17:04', '2015-03-26 00:17:04'),
(47, '', '&lt;p&gt;图片&lt;/p&gt;', 0, 'picture', '2015-03-26 22:38:45', '图片', 2, 0, '[{"alt":"jobdeer","path":"\\/Uploads\\/ueditor\\/image\\/20150326\\/551419ea0d30c.png"},{"alt":"blackwhite","path":"\\/Uploads\\/ueditor\\/image\\/20150326\\/551419ea33999.jpg"}]', 1, '2015-03-26 22:38:45', '2015-03-26 22:38:45'),
(48, '绵阳南街小学校园比赛 六（3）班女篮锦集', '&lt;p&gt;小学女子篮球&lt;/p&gt;', 0, 'video', '2015-03-29 18:02:27', '视频', 9, 0, '{"cover":"http:\\/\\/g4.ykimg.com\\/1100641F46550AB93FD60315529950AE8F1885-1E86-1986-F541-95D9ED700FDB","video_id":"0","video_url":"http:\\/\\/player.youku.com\\/player.php\\/sid\\/XOTE1NDg4OTE2\\/v.swf","width":"640","height":"480"}', 1, '2015-03-29 18:02:27', '2015-03-29 18:02:27');

-- --------------------------------------------------------

--
-- 表的结构 `fl_sns`
--

CREATE TABLE IF NOT EXISTS `fl_sns` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL COMMENT '用户',
  `type` varchar(20) NOT NULL COMMENT '绑定平台类型',
  `access_token` varchar(100) DEFAULT NULL,
  `expires_in` varchar(10) DEFAULT NULL COMMENT '授权失效时间',
  `name` varchar(100) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL,
  `openkey` varchar(50) DEFAULT NULL,
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '绑定时间，判断是否过期',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '绑定状态 ',
  `extend` text COMMENT '扩展字段'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='第三方登录授权绑定表';

-- --------------------------------------------------------

--
-- 表的结构 `fl_tags`
--

CREATE TABLE IF NOT EXISTS `fl_tags` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `description` varchar(200) DEFAULT NULL COMMENT '描述',
  `count` int(10) unsigned DEFAULT '0' COMMENT '数量',
  `order` int(10) unsigned DEFAULT '0' COMMENT '排序'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `fl_tags`
--

INSERT INTO `fl_tags` (`id`, `title`, `description`, `count`, `order`) VALUES
(5, '视频', NULL, 3, 0),
(7, '博文', NULL, 1, 0),
(8, '音乐', NULL, 1, 0),
(9, '图片', NULL, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `fl_url`
--

CREATE TABLE IF NOT EXISTS `fl_url` (
`id` int(11) unsigned NOT NULL COMMENT '链接唯一标识',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `short` char(100) NOT NULL DEFAULT '' COMMENT '短网址',
  `status` tinyint(2) NOT NULL DEFAULT '2' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='链接表' AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fl_comment`
--
ALTER TABLE `fl_comment`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fl_config`
--
ALTER TABLE `fl_config`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `uk_name` (`name`);

--
-- Indexes for table `fl_file`
--
ALTER TABLE `fl_file`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `uk_md5` (`md5`);

--
-- Indexes for table `fl_member`
--
ALTER TABLE `fl_member`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fl_message`
--
ALTER TABLE `fl_message`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fl_picture`
--
ALTER TABLE `fl_picture`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fl_post`
--
ALTER TABLE `fl_post`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fl_tags`
--
ALTER TABLE `fl_tags`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fl_url`
--
ALTER TABLE `fl_url`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `idx_url` (`url`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fl_comment`
--
ALTER TABLE `fl_comment`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键';
--
-- AUTO_INCREMENT for table `fl_config`
--
ALTER TABLE `fl_config`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `fl_file`
--
ALTER TABLE `fl_file`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件ID',AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `fl_member`
--
ALTER TABLE `fl_member`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键';
--
-- AUTO_INCREMENT for table `fl_message`
--
ALTER TABLE `fl_message`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键';
--
-- AUTO_INCREMENT for table `fl_picture`
--
ALTER TABLE `fl_picture`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id自增',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fl_post`
--
ALTER TABLE `fl_post`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `fl_tags`
--
ALTER TABLE `fl_tags`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `fl_url`
--
ALTER TABLE `fl_url`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '链接唯一标识';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
