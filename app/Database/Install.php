<?php

namespace App\Database;

use App\Views\Display;
use App\Database\Database;
use Exception;
use PDO;

class Install extends Database
{
    private $dbName = 'music'; 

    public function __construct(array $config = self::DEFAULT_CONFIG, bool $connectToDatabase = true)
    {
        parent::__construct($config,$connectToDatabase);
    }

    public function createDatabase()
    {
        try {
            self::getServerPdo()->exec("CREATE DATABASE IF NOT EXISTS `{$this->dbName}`");
        } catch (Exception $e) {
            error_log("Database creation failed: " . $e->getMessage());
            echo "Sikertelen létrehozás: " . $e->getMessage();
            return false;
        }
    }
    public function createTables(){
        try{
            $this->createTableLabels();
            $this->createTableGenres();
            $this->createTableArtists();
            $this->createTableMembers();
            $this->createTableAlbums();
            $this->createTableTracks();
            $this->uploadTestData();
            echo "<div style='color: green; text-align: center; font-size: 40px;'>Az adatbázis sikeresen létre lett hozva!</div>";
            return true;
        }catch (Exception $e) {
            error_log("Database creation failed: " . $e->getMessage());
            echo "Sikertelen létrehozás: " . $e->getMessage();
            return false;
        }
    }

    public function dbExists(): bool
{
    try {
        $serverDb = new Database(self::DEFAULT_CONFIG, false);
        $pdo = $serverDb->getPdo();

        $stmt = $pdo->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :db");
        $stmt->execute(['db' => $this->dbName]);

        return $stmt->fetch() !== false;
    } catch (Exception $e) {
        error_log("dbExists check failed: " . $e->getMessage());
        return false;
    }
}


