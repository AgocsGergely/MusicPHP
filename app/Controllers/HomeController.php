<?php
namespace App\Controllers;

use App\Models\AlbumModel;
use App\Models\ArtistModel;
use App\Models\GenreModel;
use App\Models\LabelModel;
use App\Models\MemberModel;
use App\Models\TrackModel;
use App\views\View;
use App\Models\BookModel;
use App\Models\SeriesModel;
use App\Models\PublisherModel;
use App\Models\CategoryModel;
use App\Models\AuthorModel;

use Exception;

class HomeController
{
    static function index()
    {
        try{
            $albumModel = new AlbumModel();
            $albums = $albumModel->getDb()->execSql(
                "SELECT * FROM `albums` ORDER BY `id` DESC"
            );
            
            $tracks = new TrackModel();

            $genres = new GenreModel();

            $labels = new LabelModel();

            $artists = new ArtistModel();

            $member = new MemberModel();

            View::render('layouts/index', ['tracks' => $tracks, 'albums' => $albums, 'genres' => $genres, 'labels' => $labels, 'artists' => $artists, 'member' => $member]);
        }
        catch(Exception){
            View::render('layouts/index');
        }
    }
}
?>
