<?php

if (!defined('BASEPATH'))
    die('No direct script access allowed');

$haanga_path = dirname(__FILE__) . DIRECTORY_SEPARATOR;
foreach (array(DCPATH, APPPATH) as $path)
{
    $tpl_config = $path . 'config/template.php';
    if (file_exists($tpl_config))
    {
        require_once($tpl_config);
    }
}

if (!isset($template))
{
    show_error('Haanga: The configuration file template.php does not exist.');
}

if ($template['use_haanga'])
{
    require_once($haanga_path . 'Haanga.php');

    Haanga::configure(array(
        'template_dir' => $template['dir'],
        'cache_dir' => $template['cache_dir'],
    ));
}