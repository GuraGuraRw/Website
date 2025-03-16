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

use PrestaShop\Module\EtsAutoUpgrade\UpgradeSelfCheck;
use PrestaShop\Module\EtsAutoUpgrade\Tools14;
use Context;
use Twig_Environment;

/**
 * Builds the upgrade checklist block.
*/
class UpgradeChecklist
{
    /**
     * @var Twig_Environment|\Twig\Environment
     */
    private $twig;

    /**
     * @var string
    */
    private $prodRootPath;

    /**
     * @var string
    */
    private $adminPath;

    /**
     * @var string
    */
    private $autoupgradePath;

    /**
     * @var UpgradeSelfCheck
    */
    private $selfCheck;

    /**
     * @var string
    */
    private $currentIndex;

    /**
     * @var string
    */
    private $token;

    /**
     * UpgradeChecklistBlock constructor.
     *
     * @param Twig_Environment|\Twig\Environment $twig
     * @param UpgradeSelfCheck $upgradeSelfCheck
     * @param string $prodRootPath
     * @param string $adminPath
     * @param string $autoupgradePath
     * @param string $currentIndex
     * @param string $token
    */
    public function __construct(
        $twig,//Twig_Environment
        UpgradeSelfCheck $upgradeSelfCheck,
        $prodRootPath,
        $adminPath,
        $autoupgradePath,
        $currentIndex,
        $token
    ) {
        $this->twig = $twig;
        $this->selfCheck = $upgradeSelfCheck;
        $this->prodRootPath = $prodRootPath;
        $this->adminPath = $adminPath;
        $this->autoupgradePath = $autoupgradePath;
        $this->currentIndex = $currentIndex;
        $this->token = $token;
    }

    /**
     * Returns the block's HTML.
     *
     * @return string
    */
    public function render()
    {
        $data = array(
            'showErrorMessage' => !$this->selfCheck->isOkForUpgrade(),
            'moduleVersion' => $this->selfCheck->getModuleVersion(),
            'moduleIsUpToDate' => $this->selfCheck->isModuleVersionLatest(),
            'versionGreaterThan1_5_3' => version_compare(_PS_VERSION_, '1.5.3.0', '>'),
            'adminToken' => Tools14::getAdminTokenLite('AdminModules'),
            'informationsLink' => Context::getContext()->link->getAdminLink('AdminInformation'),
            'rootDirectoryIsWritable' => $this->selfCheck->isRootDirectoryWritable(),
            'rootDirectoryWritableReport' => $this->selfCheck->getRootWritableReport(),
            'adminDirectoryIsWritable' => $this->selfCheck->isAdminAutoUpgradeDirectoryWritable(),
            'adminDirectoryWritableReport' => $this->selfCheck->getAdminAutoUpgradeDirectoryWritableReport(),
            'safeModeIsDisabled' => $this->selfCheck->isSafeModeDisabled(),
            'allowUrlFopenOrCurlIsEnabled' => $this->selfCheck->isFOpenOrCurlEnabled(),
            'zipIsEnabled' => $this->selfCheck->isZipEnabled(),
            'storeIsInMaintenance' => $this->selfCheck->isShopDeactivated(),
            'currentIndex' => $this->currentIndex,
            'token' => $this->token,
            'cachingIsDisabled' => $this->selfCheck->isCacheDisabled(),
            'maxExecutionTime' => $this->selfCheck->getMaxExecutionTime(),
            'phpUpgradeRequired' => $this->selfCheck->isPhpUpgradeRequired(),
            'isPrestaShopReady' => $this->selfCheck->isPrestaShopReady(),
        );


        return $this->twig->render('@ModuleAutoUpgrade/block/checklist.twig', $data);
    }
}
