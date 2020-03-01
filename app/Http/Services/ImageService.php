<?php


namespace App\Http\Services;


use Illuminate\Support\Facades\Storage;

class ImageService
{
    public static function addTextToImage($image_path, $text, $font,
        $size = 24, $color = '#ffffff', $position = 1){

        if (!$image_path || !$text || !file_exists($image_path)) {
            return false;
        }
        if(!$font) {
            $font = storage_path('fonts/arial.ttf');
        }
        if (!$color) {
            $color = "#ffffff";
        }
        else {
            if (strlen($color)< 7) {
                $color = '#'.$color;
            }
        }
        // FETCH IMAGE & WRITE TEXT
        $img = imagecreatefromjpeg($image_path);
        list($red, $green, $blue) = sscanf($color, "#%02x%02x%02x");
        $color = imagecolorallocate($img, $red, $green, $blue);

        // THE IMAGE SIZE
        $width = imagesx($img);
        $height = imagesy($img);

        // THE TEXT SIZE
        $text_size = imagettfbbox($size, 0, $font, $text);
        $text_width = max([$text_size[2], $text_size[4]]) - min([$text_size[0], $text_size[6]]);
        $text_height = max([$text_size[5], $text_size[7]]) - min([$text_size[1], $text_size[3]]);

        // CENTERING THE TEXT BLOCK

        $centerX = CEIL(($width - $text_width) / 2);
        $centerX = $centerX < 0 ? 0 : $centerX;
        if ($position == 1) {
            $centerY = 50;
        }
        elseif ($position == 2) {
            $centerY = CEIL(($height - $text_height) / 2);
            $centerY = $centerY < 0 ? 0 : $centerY;
        }
        else {
            $centerY = CEIL($height - $text_height);
            $centerY = $centerY < 0 ? 0 : $centerY - 50;

        }


        imagettftext($img,  $size, 0, $centerX, $centerY, $color, $font, $text);

        return $img;

    }

}