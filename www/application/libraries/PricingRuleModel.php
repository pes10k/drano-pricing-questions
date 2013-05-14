<?php

class PricingRuleModel extends MongoModel {

    public function index() {

        return $this->collection()->find()->sort(array('name' => 1));
    }

    public function insert($fields) {

        if (empty($fields['uid'])) {
            $uid = preg_replace('/\W/', '', $fields['name']);
            $fields['uid'] = strtolower($fields['name']);
        }

        $fields['prices'] = array();
        $fields['created'] = new MongoDate();
        $fields['updated'] = $fields['created'];

        $id = parent::insert($fields);
        $this->processExtraFactor($id, $fields);

        if (!empty($fields['price'])) {
            $this->addPrice($id, $fields['price']);
        }

        return $id;
    }

    public function update($id, $fields) {

        $fields['updated'] = new MongoDate();
        $rs = parent::update($id, $fields);
        $this->processExtraFactor($id, $fields);

        // Check to see if the newly submitted price is different than the
        // most recent price we have for the pricing rule.  Only updaste it
        // if it is.
        if (!empty($fields['price'])) {

            $new_price = (float)$fields['price'];

            $current_record = $this->get($id);

            if (!empty($current_record['prices'])) {

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

    public function extraFactors() {

        return $this->collection()->distinct('extra_factor');
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
            'extra_factor',
        );
    }

    protected function collection() {

        return MongoModel::db()->pricing_rules;
    }

    protected function processExtraFactor($id, &$fields) {

        if (empty($fields['severity']) OR $fields['severity'] !== 'Email plus' OR
            empty($fields['extra_factor'])) {

            $rs = $this->collection()->update(
                array('_id' => new MongoId($id)),
                array('$unset' => array('extra_factor' => 1))
            );


	    if (isset($fields['extra_factor'])) {
                unset($fields['extra_factor']);
            }

        } else {

            $this->collection()->update($id, array('extra_factor' => $fields['extra_factor']));

        }
    }
}
