<?php

if (!empty($_SESSION['warning_message'])) {
    echo '<div class="alert alert-danger text-center">' . htmlspecialchars($_SESSION['warning_message']) . '</div>';
    unset($_SESSION['warning_message']); 
}


echo <<<HTML
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="post" action="/tracks" class="p-4 border rounded shadow-sm bg-light">
                <h4 class="mb-4 text-center">Zeneszám szerkesztése</h4>
                <input type="hidden" name="id" id="id" value="{$tracks->id}">
                <input type="hidden" name="_method" value="PATCH">

                <div class="mb-3">
                    <label for="album_id" class="form-label">Album</label>
                    <select name="album_id" id="album_id" class="form-select" required>
HTML;

$instanceOfAlbums = $albums->all();
foreach ($instanceOfAlbums as $album) {
    $selected = $album->id == $tracks->album_id ? "selected" : "";
    echo "<option value='{$album->id}' {$selected}>{$album->title}</option>";
}

echo <<<HTML
                    </select>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Cím</label>
                    <input type="text" name="title" id="title" class="form-control" value="{$tracks->title}" placeholder="Cím" required>
                </div>
                <div class="mb-3">
                    <label for="spotify_embed" class="form-label">Spotify beágyazás linkje</label>
                    <input type="text" name="spotify_embed" id="spotify_embed" class="form-control" value="{$tracks->spotify_embed}" placeholder="https://spotify.com/track01213" required>
                </div>
                
                

                <div class="d-flex justify-content-between">
                    <button type="submit" name="btn-update" class="btn btn-primary">
                        <i class="fa fa-save"></i> Mentés
                    </button>
                    <a href="/tracks" class="btn btn-secondary">
                        <i class="fa fa-times"></i> Mégse
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
HTML;
