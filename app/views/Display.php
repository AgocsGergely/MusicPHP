<?php
namespace App\views;

class Display{
    static function message($message, $type='text', $important = false){
        echo "
        <div>$message</div>";
        #$style = self::STYLES[$type] ?? self::STYLES['text'];

    }
}
?>