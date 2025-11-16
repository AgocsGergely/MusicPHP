<?php

namespace App\Controllers;

use App\Models\AlbumModel;
use App\Models\GenreModel;
use App\Models\LabelModel;
use App\Models\ArtistModel;
use App\views\Display;

class AlbumController extends Controller {

    function __construct()
    {
        $albums = new AlbumModel();
        parent::__construct($albums);
    }

    function index() : void
    {
        $artists = new ArtistModel();
        $genres = new GenreModel();
        $labels = new LabelModel();
        $albums = $this->model->all(['order_by' => ['artist_id'], 'direction' => ['DESC']]);
        $this->render('albums/index', ['albums' => $albums, 'artists' => $artists, 'genres' => $genres, 'labels' => $labels]);
    }

    function show(int $id)
    {
        $artists = new ArtistModel();
        $genres = new GenreModel();
        $labels = new LabelModel();
        $albums = $this->model->find($id);
        if (!$albums) {
            $_SESSION['warning_message'] = "Az album a megadott azonosítóval: $id nem található!";
            $this->redirect('/albums');
        }

        $this->render('/albums/show', ['albums' => $albums, 'artists' => $artists, 'genres' => $genres, 'labels' => $labels]);
    }

    function create()
    {
        $artists = new ArtistModel();
        $genres = new GenreModel();
        $labels = new LabelModel();
        //$albums = $this->model->all();
        $this->render('albums/create', ['artists' => $artists, 'genres' => $genres, 'labels' => $labels]);
    }

    function save(array $data)
    {
        if (empty($data['artist_id'])) {
            $_SESSION['warning_message'] = "Az név kötelező mező!";
            $this->redirect('/albums/create');
        }
        $this->model->artist_id = $data['artist_id'];
        $this->model->genre_id = $data['genre_id'];
        $this->model->title = $data['title'];
        $this->model->photo = $data['photo'];
        $this->model->release_year = $data['release_year'];
        $this->model->label_id = $data['label_id'];
        $this->model->description = $data['description'];
        $this->model->create();
        $this->redirect('/albums');
    }

    function edit(int $id)
    {
        $artists = new ArtistModel();
        $genres = new GenreModel();
        $labels = new LabelModel();
        $album = $this->model->find($id);
        if (!$album) {
            $_SESSION['warning_message'] = "Az album a megadott azonosítóval: $id nem található";
            $this->redirect('/albums');
        }
        $this->render('albums/edit', ['albums' => $album, 'artists' => $artists, 'genres' => $genres, 'labels' => $labels]);
    }

    function update(int $id, array $data)
    {
        $album = $this->model->find($id);
        if (!$album || empty($data['artist_id'])) {
            $this->redirect('/albums');
        }
        $album->artist_id = $data['artist_id'];
        $album->title = $data['title'];
        $album->photo = $data['photo'];
        $album->release_year = $data['release_year'];
        $album->label_id = $data['label_id'];
        $album->description = $data['description'];
        $album->update();
        $this->redirect('/albums');
    }

    function delete(int $id)
    {
        $album = $this->model->find($id);
        if ($album) {
            $result = $album->delete();
            if ($result) {
                $_SESSION["success_message"] = "Sikeresen törölve";
            }
        }

        $this->redirect('/albums');
    }
}