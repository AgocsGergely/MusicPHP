<?php

namespace App\Models;

class LabelModel extends Model {

    protected static $table = 'labels';

    public string|null $name = null;

    function __construct(?string $name = null)
    {
        parent::__construct();
        if ($name) {
            $this->name = $name;
        }
    }

    public function getDb() {
        return $this->db;
    }
}