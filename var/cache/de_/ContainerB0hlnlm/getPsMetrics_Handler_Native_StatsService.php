<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'ps_metrics.handler.native.stats' shared service.

return $this->services['ps_metrics.handler.native.stats'] = new \PrestaShop\Module\Ps_metrics\Handler\NativeStatsHandler(${($_ = isset($this->services['ps_metrics.module']) ? $this->services['ps_metrics.module'] : $this->load('getPsMetrics_ModuleService.php')) && false ?: '_'});
