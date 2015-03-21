-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-03-19 05:15:14
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `fl_file`
--

CREATE TABLE IF NOT EXISTS `fl_file` (
`id` int(10) unsigned NOT NULL COMMENT '文件ID',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '原始文件名',
  `savename` char(20) NOT NULL DEFAULT '' COMMENT '保存名称',
  `savepath` char(30) NOT NULL DEFAULT '' COMMENT '文件保存路径',
  `ext` char(5) NOT NULL DEFAULT '' COMMENT '文件后缀',
  `mime` char(40) NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `location` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '文件保存位置',
  `url` varchar(255) DEFAULT '' COMMENT '远程链接',
  `create_time` int(10) unsigned NOT NULL COMMENT '上传时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文件表' AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `fl_post`
--

CREATE TABLE IF NOT EXISTS `fl_post` (
`id` int(11) unsigned NOT NULL COMMENT '主键',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `description` text COMMENT '描述',
  `member_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id 0-为官方发布的',
  `type` enum('text','pic','music','video','single') NOT NULL DEFAULT 'text' COMMENT '日志类型',
  `deadline` datetime DEFAULT NULL COMMENT '截止日期 用于定时发布',
  `tags` text COMMENT '标签',
  `views` int(11) unsigned NOT NULL COMMENT '浏览数',
  `comments` int(11) unsigned NOT NULL COMMENT '评论数',
  `content` text NOT NULL COMMENT '内容',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT 'status -1删除 0-草稿 1-正常',
  `create_at` datetime NOT NULL COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='日志表' AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

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
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID';
--
-- AUTO_INCREMENT for table `fl_file`
--
ALTER TABLE `fl_file`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件ID';
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
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id自增';
--
-- AUTO_INCREMENT for table `fl_post`
--
ALTER TABLE `fl_post`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键';
--
-- AUTO_INCREMENT for table `fl_tags`
--
ALTER TABLE `fl_tags`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fl_url`
--
ALTER TABLE `fl_url`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '链接唯一标识';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
