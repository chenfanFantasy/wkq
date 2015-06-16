/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50611
Source Host           : localhost:3306
Source Database       : wkq_system

Target Server Type    : MYSQL
Target Server Version : 50611
File Encoding         : 65001

Date: 2015-06-15 23:11:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `wkq_help_center`
-- ----------------------------
DROP TABLE IF EXISTS `wkq_help_center`;
CREATE TABLE `wkq_help_center` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `articleTitle` varchar(40) NOT NULL DEFAULT '' COMMENT '标题',
  `articleCategory` varchar(10) DEFAULT '' COMMENT '类别',
  `articleAuthor` varchar(20) DEFAULT '' COMMENT '作者',
  `articleContent` text NOT NULL COMMENT '内容',
  `articleAddTime` int(10) DEFAULT '0' COMMENT '添加时间',
  `is_delete` tinyint(1) DEFAULT '0' COMMENT '逻辑删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wkq_help_center
-- ----------------------------

-- ----------------------------
-- Table structure for `wkq_money`
-- ----------------------------
DROP TABLE IF EXISTS `wkq_money`;
CREATE TABLE `wkq_money` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `moneyType` int(2) DEFAULT '0' COMMENT '类型',
  `moneyNumber` decimal(10,2) DEFAULT '0.00' COMMENT '金额',
  `moneyBank` varchar(40) DEFAULT '' COMMENT '银行',
  `moneyAccountHolder` varchar(20) DEFAULT '' COMMENT '开户人',
  `moneyAccountAddress` varchar(40) DEFAULT '' COMMENT '开户地',
  `moneyAccount` varchar(19) DEFAULT '' COMMENT '账号',
  `moneyApplyTime` int(10) DEFAULT '0' COMMENT '申请时间',
  `moneyCashTime` int(10) DEFAULT '0' COMMENT '提现时间',
  `is_delete` tinyint(1) DEFAULT '0' COMMENT '逻辑删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wkq_money
-- ----------------------------

-- ----------------------------
-- Table structure for `wkq_result`
-- ----------------------------
DROP TABLE IF EXISTS `wkq_result`;
CREATE TABLE `wkq_result` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `resultPictureOpinion` varchar(100) DEFAULT '' COMMENT '上传的带图好评',
  `resultChatPicture` varchar(100) DEFAULT '' COMMENT '拍前聊截图',
  `resultWordPicture` varchar(100) DEFAULT '' COMMENT '好评截图',
  `is_delete` tinyint(1) DEFAULT '0',
  `taskId` int(10) DEFAULT '0' COMMENT '任务ID',
  `userId` int(10) DEFAULT '0' COMMENT '用户ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wkq_result
-- ----------------------------

-- ----------------------------
-- Table structure for `wkq_task`
-- ----------------------------
DROP TABLE IF EXISTS `wkq_task`;
CREATE TABLE `wkq_task` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `sellerId` int(10) DEFAULT '0' COMMENT '卖家ID',
  `buyerId` int(10) DEFAULT '0' COMMENT '买家id',
  `taskOrderNum` varchar(30) DEFAULT '' COMMENT '订单编号',
  `taskNum` varchar(30) DEFAULT '' COMMENT '任务编号',
  `taskShopkeeper` varchar(20) DEFAULT '' COMMENT '掌柜号',
  `taskGoodsAddress` varchar(200) DEFAULT '' COMMENT '商品地址',
  `taskGoodsPrice` decimal(7,2) DEFAULT '0.00',
  `taskPicture` varchar(100) DEFAULT '',
  `taskGoodsName` varchar(80) DEFAULT '' COMMENT '商品名称',
  `taskAssurePrice` decimal(7,2) DEFAULT '0.00' COMMENT '担保价格',
  `taskAddTime` int(10) DEFAULT '0' COMMENT '任务添加时间',
  `taskFinishTime` int(10) DEFAULT '0' COMMENT '任务完成时间',
  `taskIsTemplet` tinyint(1) DEFAULT '1' COMMENT '是否是模板1不是模板2实模板',
  `taskTempletName` varchar(16) DEFAULT '' COMMENT '模板名称',
  `taskAllPoint` decimal(5,2) DEFAULT '0.00' COMMENT '总共发布点',
  `taskStatus` int(2) DEFAULT '0' COMMENT '任务状态',
  `tasktype` tinyint(1) DEFAULT '0' COMMENT '任务类型',
  `taskBasePoint` decimal(5,2) DEFAULT '0.00' COMMENT '基本发布点',
  `taskWaybillNumType` tinyint(1) DEFAULT '0' COMMENT '运单号类型1代发空包2自发空包',
  `taskWaybillNum` varchar(30) DEFAULT '' COMMENT '运单号',
  `taskIssetKeys` tinyint(1) DEFAULT '1' COMMENT '是否启用关键字1没有2有',
  `taskIssetScript` tinyint(1) DEFAULT '1' COMMENT '是否设置定时脚本1没有2有',
  `taskScriptTime` int(10) DEFAULT '0' COMMENT '脚本时间',
  `taskSpaceTime` int(3) DEFAULT '0' COMMENT '间隔时间   单位为分钟',
  `taskKeys` varchar(1000) DEFAULT '' COMMENT '关键字Json',
  `taskMessage` varchar(200) DEFAULT '' COMMENT '卖家留言（卖家提醒买家）',
  `is_delete` tinyint(1) DEFAULT '0' COMMENT '逻辑删除',
  `taskGoodsCompare` tinyint(1) DEFAULT '1' COMMENT '货币三家 1要2不要',
  `taskCollect` tinyint(1) DEFAULT '1' COMMENT '店铺和宝贝双收藏 1收藏  2没有',
  `taskBuyerLimit` tinyint(1) DEFAULT '1' COMMENT '接手买号限制',
  `taskIssetWordsOption` tinyint(1) DEFAULT '1' COMMENT '是否启用文字好评 1没有启用 2 启用好评方向 3启用好评内容',
  `taskWordContent` varchar(200) DEFAULT '' COMMENT '文字好评内容',
  `taskPictureOption` varchar(100) DEFAULT '' COMMENT '带图好评',
  `taskIsRealName` tinyint(1) DEFAULT '0' COMMENT '是否是实名认证 1不是 2 是',
  `taskBuyerAccountRegTime` tinyint(10) DEFAULT '0' COMMENT '注册日期 1不限 2满1个月 3满3个月 4满6个月 5满12个月 6满24个月 7满36个月',
  `taskStopTime` int(2) DEFAULT '0' COMMENT '停留时间 1停5分钟 2停10 3停15 4停20',
  `taskAddPoint` decimal(5,2) DEFAULT '0.00' COMMENT '追加发布点',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wkq_task
