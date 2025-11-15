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

        $this->execSql("INSERT IGNORE INTO `artists` (`id`, `name`, `bio`, `photo`, `birth_year`, `instrument`, `is_band`) VALUES
            (1, 'The Beatles', 'Legendary British rock band.', 'https://example.com/beatles.jpg', NULL, NULL, 1),
            (2, 'Adele', 'British singer-songwriter known for powerful vocals.', 'https://example.com/adele.jpg', 1988, 'Vocals', 0),
            (3, 'Led Zeppelin', 'Iconic rock band from the 70s.', 'https://example.com/ledzeppelin.jpg', NULL, NULL, 1),
            (4, 'Miles Davis', 'Jazz trumpet legend.', 'https://example.com/milesdavis.jpg', 1926, 'Trumpet', 0),
            (5, 'Taylor Swift', 'Pop and country singer-songwriter.', 'https://example.com/taylorswift.jpg', 1989, 'Guitar/Vocals', 0);");

        $this->execSql("INSERT IGNORE INTO `members` (`id`, `artist_id`, `name`, `instrument`, `birth_year`, `photo`) VALUES
            (1, 1, 'John Lennon', 'Guitar/Vocals', 1940, 'https://example.com/johnlennon.jpg'),
            (2, 1, 'Paul McCartney', 'Bass/Vocals', 1942, 'https://example.com/paulmccartney.jpg'),
            (3, 1, 'George Harrison', 'Guitar', 1943, 'https://example.com/georgeharrison.jpg'),
            (4, 1, 'Ringo Starr', 'Drums', 1940, 'https://example.com/ringostarr.jpg'),
            (5, 3, 'Robert Plant', 'Vocals', 1948, 'https://example.com/robertplant.jpg'),
            (6, 3, 'Jimmy Page', 'Guitar', 1944, 'https://example.com/jimmypage.jpg'),
            (7, 3, 'John Paul Jones', 'Bass', 1946, 'https://example.com/johnpauljones.jpg'),
            (8, 3, 'John Bonham', 'Drums', 1948, 'https://example.com/johnbonham.jpg');");

        $this->execSql("INSERT IGNORE INTO `albums` 
            (`id`, `artist_id`, `title`, `genre_id`, `photo`, `release_year`, `label_id`, `description`) VALUES
            (1, 1, 'Abbey Road', 1, 'https://example.com/abbeyroad.jpg', 1969, 4, 'Iconic album by The Beatles featuring hits like Come Together.'),
            (2, 2, '21', 2, 'https://example.com/21.jpg', 2011, 5, 'Adele\'s breakthrough album with songs like Rolling in the Deep.'),
            (3, 3, 'IV', 1, 'https://example.com/ledzeppeliniv.jpg', 1971, 3, 'Led Zeppelin\'s untitled fourth album including Stairway to Heaven.'),
            (4, 4, 'Kind of Blue', 4, 'https://example.com/kindofblue.jpg', 1959, 5, 'Seminal jazz album by Miles Davis.'),
            (5, 5, '1989', 2, 'https://example.com/1989.jpg', 2014, 2, 'Taylor Swift\'s pop transition album with Shake It Off.');");

        $this->execSql("INSERT IGNORE INTO `tracks` 
            (`id`, `album_id`, `title`, `spotify_embed`) VALUES
            (1, 1, 'Come Together', 'https://embed.spotify.com/?uri=spotify:track:123abc'),
            (2, 1, 'Something', 'https://embed.spotify.com/?uri=spotify:track:456def'),
            (3, 1, 'Here Comes the Sun', 'https://embed.spotify.com/?uri=spotify:track:789ghi'),
            (4, 2, 'Rolling in the Deep', 'https://embed.spotify.com/?uri=spotify:track:abc123'),
            (5, 2, 'Someone Like You', 'https://embed.spotify.com/?uri=spotify:track:def456'),
            (6, 3, 'Stairway to Heaven', 'https://embed.spotify.com/?uri=spotify:track:ghi789'),
            (7, 3, 'Black Dog', 'https://embed.spotify.com/?uri=spotify:track:jkl012'),
            (8, 4, 'So What', 'https://embed.spotify.com/?uri=spotify:track:mno345'),
            (9, 4, 'Freddie Freeloader', 'https://embed.spotify.com/?uri=spotify:track:pqr678'),
            (10, 5, 'Shake It Off', 'https://embed.spotify.com/?uri=spotify:track:stu901'),
            (11, 5, 'Blank Space', 'https://embed.spotify.com/?uri=spotify:track:vwx234');");

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