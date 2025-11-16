<?php
echo <<<HTML
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="post" action="/albums" class="p-4 border rounded shadow-sm bg-light">
                <h4 class="mb-4 text-center">Új Album létrehozása</h4>

                <div class="mb-3">
                    <label for="artist_id" class="form-label"></label>
                    <select name="artist_id" id="artist_id" class="form-select" required>
                        <option value="">Válassz Zenekart</option>
HTML;

$instanceOfArtists = $artists->all();
foreach ($instanceOfArtists as $artist) {
    echo "<option value='{$artist->id}'>{$artist->name}</option>";
}

echo <<<HTML
                    </select>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Cím</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Cím" required>
                </div>
                                <div class="mb-3">
                    <label for="genre_id" class="form-label">Műfaj</label>
                    <select name="genre_id" id="genre_id" class="form-select" required>
                HTML;
$instanceOfGenres = $genres->all();
foreach ($instanceOfGenres as $genre) {
    echo "<option value='{$genre->id}'>{$genre->name}</option
>";
}
echo <<<HTML
                    </select>
                </div>
    

                <div class="mb-3">
                    <label for="photo" class="form-label">Kép linkje</label>
                    <input type="text" name="photo" id="photo" class="form-control" placeholder="https://example.com/photo" required>
                </div>
                
                <div class="mb-3">
                    <label for="release_year" class="form-label">Kiadási év</label>
                    <input type="number" name="release_year" id="release_year" class="form-control" placeholder="Év" required>
                </div>
                <div class="mb-3">
                    <label for="label_id" class="form-label">Kiadó</label>
                    <select name="label_id" id="label_id" class="form-select" required>
                HTML;
$instanceOfLabels = $labels->all();
foreach ($instanceOfLabels as $label) {
    echo "<option value='{$label->id}' >{$label->name}</option
>";
}
echo <<<HTML
                    </select>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Leírás</label>
                    <input type="text" name="description" id="description" class="form-control" placeholder="Leírás"  required>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="btn-save">
                        <i class="fa fa-save"></i> Mentés
                    </button>
                    <a href="/albums" class="btn btn-secondary">
                        <i class="fa fa-times"></i> Mégse
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
HTML;
?>
