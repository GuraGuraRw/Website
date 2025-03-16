<?php
/**
 * Copyright ETS Software Technology Co., Ltd
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future.
 *
 * @author ETS Software Technology Co., Ltd
 * @copyright  ETS Software Technology Co., Ltd
 * @license    Valid for 1 website (or project) for each purchase of license
*/

namespace PrestaShop\Module\EtsAutoUpgrade;

use PrestaShop\Module\EtsAutoUpgrade\Parameters\UpgradeConfiguration;

class ChannelInfo
{
    private $info = array();

    /**
     * @var string
    */
    private $channel;

    /**
     * ChannelInfo constructor.
     *
     * @param Upgrader $upgrader
     * @param UpgradeConfiguration $config
     * @param string $channel
    */
    public function __construct(Upgrader $upgrader, UpgradeConfiguration $config, $channel)
    {
        $this->channel = $channel;
        $publicChannels = array('minor', 'major', 'major16', 'rc', 'beta', 'alpha');

        preg_match('#([0-9]+\.[0-9]+)(?:\.[0-9]+){1,2}#', _PS_VERSION_, $matches);
        $upgrader->branch = $matches[1];
        $upgrader->channel = $channel;

        if (in_array($channel, $publicChannels)) {
            if ($channel == 'private' && !$config->get('private_allow_major')) {
                $upgrader->checkPSVersion(false, array('private', 'minor'));
            } else {
                $upgrader->checkPSVersion(false, array('minor'));
            }

            $this->info = array(
                'branch' => $upgrader->branch,
                'available' => $upgrader->available,
                'version_num' => $upgrader->version_num,
                'version_name' => $upgrader->version_name,
                'link' => $upgrader->link,
                'md5' => $upgrader->md5,
                'changelog' => $upgrader->changelog,
            );

            return;
        }

        switch ($channel) {
            case 'private':
                if (!$config->get('private_allow_major')) {
                    $upgrader->checkPSVersion(false, array('private', 'minor'));
                } else {
                    $upgrader->checkPSVersion(false, array('minor'));
                }

                $this->info = array(
                    'available' => $upgrader->available,
                    'branch' => $upgrader->branch,
                    'version_num' => $upgrader->version_num,
                    'version_name' => $upgrader->version_name,
                    'link' => $config->get('private_release_link'),
                    'md5' => $config->get('private_release_md5'),
                    'changelog' => $upgrader->changelog,
                );
                break;

            case 'archive':
            case 'directory':
                $this->info = array(
                    'available' => true,
                );
                break;
        }
    }

    /**
     * @return array
    */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @return string
    */
    public function getChannel()
    {
        return $this->channel;
    }
}
