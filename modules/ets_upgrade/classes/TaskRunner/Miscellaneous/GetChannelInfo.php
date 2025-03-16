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

namespace PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Miscellaneous;

use PrestaShop\Module\EtsAutoUpgrade\ChannelInfo;
use PrestaShop\Module\EtsAutoUpgrade\TaskRunner\AbstractTask;
use PrestaShop\Module\EtsAutoUpgrade\Twig\Block\ChannelInfoBlock;

/**
 * display informations related to the selected channel : link/changelog for remote channel,
 * or configuration values for special channels.
*/
class GetChannelInfo extends AbstractTask
{
    public function run()
    {
        // do nothing after this request (see javascript function doAjaxRequest )
        $this->next = '';

        $channel = $this->container->getUpgradeConfiguration()->getChannel();
        $channelInfo = (new ChannelInfo($this->container->getUpgrader(), $this->container->getUpgradeConfiguration(), $channel));
        $channelInfoArray = $channelInfo->getInfo();
        $this->nextParams['result']['available'] = $channelInfoArray['available'];

        $this->nextParams['result']['div'] = (new ChannelInfoBlock(
            $this->container->getUpgradeConfiguration(),
            $channelInfo,
            $this->container->getTwig())
        )->render();
    }
}
