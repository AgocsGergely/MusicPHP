<?php

namespace App\Controllers;

use App\Models\MemberModel;
use App\views\Display;

class MemberController extends Controller {

    function __construct()
    {
        $members = new MemberModel();
        parent::__construct($members);
    }

    function index() : void
    {
        $members = $this->model->all(['order_by' => ['name'], 'direction' => ['DESC']]);
        $this->render('members/index', ['members' => $members]);
    }

    function show(int $id)
    {
        $member = $this->model->find($id);
        if (!$member) {
            $_SESSION['warning_message'] = "A tag a megadott azonosítóval: $id nem található!";
            $this->redirect('/members');
        }

        $this->render('/members/show', ['members' => $member]);
    }

    function create()
    {
        $this->render('members/create');
    }

    function save(array $data)
    {
        if (empty($data['name'])) {
            $_SESSION['warning_message'] = "Az név kötelező mező!";
            $this->redirect('/members/create');
        }

        $this->model->member_id = $data['member_id'];
        $this->model->name = $data['name'];
        $this->model->photo = $data['photo'];
        $this->model->birth_year = $data['birth_year'];
        $this->model->instrument = $data['instrument'];
        $this->model->create();
        $this->redirect('/members');
    }

    function edit(int $id)
    {
        $member = $this->model->find($id);
        if (!$member) {
            $_SESSION['warning_message'] = "Az tag a megadott azonosítóval: $id nem található";
            $this->redirect('/members');
        }
        $this->render('members/edit', ['members' => $member]);
    }

    function update(int $id, array $data)
    {
        $member = $this->model->find($id);
        if (!$member || empty($data['name'])) {
            $this->redirect('/members');
        }
        $this->model->member_id = $data['member_id'];
        $this->model->name = $data['name'];
        $this->model->photo = $data['photo'];
        $this->model->birth_year = $data['birth_year'];
        $this->model->instrument = $data['instrument'];
        $member->update();
        $this->redirect('/members');
    }

    function delete(int $id)
    {
        $member = $this->model->find($id);
        if ($member) {
            $result = $member->delete();
            if ($result) {
                $_SESSION["success_message"] = "Sikeresen törölve";
            }
        }

        $this->redirect('/members');
    }
}