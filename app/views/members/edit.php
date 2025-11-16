<?php

if (!empty($_SESSION['warning_message'])) {
    echo '<div class="alert alert-danger text-center">' . htmlspecialchars($_SESSION['warning_message']) . '</div>';
    unset($_SESSION['warning_message']); 
}


echo <<<HTML
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="post" action="/members" class="p-4 border rounded shadow-sm bg-light">
                <h4 class="mb-4 text-center">Zenész szerkesztése</h4>
                <input type="hidden" name="id" id="id" value="{$members->id}">
                <input type="hidden" name="_method" value="PATCH">

                <div class="mb-3">
                    <label for="artist_id" class="form-label">Zenekar</label>
                    <select name="artist_id" id="artist_id" class="form-select" required>
HTML;

$instanceOfArtists = $artists->all();
foreach ($instanceOfArtists as $artist) {
    $selected = $artist->id == $members->artist_id ? "selected" : "";
    if ($artist->is_band == 1)
    echo "<option value='{$artist->id}' {$selected}>{$artist->name}</option>";
}

echo <<<HTML
                    </select>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Név</label>
                    <input type="text" name="name" id="name" class="form-control" value="{$members->name}" placeholder="Név" required>
                </div>
                <div class="mb-3">
                    <label for="instrument" class="form-label">Hangszer</label>
                    <input type="text" name="instrument" id="instrument" class="form-control" value="{$members->instrument}" placeholder="Gitár" required>
                </div>
                
                <div class="mb-3">
                    <label for="birth_year" class="form-label">Születési év</label>
                    <input type="number" name="birth_year" id="birth_year" class="form-control" placeholder="Év" value="{$members->birth_year}" required>
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Kép link</label>
                    <input type="text" name="photo" id="photo" class="form-control" placeholder="Kép URL" value="{$members->photo}" required>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" name="btn-update" class="btn btn-primary">
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
