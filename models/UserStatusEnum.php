<?php

namespace app\models;

use yii2mod\enum\helpers\BaseEnum;

class UserStatusEnum extends BaseEnum
{
    const ACTIVE = 0;
    const BANNED = 1;

    /**
     * @var array
     */
    public static $list = [
        self::ACTIVE => 'Active',
        self::BANNED => 'Banned',
    ];
}
