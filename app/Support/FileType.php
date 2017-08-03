<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/3/2017
 * Time: 12:05 PM
 */

namespace App\Support;


class FileType
{

    public static function getFileType($url)
    {
        $mime_type = mime_content_type($url);

        $types = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png'
        ];

        return $types[$mime_type];
    }

}