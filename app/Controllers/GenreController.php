<?php

namespace App\Controllers;

use App\Models\GenreModel;
use App\views\Display;

class GenreController extends Controller {

    function __construct()
    {
        $genres = new GenreModel();
        parent::__construct($genres);
    }

    function index() : void
    {
        $genres = $this->model->all(['order_by' => ['name'], 'direction' => ['DESC']]);
        $this->render('genres/index', ['genres' => $genres]);
    }

    function show(int $id)
    {
        $genre = $this->model->find($id);
        if (!$genre) {
            $_SESSION['warning_message'] = "A műfaj a megadott azonosítóval: $id nem található!";
            $this->redirect('/genres');
        }

        $this->render('/genres/show', ['genres' => $genre]);
    }

    function create()
    {
        $this->render('genres/create');
    }

    function save(array $data)
    {
        if (empty($data['name'])) {
            $_SESSION['warning_message'] = "Az név kötelező mező!";
            $this->redirect('/genres/create');
        }
        $this->model->name = $data['name'];

        $this->model->create();
        $this->redirect('/genres');
    }

    function edit(int $id)
    {
        $genre = $this->model->find($id);
        if (!$genre) {
            $_SESSION['warning_message'] = "A műfaj a megadott azonosítóval: $id nem található";
            $this->redirect('/genres');
        }
        $this->render('genres/edit', ['genres' => $genre]);
    }

    function update(int $id, array $data)
    {
        $genre = $this->model->find($id);
        if (!$genre || empty($data['name'])) {
            
            $this->redirect('/genres');
        }
        
        $genre->name = $data['name']; 
        $genre->update();
        $this->redirect('/genres');
    }

    function delete(int $id)
    {
        $genre = $this->model->find($id);
        if ($genre) {
            $result = $genre->delete();
            if ($result) {
                $_SESSION["success_message"] = "Sikeresen törölve";
            }
        }

        $this->redirect('/genres');
    }
}