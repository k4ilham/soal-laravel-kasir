/*
 Navicat Premium Data Transfer

 Source Server         : mylocalhost
 Source Server Type    : MySQL
 Source Server Version : 50733 (5.7.33)
 Source Host           : localhost:3306
 Source Schema         : db_kasir

 Target Server Type    : MySQL
 Target Server Version : 50733 (5.7.33)
 File Encoding         : 65001

 Date: 10/06/2023 13:23:33
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for barang
-- ----------------------------
DROP TABLE IF EXISTS `barang`;
CREATE TABLE `barang`  (
  `id_barang` int(11) NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kode_barang` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `harga` int(255) NOT NULL,
  PRIMARY KEY (`id_barang`) USING BTREE,
  INDEX `id_barang`(`id_barang`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of barang
-- ----------------------------
INSERT INTO `barang` VALUES (1, 'Sabun', 'B0567', 12000);
INSERT INTO `barang` VALUES (2, 'Shampo', 'B6789', 30000);

-- ----------------------------
-- Table structure for history_barang
-- ----------------------------
DROP TABLE IF EXISTS `history_barang`;
CREATE TABLE `history_barang`  (
  `id_history_barang` int(11) NOT NULL AUTO_INCREMENT,
  `id_faktur` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty_barang` int(11) NOT NULL,
  `jumlah_harga_barang` int(255) NOT NULL,
  PRIMARY KEY (`id_history_barang`) USING BTREE,
  INDEX `id_faktur`(`id_faktur`) USING BTREE,
  INDEX `id_barang`(`id_barang`) USING BTREE,
  CONSTRAINT `history_barang_ibfk_1` FOREIGN KEY (`id_faktur`) REFERENCES `history_faktur_barang` (`id_faktur`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `history_barang_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 49 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of history_barang
-- ----------------------------
INSERT INTO `history_barang` VALUES (47, 34, 1, 12, 144000);
INSERT INTO `history_barang` VALUES (48, 34, 2, 23, 690000);

-- ----------------------------
-- Table structure for history_faktur_barang
-- ----------------------------
DROP TABLE IF EXISTS `history_faktur_barang`;
CREATE TABLE `history_faktur_barang`  (
  `id_faktur` int(11) NOT NULL AUTO_INCREMENT,
  `no_faktur` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kode_kasir` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama_kasir` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `waktu_input` datetime NOT NULL,
  `total` int(255) NOT NULL,
  `jumlah_bayar` int(255) NOT NULL,
  `kembali` int(255) NOT NULL,
  PRIMARY KEY (`id_faktur`) USING BTREE,
  INDEX `id_faktur`(`id_faktur`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of history_faktur_barang
-- ----------------------------
INSERT INTO `history_faktur_barang` VALUES (34, 'PSI-2310-8307', 'K035', 'Andi Kurniawan', '2023-06-10 06:21:45', 834000, 2000002, 1166002);

-- ----------------------------
-- Table structure for kasir
-- ----------------------------
DROP TABLE IF EXISTS `kasir`;
CREATE TABLE `kasir`  (
  `id_kasir` int(11) NOT NULL AUTO_INCREMENT,
  `kode_kasir` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama_kasir` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_kasir`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kasir
-- ----------------------------
INSERT INTO `kasir` VALUES (1, 'K035', 'Andi Kurniawan');

SET FOREIGN_KEY_CHECKS = 1;
