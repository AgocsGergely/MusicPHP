<?php

use App\views\Layout;

// Add stylish header
echo '
<div class="d-flex justify-content-center">
  <h2 class="section-title mb-4">Most recent tracks</h2>
</div>';

echo '<div class="book-list">';


if (!empty($tracks)) {
    foreach ($tracks as $track) {
        $artistName = $artists->find($track['artist_id'])->name ?? 'Ismeretlen szerző';
        $genreName = $genres->find($track['genre'])->name ?? 'Ismeretlen kategória';
        $labelName = $labels->find($track['label_id'])->name ?? 'Ismeretlen kiadó';

        $albumName = null;
        if (!empty($track['album_id'])) {
            $albumObj = $album->find((int)$track['album_id']);
            $albumName = $albumObj ? $albumObj->name : null;
        }

        echo <<<HTML
        <div class="track-card">
          <img src="{$track['photo']}" alt="{$track['title']}">
          <div class="track-info">
            <h3>{$track['title']}</h3>
            <p><strong>Szerző:</strong> {$artistName}</p>
            <p><strong>Kategória:</strong> {$genreName}</p>
            <p><strong>Kiadó:</strong> {$labelName}</p>
            <p><strong>Kiadás éve:</strong> {$track['release_year']}</p>
HTML;

        if ($albumName) {
            echo "<p>{$albumName} : {$track['album_id']}</p>";
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
