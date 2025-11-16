<?php

echo <<<HTML
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="post" action="/labels" class="p-4 border rounded shadow-sm bg-light">
                <h4 class="mb-4 text-center">Új kategória hozzáadása</h4>

                <div class="mb-3">
                    <label for="name" class="form-label">Név</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Név" required>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="btn-save">
                        <i class="fa fa-save"></i> Mentés
                    </button>
                    <a href="/labels" class="btn btn-secondary">
                        <i class="fa fa-times"></i> Mégse
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
HTML;
?>
