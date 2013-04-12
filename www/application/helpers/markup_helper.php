<?php

function static_url($path) {
    $ts = filemtime(config_item('static_path').'/'.$path);
    return config_item('static_url').$path.'?m='.$ts;
}

function get_val($array, $key) {
    return isset($array[$key]) ? $array[$key] : '';
}
