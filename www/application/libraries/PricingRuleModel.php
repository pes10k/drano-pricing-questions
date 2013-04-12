<?php

class PricingRuleModel extends MongoModel {

    public function index() {

        return $this->collection()->find()->sort(array('name' => 1));
    }

    public function insert($record) {

        if (empty($record['uid'])) {
            $record['uid'] = str_replace(' ', '_', strtolower($record['name']));
        }

        parent::insert($record);
    }

    protected function allowed_fields() {

        return array(
            'name',
            'uid',
            'broad_rules',
            'narrow_rule',
            'narrow_rule_is_regex',
            'domain',
            'severity',
        );
    }

    protected function collection() {

        return $this->db()->pricing_rules;
    }
}
