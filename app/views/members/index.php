<?php
if (!empty($_SESSION['warning_message'])) {
    echo '<div class="alert alert-danger text-center">' . $_SESSION['warning_message'] . '</div>';
    unset($_SESSION['warning_message']); 
}

$tableBody = "";

$previousBandName = null;
$isGreyRow = false;

foreach ($members as $member) {
    $bandName = $artists->find($member->artist_id)->name;
    if ($bandName !== $previousBandName) {
        $isGreyRow = !$isGreyRow;
        $previousBandName = $bandName;
    }
    $bgClass = $isGreyRow ? 'bg-grey' : 'bg-normal';
    $tableBody .= <<<HTML
        <tr class="align-middle text-center {$bgClass}">
            <td>{$member->name}</td>
            <td>{$bandName}</td>
            <td>{$member->instrument}</td>
            <td>{$member->birth_year}</td>
            <td>{$member->photo}</td>
            

            <td>
                <div class="d-flex justify-content-center gap-2">
                    <form method='post' action='/members/edit' class='m-0'>
                        <input type='hidden' name='id' value='{$member->id}'>
                        <button type='submit' name='btn-edit' class='btn btn-sm btn-outline-primary' title='Módosít'>
                            <i class='fa fa-edit'></i>
                        </button>
                    </form>
                    <form method='post' action='/members' class='m-0'>
                        <input type='hidden' name='id' value='{$member->id}'>    
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
                    <th>Név</th>
                    <th>Zenekar neve</th>
                    <th>Hangszer</th>
                    <th>Születési év</th>
                    <th>Kép linkje</th>
                    <th class="d-flex flex-column gap-1 align-items-center">
                    <form method='post' action='/members/create' class="d-inline">
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
