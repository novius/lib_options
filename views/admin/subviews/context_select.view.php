<?php
$action = array(
    'action' => 'nosTabs',
    'method' => 'update',
    'tab' => array(
        'url' => $options['config']['controller_url'].'/form/',
        'reload' => true,
    ),
);
$uiElement = array(
    'type' => 'button',
    'label' => \Nos\Tools_Context::contextLabel($view_params['context'], array()),
    'icon' => 'ui-icon-triangle-1-s',
    'menu' => array(
        'menus' => array(),
    ),
);
$contexts = array_keys(\Nos\Tools_Context::contexts());
if (count($contexts) > 1) {
    $allowed_contexts = \Nos\User\Permission::contexts();
    if (count($allowed_contexts) > 1) {
        $i = 0;
        foreach ($allowed_contexts as $context => $domains) {
            $uiElement['menu']['menus'][$i]['content'] = \Nos\Tools_Context::contextLabel($context, array('template' => '{site}<br />{locale}', 'short' => true));
            $uiElement['menu']['menus'][$i]['label'] = \Nos\Tools_Context::contextLabel($context, array('template' => '{site}<br />{locale}', 'short' => true));
            $uiElement['menu']['menus'][$i]['action'] = $action;
            $uiElement['menu']['menus'][$i]['action']['tab']['url'] = $options['config']['controller_url'].'/form/'.$context;
            $i++;
        }
    }
}
echo (string) \Format::forge($uiElement)->to_json();