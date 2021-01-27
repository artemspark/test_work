<?php


namespace TestApi\Config;


class File
{
    public const uploadDir = '/banners';

    public static function save($file)
    {
        $fileName = md5($file['tmp_name'] . time()) . '-' . $file['name'];
        move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . self::uploadDir . '/' . $fileName);
        return $fileName;
    }

    public static function delete($name)
    {
        unlink($_SERVER['DOCUMENT_ROOT'] . self::uploadDir . '/' . $name);
    }

    public static function getPath($name)
    {
        return self::uploadDir . '/' . $name;
    }
}