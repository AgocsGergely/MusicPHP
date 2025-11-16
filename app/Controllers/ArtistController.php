<?php

namespace App\Controllers;

use App\Models\ArtistModel;
use App\views\Display;

class ArtistController extends Controller {

    function __construct()
    {
        $artists = new ArtistModel();
        parent::__construct($artists);
    }

    function index() : void
    {
        $artists = $this->model->all(['order_by' => ['name'], 'direction' => ['DESC']]);
        $this->render('artists/index', ['artists' => $artists]);
    }

    function show(int $id)
    {
        $artist = $this->model->find($id);
        if (!$artist) {
            $_SESSION['warning_message'] = "A szerző a megadott azonosítóval: $id nem található!";
            $this->redirect('/artists');
        }

        $this->render('/artists/show', ['artists' => $artist]);
    }

    function create()
    {
        $this->render('artists/create');
    }

    function save(array $data)
    {
        if (empty($data['name'])) {
            $_SESSION['warning_message'] = "Az név kötelező mező!";
            $this->redirect('/artists/create');
        }
        $this->model->name = $data['name'];
        $this->model->bio = $data['bio'];
        $this->model->photo = $data['photo'];
        $this->model->birth_year = $data['birth_year'];
        $this->model->instrument = $data['instrument'];
        $this->model->is_band = $data['is_band'];
        $this->model->create();
        $this->redirect('/artists');
    }

    function edit(int $id)
    {
        $artist = $this->model->find($id);
        if (!$artist) {
            $_SESSION['warning_message'] = "Az szerző a megadott azonosítóval: $id nem található";
            $this->redirect('/artists');
        }
        $this->render('artists/edit', ['artists' => $artist]);
    }

    function update(int $id, array $data)
    {
        $artist = $this->model->find($id);
        if (!$artist || empty($data['name'])) {
            $this->redirect('/artists');
        }
        $artist->name = $data['name'];
        $artist->bio = $data['bio'];
        $artist->photo = $data['photo'];
        $artist->birth_year = $data['birth_year'];
        $artist->instrument = $data['instrument'];
        $artist->is_band = $data['is_band'];
        $artist->update();
        $this->redirect('/artists');
    }

    function delete(int $id)
    {
        $artist = $this->model->find($id);
        if ($artist) {
            $result = $artist->delete();
            if ($result) {
                $_SESSION["success_message"] = "Sikeresen törölve";
            }
        }

        $this->redirect('/artists');
    }
}