    public function uploadTestData()
{
    try {
        $this->execSql("INSERT IGNORE INTO `labels` (`id`, `name`) VALUES
            (1, 'Sony Music'),
            (2, 'Universal Music'),
            (3, 'Warner Music'),
            (4, 'EMI'),
            (5, 'Columbia Records');");

        $this->execSql("INSERT IGNORE INTO `genres` (`id`, `name`) VALUES
            (1, 'Rock'),
            (2, 'Pop'),
            (3, 'Classical'),
            (4, 'Jazz'),
            (5, 'Hip-Hop'),
            (6, 'Electronic'),
            (7, 'Folk'),
            (8, 'Blues'),
            (9, 'Country'),
            (10, 'R&B'),
            (11, 'Metal');");
$this->execSql("INSERT IGNORE INTO `artists` 
    (`id`, `name`, `bio`, `photo`, `birth_year`, `instrument`, `is_band`) VALUES
    (1, 'The Beatles', 'Legendary British rock band.', 'https://tse1.mm.bing.net/th/id/OIP.59lUeOvQtzYpugPUdtDl6gHaFj?cb=ucfimg2ucfimg=1&rs=1&pid=ImgDetMain&o=7&rm=3', NULL, NULL, 1),
    (2, 'Adele', 'British singer-songwriter known for powerful vocals.', 'https://www.wikibio.us/wp-content/uploads/2020/05/Adele.jpg', 1988, 'Vocals', 0),
    (3, 'Led Zeppelin', 'Iconic rock band from the 70s.', 'https://cdn.britannica.com/47/243647-050-7C88FBF5/Led-Zeppelin-1968-studio-portrait-John-Bohham-Jimmy-Page-Robert-Plant-John-Paul-Jones.jpg', NULL, NULL, 1),
    (4, 'Miles Davis', 'Jazz trumpet legend.', 'https://tse1.mm.bing.net/th/id/OIP.NyoviHBYSLVRMvIxuvJgfQHaHa?cb=ucfimg2ucfimg=1&rs=1&pid=ImgDetMain&o=7&rm=3', 1926, 'Trumpet', 0),
    (5, 'Taylor Swift', 'Pop and country singer-songwriter.', 'https://tse1.explicit.bing.net/th/id/OIP.mPSf-pkHbwzKP6b7B1NaXwHaHa?cb=ucfimg2ucfimg=1&rs=1&pid=ImgDetMain&o=7&rm=3', 1989, 'Guitar/Vocals', 0);");

$this->execSql("INSERT IGNORE INTO `members` 
    (`id`, `artist_id`, `name`, `instrument`, `birth_year`, `photo`) VALUES
    (1, 1, 'John Lennon', 'Guitar/Vocals', 1940, 'https://tse3.mm.bing.net/th/id/OIP.i8qj2IMMCW1U3oEJ6B3-kgHaKx?cb=ucfimg2ucfimg=1&rs=1&pid=ImgDetMain&o=7&rm=3'),
    (2, 1, 'Paul McCartney', 'Bass/Vocals', 1942, 'https://th.bing.com/th/id/OIP.8zs-rXEYOKxJUFUI6RdhUAHaHL?o=7&cb=ucfimg2rm=3&ucfimg=1&rs=1&pid=ImgDetMain&o=7&rm=3'),
    (3, 1, 'George Harrison', 'Guitar', 1943, 'https://tse1.mm.bing.net/th/id/OIP.fEdwEA329hQSe-Cbd8tu1QHaFk?cb=ucfimg2ucfimg=1&rs=1&pid=ImgDetMain&o=7&rm=3'),
    (4, 1, 'Ringo Starr', 'Drums', 1940, 'https://th.bing.com/th/id/R.aa425dc8e06f671c0ea31eef6e8c3c90?rik=u5bWMyu1FzGCtw&pid=ImgRaw&r=0'),
    (5, 3, 'Robert Plant', 'Vocals', 1948, 'https://tse3.mm.bing.net/th/id/OIP.Z-brA8V8a7cvTUNag9jJ9gHaFj?cb=ucfimg2ucfimg=1&rs=1&pid=ImgDetMain&o=7&rm=3'),
    (6, 3, 'Jimmy Page', 'Guitar', 1944, 'https://tse3.mm.bing.net/th/id/OIP.Q3Cs7p8bIBR6cIbLw9U2qAHaF4?cb=ucfimg2ucfimg=1&rs=1&pid=ImgDetMain&o=7&rm=3'),
    (7, 3, 'John Paul Jones', 'Bass', 1946, 'https://tse2.mm.bing.net/th/id/OIP.7ZTOQm139JiWsqh6RNXXbwHaHl?cb=ucfimg2ucfimg=1&rs=1&pid=ImgDetMain&o=7&rm=3'),
    (8, 3, 'John Bonham', 'Drums', 1948, 'https://tse4.mm.bing.net/th/id/OIP.T67aIErSH7SlBkZpTiMMtQHaJH?cb=ucfimg2ucfimg=1&rs=1&pid=ImgDetMain&o=7&rm=3');");

   
$this->execSql("INSERT IGNORE INTO `albums` 
    (`id`, `artist_id`, `title`, `genre_id`, `photo`, `release_year`, `label_id`, `description`) VALUES
    (1, 1, 'Abbey Road', 1, 'https://upload.wikimedia.org/wikipedia/en/4/42/Beatles_-_Abbey_Road.jpg', 1969, 4, 'Iconic album by The Beatles featuring hits like Come Together.'),
    (2, 2, '21', 2, 'https://upload.wikimedia.org/wikipedia/en/1/1b/Adele_-_21.png', 2011, 5, 'Adele\'s breakthrough album with songs like Rolling in the Deep.'),
    (3, 3, 'IV', 1, 'https://tse1.mm.bing.net/th/id/OIP.v8wzE6_jViOfazwYbaUZawHaHa?cb=ucfimg2ucfimg=1&rs=1&pid=ImgDetMain&o=7&rm=3', 1971, 3, 'Led Zeppelin\'s untitled fourth album including Stairway to Heaven.'),
    (4, 4, 'Kind of Blue', 4, 'https://th.bing.com/th/id/OIP.YYbr6WG2XzmhYAS_zZF6pwHaHV?o=7&cb=ucfimg2rm=3&ucfimg=1&rs=1&pid=ImgDetMain&o=7&rm=3', 1959, 5, 'Seminal jazz album by Miles Davis.'),
    (5, 5, '1989', 2, 'https://upload.wikimedia.org/wikipedia/en/f/f6/Taylor_Swift_-_1989.png', 2014, 2, 'Taylor Swift\'s pop transition album with Shake It Off.');");

        $this->execSql("INSERT IGNORE INTO `tracks` 
    (`id`, `album_id`, `title`, `spotify_embed`) VALUES
    (1, 1, 'Come Together', 'https://open.spotify.com/embed/track/2EqlS6tkEnglzr7tkKAAYD'),
    (2, 1, 'Something', 'https://open.spotify.com/embed/track/3BQHpFgAp4l80e1XslIjNI'),
    (3, 1, 'Here Comes the Sun', 'https://open.spotify.com/embed/track/6dGnYIeXmHdcikdzNNDMm2'),
    (4, 2, 'Rolling in the Deep', 'https://open.spotify.com/embed/track/1c8gk2PeTE04A1pIDH9YMk'),
    (5, 2, 'Someone Like You', 'https://open.spotify.com/embed/track/4kflIGfjdZJW4ot2ioixTB'),
    (6, 3, 'Stairway to Heaven', 'https://open.spotify.com/embed/track/5CQ30WqJwcep0pYcV4AMNc'),
    (7, 3, 'Black Dog', 'https://open.spotify.com/embed/track/1aoBEc0YDLO25nAoCGJRm2'),
    (8, 4, 'So What', 'https://open.spotify.com/embed/track/7ILXfN4kJ3hYLitnPjOsLi'),
    (9, 4, 'Freddie Freeloader', 'https://open.spotify.com/embed/track/3n4xska4Mo6vXEMbpbLqSg'),
    (10, 5, 'Shake It Off', 'https://open.spotify.com/embed/track/5xTtaWoae3wi06K5WfVUUH'),
    (11, 5, 'Blank Space', 'https://open.spotify.com/embed/track/1p80LdxRV74UKvL8gnD7ky?utm_source=generator');");


    } catch (Exception $e) {
        Display::message($e->getMessage(), 'error');
        error_log($e->getMessage());
    }
}


    public function createTable(string $tableBody, string $tableName, string $dbName = ""): bool
    {
        if (empty($dbName)) $dbName = $this->dbName;

        try {
            $sql = "
                CREATE TABLE IF NOT EXISTS `$dbName`.`$tableName`
                ($tableBody)
                ENGINE = InnoDB
                DEFAULT CHARACTER SET = utf8
                COLLATE = utf8_hungarian_ci;
            ";

            return (bool) $this->execSql($sql);
        } catch (Exception $e) {
            Display::message($e->getMessage(), 'error');
            error_log($e->getMessage());
            return false;
        }
    }
    public function createTableAlbums($dbName = self::DEFAULT_CONFIG['database']): bool
    {
        $tableBody = "
            id INT PRIMARY KEY AUTO_INCREMENT,
            artist_id INT,
            title TEXT(64),
            genre_id INT,
            photo TEXT(256),
            release_year INT,
            label_id INT,
            description TEXT(2048),
            FOREIGN KEY (artist_id) REFERENCES artists(id) ON DELETE SET NULL,
            FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE SET NULL,
            FOREIGN KEY (label_id) REFERENCES labels(id) ON DELETE SET NULL
        ";
        return $this->createTable($tableBody, 'albums', $dbName);
    }

    public function createTableLabels($dbName = self::DEFAULT_CONFIG['database']): bool
    {
        $tableBody = "
            id INT PRIMARY KEY AUTO_INCREMENT,
            name TEXT
        ";
        return $this->createTable($tableBody, 'labels', $dbName);
    }

    public function createTableGenres($dbName = self::DEFAULT_CONFIG['database']): bool
    {
        $tableBody = "
            id INT PRIMARY KEY AUTO_INCREMENT,
            name TEXT
        ";
        return $this->createTable($tableBody, 'genres', $dbName);
    }

    public function createTableArtists($dbName = self::DEFAULT_CONFIG['database']): bool
    {
        $tableBody = "
            id INT PRIMARY KEY AUTO_INCREMENT,
            name TEXT,
            bio TEXT(2048),
            photo TEXT(256),
            birth_year INT,
            instrument TEXT,
            is_band TINYINT(1)
        ";
        return $this->createTable($tableBody, 'artists', $dbName);
    }

    public function createTableMembers($dbName = self::DEFAULT_CONFIG['database']): bool
    {
        $tableBody = "
            id INT PRIMARY KEY AUTO_INCREMENT,
            artist_id INT,
            name TEXT,
            instrument TEXT,
            birth_year INT,
            photo TEXT(256),
            FOREIGN KEY (artist_id) REFERENCES artists(id) ON DELETE CASCADE
        ";
        return $this->createTable($tableBody, 'members', $dbName);
    }

    public function createTableTracks($dbName = self::DEFAULT_CONFIG['database']): bool
    {
        $tableBody = "
            id INT PRIMARY KEY AUTO_INCREMENT,
            album_id INT,
            title TEXT(64),
            spotify_embed TEXT(256),
            FOREIGN KEY (album_id) REFERENCES albums(id) ON DELETE CASCADE
        ";
        return $this->createTable($tableBody, 'tracks', $dbName);
    }

}