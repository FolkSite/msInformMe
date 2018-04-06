<?php
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
}
else {
    require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var msInformMe $msInformMe */
$msInformMe = $modx->getService('msinformme', 'msInformMe', $modx->getOption('msinformme_core_path', null,
        $modx->getOption('core_path') . 'components/msinformme/') . 'model/msinformme/'
);
$modx->lexicon->load('msinformme:default');

// handle request
$corePath = $modx->getOption('msinformme_core_path', null, $modx->getOption('core_path') . 'components/msinformme/');
$path = $modx->getOption('processorsPath', $msInformMe->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));