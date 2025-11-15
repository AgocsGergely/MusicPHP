<?php
namespace App\Controllers;

use App\Models\AlbumModel;
use App\Models\ArtistModel;
use App\Models\GenreModel;
use App\Models\LabelModel;
use App\Models\MemberModel;
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
            $trackModel = new AlbumModel();
            $tracks = $trackModel->getDb()->execSql(
                "SELECT * FROM `tracks` ORDER BY `id` DESC"
            );
            
            $albums = new AlbumModel();

            $genres = new GenreModel();

            $label = new LabelModel();

            $artist = new ArtistModel();

            $member = new MemberModel();

            View::render('layouts/index', ['tracks' => $tracks, 'albums' => $albums, 'genres' => $genres, 'label' => $label, 'artist' => $artist, 'member' => $member]);
        }
        catch(Exception){
            View::render('layouts/index');
        }
    }
}
?>
