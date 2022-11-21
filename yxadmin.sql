/*
SQLyog Ultimate v12.14 (64 bit)
MySQL - 5.5.53 : Database - yxadmin
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`yxadmin` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `yxadmin`;

/*Table structure for table `yx_article` */

DROP TABLE IF EXISTS `yx_article`;

CREATE TABLE `yx_article` (
  `article_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `article_author` int(50) NOT NULL COMMENT '文章作者',
  `article_title` varchar(500) NOT NULL COMMENT '文章标题',
  `article_poster` varchar(500) NOT NULL DEFAULT '' COMMENT '文章封面',
  `article_content` longtext NOT NULL COMMENT '文章内容',
  `article_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '文章状态 0:正常',
  `article_add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  `article_category` varchar(100) NOT NULL,
  `article_read_count` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量',
  PRIMARY KEY (`article_id`)
) ENGINE=MyISAM AUTO_INCREMENT=240 DEFAULT CHARSET=utf8mb4;

/*Data for the table `yx_article` */

insert  into `yx_article`(`article_id`,`article_author`,`article_title`,`article_poster`,`article_content`,`article_status`,`article_add_time`,`article_category`,`article_read_count`) values 
(238,1,'关于美国CPI超预期的看法','\\upload\\article\\20220714\\4921f0bb4d4755e2d609d5eb3e1b8794.png','&lt;p style=&quot;box-sizing: inherit; -webkit-tap-highlight-color: rgba(255, 255, 255, 0); margin-top: 10px; margin-bottom: 25px; padding: 0px; border: 0px; font-size: 18px; vertical-align: baseline; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; color: rgb(34, 34, 34); font-family: Pingfang-SC, &amp;quot;Microsoft YaHei&amp;quot;, sans-serif; text-align: justify;&quot;&gt;本周一和周二，随着国际原油价格暴跌，西方石油股价也在这两日分别下跌1.9%和3.6%。不过本周三西方石油股价暂时企稳，股价收涨1.12%，盘后续涨0.93%。&lt;/p&gt;&lt;p style=&quot;box-sizing: inherit; -webkit-tap-highlight-color: rgba(255, 255, 255, 0); margin-top: 10px; margin-bottom: 25px; padding: 0px; border: 0px; font-size: 18px; vertical-align: baseline; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; color: rgb(34, 34, 34); font-family: Pingfang-SC, &amp;quot;Microsoft YaHei&amp;quot;, sans-serif; text-align: justify;&quot;&gt;&lt;img src=&quot;https://img.cls.cn/images/20220714/x7P60yPyY0.png&quot; alt=&quot;image&quot; style=&quot;box-sizing: inherit; -webkit-tap-highlight-color: rgba(255, 255, 255, 0); margin: 40px auto 25px; padding: 0px; vertical-align: baseline; background: transparent; max-width: 100%; display: block; height: auto !important;&quot;&gt;&lt;/p&gt;&lt;h3 id=&quot;-&quot; style=&quot;box-sizing: inherit; -webkit-tap-highlight-color: rgba(255, 255, 255, 0); margin: 10px 0px 25px; padding: 0px; border: 0px; vertical-align: baseline; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; color: rgb(153, 153, 153); font-size: 0.88889em; font-family: Pingfang-SC, &amp;quot;Microsoft YaHei&amp;quot;, sans-serif; text-align: justify;&quot;&gt;西方石油年初至今股价走势&lt;/h3&gt;&lt;p style=&quot;box-sizing: inherit; -webkit-tap-highlight-color: rgba(255, 255, 255, 0); margin-top: 10px; margin-bottom: 25px; padding: 0px; border: 0px; font-size: 18px; vertical-align: baseline; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; color: rgb(34, 34, 34); font-family: Pingfang-SC, &amp;quot;Microsoft YaHei&amp;quot;, sans-serif; text-align: justify;&quot;&gt;在周一和周二的下跌中，西方石油股价一度从周五收盘价60.67美元跌至最低55.93美元。伯克希尔哈撒韦也在这期间多次买入，买入价格从每股59.93美元到56.11美元不等。&lt;/p&gt;&lt;p style=&quot;box-sizing: inherit; -webkit-tap-highlight-color: rgba(255, 255, 255, 0); margin-top: 10px; margin-bottom: 25px; padding: 0px; border: 0px; font-size: 18px; vertical-align: baseline; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; color: rgb(34, 34, 34); font-family: Pingfang-SC, &amp;quot;Microsoft YaHei&amp;quot;, sans-serif; text-align: justify;&quot;&gt;截至周三收盘，伯克希尔本周总计花费了约2.5亿美元买入430万股西方石油股票，使其目前总共拥有 1.794 亿股西方普通股，持股比例高达19.2%。以周三收盘价计算，其持股市值约104亿美元。&lt;/p&gt;&lt;p style=&quot;box-sizing: inherit; -webkit-tap-highlight-color: rgba(255, 255, 255, 0); margin-top: 10px; margin-bottom: 25px; padding: 0px; border: 0px; font-size: 18px; vertical-align: baseline; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; color: rgb(34, 34, 34); font-family: Pingfang-SC, &amp;quot;Microsoft YaHei&amp;quot;, sans-serif; text-align: justify;&quot;&gt;除了正股外，伯克希尔还有8390万股西方石油的认股权证，若巴菲特行使认股权证，那么伯克希尔在西方石油的持股比例将达到25%以上。&lt;/p&gt;&lt;p style=&quot;box-sizing: inherit; -webkit-tap-highlight-color: rgba(255, 255, 255, 0); margin-top: 10px; margin-bottom: 25px; padding: 0px; border: 0px; font-size: 18px; vertical-align: baseline; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; color: rgb(34, 34, 34); font-family: Pingfang-SC, &amp;quot;Microsoft YaHei&amp;quot;, sans-serif; text-align: justify;&quot;&gt;今年第一季度以来，伯克希尔就持续不断买入西方石油股票，使伯克希尔第一季度在股票上的支出净额达到410亿美元，成为公司历史上最活跃的购买窗口期之一。6月以来，随着西方石油股价回落，伯克希尔又多次积极加仓，加上本周这次，已经是6月以来第四轮加仓了。&lt;/p&gt;&lt;p style=&quot;box-sizing: inherit; -webkit-tap-highlight-color: rgba(255, 255, 255, 0); margin-top: 10px; margin-bottom: 25px; padding: 0px; border: 0px; font-size: 18px; vertical-align: baseline; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; color: rgb(34, 34, 34); font-family: Pingfang-SC, &amp;quot;Microsoft YaHei&amp;quot;, sans-serif; text-align: justify;&quot;&gt;此前，巴菲特分别于6月17-22日花费约5.29亿美元，买入955万股；6月23日斥资约4400万美元，买入79.4万股；7月5-6日花费6.98亿美元增持西方石油1024.25万股。&lt;/p&gt;&lt;p style=&quot;box-sizing: inherit; -webkit-tap-highlight-color: rgba(255, 255, 255, 0); margin-top: 10px; margin-bottom: 8px; padding: 0px; border: 0px; font-size: 18px; vertical-align: baseline; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; color: rgb(34, 34, 34); font-family: Pingfang-SC, &amp;quot;Microsoft YaHei&amp;quot;, sans-serif; text-align: justify;&quot;&gt;“股神”这样积极的买入甚至引发了其可能会收购整个西方石油的猜想。这或许正如巴菲特在西方石油2021年第四季度财报会上所说的的一样：“对于西方石油，我们能买多少就买多少。”&lt;/p&gt;\r\n                                                            ',0,'2022-07-14 00:00:00','33',24),
(239,1,'四部门：到2025年 培育15个高水平特色家居产业集群','\\upload\\article\\20220808\\a00b4f74a90cc86bd45ff177860c8249.jpg','&lt;span style=&quot;color: rgb(222, 4, 34); font-family: Pingfang-SC, &amp;quot;Microsoft YaHei&amp;quot;, sans-serif; font-size: 20px;&quot;&gt;财联社8月8日电，工业和信息化部办公厅等四部门发布关于印发推进家居产业高质量发展行动方案的通知。通知提出， 到2025年，家居产业创新能力明显增强，高质量产品供给明显增加，初步形成供给创造需求、需求牵引供给的更高水平良性循环。在家用电器、照明电器等行业培育制造业创新中心、数字化转型促进中心等创新平台，重点行业两化融合水平达到65%，培育一批5G全连接工厂、智能制造示范工厂和优秀应用场景。反向定制、全屋定制、场景化集成定制等个性化定制比例稳步提高，绿色、智能、健康产品供给明显增加，智能家居等新业态加快发展。在家居产业培育50个左右知名品牌、10个家居生态品牌，推广一批优秀产品，建立500家智能家居体验中心，培育15个高水平特色产业集群，以高质量供给促进家居品牌品质消费。&lt;/span&gt;\r\n                                                            ',0,'2022-08-08 00:00:00','24',11);

/*Table structure for table `yx_attatch` */

DROP TABLE IF EXISTS `yx_attatch`;

CREATE TABLE `yx_attatch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL COMMENT '文件原名',
  `filetype` varchar(200) DEFAULT NULL COMMENT '文件类型',
  `filesize` varchar(200) DEFAULT NULL COMMENT '大小',
  `filepath` varchar(200) DEFAULT NULL COMMENT '文件路径',
  `filename` varchar(200) DEFAULT NULL COMMENT '文件名',
  `url` varchar(200) DEFAULT NULL COMMENT '全路径',
  `uptime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `yx_attatch` */

/*Table structure for table `yx_client` */

DROP TABLE IF EXISTS `yx_client`;

CREATE TABLE `yx_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(50) DEFAULT NULL COMMENT '客户姓名',
  `sex` int(11) DEFAULT '1' COMMENT '性别1男2女，默认1男',
  `job` varchar(50) DEFAULT NULL COMMENT '医师/药师/其他',
  `hospital_id` int(11) DEFAULT NULL COMMENT '医院id',
  `nature` int(11) DEFAULT NULL COMMENT '1住院医师/2主治医师/3副主任医师/4主任医师',
  `department` varchar(50) DEFAULT NULL COMMENT '科室',
  `phone` varchar(20) DEFAULT NULL COMMENT '手机号',
  `wxid` varchar(100) DEFAULT NULL COMMENT '微信openid',
  `addtime` varchar(100) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `yx_client` */

/*Table structure for table `yx_customer` */

DROP TABLE IF EXISTS `yx_customer`;

CREATE TABLE `yx_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wxid` varchar(100) DEFAULT NULL COMMENT '微信授权appid',
  `name` varchar(50) DEFAULT NULL COMMENT '名字',
  `sex` varchar(30) DEFAULT NULL COMMENT '性别',
  `job` varchar(50) DEFAULT NULL COMMENT '职业',
  `tel` varchar(50) DEFAULT NULL COMMENT '手机号',
  `title` varchar(50) DEFAULT NULL COMMENT '职称',
  `status` varchar(30) DEFAULT '1' COMMENT '状态 1正常 2废除',
  `addtime` varchar(50) DEFAULT NULL,
  `hospitalid` int(20) DEFAULT NULL COMMENT '医院id',
  `depart` varchar(50) DEFAULT NULL COMMENT '科室',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `birthday` varchar(100) DEFAULT NULL COMMENT '生日',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `yx_customer` */

insert  into `yx_customer`(`id`,`wxid`,`name`,`sex`,`job`,`tel`,`title`,`status`,`addtime`,`hospitalid`,`depart`,`email`,`birthday`) values 
(4,'12334','狄仁杰','女','护士','13198782655','主任医师','2','2022-11-14',9,'神经内科','734082037@qq.com','2022-11-28'),
(5,'12334','歌尔','女','医生','88888888','医生','1','2022-11-17',15,'体检科','info@baiyu.cn (国际/国内销售)','2022-11-15'),
(6,'dddddfa34211','证券','男','医生','13198782655','主任','1','2022-11-17',15,'皮肤科','734082037@qq.com','2022-11-22'),
(7,'dddddfa34211','信创','男','医生','789456123','主任医师','1','2022-11-17',15,'肝胆内科','45645464@163.com','2022-11-22'),
(8,'dfsdfda343242','医药','男','医生','34234233423423','副主任医师','1','2022-11-17',9,'消化科','info@baiyu.cn (国际/国内）','2022-11-02');

/*Table structure for table `yx_employee` */

DROP TABLE IF EXISTS `yx_employee`;

CREATE TABLE `yx_employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '员工id',
  `name` varchar(50) DEFAULT NULL COMMENT '员工姓名',
  `part` varchar(50) DEFAULT NULL COMMENT '部门',
  `job` varchar(50) DEFAULT NULL COMMENT '职称',
  `phone` varchar(20) DEFAULT NULL COMMENT '手机号',
  `addtime` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `yx_employee` */

insert  into `yx_employee`(`id`,`name`,`part`,`job`,`phone`,`addtime`) values 
(1,'李瑞','人力','人事招聘','13544562398',NULL),
(2,'邓兵','第二事业部','经理','18783938956',NULL),
(3,'丁俊晖','总经办','主管','13189892655',NULL);

/*Table structure for table `yx_fee` */

DROP TABLE IF EXISTS `yx_fee`;

CREATE TABLE `yx_fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(200) DEFAULT NULL COMMENT '费用名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `yx_fee` */

/*Table structure for table `yx_hospital` */

DROP TABLE IF EXISTS `yx_hospital`;

CREATE TABLE `yx_hospital` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `code` varchar(100) DEFAULT NULL COMMENT '医院编码',
  `name` varchar(100) DEFAULT NULL COMMENT '医院名称',
  `othername` varchar(100) DEFAULT NULL COMMENT '其他名称',
  `quality` varchar(50) DEFAULT NULL COMMENT '性质:公立/私立',
  `level` varchar(50) DEFAULT NULL COMMENT '医院级别',
  `province` varchar(50) DEFAULT NULL COMMENT '省',
  `city` varchar(50) DEFAULT NULL COMMENT '市',
  `area` varchar(50) DEFAULT NULL COMMENT '区',
  `address` varchar(200) DEFAULT NULL COMMENT '详细地址',
  `development` varchar(20) DEFAULT NULL COMMENT '开发情况：1空白2签约3开发4僵尸',
  `divided` varchar(20) DEFAULT NULL COMMENT '是否是分院:1是2否',
  `hostname` varchar(100) DEFAULT NULL COMMENT '主院名称',
  `add_time` varchar(30) DEFAULT NULL COMMENT '新增时间',
  `status` varchar(30) DEFAULT '1' COMMENT '状态1正常2作废',
  `details` varchar(200) DEFAULT NULL COMMENT '详细地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `yx_hospital` */

insert  into `yx_hospital`(`id`,`code`,`name`,`othername`,`quality`,`level`,`province`,`city`,`area`,`address`,`development`,`divided`,`hostname`,`add_time`,`status`,`details`) values 
(1,'BY20180821','南充市川北医学院附属第1医院','南充市川北医学院附属第1医院','公立','三级甲等','四川省','南充市','顺庆区','东顺大街453号','空白网点','2','无',NULL,'1',NULL),
(4,'BY20180822','川北医学院附属第1医院','川北医学院附属第1医院','公立','三级甲等','山东','山东','顺庆区','东顺大街453号','空白网点','1','无',NULL,'1',NULL),
(5,'BY20180823','南充市川北医学院附属第2医院','南充市川北医学院附属第2医院','公立','三级甲等','上海','上海','顺庆区','东顺大街453号','空白网点','2','无',NULL,'1',NULL),
(6,'BY20180824','南充市川北医学院附属第3医院','南充市川北医学院附属第3医院','公立','三级甲等','河南','南充市','顺庆区','东顺大街453号','空白网点','1','无',NULL,'1',NULL),
(7,'BY20180825','南充市川北医学院附属第4医院','南充市川北医学院附属第4医院','公立','三级甲等','河北','南充市','顺庆区','东顺大街453号','空白网点','2','无',NULL,'1',NULL),
(8,'BY20180826','南充市川北医学院附属第5医院','南充市川北医学院附属第5医院','公立','三级甲等','台湾','南充市','顺庆区','东顺大街453号','空白网点','1','无',NULL,'1',NULL),
(9,'BY20180827','川北医学院附属第2医院','川北医学院附属第2医院','公立','三级甲等','香港','南充市','顺庆区','东顺大街453号','空白网点','2','无',NULL,'1',NULL),
(10,'BY20180828','南充市川北医学院附属第6医院','南充市川北医学院附属第6医院','公立','三级甲等','吉林','南充市','顺庆区','东顺大街453号','空白网点','1','无',NULL,'1',NULL),
(11,'BY20180829','南充市川北医学院附属第7医院','南充市川北医学院附属第7医院','公立','三级甲等','内蒙古','南充市','顺庆区','东顺大街453号','空白网点','2','无',NULL,'1',NULL),
(12,'BY20180830','南充市川北医学院附属第8医院','南充市川北医学院附属第8医院','公立','三级甲等','广东','南充市','顺庆区','东顺大街453号','空白网点','1','无',NULL,'1',NULL),
(13,'BY20180820','南充市川北医学院附属第9医院','南充市川北医学院附属第9医院','公立','三级甲等','福建','南充市','顺庆区','东顺大街453号','空白网点','2','无',NULL,'1',NULL),
(14,'BY20180831','川北医学院附属第3医院','川北医学院附属第3医院','公立','三级甲等','广西','南充市','顺庆区','东顺大街453号','空白网点','1','无',NULL,'2',NULL),
(15,'BY20180832','南充市川北医学院附属第10医院','南充市川北医学院附属第10医院','公立','三级甲等','西藏','南充市','顺庆区','东顺大街453号','空白网点','2','无',NULL,'2',NULL);

/*Table structure for table `yx_index_menu` */

DROP TABLE IF EXISTS `yx_index_menu`;

CREATE TABLE `yx_index_menu` (
  `menu_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(50) NOT NULL DEFAULT '',
  `menu_pid` int(11) NOT NULL DEFAULT '0',
  `menu_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1为删除状态 0为使用状态',
  `menu_sort` tinyint(3) NOT NULL DEFAULT '0',
  `type` varchar(10) NOT NULL DEFAULT 'tag' COMMENT 'type: menu | tag',
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4;

/*Data for the table `yx_index_menu` */

insert  into `yx_index_menu`(`menu_id`,`menu_name`,`menu_pid`,`menu_status`,`menu_sort`,`type`) values 
(18,'后端开发',0,0,2,'menu'),
(19,'服务器',0,0,3,'menu'),
(20,'前端开发',0,0,1,'menu'),
(21,'CSS',20,0,0,'tag'),
(22,'JavaScript',20,0,0,'tag'),
(23,'PHP',18,0,0,'tag'),
(24,'Python',18,0,0,'tag'),
(25,'Apache',19,0,0,'tag'),
(26,'Nginx',19,0,0,'tag'),
(10,'数据库',0,0,4,'menu'),
(11,'mysql',10,0,0,'tag'),
(12,'mongodb',10,0,0,'tag'),
(16,'redis',10,0,0,'tag'),
(17,'Linux',19,0,0,'tag'),
(29,'HTML',20,0,0,'tag'),
(30,'memcache',10,0,0,'tag'),
(31,'开发工具',0,0,5,'menu'),
(32,'GIT',31,0,0,'tag'),
(33,'计算机',18,0,0,'tag'),
(34,'JAVA',18,0,0,'tag'),
(35,'docker',19,0,0,'tag'),
(36,'编辑器',31,0,0,'tag'),
(37,'spring',18,0,0,'tag'),
(38,'vue',20,0,0,'tag'),
(39,'中间件',18,0,0,'tag');

/*Table structure for table `yx_meetting` */

DROP TABLE IF EXISTS `yx_meetting`;

CREATE TABLE `yx_meetting` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(50) DEFAULT NULL COMMENT '会议名称',
  `type1` varchar(30) DEFAULT NULL COMMENT '1学术会 2销售会',
  `type2` varchar(30) DEFAULT NULL COMMENT '1城市会 2科室会 3病例分享',
  `mdate` varchar(50) DEFAULT NULL COMMENT '日期',
  `starttime` varchar(50) DEFAULT NULL COMMENT '开始时间',
  `endtime` varchar(50) DEFAULT NULL COMMENT '结束时间',
  `province` varchar(50) DEFAULT NULL COMMENT '省',
  `city` varchar(50) DEFAULT NULL COMMENT '市',
  `area` varchar(50) DEFAULT NULL COMMENT '区',
  `addressdetail` varchar(200) DEFAULT NULL COMMENT '详细地址',
  `uid` int(11) DEFAULT NULL COMMENT '创建员工id',
  `add_time` varchar(200) DEFAULT NULL COMMENT '提交时间',
  `status` int(11) DEFAULT '1' COMMENT '1未审核，2通过，3废弃,4不通过',
  `hospitalids` varchar(100) DEFAULT NULL COMMENT '关联医院id',
  `processids` varchar(50) DEFAULT NULL COMMENT '议程id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

/*Data for the table `yx_meetting` */

insert  into `yx_meetting`(`id`,`name`,`type1`,`type2`,`mdate`,`starttime`,`endtime`,`province`,`city`,`area`,`addressdetail`,`uid`,`add_time`,`status`,`hospitalids`,`processids`) values 
(2,'20221021北京科室会','1','2','2022-09-20','09:00','12:00','山东省','淄博市','博山区','天府生命科技园A1栋303',1,'2022-09-20 14:32:24',2,'2',NULL),
(3,'20221020天津病例分享会','2','3','2022-09-20','09:00','12:00','山东省','淄博市','博山区','香格里拉大酒店',2,NULL,1,'3',NULL),
(7,'20220920成都城市会12','2','2','2022-09-20','09:00','12:00','山东省','淄博市','博山区','天府生命科技园A1栋303',1,NULL,1,'1,4,5,6,7,8,9,10,11,12,13,14',NULL),
(27,'商业化产品','2','1','2022-10-31','09:00','12:00','湖南省','株洲市','芦淞区','成华区',11,NULL,1,NULL,NULL),
(28,'商业化产品','2','1','2022-10-31','09:00','12:00','湖南省','株洲市','芦淞区','成华区',11,NULL,1,NULL,NULL),
(29,'商业化产品','2','1','2022-10-31','09:00','12:00','湖南省','株洲市','芦淞区','成华区',11,NULL,1,NULL,NULL),
(30,'商业化产品','2','1','2022-10-31','09:00','12:00','湖南省','株洲市','芦淞区','成华区',11,NULL,1,NULL,NULL),
(31,'商业化产品','2','1','2022-10-31','09:00','12:00','湖南省','株洲市','芦淞区','成华区',11,NULL,1,NULL,NULL),
(32,'商业化产品','2','1','2022-10-31','09:00','12:00','湖南省','株洲市','芦淞区','成华区',11,NULL,1,NULL,NULL),
(33,'商业化产品','2','1','2022-10-31','09:00','12:00','湖南省','株洲市','芦淞区','成华区',11,NULL,1,NULL,NULL),
(34,'商业化产品','2','1','2022-10-31','09:00','12:00','湖南省','株洲市','芦淞区','成华区',11,NULL,1,NULL,NULL),
(35,'商业化产品','2','1','2022-10-31','09:00','12:00','湖南省','株洲市','芦淞区','成华区',11,NULL,1,NULL,NULL),
(36,'商业化产品','2','1','2022-10-31','09:00','12:00','湖南省','株洲市','芦淞区','成华区',11,NULL,1,NULL,NULL),
(37,'商业化产品','2','1','2022-10-31','09:00','12:00','湖南省','株洲市','芦淞区','成华区',11,NULL,1,NULL,NULL),
(38,'商业化产品','2','1','2022-10-31','09:00','12:00','湖南省','株洲市','芦淞区','成华区',11,NULL,1,NULL,NULL),
(39,'商业化产品','2','1','2022-10-31','09:00','12:00','湖南省','株洲市','芦淞区','成华区',11,NULL,1,NULL,NULL),
(40,'商业化产品1','2','1','2022-10-31','09:00','12:00','湖南省','株洲市','芦淞区','成华区',11,NULL,1,NULL,NULL),
(41,'20220920成都城市会','2','1','2022-11-02','09:00','12:00','湖南省','株洲市','石峰区','香格里拉大酒店',11,NULL,1,NULL,NULL),
(42,'20220920成都城市会1','2','1','2022-11-02','09:00','12:00','河南省','开封市','顺河回族区','成华区',2,NULL,4,NULL,NULL),
(43,'20220920成都城市会1','2','1','2022-11-02','09:00','12:00','河南省','开封市','顺河回族区','成华区',2,NULL,1,NULL,NULL);

/*Table structure for table `yx_meettingcustomer` */

DROP TABLE IF EXISTS `yx_meettingcustomer`;

CREATE TABLE `yx_meettingcustomer` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `meettingid` int(11) DEFAULT NULL COMMENT '会议id',
  `name` varchar(50) DEFAULT NULL COMMENT '名字',
  `sex` varchar(20) DEFAULT NULL COMMENT '性别',
  `job` varchar(30) DEFAULT NULL COMMENT '职业',
  `hospitalid` varchar(50) DEFAULT NULL COMMENT '医院id',
  `title` varchar(50) DEFAULT NULL COMMENT '职称',
  `depart` varchar(100) DEFAULT NULL COMMENT '科室',
  `phone` varchar(50) DEFAULT NULL COMMENT '手机号',
  `wxid` varchar(100) DEFAULT NULL COMMENT '微信id',
  `addtime` varchar(100) DEFAULT NULL,
  `way` varchar(20) DEFAULT NULL COMMENT '参会方式1扫码2手动',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `yx_meettingcustomer` */

insert  into `yx_meettingcustomer`(`id`,`meettingid`,`name`,`sex`,`job`,`hospitalid`,`title`,`depart`,`phone`,`wxid`,`addtime`,`way`) values 
(2,7,'测试','男','医师','13','住院医师','生物科','18782927645','','2022-10-25 09:04:37',NULL),
(4,7,'元芳','女','药师','15','主任医师','肝胆内科','13541646842','','2022-10-25 11:47:21',NULL),
(5,7,'狄仁杰','女','医师','10','主治医师','皮肤科','13198782688','','2022-10-25 11:45:45',NULL),
(6,7,'郭美美','女','药师','13','主治医师','神经内科','18782927645','','2022-10-25 11:47:08',NULL),
(7,43,'4','男','医师',NULL,'住院医师','','18782927645','','2022-11-17 15:45:28',NULL),
(8,43,'5','男','医师','8','住院医师','皮肤科','666','','2022-11-17 16:20:21',NULL),
(9,43,'8','男','医师','9','住院医师','生物科','46465','dddddfa34211','2022-11-18 11:14:05',NULL),
(10,41,'8','男','医师','8','主治医师','生物科','13541646842','dddddfa34211','2022-11-18 11:18:51',NULL),
(11,43,'7','男','医师','11','主治医师','跳水科','2343242','12334','2022-11-18 17:23:12',NULL),
(12,43,'6','男','医师','11','主治医师','跳水科','2343242','1111111','2022-11-18 17:24:23','手动录入');

/*Table structure for table `yx_meettingemployee` */

DROP TABLE IF EXISTS `yx_meettingemployee`;

CREATE TABLE `yx_meettingemployee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meettingid` int(11) DEFAULT NULL COMMENT '会议id',
  `employeeid` int(11) DEFAULT NULL COMMENT '员工id',
  `work` varchar(200) DEFAULT NULL COMMENT '会务工作',
  `addtime` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `yx_meettingemployee` */

insert  into `yx_meettingemployee`(`id`,`meettingid`,`employeeid`,`work`,`addtime`) values 
(3,7,11,'签到,会场,接送','2022-10-21 10:56:33'),
(4,7,3,'讲稿,餐饮,陪同','2022-10-21 10:56:46'),
(5,7,2,'行程,餐饮,陪同','2022-10-24 13:34:27');

/*Table structure for table `yx_meettingfee` */

DROP TABLE IF EXISTS `yx_meettingfee`;

CREATE TABLE `yx_meettingfee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meettingid` int(11) DEFAULT NULL COMMENT '会议id',
  `content` varchar(50) DEFAULT NULL COMMENT '科目',
  `details` varchar(300) DEFAULT NULL COMMENT '明细',
  `money` varchar(50) DEFAULT NULL COMMENT '金额',
  `number` int(11) DEFAULT NULL COMMENT '票据数',
  `uid` int(11) DEFAULT NULL COMMENT '报销人id',
  `mark` varchar(200) DEFAULT NULL COMMENT '备注',
  `status` varchar(30) DEFAULT NULL COMMENT '通过/不通过/待办',
  `addtime` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `yx_meettingfee` */

insert  into `yx_meettingfee`(`id`,`meettingid`,`content`,`details`,`money`,`number`,`uid`,`mark`,`status`,`addtime`) values 
(2,7,'市内交通费','接送主任','152',2,11,'123','待办','2022-10-27 13:19:54'),
(3,7,'餐饮费','酒店住宿1','500.21',1,2,'离职书1','不通过','2022-10-27 15:57:38'),
(4,40,'市内交通费','','',0,11,'','通过','2022-10-31 17:20:08'),
(5,40,'市内交通费','','',0,11,'','通过','2022-10-31 17:20:46');

/*Table structure for table `yx_meettinghospital` */

DROP TABLE IF EXISTS `yx_meettinghospital`;

CREATE TABLE `yx_meettinghospital` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meettingid` int(11) DEFAULT NULL,
  `hospitalid` int(11) DEFAULT NULL,
  `addtime` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

/*Data for the table `yx_meettinghospital` */

insert  into `yx_meettinghospital`(`id`,`meettingid`,`hospitalid`,`addtime`) values 
(1,7,1,'2022-10-31 15:39:57'),
(34,7,4,NULL),
(33,7,5,NULL),
(32,7,6,NULL),
(31,7,7,NULL),
(30,7,8,NULL),
(29,7,9,NULL),
(28,7,10,NULL),
(27,7,11,NULL),
(26,7,12,NULL),
(25,7,13,NULL),
(24,7,14,NULL),
(23,7,15,'2022-10-31 16:20:13');

/*Table structure for table `yx_meettingprocess` */

DROP TABLE IF EXISTS `yx_meettingprocess`;

CREATE TABLE `yx_meettingprocess` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `mid` int(11) DEFAULT NULL COMMENT '会议id',
  `mdate` varchar(50) DEFAULT NULL COMMENT '日期',
  `start` varchar(50) DEFAULT NULL COMMENT '开始时间',
  `end` varchar(50) DEFAULT NULL COMMENT '结束时间',
  `theme` varchar(200) DEFAULT NULL COMMENT '课题',
  `speaker` varchar(50) DEFAULT NULL COMMENT '讲者',
  `photo` varchar(200) DEFAULT NULL COMMENT '照片',
  `ppt` varchar(200) DEFAULT NULL COMMENT 'ppt',
  `addtime` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `yx_meettingprocess` */

insert  into `yx_meettingprocess`(`id`,`mid`,`mdate`,`start`,`end`,`theme`,`speaker`,`photo`,`ppt`,`addtime`) values 
(6,7,'2022-09-22','09:30','12:00','今晚吃鸡','刘旭东','/upload/meetting/20221019/9b357f0e39f458e4549484c692ea78fc.jpg','/upload/meetting/20221019/c261bec41479bb97b94ba85ed13e196e.ppt','2022-10-19 14:05:11'),
(7,7,'2022-09-23','13:00','17:30','洛杉矶鬼泣第十三届秋名山密室大逃亡','燕双飞','/upload/meetting/20221019/005354d4eb6b8e1fd4654fa89182de54.jpg',NULL,'2022-10-19 14:07:10'),
(9,7,'2022-09-23','13:00','17:30','洛杉矶鬼泣第十三届秋名山密室大逃亡','燕双飞1','/upload/meetting/20221026/ef2bedab5829a2bee3a4939b8bcad1a0.jpg','/upload/meetting/20221026/e2fdfdb86ae2aeedde472c77a04f2bc1.ppt','2022-10-26 13:52:33');

/*Table structure for table `yx_meettingsale` */

DROP TABLE IF EXISTS `yx_meettingsale`;

CREATE TABLE `yx_meettingsale` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(50) DEFAULT NULL COMMENT '会议名称',
  `type1` varchar(30) DEFAULT NULL COMMENT '1学术会 2销售会',
  `type2` varchar(30) DEFAULT NULL COMMENT '1城市会 2科室会 3病例分享',
  `mdate` varchar(50) DEFAULT NULL COMMENT '日期',
  `starttime` varchar(50) DEFAULT NULL COMMENT '开始时间',
  `endtime` varchar(50) DEFAULT NULL COMMENT '结束时间',
  `province` varchar(50) DEFAULT NULL COMMENT '省',
  `city` varchar(50) DEFAULT NULL COMMENT '市',
  `area` varchar(50) DEFAULT NULL COMMENT '区',
  `addressdetail` varchar(200) DEFAULT NULL COMMENT '详细地址',
  `uid` int(11) DEFAULT NULL COMMENT '创建员工id',
  `add_time` varchar(200) DEFAULT NULL COMMENT '提交时间',
  `status` int(11) DEFAULT '1' COMMENT '1未审核，2已审核，3废弃',
  `hospitalids` varchar(100) DEFAULT NULL COMMENT '关联医院id',
  `processids` varchar(50) DEFAULT NULL COMMENT '议程id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `yx_meettingsale` */

insert  into `yx_meettingsale`(`id`,`name`,`type1`,`type2`,`mdate`,`starttime`,`endtime`,`province`,`city`,`area`,`addressdetail`,`uid`,`add_time`,`status`,`hospitalids`,`processids`) values 
(7,'测试','2','2','2022-11-07','09:00','12:00','湖南省','湘潭市','岳塘区','香格里拉大酒店',11,NULL,2,NULL,NULL),
(6,'商业化产品','2','2','2022-11-02','09:00','12:00','河南省','洛阳市','涧西区','成华区',11,NULL,3,NULL,NULL),
(5,'11111','2','1','2022-11-02','09:00','12:00','山东省','青岛市','黄岛区','2333',3,NULL,3,NULL,NULL),
(8,'20220920成都城市会1','2','1','2022-11-09','09:00','12:00','江西省','景德镇市','昌江区','成华区奥园广场',11,NULL,1,NULL,NULL);

/*Table structure for table `yx_meettingsummary` */

DROP TABLE IF EXISTS `yx_meettingsummary`;

CREATE TABLE `yx_meettingsummary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meettingid` int(11) DEFAULT NULL COMMENT '会议id',
  `uid` int(11) DEFAULT NULL COMMENT '员工id',
  `content` varchar(1000) DEFAULT NULL COMMENT '内容',
  `timing` varchar(50) DEFAULT NULL COMMENT '日期',
  `urls` varchar(500) DEFAULT NULL COMMENT '图片',
  `judge` int(11) DEFAULT NULL COMMENT '评分',
  `status` varchar(50) DEFAULT NULL COMMENT '状态',
  `addtime` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

/*Data for the table `yx_meettingsummary` */

insert  into `yx_meettingsummary`(`id`,`meettingid`,`uid`,`content`,`timing`,`urls`,`judge`,`status`,`addtime`) values 
(19,40,3,'电灯胆','2022-11-30','',3,'通过','2022-11-01 13:46:39'),
(20,40,2,'','','/upload/meetting/20221101/950223e3d5b7dd14c64c8bd1430113a2.jpg',1,'通过','2022-11-01 11:26:00'),
(21,40,11,'','2022-11-01','',1,'通过','2022-11-01 13:47:01'),
(22,40,11,'985','','',1,'通过','2022-11-01 13:46:51');

/*Table structure for table `yx_process` */

DROP TABLE IF EXISTS `yx_process`;

CREATE TABLE `yx_process` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `mdate` varchar(50) DEFAULT NULL COMMENT '会议日期',
  `starttime` varchar(50) DEFAULT NULL COMMENT '开始时间',
  `endtime` varchar(50) DEFAULT NULL COMMENT '结束时间',
  `theme` varchar(50) DEFAULT NULL COMMENT '主题',
  `doctor` varchar(50) DEFAULT NULL COMMENT '讲者',
  `picurl` varchar(100) DEFAULT NULL COMMENT '照片地址',
  `ppt` varchar(100) DEFAULT NULL COMMENT 'ppt地址',
  `addtime` varchar(100) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `yx_process` */

/*Table structure for table `yx_role` */

DROP TABLE IF EXISTS `yx_role`;

CREATE TABLE `yx_role` (
  `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(30) NOT NULL COMMENT '角色名',
  `role_describe` text NOT NULL COMMENT '角色描述',
  `role_auth` text NOT NULL COMMENT '角色权限',
  `role_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '角色状态 0:正常',
  `role_add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '角色添加时间',
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `yx_role` */

insert  into `yx_role`(`role_id`,`role_name`,`role_describe`,`role_auth`,`role_status`,`role_add_time`) values 
(1,'超级管理员','整站权限','all',0,'2018-07-21 22:02:45'),
(2,'管理员','编辑查看部分权限','admin/Order,admin/Article/articleList,admin/Article/addArticle,admin/Article/updateArticle',0,'2018-07-18 22:08:13'),
(6,'员工','','admin/Order,admin/Order',0,'2022-09-20 13:27:26');

/*Table structure for table `yx_user` */

DROP TABLE IF EXISTS `yx_user`;

CREATE TABLE `yx_user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL COMMENT '用户登入名',
  `user_pass` varchar(255) NOT NULL COMMENT '用户密码',
  `user_nicename` varchar(50) NOT NULL COMMENT '用户别名',
  `user_email` varchar(100) NOT NULL COMMENT '用户邮箱',
  `user_phone` varchar(30) NOT NULL COMMENT '用户电话',
  `user_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户状态',
  `user_role` int(11) unsigned NOT NULL COMMENT '用户所属角色ID',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '用户注册时间',
  `token` varchar(50) DEFAULT NULL COMMENT '秘钥',
  `tokentime` varchar(50) DEFAULT NULL COMMENT '秘钥有效期',
  `part` varchar(50) DEFAULT NULL COMMENT '部门',
  `job` varchar(50) DEFAULT NULL COMMENT '职称',
  `addtime` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Data for the table `yx_user` */

insert  into `yx_user`(`user_id`,`user_login`,`user_pass`,`user_nicename`,`user_email`,`user_phone`,`user_status`,`user_role`,`user_registered`,`token`,`tokentime`,`part`,`job`,`addtime`) values 
(1,'admin','$P$BnsmcRm/HWAH2bcuDYrnuen9cd8DVj.','超级管理员','admin@sina.com','15889745718',0,1,'2018-07-21 22:01:32',NULL,NULL,NULL,NULL,NULL),
(11,'ceshi','$P$BAXlWHiiKPK0Lfoub9it3ObtzcCaJe0','测试','','13541626845',0,6,'2022-09-20 13:28:07',NULL,NULL,'企划部','UI设计',NULL),
(2,'zhangsan','$P$BAXlWHiiKPK0Lfoub9it3ObtzcCaJe0','张三','','16522235555',0,6,'2022-09-20 13:28:07',NULL,NULL,'医院部','推广经理',NULL),
(3,'lisi','$P$BnsmcRm/HWAH2bcuDYrnuen9cd8DVj.','李四','','15468455557',0,6,'2022-09-20 13:28:07',NULL,NULL,'市场部','医学助理',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
