<?php


namespace App\Routing;
use App\Database\Install;
use App\views\Display;
use App\Views\Layout;
use App\Controllers\HomeController;
use App\Controllers;
use App\Controllers\ArtistController;
use App\Controllers\AlbumController;
use App\Controllers\GenreController;
use App\Controllers\LabelController;
use App\Controllers\MemberController;
use App\Controllers\TrackController;

class Router {
    public function handle(): void
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        $requestUri = $_SERVER['REQUEST_URI'];

        if($method === 'POST' && isset($_POST['_method'])){
            $method = strtoupper($_POST['_method']);
        }

        $this->dispatch($method,$requestUri);
    }
    private function dispatch(string $method, string $requestUri): void
    {
        switch ($method){
            case 'GET':
                $this->handleGetRequests($requestUri);
                break;
            case 'POST':
                $this->handlePostRequests($requestUri);
                break;
            case 'PATCH':
                $this->handlePatchRequests($requestUri);
                break;
            case 'DELETE':
                $this->handleDeleteRequests($requestUri);
                break;
            default:
                $this->methodNotAllowed();
        }
    }

    private function handlePostRequests($requestUri){
        $data = $this->filterPostData($_POST);
        $id = $data['id'] ?? null;
        switch ($requestUri) {
            case '/artists':
                if(!empty($data)) {
                    $artistController = new artistController();
                    $artistController->save($data);
                }
                break;
            case '/artists/create':
                $artistController = new artistController();
                $artistController->create();
                break;
            case '/artists/edit':
                $artistController = new artistController();
                $artistController->edit($id);
                break;

                //-------------------------------------------------
            case '/genres':
                if(!empty($data)) {
                    $genreController = new GenreController();
                    $genreController->save($data);
                }
                break;
            case '/genres/create':
                $genreController = new GenreController();
                $genreController->create();
                break;
            case '/genres/edit':
                $genreController = new GenreController();
                $genreController->edit($id);
                break;

                //-------------------------------------------------
            case '/labels':
                if(!empty($data)) {
                    $labelController = new LabelController();
                    $labelController->save($data);
                }
                break;
            case '/labels/create':
                $labelController = new LabelController();
                $labelController->create();
                break;
            case '/labels/edit':
                $labelController = new LabelController();
                $labelController->edit($id);
                break;

                //-------------------------------------------------
            case '/albums':
                if(!empty($data)) {
                    $albumController = new AlbumController();
                    $albumController->save($data);
                }
                break;
            case '/albums/create':
                $albumController = new AlbumController();
                $albumController->create();
                break;
            case '/albums/edit':
                $albumController = new AlbumController();
                $albumController->edit($id);
                break;
                //-------------------------------------------------

            case '/tracks/create':
                $trackController = new TrackController();
                $trackController->create();
                break;
            case '/tracks':
                if(!empty($data)) {
                    $trackController = new TrackController();
                    $trackController->save($data);
                }
                break;
            case '/tracks/edit/submit':
                foreach($data as $d) error_log($d); 
                $trackController = new TrackController();
                if(!empty($data)) {
                    $trackController->update($data['id'],$data);
                    break;
                }
                break;            
            case '/tracks/edit':
                $trackController = new TrackController();
                $trackController->edit($id);
                break;

                //-------------------------------------------------

            case '/install':
                Layout::header();
                $db = new Install([],false);
                $db->createDatabase();
                $db = new Install();
                $db->createTables();
                Layout::footer();
                break;
            default:
                $this->notFound();
            }
            
        
    }
    
    private function handlePatchRequests($requestUri){
        $data = $this->filterPostData($_POST);
        switch($requestUri) {
            case '/artists':
                $id = $data['id'] ?? null;
                $artistController = new ArtistController();
                $artistController->update($id, $data);
                break;
            case '/genres':
                $id = $data['id'] ?? null;
                $genreController = new GenreController();
                $genreController->update($id, $data);
                break;
            case '/labels':
                $id = $data['id'] ?? null;
                $labelController = new LabelController();
                $labelController->update($id, $data);
                break;
            case '/album':
                $id = $data['id'] ?? null;
                $albumController = new AlbumController();
                $albumController->update($id, $data);
                break;
            case '/tracks':
                $id = $data['id'] ?? null;
                $trackController = new TrackController();
                $trackController->update($id, $data);
                break;
            default:
                $this->notFound();
        }
       
    }
    private function handleDeleteRequests($requestUri){
        $data = $this->filterPostData($_POST);

        switch($requestUri) {
            case '/artists':
                $artistController = new artistController();
                $artistController->delete((int) $data['id']);
                break;
            case '/genres':
                $genreController = new genreController();
                $genreController->delete((int) $data['id']);
                break;
            case '/labels':
                $labelController = new labelController();
                $labelController->delete((int) $data['id']);
                break;
            case '/album':
                $albumController = new albumController();
                $albumController->delete((int) $data['id']);
                break;
            case '/tracks':
                $trackController = new TrackController();
                $trackController->delete((int) $data['id']);
                break;
            default:
                $this->notFound();
        }

        
    }
    private function methodNotAllowed(){
        header ($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        Display::message("405 Method Not Allowed");
    }
    private function filterPostData(array $data): array
    {
        $filterKeys = ['_method', 'submit', 'btn-del', 'btn-save', 'btn-edit', 'btn-plus', 'btn-update'];
        return array_diff_key($data, array_flip($filterKeys));
    }
    private function notFound(): void
    {
        header($_SERVER['SERVER_PROTOCOL'] . '404 Not Found');
        Display::message("404 Not Found","error");
    }
    private function handleGetRequests(mixed $requestUri){
        switch($requestUri){
            case '/':
                HomeController::index();
                return;
            case '/artists':
                $artistController = new artistController();
                $artistController->index();
                break;
            case '/genres':
                $genreController = new genreController();
                $genreController->index();
                break;
            case '/labels':
                $labelController = new labelController();
                $labelController->index();
                break;
            case '/album':
                $serieController = new albumController();
                $serieController->index();
                break;
            case '/tracks':
                $trackController = new TrackController();
                $trackController->index();
                break;
            default:
                $this->notFound();
            }
        
    }
}