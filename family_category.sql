/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : family

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 02/03/2024 16:34:05
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for family_category
-- ----------------------------
DROP TABLE IF EXISTS `family_category`;
CREATE TABLE `family_category`  (
  `cat_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id2` int(10) UNSIGNED NULL DEFAULT NULL,
  `pid2` int(10) UNSIGNED NULL DEFAULT NULL,
  `pid` smallint(5) UNSIGNED NOT NULL,
  `cat_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '类别名称',
  `cat_mark` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标识',
  `orderno` mediumint(9) NOT NULL,
  `is_enable` tinyint(4) NOT NULL DEFAULT -1 COMMENT '是否可用：1可用，2不可用',
  `delete_time` int(10) UNSIGNED NOT NULL COMMENT '删除时间',
  `remark` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '注释',
  `color` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '颜色',
  PRIMARY KEY (`cat_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 201 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '类别表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of family_category
-- ----------------------------
INSERT INTO `family_category` VALUES (89, NULL, NULL, 0, '郑氏家谱', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (90, 34, 0, 89, '一世郑玥', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (91, 35, 34, 90, '二世郑文举，郑玥长子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (92, 36, 35, 91, '三世郑代禹，郑文举次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (93, 37, 36, 92, '四世郑计常，郑代禹之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (94, 38, 37, 93, '五世郑朝圣，郑计常之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (95, 39, 38, 94, '六世郑仁，郑朝圣长子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (96, 40, 39, 95, '七世郑国安，郑仁之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (97, 41, 40, 96, '八世郑名银，郑国安次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (98, 42, 41, 97, '九世郑海，郑名银之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (99, 43, 42, 98, '十世郑可达，郑海长子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (100, 44, 43, 99, '十一世郑志尧，郑可达之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (101, 45, 44, 100, '十二世郑九如，郑志尧之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (102, 46, 45, 101, '十三世郑长清，郑九如次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (103, 47, 46, 102, '十四世郑安行，郑长清之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (104, 48, 47, 103, '十五世郑云秀，郑安行长子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (105, 49, 48, 104, '十六世郑本荣，郑云秀次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (106, 50, 49, 105, '十七世郑爱民，郑本荣长子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (107, 51, 49, 105, '十七世郑爱群，郑本荣次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (108, 52, 49, 105, '十七世郑爱军，郑本荣三子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (109, 53, 48, 104, '十六世郑本福，郑云秀长子', '', 10, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (110, 54, 48, 104, '十六世郑本贵，郑云秀三子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (111, 55, 34, 90, '二世郑文表，郑玥次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (112, 56, 34, 90, '二世郑文章，郑玥三子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (113, 57, 35, 91, '三世郑代贤，郑文举长子', '', 10, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (114, 58, 35, 91, '三世郑代善，郑文举三子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (115, 59, 35, 91, '三世郑代全，郑文举四子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (116, 60, 38, 94, '六世郑信，郑朝圣次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (117, 61, 38, 94, '六世郑义，郑 朝圣三子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (118, 62, 55, 111, '三世郑代兴，郑文表长子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (119, 63, 55, 111, '三世郑代江，郑文表次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (120, 64, 56, 112, '三世郑代才，郑文章长子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (121, 65, 56, 112, '三世郑代英，郑文章次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (122, 66, 65, 121, '四世 绝', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (123, 67, 64, 120, '四世 绝', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (124, 68, 63, 119, '四世 绝', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (125, 69, 62, 118, '四世 绝', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (126, 70, 58, 114, '四世郑计登，郑代善之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (127, 71, 57, 113, '四世郑计先，郑代贤长子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (128, 72, 57, 113, '四世郑计后，郑代贤次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (129, 73, 59, 115, '四世郑计选，郑代全之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (130, 74, 73, 129, '五世郑朝乡，郑计先之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (131, 75, 72, 128, '五世郑朝礼，郑计后之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (132, 76, 70, 126, '五世郑朝相，郑计登长子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (133, 77, 70, 126, '五世郑朝豹，郑计登次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (134, 78, 74, 130, '六世郑士吕，郑朝乡长子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (135, 79, 74, 130, '六世郑士名，郑朝乡次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (136, 80, 74, 130, '六世郑士成，郑朝乡三子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (137, 81, 75, 131, '六世郑士俊，郑朝礼之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (138, 82, 76, 132, '六世郑才兴，郑朝相之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (139, 83, 77, 133, '六世郑才贵，郑朝豹之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (140, 84, 71, 127, '五世郑朝印，郑计先之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (141, 85, 84, 140, '六世郑士宜，郑朝印长子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (142, 86, 84, 140, '六世郑士奇，郑朝印次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (143, 87, 78, 134, '七世郑法春，郑士吕之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (144, 88, 79, 135, '七世郑法祥，郑士名之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (145, 89, 80, 136, '七世郑国林，郑士成之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (146, 90, 81, 137, '七世郑一省，郑士俊之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (147, 91, 82, 138, '七世郑国玉，郑才兴之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (148, 92, 83, 139, '七世郑国连，郑才贵之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (149, 93, 87, 143, '八世郑名举，郑法春之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (150, 94, 88, 144, '八世郑名甫，郑法祥长子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (151, 95, 88, 144, '八世郑名德，郑法祥次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (152, 96, 88, 144, '八世郑名立，郑法祥三子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (153, 97, 89, 145, '八世郑名虎，郑国林之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (154, 98, 90, 146, '八世郑名全，郑一省之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (155, 99, 90, 146, '八世郑名旺，郑一省次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (156, 100, 91, 147, '八世郑名士，郑国玉之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (157, 101, 92, 148, '八世郑名智，郑国连之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (158, 102, 101, 157, '九世 绝', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (159, 103, 85, 141, '七世郑国瑞，郑士宜之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (160, 104, 85, 141, '七世郑国班，郑士宜次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (161, 105, 86, 142, '七世郑国现，郑士奇之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (162, 106, 103, 159, '八世郑名刚，郑国瑞之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (163, 107, 105, 161, '八世郑名玉，郑国现之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (164, 108, 104, 160, '八世 绝', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (165, 109, 93, 149, '九世郑亮，郑名举之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (166, 110, 95, 151, '九世郑勤，郑名德之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (167, 111, 95, 151, '九世郑明，郑名德次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (168, 112, 97, 153, '九世郑天宝，郑名虎之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (169, 113, 109, 165, '十世郑可举，郑亮之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (170, 114, 110, 166, '十世郑可宽，郑勤之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (171, 115, 111, 167, '十世郑可仕，郑明之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (172, 116, 112, 168, '十世郑可德，郑天宝长子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (173, 117, 112, 168, '十世郑可禄，郑天宝次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (174, 118, 97, 153, '九世郑天虎，郑名虎次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (175, 119, 106, 162, '九世郑汉，郑明刚长子(郑名刚)', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (176, 120, 106, 162, '九世郑河，郑明刚次子(郑名刚)', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (177, 121, 107, 163, '九世郑良，郑明玉之子(郑名玉)', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (178, 122, 119, 175, '十世郑可法，郑汉长子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (179, 123, 119, 175, '十世郑可义，郑汉次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (180, 124, 120, 176, '十世郑可官，郑河长子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (181, 125, 120, 176, '十世郑可玉，郑河次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (182, 126, 121, 177, '十世郑可智，郑良之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (183, 127, 98, 154, '九世郑汜，郑名全无子，过', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (184, 128, 127, 183, '十世郑可甫，郑汜长子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (185, 129, 127, 183, '十世郑可？，郑汜次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (186, 130, 127, 183, '十世郑可周，郑汜三子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (187, 131, 113, 169, '十一世郑志恭，郑可举长子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (188, 132, 113, 169, '十一世郑智俭，郑可举次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (189, 133, 114, 170, '十一世郑志壤，郑可宽之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (190, 134, 114, 170, '十一世郑志敬，郑可宽次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (191, 135, 131, 187, '十二世 绝', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (192, 136, 132, 188, '十二世 绝', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (193, 137, 133, 189, '十二世郑九商，郑志壤志子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (194, 138, 134, 190, '十二世郑九功，郑志敬之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (195, 139, 115, 171, '十一世郑志友，郑可仕之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (196, 140, 130, 186, '十一世郑志谦，郑可周之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (197, 141, 139, 195, '十二世郑九仙，郑志友之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (198, 142, 140, 196, '十二世郑九叙，郑志谦之子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (199, 143, 140, 196, '十二世郑九章，郑志谦次子', '', 0, 1, 0, '', 'FFFFFF');
INSERT INTO `family_category` VALUES (200, 144, 138, 194, '十三世郑长德，郑九功之子', '', 0, 1, 0, '', 'FFFFFF');

SET FOREIGN_KEY_CHECKS = 1;
