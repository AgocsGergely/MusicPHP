<?php
namespace App\Controllers;

use App\Models\RatingModel;
use App\Controllers\Controller;
use App\views\Display;
class RatingController extends Controller {

    function __construct()
    {
        $ratings = new RatingModel();
        parent::__construct($ratings);
    }
    function index() : void
    {
        $ratings = $this->model->all(['order_by' => ['album_id'], 'direction' => ['DESC']]);
        $this->render('ratings/index', ['ratings' => $ratings]);
    }
    function show(int $id)
    {
        $rating = $this->model->find($id);
        if (!$rating) {
            $_SESSION['warning_message'] = "A értékelés a megadott azonosítóval: $id nem található!";
            $this->redirect('/ratings');
        }

        $this->render('/ratings/show', ['ratings' => $rating]);
    }
    function create()
    { 
        $this->render('ratings/create');
    }
    function save(array $data)
    {
        if (empty($data['album_id'])) {
            $_SESSION['warning_message'] = "Az album azonosító kötelező mező!";
            $this->redirect('/ratings/create');
        }

        $this->model->album_id = $data['album_id'];
        $this->model->rating = $data['rating'];
        $this->model->create();
        $this->redirect('/ratings');
    }
    function edit(int $id)
    {
        $rating = $this->model->find($id);
        if (!$rating) {
            $_SESSION['warning_message'] = "Az értékelés a megadott azonosítóval: $id nem található!";
            $this->redirect('/ratings');
        }

        $this->render('ratings/edit', ['ratings' => $rating]);
    }
    function update(int $id, array $data)
    {
        $rating = $this->model->find($id);
        if (!$rating) {
            $_SESSION['warning_message'] = "Az értékelés a megadott azonosítóval: $id nem található!";
            $this->redirect('/ratings');
        }

        if (empty($data['album_id'])) {
            $_SESSION['warning_message'] = "Az album azonosító kötelező mező!";
            $this->redirect("/ratings/edit/$id");
        }

        $rating->album_id = $data['album_id'];
        $rating->rating = $data['rating'];
        $rating->update();
        $this->redirect('/ratings');
    }
    function delete(int $id)
    {
        $rating = $this->model->find($id);
        if (!$rating) {
            $_SESSION['warning_message'] = "Az értékelés a megadott azonosítóval: $id nem található!";
            $this->redirect('/ratings');
        }

        $rating->delete();
        $this->redirect('/ratings');
    }
    function averageRating(int $album_id): float|null
    {
        $sql = "SELECT AVG(rating) as avg_rating FROM `" . RatingModel::$table . "` WHERE album_id = :album_id";
        $result = $this->model->getDb()->execSql($sql, ['album_id' => $album_id]);
        if (!empty($result) && isset($result[0]['avg_rating'])) {
            return (float)$result[0]['avg_rating'];
        }
        return null;
    }
}


?>