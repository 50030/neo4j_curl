/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : zheng

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 15/02/2024 14:49:09
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for family_admin
-- ----------------------------
DROP TABLE IF EXISTS `family_admin`;
CREATE TABLE `family_admin`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增',
  `admin` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '管理员用户名',
  `create_time` int(10) UNSIGNED NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '管理员表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of family_admin
-- ----------------------------
INSERT INTO `family_admin` VALUES (1, 'admin', 1576065100);

-- ----------------------------
-- Table structure for family_admin_password
-- ----------------------------
DROP TABLE IF EXISTS `family_admin_password`;
CREATE TABLE `family_admin_password`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `admin_id` int(10) UNSIGNED NOT NULL COMMENT '管理员id',
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '管理员密码表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of family_admin_password
-- ----------------------------
INSERT INTO `family_admin_password` VALUES (1, 1, '$2y$10$5n0D67AOFS7lhKj3UMPxA.NyL/TWxzq0139I5G0z/7CigKh0KDOyW');

-- ----------------------------
-- Table structure for family_category
-- ----------------------------
DROP TABLE IF EXISTS `family_category`;
CREATE TABLE `family_category`  (
  `cat_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` smallint(5) UNSIGNED NOT NULL,
  `cat_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '类别名称',
  `cat_mark` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标识',
  `orderno` mediumint(9) NOT NULL,
  `is_enable` tinyint(4) NOT NULL DEFAULT -1 COMMENT '是否可用：1可用，2不可用',
  `delete_time` int(10) UNSIGNED NOT NULL COMMENT '删除时间',
  `remark` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '注释',
  `color` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '颜色',
  PRIMARY KEY (`cat_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 203 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '类别表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of family_category
-- ----------------------------
INSERT INTO `family_category` VALUES (201, 0, '始祖', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (202, 201, '杨某', '', 0, 1, 0, '大儿', 'FFFFFF');

-- ----------------------------
-- Table structure for family_category_group
-- ----------------------------
DROP TABLE IF EXISTS `family_category_group`;
CREATE TABLE `family_category_group`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `mark` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标识',
  `root_cat_id` int(10) UNSIGNED NOT NULL COMMENT '根类别id',
  `cat_group` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '类别组集合',
  `rebuild` tinyint(4) NOT NULL DEFAULT -1 COMMENT '是否重建：1已重建，2未重建',
  `orderno` int(11) NOT NULL COMMENT '排序值',
  `is_enable` tinyint(4) NOT NULL DEFAULT -1 COMMENT '是否启用：1启用，2未启用',
  `remark` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注',
  `delete_time` int(11) UNSIGNED NOT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '类别组' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of family_category_group
-- ----------------------------

-- ----------------------------
-- Table structure for family_set
-- ----------------------------
DROP TABLE IF EXISTS `family_set`;
CREATE TABLE `family_set`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `cat_id` int(10) UNSIGNED NOT NULL COMMENT '类别id',
  `orderno` int(10) NOT NULL,
  `is_enable` tinyint(4) NOT NULL DEFAULT -1 COMMENT '是否启用：1启用，2不启用',
  `delete_time` int(10) UNSIGNED NOT NULL COMMENT '删除时间',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名称',
  `key` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `remark` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 158 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '公共配置表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of family_set
-- ----------------------------
INSERT INTO `family_set` VALUES (1, 0, 0, 1, 0, '分页数', 'pageSize', '10', '每页条数');
INSERT INTO `family_set` VALUES (151, 0, 0, 1, 0, '提示时间', 'waitTime', '500', '提示停留时间');
INSERT INTO `family_set` VALUES (152, 0, -100, 2, 0, '订单未支付保留时间', 'keepTime', '86400', '第一次未支付保留 N 秒，以后再有未支付自动缩短一半时间');

SET FOREIGN_KEY_CHECKS = 1;
