<?php

function rule_path($rule_record)
{
    return base_url('rules/edit/'.$rule_record['_id']);
}

function rule_has_favicon($rule)
{
    return is_file(config_item('static_path').'/img/favicons/'.$rule['_id'].'.png');
}

function rule_favicon_tag($rule)
{
    if (!rule_has_favicon($rule))
    {
        return FALSE;
    }
    else
    {
        return sprintf(
            '<img class="favicon" src="%s" alt="%s">',
            base_url('static/img/favicons/'.$rule['_id'].'.png'),
            $rule['name']
        );
    }
}

function rule_update_favicon($rule)
{
    $dest = config_item('static_path').'/img/favicons/'.$rule['_id'].'.png';

    if (is_file($dest))
    {
        return FALSE;
    }
    else
    {
        $favicon_bits = file_get_contents('https://plus.google.com/_/favicon?domain='.$rule['domain']);

        if (empty($favicon_bits))
        {
            return FALSE;
        }
        else
        {
            return !! file_put_contents($dest, $favicon_bits);
        }
    }
}

function rule_delete_favicon($rule)
{
    $id = is_numeric($rule) ? $rule : $rule['_id'];
    $path = config_item('static_path').'/img/favicons/'.$id.'.png';
    return file_exists($path) ? unlink($path) : FALSE;
}
