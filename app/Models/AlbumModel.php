<?php

namespace App\Models;

class AlbumModel extends Model {
    protected static $table = 'albums';

    public int $id;
    public int $artist_id;
    public string $title;
    public int $genre_id;
    public string $photo;
    public int $release_year;
    public int $label_id;
    public string $description;

    public function getDb() {
        return $this->db;
    }
}