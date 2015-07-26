CREATE DATABASE IF NOT EXISTS `static_deploy` charset=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `app` (
  `appId` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `config` text NOT NULL DEFAULT '',
  `deleted` tinyint unsigned NOT NULL DEFAULT 0,
  `deletedByUserId` int unsigned NOT NULL DEFAULT 0,
  `createdDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `createdByUserId` varchar(64) NOT NULL,
  `updatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updatedByUserId` varchar(64) NOT NULL,
  PRIMARY KEY (`appId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `user` (
  `userId` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fullName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `firstName` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lastName` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `jobTitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `lastLoginDate` datetime DEFAULT '0000-00-00 00:00:00',
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `confCode` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `resetToken` varchar(127) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resetCode` varchar(127) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resetExpiryDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` tinyint unsigned NOT NULL,
  `createdDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `createdBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `createdByUserId` int unsigned NOT NULL DEFAULT '0',
  `updatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updatedBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updatedByUserId` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
