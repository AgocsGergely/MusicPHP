<?php

namespace App\Controllers;

use App\Models\TrackModel;
use App\Models\AlbumModel;
use App\views\Display;

class TrackController extends Controller {

    function __construct()
    {
        $tracks = new TrackModel();
        parent::__construct($tracks);
    }

    function index() : void
    {
        $albums = new AlbumModel();
        $tracks = $this->model->all(['order_by' => ['album_id'], 'direction' => ['DESC']]);
        $this->render('tracks/index', ['tracks' => $tracks, 'albums' => $albums]);
    }

    function show(int $id)
    {
        $albums = new AlbumModel();
        $track = $this->model->find($id);
        if (!$track) {
            $_SESSION['warning_message'] = "A zeneszám a megadott azonosítóval: $id nem található!";
            $this->redirect('/tracks');
        }

        $this->render('/tracks/show', ['tracks' => $track, 'albums' => $albums]);
    }

    function create()
    {
        $albums = new AlbumModel();
        $this->render('tracks/create', ['albums' => $albums]);
    }

    function save(array $data)
    {
        if (empty($data['title'])) {
            $_SESSION['warning_message'] = "Az név kötelező mező!";
            $this->redirect('/tracks/create');
        }

        $this->model->album_id = $data['album_id'];
        $this->model->title = $data['title'];
        $this->model->spotify_embed = $data['spotify_embed'];
        $this->model->create();
        $this->redirect('/tracks');
    }

    function edit(int $id)
    {
        $albums = new AlbumModel();
        $track = $this->model->find($id);
        if (!$track) {
            $_SESSION['warning_message'] = "Az zeneszám a megadott azonosítóval: $id nem található";
            $this->redirect('/tracks');
        }
        $this->render('tracks/edit', ['tracks' => $track, 'albums' => $albums]);
    }

    function update(int $id, array $data)
    {
        $track = $this->model->find($id);
        if (!$track || empty($data['title'])) {
            $this->redirect('/tracks');
        }
        $track->album_id = $data['album_id'];
        $track->title = $data['title'];
        $track->spotify_embed = $data['spotify_embed'];
        $track->update();
        $this->redirect('/tracks');
    }

    function delete(int $id)
    {
        $track = $this->model->find($id);
        if ($track) {
            $result = $track->delete();
            if ($result) {
                $_SESSION["success_message"] = "Sikeresen törölve";
            }
        }

        $this->redirect('/tracks');
    }
}