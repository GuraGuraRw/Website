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

use Configuration;
use PrestaShop\Module\EtsAutoUpgrade\ChannelInfo;
use PrestaShop\Module\EtsAutoUpgrade\Parameters\UpgradeConfiguration;
use PrestaShop\Module\EtsAutoUpgrade\TaskRunner\AbstractTask;
use PrestaShop\Module\EtsAutoUpgrade\Tools14;
use PrestaShop\Module\EtsAutoUpgrade\Upgrader;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeSelfCheck;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\Translator;
use Twig_Environment;

class UpgradeButtonBlock
{
    /**
     * @var Twig_Environment|\Twig\Environment
     */
	private $twig;

	/**
	 * @var Translator
	*/
	private $translator;

	/**
	 * @var Upgrader
	*/
	private $upgrader;

	/**
	 * @var UpgradeConfiguration
	*/
	private $config;

	/**
	 * @var UpgradeSelfCheck
	*/
	private $selfCheck;

	/**
	 * @var string
	*/
	private $downloadPath;

	/**
	 * @var string
	*/
	private $token;

	/**
	 * @var bool
	*/
	private $manualMode;

	/**
	 * UpgradeButtonBlock constructor.
	 *
     * @param Twig_Environment|\Twig\Environment $twig
	 * @param Translator $translator
	 * @param UpgradeConfiguration $config
	 * @param Upgrader $upgrader
	 * @param UpgradeSelfCheck $selfCheck
	*/
	public function __construct(
		$twig,//Twig_Environment
		Translator $translator,
		UpgradeConfiguration $config,
		Upgrader $upgrader,
		UpgradeSelfCheck $selfCheck,
		$downloadPath,
		$token,
		$manualMode
	)
	{
		$this->twig = $twig;
		$this->translator = $translator;
		$this->upgrader = $upgrader;
		$this->config = $config;
		$this->selfCheck = $selfCheck;
		$this->downloadPath = $downloadPath;
		$this->token = $token;
		$this->manualMode = $manualMode;
	}

    /**
     * display the summary current version / target version + "Upgrade Now" button with a "more options" button.
     *
     * @return string HTML
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
    */
	public function render()
	{
		$translator = $this->translator;

		$versionCompare = version_compare(_PS_VERSION_, $this->upgrader->version_num);
		$channel = $this->config->get('channel');

		if (!in_array($channel, array('archive', 'directory')) && !empty($this->upgrader->version_num)) {
			$latestVersion = "{$this->upgrader->version_name} - ({$this->upgrader->version_num})";
		} else {
			$latestVersion = $translator->trans('N/A', array(), 'Admin.Global');
		}

		$showUpgradeButton = false;
		$showUpgradeLink = false;
		$upgradeLink = '';
		$changelogLink = '';
		$skipActions = array();

		// decide to display "Start Upgrade" or not
		if ($this->selfCheck->isOkForUpgrade() && $versionCompare < 0) {
			$showUpgradeButton = true;
			if (!in_array($channel, array('archive', 'directory'))) {
				if ($channel == 'private') {
					$this->upgrader->link = $this->config->get('private_release_link');
				}

				$showUpgradeLink = true;
				$upgradeLink = $this->upgrader->link;
				$changelogLink = $this->upgrader->changelog;
			}

			// if skipActions property is used, we will handle that in the display :)
			$skipActions = AbstractTask::$skipAction;
		}

		if (empty($channel)) {
			$channel = Upgrader::DEFAULT_CHANNEL;
		}

		$dir = glob($this->downloadPath . DIRECTORY_SEPARATOR . '*.zip');

		$data = array(
			'versionCompare' => $versionCompare,
			'currentPsVersion' => _PS_VERSION_,
			'latestChannelVersion' => $latestVersion,
			'channel' => $channel,
			'showUpgradeButton' => $showUpgradeButton,
			'upgradeLink' => $upgradeLink,
			'showUpgradeLink' => $showUpgradeLink,
			'changelogLink' => $changelogLink,
			'skipActions' => $skipActions,
			'lastVersionCheck' => Configuration::get('PS_LAST_VERSION_CHECK'),
			'token' => $this->token,
			'channelOptions' => $this->getOptChannels(),
			'channelInfoBlock' => $this->buildChannelInfoBlock($channel),
			'privateChannel' => array(
				'releaseLink' => $this->config->get('private_release_link'),
				'releaseMd5' => $this->config->get('private_release_md5'),
				'allowMajor' => $this->config->get('private_allow_major'),
			),
			'archiveFiles' => $dir,
			'archiveFileName' => $this->config->get('archive.filename'),
			'archiveVersionNumber' => $this->config->get('archive.version_num'),
			'downloadPath' => $this->downloadPath . DIRECTORY_SEPARATOR,
			'directoryVersionNumber' => $this->config->get('directory.version_num'),
			'manualMode' => $this->manualMode,
		);

		return $this->twig->render('@ModuleAutoUpgrade/block/upgradeButtonBlock.twig', $data);
	}

	/**
	 * @return array
	*/
	private function getOptChannels()
	{
		$translator = $this->translator;
        $opts = array();

        if ($channels = $this->upgrader->getChannels(_PS_VERSION_)) {//_PS_VERSION_
            foreach ($channels as $key => $channel) {
                $opts[$key] = array('use'.Tools14::ucfirst($key), $key, $translator->trans('Prestashop %s latest version - %s', array_values($channel), 'Modules.Etsupgrade.Admin'));
            }
        }
		return $opts;
	}

	private function getInfoForChannel($channel)
	{
		return new ChannelInfo($this->upgrader, $this->config, $channel);
	}

	/**
	 * @param string $channel
	 *
	 * @return string
	*/
	private function buildChannelInfoBlock($channel)
	{
		$channelInfo = $this->getInfoForChannel($channel);

		return (new ChannelInfoBlock($this->config, $channelInfo, $this->twig))
			->render();
	}
}
