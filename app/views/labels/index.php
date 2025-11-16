<?php

$tableBody = "";
foreach ($labels as $label) {
    $labelName = $label->name;

    $tableBody .= <<<HTML
        <tr class="align-middle text-center">
            <td>{$labelName}</td>
            <td>
                <div class="d-flex justify-content-center gap-2">
                    <form method='post' action='/labels/edit' class='m-0'>
                        <input type='hidden' name='id' value='{$label->id}'>
                        <button type='submit' name='btn-edit' class='btn btn-sm btn-outline-primary' title='Módosít'>
                            <i class='fa fa-edit'></i>
                        </button>
                    </form>
                    <form method='post' action='/labels' class='m-0'>
                        <input type='hidden' name='id' value='{$label->id}'>    
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
                    <th>
                        <form method='post' action='/labels/create' class="d-inline">
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
