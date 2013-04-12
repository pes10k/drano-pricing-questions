<?php

function array_common_keys($array, $keys) {

    $new_array = array();
    foreach ($keys as $key) {
        if (isset($array[$key])) {
            $new_array[$key] = $array[$key];
        }
    }
    return $new_array;
}
