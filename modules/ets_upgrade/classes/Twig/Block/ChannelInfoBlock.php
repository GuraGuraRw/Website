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

namespace PrestaShop\Module\EtsAutoUpgrade\Twig\Block;

use PrestaShop\Module\EtsAutoUpgrade\ChannelInfo;
use PrestaShop\Module\EtsAutoUpgrade\Parameters\UpgradeConfiguration;
use Twig_Environment;

class ChannelInfoBlock
{
    /**
     * @var UpgradeConfiguration
    */
    private $config;

    /**
     * @var ChannelInfo
    */
    private $channelInfo;

    /**
     * @var Twig_Environment|\Twig\Environment
     */
    private $twig;

    /**
     * ChannelInfoBlock constructor.
     *
     * @param UpgradeConfiguration $config
     * @param ChannelInfo $channelInfo
     * @param Twig_Environment|\Twig\Environment $twig
    */
    public function __construct(UpgradeConfiguration $config, ChannelInfo $channelInfo, $twig)//Twig_Environment
    {
        $this->config = $config;
        $this->channelInfo = $channelInfo;
        $this->twig = $twig;
    }

    /**
     * @return string HTML
    */
    public function render()
    {
        $channel = $this->channelInfo->getChannel();
        $upgradeInfo = $this->channelInfo->getInfo();

        if ($channel == 'private') {
            $upgradeInfo['link'] = $this->config->get('private_release_link');
            $upgradeInfo['md5'] = $this->config->get('private_release_md5');
        }

        return $this->twig->render(
            '@ModuleAutoUpgrade/block/channelInfo.twig',
            array(
                'upgradeInfo' => $upgradeInfo,
            )
        );
    }
}
