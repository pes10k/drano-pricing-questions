<?php

class PricingRuleModel extends MongoModel {

    public function index() {

        return $this->collection()->find()->sort(array('name' => 1));
    }

    public function insert(&$fields) {

        if (empty($fields['uid'])) {
            $uid = preg_replace('/\W/', '', $fields['name']);
            $fields['uid'] = strtolower($fields['name']);
        }

        $fields['prices'] = array();
        $fields['created'] = new MongoDate();
        $fields['updated'] = $fields['created'];

        if (!parent::insert($fields)) {

            return FALSE;

        } else {

            if (!empty($fields['price'])) {
                $this->addPrice($fields['_id'], $fields['price']);
            }

            return TRUE;
        }
    }

    public function update($id, $fields) {

        $fields['updated'] = new MongoDate();
        $rs = parent::update($id, $fields);

        // Check to see if the newly submitted price is different than the
        // most recent price we have for the pricing rule.  Only updaste it
        // if it is.
        if (!empty($fields['price'])) {

            $new_price = (float)$fields['price'];

            $current_record = $this->get($id);

            if (empty($current_record['prices'])) {
                $this->addPrice($id, $new_price);
            } else {
                $prices = $current_record['prices'];
                $most_recent_price = $prices[count($prices) - 1]['price'];

                if ($most_recent_price !== $new_price) {
                    $this->addPrice($id, $new_price);
                }
            }
        }

        return $rs;
    }

    public function addPrice($id, $price) {

        return $this->collection()->update(
            array('_id' => new MongoId($id)),
            array('$push' => array('prices' => array(
                'price' => (float)$price,
                'date' => new MongoDate(),
            )))
        );
    }

    public function allSecurityMethods() {

        return $this->collection()->distinct('extra_factors');
    }

    public function allAdditionalEmailInfo() {

        return $this->collection()->distinct('more_email_info');
    }

    protected function allowed_fields() {

        return array(
            'more_email_info',
            'name',
            'uid',
            'broad_rules',
            'broad_rules_negation',
            'narrow_rule',
            'narrow_rule_is_regex',
            'domain',
            'severity',
            'extra_factors',
        );
    }

    protected function collection() {

        return MongoModel::db()->pricing_rules;
    }
}
