<?php
/** @var modX $modx */
/** @var msInformMe $msInformMe */

switch ($modx->event->name) {
    case 'OnMODXInit':
        $map = array(
            'msProductData' => array(
                'fields' => array(
                    'im_email' => '',
                ),
                'fieldMeta' => array(
                    'im_email' => array (
                        'dbtype' => 'varchar',
                        'precision' => '100',
                        'phptype' => 'string',
                        'null' => false,
                        'default' => '',
                    ),
                ),
            ),
        );

        foreach ($map as $class => $data) {
            $modx->loadClass($class);
            foreach ($data as $tmp => $fields) {
                if ($tmp == 'fields') {
                    foreach ($fields as $field => $value) {
                        foreach (array(
                                     'fields',
                                     'fieldMeta',
                                     'indexes',
                                     'composites',
                                     'aggregates',
                                     'fieldAliases',
                                 ) as $key) {
                            if (isset($data[$key][$field])) {
                                $modx->map[$class][$key][$field] = $data[$key][$field];
                            }
                        }
                    }
                }
            }
        }
        break;

    case 'OnDocFormPrerender':
        if ($resource->class_key != 'msProduct') { return; }

        $modx->controller->addLexiconTopic('msinformme:default');

        if (!$msInformMe = $modx->getService('msinformme', 'msInformMe', MODX_CORE_PATH
            . 'components/msinformme/model/msinformme/')) {
            $modx->log(modX::LOG_LEVEL_ERROR, $modx->event->name . ' '
                . $modx->lexicon('msinformme_err_not_class') . ' msInformMe');
            return;
        }

        if ($obj = $modx->getObject('msProductData', array('id' => $id))) {
            $data = array();
            $data['email'] = $obj->get('im_email');

            $patch = MODX_ASSETS_URL . 'components/msinformme/js/mgr/';
            //$modx->regClientStartupScript($patch . 'msinformme.js');
            $modx->regClientStartupScript($patch . 'misc/utils.js');
            $modx->regClientStartupScript($patch . 'sections/home.js');
            $modx->controller->addJavascript($patch . 'msinformme.js');
            $modx->controller->addHtml('<script type="text/javascript">
                miniShop2.msInformMe = {
                    im_email: "' . $data['email'] . '"
                };
                msInformMe.config = ' . json_encode($msInformMe->config) . ';
                msInformMe.config.connector_url = "' . $msInformMe->config['connectorUrl'] . '";
            </script>
            ');
        }
        break;
}