-- ----------------------------

-- ----------------------------
-- Table structure for `wkq_task_templet`
-- ----------------------------
DROP TABLE IF EXISTS `wkq_task_templet`;
CREATE TABLE `wkq_task_templet` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `sellerId` int(10) DEFAULT '0' COMMENT '卖家ID',
  `buyerId` int(10) DEFAULT '0' COMMENT '买家id',
  `taskOrderNum` varchar(30) DEFAULT '' COMMENT '订单编号',
  `taskNum` varchar(30) DEFAULT '' COMMENT '任务编号',
  `taskShopkeeper` varchar(20) DEFAULT '' COMMENT '掌柜号',
  `taskGoodsAddress` varchar(200) DEFAULT '' COMMENT '商品地址',
  `taskGoodsPrice` decimal(7,2) DEFAULT '0.00',
  `taskPicture` varchar(100) DEFAULT '',
  `taskGoodsName` varchar(80) DEFAULT '' COMMENT '商品名称',
  `taskAssurePrice` decimal(7,2) DEFAULT '0.00' COMMENT '担保价格',
  `taskAddTime` int(10) DEFAULT '0' COMMENT '任务添加时间',
  `taskFinishTime` int(10) DEFAULT '0' COMMENT '任务完成时间',
  `taskIsTemplet` tinyint(1) DEFAULT '1' COMMENT '是否是模板1不是模板2实模板',
  `taskTempletName` varchar(16) DEFAULT '' COMMENT '模板名称',
  `taskAllPoint` decimal(5,2) DEFAULT '0.00' COMMENT '总共发布点',
  `taskStatus` int(2) DEFAULT '0' COMMENT '任务状态',
  `tasktype` tinyint(1) DEFAULT '0' COMMENT '任务类型',
  `taskBasePoint` decimal(5,2) DEFAULT '0.00' COMMENT '基本发布点',
  `taskWaybillNumType` tinyint(1) DEFAULT '0' COMMENT '运单号类型1代发空包2自发空包',
  `taskWaybillNum` varchar(30) DEFAULT '' COMMENT '运单号',
  `taskIssetKeys` tinyint(1) DEFAULT '1' COMMENT '是否启用关键字1没有2有',
  `taskIssetScript` tinyint(1) DEFAULT '1' COMMENT '是否设置定时脚本1没有2有',
  `taskScriptTime` int(10) DEFAULT '0' COMMENT '脚本时间',
  `taskSpaceTime` int(3) DEFAULT '0' COMMENT '间隔时间   单位为分钟',
  `taskKeys` varchar(1000) DEFAULT '' COMMENT '关键字Json',
  `taskMessage` varchar(200) DEFAULT '' COMMENT '卖家留言（卖家提醒买家）',
  `is_delete` tinyint(1) DEFAULT '0' COMMENT '逻辑删除',
  `taskGoodsCompare` tinyint(1) DEFAULT '1' COMMENT '货币三家 1要2不要',
  `taskCollect` tinyint(1) DEFAULT '1' COMMENT '店铺和宝贝双收藏 1收藏  2没有',
  `taskBuyerLimit` tinyint(1) DEFAULT '1' COMMENT '接手买号限制',
  `taskIssetWordsOption` tinyint(1) DEFAULT '1' COMMENT '是否启用文字好评 1没有启用 2 启用好评方向 3启用好评内容',
  `taskWordContent` varchar(200) DEFAULT '' COMMENT '文字好评内容',
  `taskPictureOption` varchar(100) DEFAULT '' COMMENT '带图好评',
  `taskIsRealName` tinyint(1) DEFAULT '0' COMMENT '是否是实名认证 1不是 2 是',
  `taskBuyerAccountRegTime` tinyint(10) DEFAULT '0' COMMENT '注册日期 1不限 2满1个月 3满3个月 4满6个月 5满12个月 6满24个月 7满36个月',
  `taskStopTime` int(2) DEFAULT '0' COMMENT '停留时间 1停5分钟 2停10 3停15 4停20',
  `taskAddPoint` decimal(5,2) DEFAULT '0.00' COMMENT '追加发布点',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wkq_task_templet
