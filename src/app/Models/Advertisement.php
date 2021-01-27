<?php

namespace TestApi\Models;

use TestApi\Config\DB;
use TestApi\Config\File;

class Advertisement
{
    public const table = 'advertisements';

    private static array $fields = [
        'text',
        'price',
        'amount',
        'banner',
        'counter'
    ];

    /**
     * @param $id
     * @param $data
     * @return bool|mysqli_result
     */
    public static function update($id, $data)
    {
        $data = self::prepareFields($data);
        if ($data) {
            $queryStr = self::makeDataSql($data);
            $query = "update " . self::table . $queryStr . " where id = " . $id;
            return mysqli_query((new DB())->getConnection(), $query);
        }
        return false;
    }

    /**
     * Подготавливаем данные для передачи
     * обрабатываем/отсеиваем лишнее
     * @param array $data
     * @return array
     */
    public static function prepareFields(array $data)
    {
        $newData = [];
        foreach ($data as $key => $value) {
            //Отсеиваем поля, которые не описаны
            if (!in_array($key, self::$fields)) {
                continue;
            }

            //Делаем текст безопасным
            if ($key == 'text') {
                $value = htmlspecialchars(strip_tags($value));
            }

            if ($key == 'banner') {
                $value = File::save($value);
            }

            $newData[$key] = $value;
        }

        return $newData;
    }

    /**
     * Готовим строку для sql запроса из параметров
     * @param array $data
     * @return string
     */
    public static function makeDataSql(array $data)
    {
        $sql = ' set ';
        $queryPieces = [];

        foreach ($data as $key => $value) {
            $queryPieces[] = "" . $key . " = '" . $value . "'";
        }

        if ($queryPieces) {
            $sql .= implode(', ', $queryPieces);
        }

        return $sql;
    }

    /**
     * Находим подходящее объявление
     * @return mixed
     */
    public static function findAvailable()
    {
        $query = "select * from " . self::table . " where counter < amount or amount = 0 order by price desc limit 1";
        $dbRes = mysqli_query((new DB())->getConnection(), $query);
        $res = mysqli_fetch_all($dbRes, MYSQLI_ASSOC)[0];
        if ($res['banner']) {
            $res['banner'] = File::getPath($res['banner']);
        }
        return $res;
    }

    /**
     * @param $data
     * @return bool|mixed
     */
    public static function create($data)
    {
        $result = [
            'id' => false,
        ];

        $data = self::prepareFields($data);
        if ($data) {
            $queryStr = self::makeDataSql($data);
            $query = "insert into " . self::table . $queryStr;
            $connection = (new DB())->getConnection();
            $res = mysqli_query($connection, $query);
            if ($res) {
                $result['id'] = $connection->insert_id;
            } else {
                $result['error'] = $connection->error;
            }
        }

        return $result;
    }

    /**
     * Получение объявления по ID
     * @param int $id
     * @return mixed
     */
    public static function getById(int $id)
    {
        $query = "select * from " . self::table . ' where id = ' . $id;
        $dbRes = mysqli_query((new DB())->getConnection(), $query);
        return mysqli_fetch_all($dbRes, MYSQLI_ASSOC)[0];
    }
}