<?php

namespace App\Models;
class RatingModel extends Model {

    public static $table = 'ratings';

    public int|null $album_id = null;
    public int|null $rating = null;

    function __construct(?int $album_id = null, ?int $rating = null)
    {
        parent::__construct();
        if ($album_id) {
            $this->album_id = $album_id;
        }
        if ($rating) {
            $this->rating = $rating;
        }
    }
    function getDb() {
        return $this->db;
    }
}
?>