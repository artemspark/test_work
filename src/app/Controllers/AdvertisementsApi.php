<?php

namespace TestApi\Controllers;

use TestApi\Config\File;
use TestApi\Models\Advertisement;

class AdvertisementsApi
{
    /**
     * Создание рекламного объявления
     * @param $request
     */
    public static function createAdvertisement($request)
    {
        $result = Advertisement::create($request);
        if ($result['id']) {
            self::response(
                [
                    'status' => 'ok',
                    'data' => ['id' => $result['id']]
                ]
            );
            return;
        } else {
            self::response(
                [
                    'status' => 'error',
                    'error' => 'Unable to create advertisement. ' . $result['error']
                ]
            );
        }
    }

    /**
     * Выводит подготовленный ответ
     * @param $data
     */
    protected static function response($data)
    {
        header("Content-Type: application/json");
        echo json_encode($data);
    }

    /**
     * Показ рекламного объявления
     * @param $request
     */
    public static function showAdvertisement($request)
    {
        $res = Advertisement::findAvailable();
        //Увеличиваем счетчик просмотров объявления
        if ($res['id']) {
            Advertisement::update($res['id'], ['counter' => ($res['counter'] + 1)]);

            self::response(
                [
                    'status' => 'ok',
                    'data' => [
                        'text' => $res['text'],
                        'banner' => $res['banner']
                    ]
                ]
            );
            return;
        }

        self::response(
            [
                'status' => 'ok',
                'data' => null
            ]
        );
    }

    /**
     *  Обновление рекламного объявления
     * @param $request
     */
    public static function updateAdvertisement($request)
    {
        $result = [
            'status' => 'ok'
        ];

        $id = $request['id'];

        if ($id) {
            //Проверяем есть ли элемент с таким ID
            $elExist = Advertisement::getById($id);
            if ($elExist) {
                $res = Advertisement::update($id, $request);
                if (!$res) {
                    $result['status'] = 'error';
                    $result['error'] = 'Unable to update element';
                } elseif (array_key_exists('banner', $request) && $elExist['banner']) {
                    //Не забываем удалять баннер если его перезалили
                    File::delete($elExist['banner']);
                }
            } else {
                $result['status'] = 'error';
                $result['error'] = 'Wrong element for update';
            }
        } else {
            $result['status'] = 'error';
            $result['error'] = 'Missing Id for update';
        }

        self::response($result);
    }
}