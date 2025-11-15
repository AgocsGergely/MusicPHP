<?php

namespace App\Controllers;

use App\Models\AlbumModel;
use App\views\Display;

class AlbumController extends Controller {

    function __construct()
    {
        $albums = new AlbumModel();
        parent::__construct($albums);
    }

    function index() : void
    {
        $albums = $this->model->all(['order_by' => ['name'], 'direction' => ['DESC']]);
        $this->render('albums/index', ['albums' => $albums]);
    }

    function show(int $id)
    {
        $album = $this->model->find($id);
        if (!$album) {
            $_SESSION['warning_message'] = "A szerző a megadott azonosítóval: $id nem található!";
            $this->redirect('/albums');
        }

        $this->render('/albums/show', ['albums' => $album]);
    }

    function create()
    {
        $this->render('albums/create');
    }

    function save(array $data)
    {
        if (empty($data['name'])) {
            $_SESSION['warning_message'] = "Az név kötelező mező!";
            $this->redirect('/albums/create');
        }
        $this->model->artist_id = $data['artist_id'];
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
        $album = $this->model->find($id);
        if (!$album) {
            $_SESSION['warning_message'] = "Az író a megadott azonosítóval: $id nem található";
            $this->redirect('/albums');
        }
        $this->render('albums/edit', ['albums' => $album]);
    }

    function update(int $id, array $data)
    {
        $album = $this->model->find($id);
        if (!$album || empty($data['name'])) {
            $this->redirect('/albums');
        }
        $this->model->artist_id = $data['artist_id'];
        $this->model->title = $data['title'];
        $this->model->photo = $data['photo'];
        $this->model->release_year = $data['release_year'];
        $this->model->label_id = $data['label_id'];
        $this->model->description = $data['description'];
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