<?php

namespace App\Models;

class GenreModel extends Model {

    protected static $table = 'genres';

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