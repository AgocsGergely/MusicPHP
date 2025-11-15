<?php

namespace App\Views;
use App\Database\Database;
use App\Database\Install;
use Exception;

class Layout
{
    public static function header($title = "Music") {
        echo <<<HTML
        <!DOCTYPE html>
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>$title</title>

                <link href="/fontawesome/css/all.css" rel="stylesheet" type="text/css">
                <link href="/css/sajat.css" rel="stylesheet" type="text/css">
                <link href="/css/styles.css" rel="stylesheet" type="text/css">
                <style>
                    body {
                        background: beige;
                    }
                </style>

            </head>

            <body>
        HTML;
        self::navbar();
        self::handleMessage();
        echo '<div class="container pt-5 mt-5">';
    }

    private static function handleMessage(): void
    {
        $message = [
            'success_message' => 'success',
        ];
    }

    public static function navbar() {

        $dbModel = new Install([], false);


        echo <<<HTML
                <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" id="mainNav">
                    <div class="container">
                        <a class="navbar-brand">Music</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                            Menu
                            <i class="fas fa-bars ms-1"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarResponsive">
                            <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                                <li class="nav-item">
                                    <form action="/install" method="post" class="d-inline">
                                        <input type="hidden" name="action" value="create_database">
                                        <button type="submit" class="nav-link btn btn-link text-uppercase px-0" style="text-decoration: none;">Adatbázis létrehozása</button>
                                    </form>
                                </li>
                HTML;
        if ($dbModel->dbExists()){
        echo <<<HTML
                                <li class="nav-item"><a class="nav-link" href="/artists">Artists</a></li>
                                <li class="nav-item"><a class="nav-link" href="/labels">Labels</a></li>
                                <li class="nav-item"><a class="nav-link" href="/genres">Genres</a></li>
                                <li class="nav-item"><a class="nav-link" href="/albums">Albums</a></li>
                                <li class="nav-item"><a class="nav-link" href="/tracks">Tracks</a></li>
                HTML;
        }

        echo <<<HTML
                                <li class="nav-item"><a class="nav-link" href="/">Kezdőlap</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
    HTML;
    }

    public static function footer() {
    echo <<<HTML
        </div>
        <footer class="bg-light text-center text-lg-start mt-5">
            <hr class="m-0">
            <div class="text-center p-3" style="background-color: rgb(255, 218, 125);">
                &copy; 2025 
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    HTML;
}
}