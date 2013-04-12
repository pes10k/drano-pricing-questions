<?php

function rule_path($rule_record)
{
    return base_url('rules/edit/'.$rule_record['_id']);
}
