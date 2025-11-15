<?php

use App\views\Layout;

// Add stylish header
echo '
<div class="d-flex justify-content-center">
  <h2 class="section-title mb-4">Most recent albums</h2>
</div>';

echo '<div class="book-list">';


if (!empty($albums)) {
    foreach ($albums as $album) {
        $artistName = $artists->find($album['artist_id'])->name ?? 'Ismeretlen szerző';
        $genreName = $genres->find($album['genre_id'])->name ?? 'Ismeretlen kategória';
        $labelName = $labels->find($album['label_id'])->name ?? 'Ismeretlen kiadó';

        $albumName = null;
        if (!empty($album['album_id'])) {
            $albumObj = $album->find((int)$album['album_id']);
            $albumName = $albumObj ? $albumObj->name : null;
        }

        echo <<<HTML
        <div class="album-card">
          <img src="{$album['photo']}" alt="{$album['title']}">
          <div class="album-info">
            <h3>{$album['title']}</h3>
            <p><strong>Szerző:</strong> {$artistName}</p>
        HTML;
        $members = $member->all(['where' => ['artist_id' => $album['artist_id']]]);
        if ($artists->find($album['artist_id'])->is_band == 1) {
            echo "<p><strong>Zenekar tagjai:</strong></p>";
            
            if (!empty($members)) {
                echo "<ul>";
                foreach ($members as $mem) {
                    if ($mem->artist_id == $album['artist_id'])
                    echo "<li><div class='myDIV'>$mem->name</div>
                <div class='hide'>$mem->instrument <br> $mem->birth_year  </div></li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Nincsenek elérhető tagok.</p>";
            }
        }
        echo <<<HTML
            
            <p><strong>Kategória:</strong> {$genreName}</p>
            <p><strong>Kiadó:</strong> {$labelName}</p>
            <p><strong>Kiadás éve:</strong> {$album['release_year']}</p>
HTML;

        if ($albumName) {
            echo "<p>{$albumName} : {$album['album_id']}</p>";
        }

        echo <<<HTML
          </div>
        </div>
HTML;
}


} else {
    echo '<p>Nincsenek zenék az adatbázisban.</p>';
}
echo '</div>';
?>
