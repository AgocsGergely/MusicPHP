<?php
echo <<<HTML
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="post" action="/tracks" class="p-4 border rounded shadow-sm bg-light">
                <h4 class="mb-4 text-center">Új Zeneszám létrehozása</h4>

                <div class="mb-3">
                    <label for="album_id" class="form-label"></label>
                    <select name="album_id" id="album_id" class="form-select" required>
                        <option value="">Válassz Albumot</option>
HTML;

$instanceOfAlbums = $albums->all();
foreach ($instanceOfAlbums as $album) {
    echo "<option value='{$album->id}'>{$album->title}</option>";
}

echo <<<HTML
                    </select>
                </div>

                

                <div class="mb-3">
                    <label for="title" class="form-label">Cím</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Cím" required>
                </div>
                <div class="mb-3">
                    <label for="spotify_embed" class="form-label">Spotify beágyazás linkje</label>
                    <input type="text" name="spotify_embed" id="spotify_embed" class="form-control" placeholder="https://spotify.com/track01213" required>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="btn-save">
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
?>