-- ----------------------------

-- ----------------------------
-- Table structure for `wk_account`
-- ----------------------------
DROP TABLE IF EXISTS `wk_account`;
CREATE TABLE `wk_account` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `userId` int(10) DEFAULT '0' COMMENT '用户ID',
  `accountType` tinyint(1) DEFAULT '0' COMMENT '账号类型 ',
  `accountPlatform` int(2) DEFAULT '0' COMMENT '账号平台',
  `accountName` varchar(30) DEFAULT '' COMMENT '账号名',
  `accountStatus` int(2) DEFAULT '0' COMMENT '状态',
  `accountIsRealName` tinyint(1) DEFAULT '0' COMMENT '是否是实名制',
  `accountDayCatcher` int(3) DEFAULT '0' COMMENT '日可接手',
  `accountWeekCatcher` int(3) DEFAULT '0' COMMENT '周可接手',
  `accountMonthCatcher` int(3) DEFAULT '0' COMMENT '月可接手',
  `accountLastMakeOrderTime` int(10) DEFAULT '0' COMMENT '最近一次接单时间',
  `accountAddTime` int(10) DEFAULT '0' COMMENT '添加到平台的时间',
  `accountDeleteTime` int(10) DEFAULT '0' COMMENT '在平台的删除时间',
  `accountRegisterTime` int(10) DEFAULT '0' COMMENT '账号的注册时间',
  `accountRank` int(3) DEFAULT '0' COMMENT '账号的等级',
  `accountWeekCredit` int(3) DEFAULT '0' COMMENT '周信誉',
  `accountMonthCredit` int(3) DEFAULT '0' COMMENT '月信誉',
  `accountAddress` varchar(100) DEFAULT '' COMMENT '收货地址',
  `accountIsWireless` tinyint(1) DEFAULT '0' COMMENT '是否是无线端买号',
  `is_delete` tinyint(1) DEFAULT '0' COMMENT '逻辑删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wk_account
-- ----------------------------

-- ----------------------------
-- Table structure for `wk_user`
-- ----------------------------
DROP TABLE IF EXISTS `wk_user`;
CREATE TABLE `wk_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `userName` varchar(40) NOT NULL DEFAULT '' COMMENT '真实名字',
  `userNickName` varchar(60) NOT NULL DEFAULT '' COMMENT '昵称',
  `userType` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户类型1刷客2卖家',
  `userLoginPassword` varchar(65) NOT NULL DEFAULT '' COMMENT '登录密码',
  `userSafePassword` varchar(65) NOT NULL DEFAULT '' COMMENT '安全密码',
  `userEmail` varchar(64) NOT NULL DEFAULT '' COMMENT '邮箱',
  `userTelephone` varchar(12) DEFAULT '' COMMENT '电话号码',
  `userQq` varchar(12) DEFAULT '' COMMENT 'QQ号',
  `userRank` int(3) DEFAULT '0' COMMENT '用户等级',
  `userPoint` decimal(8,2) DEFAULT '0.00' COMMENT '发布点',
  `userMoney` decimal(8,2) DEFAULT '0.00' COMMENT '金额',
  `userIntegration` int(5) DEFAULT '0' COMMENT '积分',
  `userRefereeId` int(10) NOT NULL DEFAULT '0' COMMENT '推荐人',
  `userAddTime` int(10) DEFAULT '0' COMMENT '注册时间',
  `userLoginTime` int(10) DEFAULT '0' COMMENT '登录时间',
  `userLoginIp` char(16) DEFAULT '' COMMENT '登录ip',
  `is_delete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wk_user
-- ----------------------------
INSERT INTO `wk_user` VALUES ('1', 'rr', '', '0', '', '', '', null, null, null, null, null, null, '0', null, null, null, '0');
INSERT INTO `wk_user` VALUES ('2', 'yyn', '', '0', '', '', '', null, null, null, null, null, null, '0', null, null, null, '0');
