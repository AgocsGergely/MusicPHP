<?php
echo <<<HTML
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="post" action="/members" class="p-4 border rounded shadow-sm bg-light">
                <h4 class="mb-4 text-center">Új Zenész létrehozása</h4>

                <div class="mb-3">
                    <label for="artist_id" class="form-label"></label>
                    <select name="artist_id" id="artist_id" class="form-select" required>
                        <option value="">Válassz Zenekart</option>
HTML;

$instanceOfArtists = $artists->all();
foreach ($instanceOfArtists as $artist) {
    if ($artist->is_band == 1)
    echo "<option value='{$artist->id}'>{$artist->name}</option>";
}

echo <<<HTML
                    </select>
                </div>

                

                <div class="mb-3">
                    <label for="name" class="form-label">Név</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Leírás" required>
                </div>
                <div class="mb-3">
                    <label for="instrument" class="form-label">Hangszer</label>
                    <input type="text" name="instrument" id="instrument" class="form-control" placeholder="Leírás" required>
                </div>
                <div class="mb-3">
                    <label for="birth_year" class="form-label">Születési év</label>
                    <input type="number" name="birth_year" id="birth_year" class="form-control" placeholder="Sorszám" required>
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Kép linkje</label>
                    <input type="text" name="photo" id="photo" class="form-control" placeholder="Leírás" required>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="btn-save">
                        <i class="fa fa-save"></i> Mentés
                    </button>
                    <a href="/members" class="btn btn-secondary">
                        <i class="fa fa-times"></i> Mégse
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
HTML;
?>
