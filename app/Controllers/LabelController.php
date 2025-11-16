<?php

namespace App\Controllers;

use App\Models\LabelModel;
use App\views\Display;

class LabelController extends Controller {

    function __construct()
    {
        $labels = new LabelModel();
        parent::__construct($labels);
    }

    function index() : void
    {
        $labels = $this->model->all(['order_by' => ['name'], 'direction' => ['DESC']]);
        $this->render('labels/index', ['labels' => $labels]);
    }

    function show(int $id)
    {
        $label = $this->model->find($id);
        if (!$label) {
            $_SESSION['warning_message'] = "A label a megadott azonosítóval: $id nem található!";
            $this->redirect('/labels');
        }

        $this->render('/labels/show', ['labels' => $label]);
    }

    function create()
    {
        $this->render('labels/create');
    }

    function save(array $data)
    {
        if (empty($data['name'])) {
            $_SESSION['warning_message'] = "Az név kötelező mező!";
            $this->redirect('/labels/create');
        }
        $this->model->name = $data['name'];

        $this->model->create();
        $this->redirect('/labels');
    }

    function edit(int $id)
    {
        $label = $this->model->find($id);
        if (!$label) {
            $_SESSION['warning_message'] = "A label a megadott azonosítóval: $id nem található";
            $this->redirect('/labels');
        }
        $this->render('labels/edit', ['labels' => $label]);
    }

    function update(int $id, array $data)
    {
        $label = $this->model->find($id);
        if (!$label || empty($data['name'])) {
            $this->redirect('/labels');
        }
        $label->name = $data['name'];
        $label->update();
        $this->redirect('/labels');
    }

    function delete(int $id)
    {
        $label = $this->model->find($id);
        if ($label) {
            $result = $label->delete();
            if ($result) {
                $_SESSION["success_message"] = "Sikeresen törölve";
            }
        }

        $this->redirect('/labels');
    }
}