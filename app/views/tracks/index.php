<?php


$tableBody = "";

$previousalbumName = null;
$isGreyRow = false;

foreach ($tracks as $track) {
    $albumName = $albums->find($track->album_id)->title;
    if ($albumName !== $previousalbumName) {
        $isGreyRow = !$isGreyRow;
        $previousalbumName = $albumName;
    }
    $bgClass = $isGreyRow ? 'bg-grey' : 'bg-normal';
    $tableBody .= <<<HTML
        <tr class="align-middle text-center {$bgClass}">
            <td>{$albumName}</td>
            <td>{$track->title}</td>
            <td>{$track->spotify_embed}</td>            

            <td>
                <div class="d-flex justify-content-center gap-2">
                    <form method='post' action='/tracks/edit' class='m-0'>
                        <input type='hidden' name='id' value='{$track->id}'>
                        <button type='submit' name='btn-edit' class='btn btn-sm btn-outline-primary' title='Módosít'>
                            <i class='fa fa-edit'></i>
                        </button>
                    </form>
                    <form method='post' action='/tracks' class='m-0'>
                        <input type='hidden' name='id' value='{$track->id}'>    
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
                    <th>Album</th>
                    <th>Cím</th>
                    <th>Spotify beágyzás link</th>
                    <th class="d-flex flex-column gap-1 align-items-center">
                    <form method='post' action='/tracks/create' class="d-inline">
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
