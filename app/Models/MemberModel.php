<?php

namespace App\Models;

class MemberModel extends Model {

    protected static $table = 'members';

    public int|null $artist_id = null;
    public string|null $name = null;
    public string|null $instrument = null;
    public int|null $birth_year = null;
    public string|null $photo = null;

    function __construct(?int $artist_id = null, ?string $name = null, ?string $instrument = null, ?int $birth_year = null, ?string $photo = null) {
        parent::__construct();

        if ($artist_id !== null) {
            $this->artist_id = $artist_id;
        }
        if ($name) {
            $this->name = $name;
        }
        if ($instrument) {
            $this->instrument = $instrument;
        }
        if ($birth_year) {
            $this->birth_year = $birth_year;
        }
        if ($photo) {
            $this->photo = $photo;
        }
    }

    public function getDb() {
        return $this->db;
    }
}
