<?php

abstract class MongoModel {

    static protected $client = NULL;
    static protected $db = NULL;

    static protected function db() {

        if (self::$client === NULL) {
            self::$client = new MongoClient();
            self::$db = self::$client->drano;
        }

        return self::$db;
    }

    public function get($id)
    {
        return $this->collection()->findOne(array('_id' => new MongoId($id)));
    }

    public function delete($id)
    {
        return $this->collection()->remove(array('_id' => new MongoId($id)));
    }

    public function update($id, $fields)
    {
        $fields = array_common_keys($fields, $this->allowed_fields());
        return $this->collection()->update(
            array('_id' => new MongoId($id)),
            array('$set' => $fields)
        );
    }

    public function insert($record)
    {
        $record = array_common_keys($record, $this->allowed_fields());
        $rs = $this->collection()->insert($record);
        return empty($rs['err']) ? $record['_id'] : FALSE;
    }

    abstract protected function allowed_fields();

    abstract protected function collection();
}
