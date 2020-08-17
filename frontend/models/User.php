<?php

namespace frontend\models;

use yii\helpers\ArrayHelper;

class User extends \common\models\User
{
    /* @var $SCENARIO_LOGIN */
    const SCENARIO_LOGIN = 'login';

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required', 'on' => self::SCENARIO_LOGIN],
        ];
    }

    /**
     * @param String $email
     * @return null|User
     */
    public static function findByEmail($email)
    {
        return self::findOne(['email' => $email]);
    }

}
