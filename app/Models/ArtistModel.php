<?php

namespace App\Models;

class ArtistModel extends Model {

    protected static $table = 'artists';

    public string|null $name = null;
    public string|null $bio = null;
    public string|null $photo = null;
    public int|null $birth_year = null;
    public string|null $instrument = null;
    public int|null $is_band = null;

    function __construct(?string $name = null, ?string $bio = null, ?string $photo = null, ?int $birth_year = null, ?string $instrument = null, ?int $is_band = null) {
        parent::__construct();

        if ($name) {
            $this->name = $name;
        }
        if ($bio) {
            $this->bio = $bio;
        }
        if ($photo) {
            $this->photo = $photo;
        }
        if ($birth_year) {
            $this->birth_year = $birth_year;
        }
        if ($instrument) {
            $this->instrument = $instrument;
        }
        if ($is_band !== null) {
            $this->is_band = $is_band;
        }
    }

    public function getDb() {
        return $this->db;
    }
}
