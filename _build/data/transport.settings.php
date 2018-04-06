<?php
/** @var modX $modx */
/** @var array $sources */

$settings = array();

$tmp = array(
    'template_send' => array(
        'xtype' => 'modx-combo-template',
        'value' => '',
        'area' => 'msinformme_email',
    ),
    'email_subject' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'msinformme_email',
    ),
    'email_sender' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'msinformme_email',
    ),
    'email_reply_to' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'msinformme_email',
    ),
);

foreach ($tmp as $k => $v) {
    /** @var modSystemSetting $setting */
    $setting = $modx->newObject('modSystemSetting');
    $setting->fromArray(array_merge(
        array(
            'key' => 'msinformme_' . $k,
            'namespace' => PKG_NAME_LOWER,
        ), $v
    ), '', true, true);

    $settings[] = $setting;
}
unset($tmp);

return $settings;
