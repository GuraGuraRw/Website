CREATE TABLE IF NOT EXISTS `PREFIX_zslideshow` (
    `id_zslideshow` int(11) NOT NULL AUTO_INCREMENT,
	`id_shop` int(10) unsigned NOT NULL DEFAULT 1,
	`active` tinyint(1) unsigned NOT NULL DEFAULT 1,
	`active_mobile` tinyint(1) unsigned DEFAULT 1,
	`position` int(10) unsigned NOT NULL DEFAULT 0,
	`image` varchar(100) DEFAULT '',
	`related_products` varchar(100) DEFAULT NULL,
    PRIMARY KEY  (`id_zslideshow`)
) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_zslideshow_lang` (
	`id_zslideshow` int(10) unsigned NOT NULL,
	`id_lang` int(10) unsigned NOT NULL,
	`title` varchar(254) DEFAULT NULL,
	`image_name` varchar(100) NULL DEFAULT '',
	`slide_link` varchar(254) DEFAULT NULL,
	`caption` text DEFAULT NULL,
	PRIMARY KEY (`id_zslideshow`,`id_lang`)
) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;