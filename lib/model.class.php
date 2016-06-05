<?php

class Model
{
    protected $db;
    protected $affected_rows;
    public function __construct()
    {
        $this->db=App::$db;
    }

    /**
     * @return mixed
     */
    public function getAffectedRows()
    {
        return $this->affected_rows;
    }
    public function extractId($alias)
    {
        $parts = explode('-', $alias);
        $id = (int)(end($parts));
        return $id;
    }
}
