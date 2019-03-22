/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.21-MariaDB : Database - db_rekrutment
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `module` */

DROP TABLE IF EXISTS `module`;

CREATE TABLE `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(100) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `controller` varchar(100) DEFAULT NULL,
  `position` int(1) DEFAULT NULL COMMENT '1=Parent,2=Child',
  `have_child` varchar(1) DEFAULT 'N' COMMENT 'Y=Punya,N=Tidak Punya',
  `parent` int(10) DEFAULT '0',
  `sequence` varchar(1) NOT NULL,
  `is_deleted` int(1) DEFAULT '0',
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=latin1;

/*Data for the table `module` */

insert  into `module`(`id`,`icon`,`name`,`controller`,`position`,`have_child`,`parent`,`sequence`,`is_deleted`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (2,'ios-cog','Pengaturan','#',1,'Y',0,'',0,NULL,NULL,'1','2019-02-14 14:37:18'),(4,NULL,'Modul','module',2,'N',2,'2',0,NULL,NULL,NULL,NULL),(69,NULL,'Role','role/index',2,'N',2,'0',0,'2018052199999','2018-10-21 10:39:32',NULL,NULL),(92,NULL,'Menu Web','menu',2,'N',2,'0',0,'1','2019-02-13 10:36:56',NULL,NULL),(93,'ios-people','Pengguna','#',1,'Y',0,'0',0,'1','2019-02-14 09:48:05',NULL,NULL),(94,'','Data Pengguna','users',2,'N',93,'0',0,'1','2019-02-14 09:49:22','1','2019-02-22 06:49:59'),(95,'ios-paper','Berita','#',1,'Y',0,'0',1,'1','2019-02-14 13:44:07','1','2019-03-01 05:46:08'),(96,NULL,'Data Berita','berita',2,'N',95,'0',1,'1','2019-02-14 13:50:57','1','2019-03-01 05:46:13'),(97,NULL,'Data Berita - Approved','berita/approved',2,'N',95,'0',1,'1','2019-02-14 14:44:34','1','2019-02-22 05:44:47'),(98,'ios-recording','Media','#',1,'Y',0,'0',0,'1','2019-02-14 16:55:34','1','2019-02-14 17:04:38'),(99,NULL,'Slider Web','slider',2,'N',98,'0',0,'1','2019-02-14 17:05:12',NULL,NULL),(100,NULL,'Jumlah Posting','jumposting/index',2,'N',2,'0',1,'1','2019-02-15 02:50:05','1','2019-02-20 06:03:29'),(101,'ios-browsers','Produk','#',1,'Y',0,'0',0,'1','2019-02-22 05:55:47','1','2019-02-22 05:56:48'),(102,NULL,'Data Produk','produk',2,'N',101,'0',0,'1','2019-02-22 05:56:08',NULL,NULL),(103,'ios-cart','Penjualan','#',1,'Y',0,'0',0,'1','2019-02-22 05:57:27',NULL,NULL),(104,'','Data Pesanan','penjualan/pesanan',2,'N',103,'0',0,'1','2019-02-22 05:57:47','1','2019-02-28 12:02:27'),(105,NULL,'Data Member','member',2,'N',93,'0',0,'1','2019-02-22 06:50:25',NULL,NULL),(106,NULL,'Kategori','kategori',2,'N',101,'0',0,'1','2019-02-22 07:33:59',NULL,NULL),(107,'ios-book','Ticket Support','support',1,'N',0,'0',0,'1','2019-02-28 13:45:48',NULL,NULL),(108,'ios-browsers','Konten Web','#',1,'Y',0,'0',0,'1','2019-03-01 05:40:04',NULL,NULL),(109,'','About Us','aboutus',2,'N',108,'0',0,'1','2019-03-01 05:42:11','1','2019-03-01 07:29:51'),(110,'','News & Event','berita',2,'N',108,'0',0,'1','2019-03-01 05:42:34','1','2019-03-01 05:46:28'),(111,'','Our Project & Testimoni','testimoni',2,'N',108,'0',0,'1','2019-03-01 05:42:55','1','2019-03-02 05:42:38'),(112,NULL,'Agent','agent',2,'N',108,'0',0,'1','2019-03-01 05:43:11',NULL,NULL),(113,NULL,'Partner','partner',2,'N',108,'0',0,'1','2019-03-01 05:43:25',NULL,NULL),(114,NULL,'Certificate','certificate',2,'N',108,'0',0,'1','2019-03-01 05:43:45',NULL,NULL),(115,NULL,'Email Conf','identitas/email_config',2,'N',2,'0',0,'1','2019-03-20 11:36:40',NULL,NULL);

/*Table structure for table `module_permission` */

DROP TABLE IF EXISTS `module_permission`;

CREATE TABLE `module_permission` (
  `id_module_role` int(20) DEFAULT NULL,
  `id_module` int(11) DEFAULT NULL,
  `cbx` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `module_permission` */

insert  into `module_permission`(`id_module_role`,`id_module`,`cbx`) values (2,95,1),(2,96,1),(10,107,1),(1,2,1),(1,4,1),(1,69,1),(1,92,1),(1,115,1),(1,93,1),(1,94,1),(1,105,1),(1,98,1),(1,99,1),(1,101,1),(1,102,1),(1,106,1),(1,103,1),(1,104,1),(1,107,1),(1,108,1),(1,109,1),(1,110,1),(1,111,1),(1,112,1),(1,113,1),(1,114,1);

/*Table structure for table `module_role` */

DROP TABLE IF EXISTS `module_role`;

CREATE TABLE `module_role` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `is_deleted` int(1) DEFAULT '0',
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `module_role` */

insert  into `module_role`(`id`,`nama`,`is_deleted`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (1,'Superadmin',0,NULL,NULL,NULL,NULL),(9,'HRD',0,'1','2019-02-22 05:54:43',NULL,NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_module_role` int(10) DEFAULT '0',
  `login_lst` datetime DEFAULT NULL,
  `login_exp` datetime DEFAULT NULL,
  `token` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `aktif` int(1) DEFAULT '1',
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cookie` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `UNIQ_5CAB8173C05FB297` (`token`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `users` */

insert  into `users`(`id`,`nama`,`email`,`username`,`password`,`id_module_role`,`login_lst`,`login_exp`,`token`,`aktif`,`avatar`,`cookie`,`is_deleted`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (1,'Administrator','tes@gmail.com','admin','e61eb30e63a83beec52c360479c17470e15459225db4aa45dfb73b167421256d8de86ac161189e347b1835ac1f75a7a707a9e5710c2d8453d6bd3968e71d5ad1',1,'2019-03-21 14:49:25','2019-03-21 18:49:25','RU0CrwVmdG6Axy1',1,'assets/avatar/av_201220171513703226H17DD.png',NULL,0,NULL,NULL,13,'2017-12-20 00:06:43');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
