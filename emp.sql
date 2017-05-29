/*
Navicat MySQL Data Transfer

Source Server         : localhost_mysql
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : emp

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2017-05-29 09:43:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for emp_admin
-- ----------------------------
DROP TABLE IF EXISTS `emp_admin`;
CREATE TABLE `emp_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `remark` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for emp_beautycategray
-- ----------------------------
DROP TABLE IF EXISTS `emp_beautycategray`;
CREATE TABLE `emp_beautycategray` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `intro` varchar(300) NOT NULL DEFAULT '',
  `is_show` enum('0','1') NOT NULL DEFAULT '1',
  `pid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for emp_comment
-- ----------------------------
DROP TABLE IF EXISTS `emp_comment`;
CREATE TABLE `emp_comment` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `title` varchar(300) NOT NULL DEFAULT '' COMMENT '评论标题（话题）',
  `content` text NOT NULL COMMENT '评论内容',
  `time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论的时间戳',
  `nice` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '顶',
  `bad` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '踩',
  `topic_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for emp_hot
-- ----------------------------
DROP TABLE IF EXISTS `emp_hot`;
CREATE TABLE `emp_hot` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL DEFAULT '',
  `action` varchar(15) NOT NULL DEFAULT '',
  `intro` text NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `is_show` enum('0','1') NOT NULL DEFAULT '1',
  `is_index` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for emp_replay
-- ----------------------------
DROP TABLE IF EXISTS `emp_replay`;
CREATE TABLE `emp_replay` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `com_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属评论Id',
  `content` varchar(1000) NOT NULL DEFAULT '' COMMENT '回复内容',
  `time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'hui回复时间戳',
  `nice` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '顶',
  `bad` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '踩',
  `topic_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `com_id` (`com_id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for emp_topic
-- ----------------------------
DROP TABLE IF EXISTS `emp_topic`;
CREATE TABLE `emp_topic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author` varchar(20) NOT NULL DEFAULT '' COMMENT '作者',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '话题标题',
  `intro` varchar(1000) NOT NULL DEFAULT '',
  `pic` varchar(255) NOT NULL DEFAULT '' COMMENT '显示图片',
  `is_index` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否显示到主页',
  `is_valid` enum('0','1') NOT NULL DEFAULT '1' COMMENT '是否有效',
  `cate_id` tinyint(3) unsigned NOT NULL,
  `time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`time`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for emp_topiccategray
-- ----------------------------
DROP TABLE IF EXISTS `emp_topiccategray`;
CREATE TABLE `emp_topiccategray` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `remark` varchar(300) NOT NULL DEFAULT '',
  `is_valid` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for emp_user
-- ----------------------------
DROP TABLE IF EXISTS `emp_user`;
CREATE TABLE `emp_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `alias` varchar(24) NOT NULL DEFAULT '',
  `pic` varchar(30) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `last_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
