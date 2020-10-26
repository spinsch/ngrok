<?php

$helper = new Spinsch_Ngrok_Helper_Data();

if ($helper->isActive()) {

    // add cache prefix
    // notice: requires index.php modification
    $options = array(
        'cache' => array(
            'id_prefix' => 'ngrok_'
        )
    );

    // fix infinity redirect loop for laravel valet
    if ($helper->isSecure()) {
        $_SERVER['HTTPS'] = 'on';
    }
}