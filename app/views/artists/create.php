<?php

echo <<<HTML
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="post" action="/artists" class="p-4 border rounded shadow-sm bg-light">
                <h4 class="mb-4 text-center">Új Zenekar/Művész hozzáadása</h4>

                <div class="mb-3">
                    <label for="name" class="form-label">Név</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Név" required>
                </div>

                <div class="mb-3">
                    <label for="bio" class="form-label">Bio</label>
                    <input type="text" name="bio" id="bio" class="form-control" placeholder="Bio" required>
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Kép linkje</label>
                    <input type="text" name="photo" id="photo" class="form-control" placeholder="Név" required>
                </div>
                <div class="mb-3">
                    <label for="birth_year" class="form-label">Születés éve</label>
                    <input type="text" name="birth_year" id="birth_year" class="form-control" placeholder="2000">
                </div>
                <div class="mb-3">
                    <label for="instrument" class="form-label">Hangszer</label>
                    <input type="text" name="instrument" id="instrument" class="form-control" placeholder="Gitár">
                </div>
                <div class="mb-3">
                    <label for="is_band" class="form-label">Zenekar?</label>
                    <input type="hidden" name="is_band" value="0">
                    <input type="checkbox" style="width:20px; height:20px;" name="is_band" id="is_band" value="1">
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="btn-save">
                        <i class="fa fa-save"></i> Mentés
                    </button>
                    <a href="/artists" class="btn btn-secondary">
                        <i class="fa fa-times"></i> Mégse
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
HTML;
?>
