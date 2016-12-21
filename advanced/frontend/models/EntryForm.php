<?php
/**
 * Created by PhpStorm.
 * User: Hitch
 * Date: 10.11.2016
 * Time: 15:56
 */
namespace app\models;

use yii\base\Model;

class EntryForm extends Model
{
    public $name;
    public $email;
    public $message;

    public function rules()
    {


        return [
            'name' => [['name'], 'required', 'message' => 'Пожалуста введите ваше имя.'],
            'email' => [['email'], 'required','message' => 'Пожалуйста введите вашу почту.'],
            ['email', 'email', 'message' => 'Почта не коректна.'],
            [['message'], 'string', 'max' => 1000]
        ];
    }
}