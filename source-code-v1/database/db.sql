/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.37-MariaDB : Database - db_motekarcemerlang
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_motekarcemerlang` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_motekarcemerlang`;

/*Table structure for table `album` */

DROP TABLE IF EXISTS `album`;

CREATE TABLE `album` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `is_deleted` int(1) DEFAULT '0',
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `album` */

insert  into `album`(`id`,`nama`,`is_deleted`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (1,'Album 1',1,'1','2018-12-20 11:02:35','1','2018-12-22 03:29:44'),(2,'Album 2',1,'1','2018-12-22 03:30:59','1','2019-02-10 00:01:52'),(3,'Album 3',0,'1','2019-02-10 00:01:58',NULL,NULL),(4,'Album 4',0,'1','2019-02-10 00:02:59',NULL,NULL);

/*Table structure for table `berita` */

DROP TABLE IF EXISTS `berita`;

CREATE TABLE `berita` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `judul` varchar(100) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `is_deleted` int(1) DEFAULT '0',
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `berita` */

insert  into `berita`(`id`,`judul`,`gambar`,`deskripsi`,`is_deleted`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (1,'PENTINGNYA MENJAGA KEBERSIHAN LINGKUNGAN','img_1203201915523898795A7U1.jpg','<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<div class=\"itemIntroText\">\r\n<p>Lingkungan yang bersih merupakan awal hidup sehat. Walaupun demikian kesadaran untuk menjaga&nbsp;<em>kebersihan lingkungan</em>&nbsp;pada masyarakat kita sangat kurang. Kebiasaan-kebiasaan serba asal masih terlalu melekat dalam kehidupan.</p>\r\n</div>\r\n<p>&nbsp;</p>\r\n<div class=\"itemFullText\">\r\n<p>Selain untuk mendapatkan derajat kesehatan yang lebih baik,&nbsp;<strong>lingkungan sehat</strong>juga bisa melahirkan kreatifitas lebih. ide-ide cemerlang pun bermunculan. Konsentrasi tetap terjaga.. tidak terganggu oleh aroma bau.. pemandangan pun indah sedap untuk dipandang, tidak penuh sampah yang berserakan perasaan pun nyaman jadinya.</p>\r\n<p>PENTINGNYA MENJAGA KEBERSIHAN LINGKUNGAN</p>\r\n<p><strong>Lingkungan</strong>, bukan hanya mencakup daerah sekitar rumah saja tetapi meliputi lingkungan tempat kita bekerja, lingkungan sekolah. Dll. Bayangkan jika kita sekolah ditempat yang super jorok kebersihan ruang dan sekitar tidak terjaga penuh sampah dan bau. BISAKAH KITA FOKUS BELAJAR? Tentu saja tidak ini merupakan sebuah contoh kecil dari<strong>&nbsp;</strong><strong>pentingnya menjaga kebersihan lingkungan</strong><em>.</em></p>\r\n<p><strong>Jenis-jenis penyakit yang bisa disebabkan oleh lingkungan.</strong></p>\r\n<p>Sampai saat ini secara keselurahan Penyuluhan kesehatan yang dilakukan oleh petugas kesehatan masyarakat (Kesmas) menyangkut program pemerintah tentang Kesling masih kurang Efektif. Tingkat kesadaran masyarakat sangat kecil. Ini dibuktikan dengan masih tingginya kasus-kasus terjadinya&nbsp;<strong>penyakit yang berhubungan dengan kebersihan lingkungan</strong>&nbsp;seperti : Penyakit Demam berdarah (DBD), Malaria, Diare, radang pernafasan, disentri, infeksi berbagia penyakit kulit dan masih banyak lagi penyakit lainnya.</p>\r\n<p><strong>Bagaimana cara mengajak orang-orang sekitar kita untuk ikut serta..?</strong></p>\r\n<p>Kebersihan lingkungan sekitar rumah merupakan kewajiban seluruh warga, begitu pun&nbsp;<strong>kebersihan lingkungan</strong>&nbsp;sekolah kewajiban semua siswa, dikantor kewajiban seluruh karyawan. Dan mustahil terwujud jika tidak sama-sama menjaga. Maka dari itu perlu adanya perubahan kebiasaan pada setiap orang tentang kesadaran dan keinginan untuk peduli pada lingkungan sekitar.</p>\r\n<p>&nbsp;</p>\r\n<p>Semua hal-hal besar dimulai dari sesuatu yang kecil.. setuju..?</p>\r\n<p>Mulailah dengan membuat perubahan dari diri sendiri, terkadang tanpa kita sadari banyak orang disekitar yang memperhatikan apa yang kita lakukan. Baru Kemudian lakukan pendekatan secara sistematis, pelan-pelan agar orang-orang disekitar mau ikut serta dalam&nbsp;<em>menjaga kebersihan lingkungan.</em>&nbsp;Hal ini memang tidak lah mudah. Berikan pemahaman- pemahaman yang bisa merubah cakrawala berpikir Mereka.</p>\r\n<p>&nbsp;</p>\r\n<p>\'Ingat kebersihan sebagian dari iman. Tuhan&nbsp; itu zat yang paling indah dan allah menyukai keindahan\'</p>\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"http://www.idmedis.com\">www.idmedis.com</a></p>\r\n<p>&nbsp;</p>\r\n<p>Sumber : http://pusknn.dinkes-kotakupang.web.id/artikel/info-kesehatan/item/72-pentingnya-menjaga-kebersihan-lingkungan.html</p>\r\n</div>\r\n<p>&nbsp;</p>\r\n</body>\r\n</html>',0,'1','2019-02-10 18:26:43','1','2019-03-12 18:24:40'),(2,'Jaga Kebersihan Mulai Dari Lingkungan Sekitar Kita','img_12032019155238998223DJW.jpg','<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>Kebersihan lingkungan mempunyai peranan yang sangat penting dan tak terpisahkan dalam kehidupan manusia. Menjaga kebersihan lingkungan sama artinya menciptakan lingkungan yang sehat, bebas dari kotoran, seperti debu, &nbsp;sampahdan bau yang tidak sedap. Dengan lingkungan yang sehat, kita tidak akan mudah terserang berbagai penyakit seperti demam berdarah, malaria, muntaber dan lainnya. Tidak hanya di bidang kesehatan, kebersihan lingkungan juga sangat berpengaruh terhadap kenyamanan, keindahan dan keasrian lingkungan yang nantinya bermuara pada kedamaian. Semua ini dapat kita raih dengan melakukan perbuatan kecil dan sederhana, mulai dari menjaga kebersihan lingkungan di sekitar kita.</p>\r\n<p>Kebersihan lingkungan dimulai dari lingkungan rumah dan tempat kita bekerja. Untuk kebersihan lingkungan di sekitar rumah, kita lakukan dengan membersihkan halaman dan telajakan rumah. Mari biasakan diridengan pola hidup bersih.Sampah yang dihasilkan rumah tangga selanjutnya kita pilah menjadi tiga, sampah organik, sampah non organik dan sampah botol atau pecah belah. Dengan pemilahan jenis sampah ini akan sangat bermanfaat, sampah organik bisa kita jadikan kompos sehingga bermanfaat untuk menyuburkan tanah dan tanaman.Sampah non organik kita kumpulkan dan kita jual ke pengepul untuk didaur ulang sehingga memberikan nilai lebih. Sementara itu untuk tempat kerja, ciptakan suasana ruang kerja yang bersih, rapi dan indah sehingga kita nyaman dalam melakukan aktivitas pekerjaan sehari-hari. Perlu juga diatur jadwal untuk kegiatan kerja bakti membersihkan lingkungan kantor.&nbsp;</p>\r\n<p>Hal yang tidak kalah penting &nbsp;adalah menanam tanaman. Tanaman mempunyai banyak fungsi yaitu sebagai penyaring debu, penyimpan air tanah, penyejuk dan pendingin alami. Selain itu tanaman juga dapat dijadikan sebagai taman yang akan memberikan suasana asri dan indah lingkungan sekitar kita.Dengan adanya pohon yang rindang, taman yang asri, otomatis kita akan menjadi nyaman dan betah di rumah maupun di kantor dalam melaksanakan tugas sehari-hari.</p>\r\n</body>\r\n</html>',0,'1','2019-03-12 18:26:22',NULL,NULL);

/*Table structure for table `galeri` */

DROP TABLE IF EXISTS `galeri`;

CREATE TABLE `galeri` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `id_album` int(100) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `is_deleted` int(1) DEFAULT '0',
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `galeri` */

insert  into `galeri`(`id`,`id_album`,`title`,`nama`,`path`,`is_deleted`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (7,3,NULL,'img_3_12_Maret_2019_i8XWjlGV_3448_hfCh_35000450_504896113272856_8138914110537465856_n.jpg','uploads/img_galeri/img_3_12_Maret_2019_i8XWjlGV_3448_hfCh_35000450_504896113272856_8138914110537465856_n.jpg',0,'1','2019-03-12 06:36:50',NULL,NULL),(8,3,NULL,'img_3_12_Maret_2019_pMigwrqJ_uzfP_5jeG_34815262_1552877141502357_126511324015362048_n.jpg','uploads/img_galeri/img_3_12_Maret_2019_pMigwrqJ_uzfP_5jeG_34815262_1552877141502357_126511324015362048_n.jpg',0,'1','2019-03-12 06:36:52',NULL,NULL),(9,4,NULL,'img_4_12_Maret_2019_7oDfp94o_iDe0_I7Hf_30086843_1659008470873427_1221000537294503936_n.jpg','uploads/img_galeri/img_4_12_Maret_2019_7oDfp94o_iDe0_I7Hf_30086843_1659008470873427_1221000537294503936_n.jpg',0,'1','2019-03-12 06:37:05',NULL,NULL),(10,4,NULL,'img_4_12_Maret_2019_m4TXrITR_7Obh_GgVq_29716588_856912937850356_1074109872632496128_n.jpg','uploads/img_galeri/img_4_12_Maret_2019_m4TXrITR_7Obh_GgVq_29716588_856912937850356_1074109872632496128_n.jpg',0,'1','2019-03-12 06:37:07',NULL,NULL),(11,3,NULL,'img_3_12_Maret_2019_MsojQInT_JOrD_tysl_index.jpg','uploads/img_galeri/img_3_12_Maret_2019_MsojQInT_JOrD_tysl_index.jpg',0,'1','2019-03-12 06:46:30',NULL,NULL);

/*Table structure for table `identitas` */

DROP TABLE IF EXISTS `identitas`;

CREATE TABLE `identitas` (
  `id_identitas` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `logo` varchar(50) NOT NULL,
  `no_telp1` varchar(50) NOT NULL,
  `no_telp2` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `maps` text NOT NULL,
  `facebook` varchar(100) NOT NULL,
  `instagram` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `profil_singkat` text NOT NULL,
  `profil_visi` text,
  `profil_misi` text,
  `waktu_layanan` varchar(100) DEFAULT NULL,
  `keywordseo` text,
  `alamat` text,
  PRIMARY KEY (`id_identitas`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `identitas` */

insert  into `identitas`(`id_identitas`,`title`,`nama`,`logo`,`no_telp1`,`no_telp2`,`email`,`maps`,`facebook`,`instagram`,`twitter`,`profil_singkat`,`profil_visi`,`profil_misi`,`waktu_layanan`,`keywordseo`,`alamat`) values (1,'Official Web','PT Motekar Cemerlang','080320191552042891_CD8F1.jpeg','021-74632976','+62853-3805-4056','halo@motekarcemerlang.co.id','https://www.google.com/maps/embed/v1/place?q=Jl.Jembatan Tiga  Kec.Penjaringan Jakarta Utara - Indonesia&amp;key=AIzaSyD7zqaZvMqDRQZy3kpMe_4z3YS65G3k3Cc','fb','@motekar.cemerlang','twitte','<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>PT. Motekar Cemerlang merupakan Perusahaan Jasa yang bergerak dalam bidang Pekerjaan Pelayanan dan Pemeliharaan Kebersihan (Cleaning Service), Pembersihan Kaca Luar (Gondola) dan Perawatan Pertamanan (Gardener and Landscape). Sebagai perusahaan Jasa Pelayanan dan Pemeliharaan Kebersihan kami menyadari bahwa sarana dan fasilitas pendukung merupakan hal yang utama bagi perusahaan. Setiap perusahaan membutuhkan pengelolaan, pemeliharaan dan perawatan agar semua aset perusahaan tetap terjaga dan terawat dengan baik. Oleh karena itu diperlukan tenaga profesional yang dilengkapi dengan peralatan dan perlengkapan kerja yang terbaik, serta ditunjang dengan tenaga kerja ahli yang berpengalaman, terampil, jujur dan memiliki disiplin yang tinggi PT. Motekar Cemerlang menawarkan solusi dalam pengelolaan Pelayanan dan Pemeliharaan Kebersihan (Cleaning Service), Pembersihan Kaca Luar (Gondola) dan Perawatan Pertamanan (Gardener and Landscape) dengan kontrak periodik, jangka pendek sampai dengan kontrak jangka panjang. Dengan Motto : &ldquo;KEPUASAN ANDA ADALAH TUJUAN KAMI&rdquo; PT. Motekar Cemerlang secara aktif memberikan pengawasan agar kegiatan oprasional di setiap area kerja dapat berjalan dengan baik dan memberikan kepuasan kepada rekan kerja kami. Terima Kasih.</p>\r\n</body>\r\n</html>','<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>Menjadi perusahaan general cleaning terbaik di dunia melalui budaya spiritual company dengan menekankan kejujuran dan kepuasan klien sehingga tercipta sebuah hubungan kerjasama yang lebih dari sekedar partner kerja.</p>\r\n</body>\r\n</html>','<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>Menjamin kualitas pekerjaan sebagai dasar dari budaya perusahaan kami dengan menerapkan sistem quality control yang ketat dengan bertumpu pada kepuasan pelanggan dan menciptakan hubungan baik dengan klien.</p>\r\n</body>\r\n</html>','Senin s.d Jumat 08.00 s/d 17.00 WIB','-','Jl. H. M.  Asmawi Perum Griya Damai Asri Sawah Baru Ciputat Tangerang Selatan.');

/*Table structure for table `klien` */

DROP TABLE IF EXISTS `klien`;

CREATE TABLE `klien` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `is_deleted` int(1) DEFAULT '0',
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `klien` */

insert  into `klien`(`id`,`nama`,`gambar`,`is_deleted`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (1,'Bank Mega','img_110320191552299396AYX6B.png',0,'1','2019-03-11 04:19:08',NULL,NULL),(2,'Bank Mega','img_110320191552299396AYX6B.png',0,'1','2019-03-11 17:16:36',NULL,NULL);

/*Table structure for table `layanan` */

DROP TABLE IF EXISTS `layanan`;

CREATE TABLE `layanan` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `judul` varchar(100) DEFAULT NULL,
  `deskripsi` varchar(250) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `is_deleted` int(1) DEFAULT '0',
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `layanan` */

insert  into `layanan`(`id`,`judul`,`deskripsi`,`icon`,`is_deleted`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (1,'Jasa Cleaning Service','<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>Motekar Cemerlang&nbsp; menyediakan jasa cleaning service untuk pembersihan secara menyeluruh baik kantor, rumah, hotel, dll.</p>\r\n</body>\r\n</html>','',0,'1','2019-02-09 23:41:40',NULL,NULL),(2,'Office Boy','<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>Motekar Cemerlang menyediakan untuk layanan office boy, yang dapat memberikan layanan kebersihan untuk perusahaan.</p>\r\n</body>\r\n</html>','',0,'1','2019-02-09 23:43:11',NULL,NULL),(3,'Gondola & General Cleaning ','<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>Motekar Cemerlang persiapkan cleaner terpilih sehingga mampu memberikan layanan yang cepat , secara aktif memberikan pengawasan agar kegiatan berjalan baik.</p>\r\n','',0,'1','2019-02-09 23:44:22','1','2019-03-12 05:45:47');

/*Table structure for table `layanan_booking` */

DROP TABLE IF EXISTS `layanan_booking`;

CREATE TABLE `layanan_booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_layanan` varchar(20) DEFAULT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL COMMENT '1 = Rumah, 2 = Perusahaan',
  `nohp` varchar(15) DEFAULT NULL,
  `catatan` text,
  `alamat` text,
  `is_deleted` int(1) DEFAULT '0',
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `layanan_booking` */

insert  into `layanan_booking`(`id`,`id_layanan`,`kode`,`nama`,`email`,`nohp`,`catatan`,`alamat`,`is_deleted`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (4,'1','297009','Saeful Bahri','sf.bahri@yahoo.co.id','081318803317','Rumah ','akshkahakjskajsasasa',0,NULL,'2019-03-12 08:41:44',NULL,NULL),(5,'2','528202','Adilla','adilla@gmail.com','081318803317','asa','sasas',0,NULL,'2019-03-12 08:42:09',NULL,NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;

/*Data for the table `module` */

insert  into `module`(`id`,`icon`,`name`,`controller`,`position`,`have_child`,`parent`,`sequence`,`is_deleted`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (1,'ios-home','Home','home',1,'N',0,'0',0,NULL,NULL,NULL,NULL),(2,'ios-cog','Pengaturan','#',1,'Y',0,'',0,NULL,NULL,NULL,NULL),(4,NULL,'Modul','module',2,'N',2,'2',0,NULL,NULL,NULL,NULL),(69,NULL,'Role','role/index',2,'N',2,'0',0,'2018052199999','2018-10-21 10:39:32',NULL,NULL),(77,'ios-images','Media','#',1,'Y',0,'0',1,'1','2018-12-20 10:18:44','1','2019-02-10 18:11:16'),(78,NULL,'Album Foto','media/album',2,'N',77,'0',0,'1','2018-12-20 10:19:57',NULL,NULL),(79,'','Artikel','berita',2,'N',77,'0',1,'1','2019-01-01 16:18:04','1','2019-01-04 22:57:01'),(80,'ios-globe','Konten Website','#',1,'Y',0,'0',0,'1','2019-01-01 16:20:32','1','2019-01-01 16:21:20'),(81,'','Profil Website','identitas',2,'N',80,'0',0,'1','2019-01-01 16:22:00','1','2019-01-04 23:24:24'),(82,NULL,'Layanan','layanan',2,'N',80,'0',0,'1','2019-01-01 16:25:05',NULL,NULL),(83,NULL,'Slider','slider',2,'N',77,'0',1,'1','2019-01-01 16:26:01','1','2019-02-10 18:08:52'),(84,'ios-chatboxes','Pesan','pesan',1,'N',0,'0',1,'1','2019-01-01 16:26:56','1','2019-02-10 18:11:52'),(85,'ios-notifications-outline','Informasi','#',1,'Y',0,'0',0,'1','2019-01-04 22:54:38',NULL,NULL),(86,NULL,'Artikel','berita',2,'N',85,'0',0,'1','2019-01-04 22:56:34',NULL,NULL),(88,NULL,'Slider Gambar','slider',2,'N',80,'0',1,'1','2019-02-10 18:09:23','1','2019-03-08 17:13:36'),(89,NULL,'Foto Pekerjaan','media/album',2,'N',80,'0',1,'1','2019-02-10 18:10:43','1','2019-03-08 17:13:39'),(90,'ios-chatboxes','Pesan','kirim/kirim_page',1,'N',0,'0',0,'1','2019-02-10 18:12:14','1','2019-03-12 18:09:20'),(91,'ios-clipboard','Booking Online','kirim/kirim_page_survey',1,'N',0,'0',0,'1','2019-02-10 18:23:21','1','2019-03-12 18:12:31'),(92,'ios-apps','Media','#',1,'Y',0,'0',0,'1','2019-03-08 17:11:07',NULL,NULL),(93,NULL,'Slider','slider',2,'N',92,'0',0,'1','2019-03-08 17:12:28',NULL,NULL),(94,NULL,'Foto - Foto','media/album',2,'N',92,'0',0,'1','2019-03-08 17:13:03',NULL,NULL),(95,NULL,'Testimoni','testimoni',2,'N',80,'0',0,'1','2019-03-08 18:16:46',NULL,NULL),(96,NULL,'Client','klien',2,'N',80,'0',0,'1','2019-03-10 09:01:52',NULL,NULL);

/*Table structure for table `module_permission` */

DROP TABLE IF EXISTS `module_permission`;

CREATE TABLE `module_permission` (
  `id_module_role` int(20) DEFAULT NULL,
  `id_module` int(11) DEFAULT NULL,
  `cbx` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `module_permission` */

insert  into `module_permission`(`id_module_role`,`id_module`,`cbx`) values (2,1,1),(2,70,1),(3,1,1),(3,71,1),(3,72,1),(3,73,1),(3,75,1),(3,76,1),(1,1,1),(1,2,1),(1,4,1),(1,69,1),(1,80,1),(1,81,1),(1,82,1),(1,95,1),(1,96,1),(1,85,1),(1,86,1),(1,90,1),(1,91,1),(1,92,1),(1,93,1),(1,94,1);

/*Table structure for table `module_role` */

DROP TABLE IF EXISTS `module_role`;

CREATE TABLE `module_role` (
  `id` int(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `is_deleted` int(1) DEFAULT '0',
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `module_role` */

insert  into `module_role`(`id`,`nama`,`is_deleted`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (1,'SUPERADMIN',0,NULL,NULL,NULL,NULL),(2,'ADMIN',0,NULL,NULL,NULL,NULL);

/*Table structure for table `pesan` */

DROP TABLE IF EXISTS `pesan`;

CREATE TABLE `pesan` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `pesan` text,
  `is_deleted` int(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `pesan` */

insert  into `pesan`(`id`,`nama`,`email`,`phone`,`pesan`,`is_deleted`,`created_at`) values (3,'Saeful','sf.bahri@yahoo.co.id','081318803317','tes tes tes tes tes',0,'2019-03-12 18:11:28');

/*Table structure for table `slider` */

DROP TABLE IF EXISTS `slider`;

CREATE TABLE `slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gambar` varchar(250) DEFAULT NULL,
  `path` varchar(100) DEFAULT NULL,
  `kata_1` varchar(100) DEFAULT NULL,
  `kata_2` varchar(500) DEFAULT NULL,
  `kata_3` varchar(100) DEFAULT NULL,
  `is_deleted` int(1) DEFAULT '0',
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `slider` */

insert  into `slider`(`id`,`gambar`,`path`,`kata_1`,`kata_2`,`kata_3`,`is_deleted`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (2,'img_9_Februari_2019_60p6SXSL_5MuD_Aw6F_bg-img2.jpg','/uploads/img_slider/img_9_Februari_2019_60p6SXSL_5MuD_Aw6F_bg-img2.jpg',NULL,NULL,NULL,1,'1','2019-02-09 22:58:48','1','2019-02-09 23:00:30'),(3,'img_9_Februari_2019_hkZQxwd4_Nquy_nXxF_general-cleaning-service.png','/uploads/img_slider/img_9_Februari_2019_hkZQxwd4_Nquy_nXxF_general-cleaning-service.png',NULL,NULL,NULL,1,'1','2019-02-09 23:00:38','1','2019-02-09 23:02:06'),(4,'img_9_Februari_2019_SYqMLKJb_tl1n_ET3I_CleaningService_LG.jpg','/uploads/img_slider/img_9_Februari_2019_SYqMLKJb_tl1n_ET3I_CleaningService_LG.jpg',NULL,NULL,NULL,1,'1','2019-02-09 23:02:10','1','2019-02-09 23:02:28'),(5,'img_9_Februari_2019_uT3i7A36_Eznx_MM27_Domestic-Cleaning-Service.jpg','/uploads/img_slider/img_9_Februari_2019_uT3i7A36_Eznx_MM27_Domestic-Cleaning-Service.jpg',NULL,NULL,NULL,1,'1','2019-02-09 23:02:32','1','2019-02-09 23:03:31'),(6,'img_9_Februari_2019_LaLxTMun_yWFU_5M00_1000000014029-636673183166163462-65c9efeb-2ca8-465a-9153-3ec75f2f6afc.jpg','/uploads/img_slider/img_9_Februari_2019_LaLxTMun_yWFU_5M00_1000000014029-636673183166163462-65c9efeb',NULL,NULL,NULL,1,'1','2019-02-09 23:03:35','1','2019-02-09 23:05:13'),(7,'img_9_Februari_2019_DY5y2z0i_U2cP_l5wZ_b1-slider.jpg','/uploads/img_slider/img_9_Februari_2019_DY5y2z0i_U2cP_l5wZ_b1-slider.jpg',NULL,NULL,NULL,1,'1','2019-02-09 23:05:16','1','2019-02-09 23:05:36'),(8,'img_9_Februari_2019_yP4rFKiy_qMCy_XNTq_cleangreen-slider15.jpg','/uploads/img_slider/img_9_Februari_2019_yP4rFKiy_qMCy_XNTq_cleangreen-slider15.jpg',NULL,NULL,NULL,1,'1','2019-02-09 23:05:40','1','2019-03-06 03:44:04'),(9,'img_9_Februari_2019_ryW42aAz_oeL8_omlv_3.jpg','/uploads/img_slider/img_9_Februari_2019_ryW42aAz_oeL8_omlv_3.jpg',NULL,NULL,NULL,1,'1','2019-02-09 23:06:11','1','2019-02-09 23:07:29'),(10,'img_9_Februari_2019_16t5xxT5_kgyV_6x2d_slide-2.jpg','/uploads/img_slider/img_9_Februari_2019_16t5xxT5_kgyV_6x2d_slide-2.jpg',NULL,NULL,NULL,1,'1','2019-02-09 23:07:37','1','2019-03-06 03:44:02'),(11,'img_9_Februari_2019_wkYeqRTK_5GXO_yXh4_slider3-1920x615.png','/uploads/img_slider/img_9_Februari_2019_wkYeqRTK_5GXO_yXh4_slider3-1920x615.png',NULL,NULL,NULL,1,'1','2019-02-09 23:08:02','1','2019-03-06 03:44:00'),(12,'img_8_Maret_2019_rQUoMVoj_tPye_ll24_image-1.jpg','/uploads/img_slider/img_8_Maret_2019_rQUoMVoj_tPye_ll24_image-1.jpg','Siap Melayani Anda','Gondola & General Cleaning','Jasa Layanan kami melayani cleaning service & General Cleaning',1,'1','2019-03-08 17:14:57','1','2019-03-11 16:08:41'),(13,'img_11_Maret_2019_j4WB3Low_gvVo_2YDa_cleaning_services_png_283976.png','/uploads/img_slider/img_11_Maret_2019_j4WB3Low_gvVo_2YDa_cleaning_services_png_283976.png','Jasa Cleaning Service','PT. Motekar Cemerlang menyediakan jasa cleaning service untuk pembersihan secara menyeluruh baik kantor, rumah, hotel, dll. ','+62853-3805-4056',0,'1','2019-03-11 16:08:46','1','2019-03-11 16:21:22'),(14,'img_11_Maret_2019_QEdPrLNL_ZgiV_KLKI_House-Keeping-Service.png','/uploads/img_slider/img_11_Maret_2019_QEdPrLNL_ZgiV_KLKI_House-Keeping-Service.png','Jasa Office Boy','PT. Motekar Cemerlang menyediakan untuk layanan office boy, yang dapat memberikan layanan kebersihan untuk perusahaan. ','+62853-3805-4056',0,'1','2019-03-11 16:14:15','1','2019-03-11 16:21:47'),(15,'img_11_Maret_2019_WXivpttL_aH9l_ko7J_slide3_3.png','/uploads/img_slider/img_11_Maret_2019_WXivpttL_aH9l_ko7J_slide3_3.png',NULL,NULL,NULL,1,'1','2019-03-11 16:14:18','1','2019-03-11 16:14:57'),(16,'img_11_Maret_2019_Alhz3PSp_db8r_tutf_wom2.png','/uploads/img_slider/img_11_Maret_2019_Alhz3PSp_db8r_tutf_wom2.png','Perawatan Pertamanan',' PT. Motekar Cemerlang persiapkan cleaner terpilih sehingga mampu memberikan layanan yang cepat dan detail. ','+62853-3805-4056',0,'1','2019-03-11 16:15:06','1','2019-03-11 16:23:02');

/*Table structure for table `tentang_kami` */

DROP TABLE IF EXISTS `tentang_kami`;

CREATE TABLE `tentang_kami` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(100) DEFAULT NULL,
  `deskripsi` text,
  `gambar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tentang_kami` */

/*Table structure for table `testimoni` */

DROP TABLE IF EXISTS `testimoni`;

CREATE TABLE `testimoni` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `perusahaan` varchar(100) DEFAULT NULL,
  `jabatan` varchar(200) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `is_deleted` int(1) DEFAULT '0',
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `testimoni` */

insert  into `testimoni`(`id`,`nama`,`perusahaan`,`jabatan`,`foto`,`deskripsi`,`is_deleted`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (1,'Saeful Bahri','Nama Perusahaan','CEO','img_09032019155210604839OB5.png','<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>TES TES TES</p>\r\n</body>\r\n</html>',0,'1','2019-03-09 11:34:08','1','2019-03-10 08:43:27');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
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

insert  into `users`(`id`,`nama`,`username`,`password`,`id_module_role`,`login_lst`,`login_exp`,`token`,`aktif`,`avatar`,`cookie`,`is_deleted`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (1,'SAEFUL BAHRI','admin','e61eb30e63a83beec52c360479c17470e15459225db4aa45dfb73b167421256d8de86ac161189e347b1835ac1f75a7a707a9e5710c2d8453d6bd3968e71d5ad1',1,'2019-03-12 15:42:45','2019-03-12 19:42:45','LmRRurCGpXU9Jth',1,'assets/avatar/av_201220171513703226H17DD.png',NULL,0,NULL,NULL,13,'2017-12-20 00:06:43');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
