<?php

$tableBody = "";

$previousBandName = null;
$isGreyRow = false;

foreach ($albums as $album) {
    $bandName = $artists->find($album->artist_id)->name;
    $genreName = $genres->find($album->genre_id)->name;
    $labelName = $labels->find($album->label_id)->name;
    if ($bandName !== $previousBandName) {
        $isGreyRow = !$isGreyRow;
        $previousBandName = $bandName;
    }
    $bgClass = $isGreyRow ? 'bg-grey' : 'bg-normal';
    $tableBody .= <<<HTML
        <tr class="align-middle text-center {$bgClass}">
            <td>{$bandName}</td>
            <td>{$album->title}</td>
            <td>{$genreName}</td>
            <td>{$album->photo}</td>
            <td>{$album->release_year}</td>
            <td>{$labelName}</td>
            <td>{$album->description}</td>
            

            <td>
                <div class="d-flex justify-content-center gap-2">
                    <form method='post' action='/albums/edit' class='m-0'>
                        <input type='hidden' name='id' value='{$album->id}'>
                        <button type='submit' name='btn-edit' class='btn btn-sm btn-outline-primary' title='Módosít'>
                            <i class='fa fa-edit'></i>
                        </button>
                    </form>
                    <form method='post' action='/albums' class='m-0'>
                        <input type='hidden' name='id' value='{$album->id}'>    
                        <input type='hidden' name='_method' value='DELETE'>
                        <button type='submit' name='btn-del' class='btn btn-sm btn-outline-danger' title='Töröl'>
                            <i class='fa fa-trash'></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    HTML;
}

$html = <<<HTML
<div class="container mt-5">
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle shadow-sm">
            <thead class="table-light">
                <tr>
                    <th>Zenekar neve</th>
                    <th>Cím</th>
                    <th>Műfaj</th>
                    <th>Kép linkje</th>
                    <th>Megjelenés éve</th>
                    <th>Kiadó</th>
                    <th>Leírás</th>
                    <th class="d-flex flex-column gap-1 align-items-center">
                    <form method='post' action='/albums/create' class="d-inline">
                        <button type="submit" name='btn-plus' class="btn btn-success btn-sm" title='Új'>
                            <i class='fa fa-plus'></i>&nbsp;Új
                        </button>
                    </form>
                </th>
                </tr>
            </thead>
            <tbody>
                %s
            </tbody>
        </table>
    </div>
</div>
HTML;

echo sprintf($html, $tableBody);
