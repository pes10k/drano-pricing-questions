<?php

abstract class MongoModel {

    protected $client = NULL;
    protected $db = NULL;

    protected function db() {

        if (!$this->db) {
            $this->client = new MongoClient();
            $this->db = $this->client->drano;
        }

        return $this->db;
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

    abstract protected function allowed_fields();

    abstract protected function collection();
}
