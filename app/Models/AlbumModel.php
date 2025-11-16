<?php

namespace App\Models;

class AlbumModel extends Model {
    protected static $table = 'albums';

    public int $id;
    public int|null $artist_id;
    public string|null $title;
    public int|null $genre_id;
    public string|null $photo;
    public int|null $release_year;
    public int|null $label_id;
    public string|null $description;

    public function getDb() {
        return $this->db;
    }
}