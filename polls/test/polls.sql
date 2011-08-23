/*
 Navicat Premium Data Transfer

 Source Server         : devserver
 Source Server Type    : MySQL
 Source Server Version : 50032
 Source Host           : 10.37.74.212
 Source Database       : polls

 Target Server Type    : MySQL
 Target Server Version : 50032
 File Encoding         : UTF-8

 Date: 02/25/2010 12:39:52 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `options`
-- ----------------------------
DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `option_id` mediumint(9) NOT NULL auto_increment,
  `poll_id` mediumint(9) NOT NULL,
  `option_text` varchar(255) NOT NULL,
  PRIMARY KEY  (`option_id`),
  KEY `poll_id` (`poll_id`)
) ENGINE=MyISAM AUTO_INCREMENT=96 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `polls`
-- ----------------------------
DROP TABLE IF EXISTS `polls`;
CREATE TABLE `polls` (
  `id` mediumint(9) NOT NULL auto_increment,
  `question` text NOT NULL,
  `max_options` tinyint(2) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `user_id` mediumint(9) NOT NULL,
  `type_id` mediumint(9) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `type_config`
-- ----------------------------
DROP TABLE IF EXISTS `type_config`;
CREATE TABLE `type_config` (
  `type_id` mediumint(9) NOT NULL auto_increment,
  `poll_type` varchar(50) NOT NULL,
  `poll_title` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL default '1',
  `friendly_name` varchar(100) NOT NULL,
  PRIMARY KEY  (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` mediumint(9) NOT NULL auto_increment,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `password_hint` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `locked` tinyint(1) NOT NULL default '0',
  `time_init` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `admin` tinyint(1) NOT NULL default '0',
  `time_locked` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `username_idx` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `votes`
-- ----------------------------
DROP TABLE IF EXISTS `votes`;
CREATE TABLE `votes` (
  `vote_id` mediumint(9) NOT NULL auto_increment,
  `poll_id` mediumint(9) NOT NULL,
  `option_id` mediumint(9) NOT NULL,
  `time_init` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `ip_address` varchar(25) NOT NULL,
  PRIMARY KEY  (`vote_id`),
  KEY `poll_id` (`poll_id`),
  KEY `option_id` (`option_id`)
) ENGINE=MyISAM AUTO_INCREMENT=160 DEFAULT CHARSET=latin1;

