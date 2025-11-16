<?php

$tableBody = "";
foreach ($artists as $artist) {
    $artistName = $artist->name;
    $artistBio = $artist->bio;
    $artistBirthYear = !empty($artist->birth_year) ? $artist->birth_year : 'Ismeretlen';
    $artistInstrument = !empty($artist->instrument) ? $artist->instrument : 'Ismeretlen';

    $artistIsBand = $artist->is_band ? 'Igen' : 'Nem';

    $tableBody .= <<<HTML
        <tr class="align-middle text-center">
            <td>{$artistName}</td>
            <td>{$artistBio}</td>
            <td>{$artistBirthYear}</td>
            <td>{$artistInstrument}</td>
            <td>{$artistIsBand}</td>
            <td>
                <div class="d-flex justify-content-center gap-2">
                    <form method='post' action='/artists/edit' class='m-0'>
                        <input type='hidden' name='id' value='{$artist->id}'>
                        <button type='submit' name='btn-edit' class='btn btn-sm btn-outline-primary' title='Módosít'>
                            <i class='fa fa-edit'></i>
                        </button>
                    </form>
                    <form method='post' action='/artists' class='m-0'>
                        <input type='hidden' name='id' value='{$artist->id}'>    
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
        <table class="table table-bordered table-hover text-center align-middle shadow-sm bg-tablecolor">
            <thead class="table-light">
                <tr>
                    <th>Név</th>
                    <th>Bio</th>
                    <th>Keletkezés/Születés</th>
                    <th>Hangszer</th>
                    <th>Zenekar?</th>
                    <th>
                        <form method='post' action='/artists/create' class="d-inline">
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
?>
