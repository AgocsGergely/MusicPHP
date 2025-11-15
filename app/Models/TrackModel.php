<?php

namespace App\Models;

class TrackModel extends Model {

    protected static $table = 'tracks';

    public int|null $album_id = null;
    public string|null $title = null;
    public string|null $spotify_embed = null;

    function __construct(?int $album_id = null, ?string $title = null, ?string $spotify_embed = null) {
        parent::__construct();

        if ($album_id !== null) {
            $this->album_id = $album_id;
        }
        if ($title) {
            $this->title = $title;
        }
        if ($spotify_embed) {
            $this->spotify_embed = $spotify_embed;
        }
    }

    public function getDb() {
        return $this->db;
    }
}
