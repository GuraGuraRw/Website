SET NAMES 'utf8';

ALTER TABLE `PREFIX_address` CHANGE `company` `company` VARCHAR(255) DEFAULT NULL;
UPDATE `PREFIX_attribute` SET `color` = '' WHERE `color` is NULL;