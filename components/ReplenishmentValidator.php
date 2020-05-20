<?php

namespace app\components;

use yii\validators\Validator;
use app\models\User;
use app\models\Replenishment;

class ReplenishmentValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $userById = User::find()->where(['id' => $model->user_id]);
        $userByphone = User::find()->where(['phone_number' => $model->user_id]);
        if (!($userById->exists() xor $userByphone->exists())) {
            $this->addError($model, $attribute, "There is no such id or phone!");
            return false;
        }
        if (($userById->exists() && $userById->one()->status == User::STATUS_BANNED) ||
            ($userByphone->exists() && $userByphone->one()->status == User::STATUS_BANNED)
        ) {
            $this->addError($model, $attribute, "User with id $model->user_id is banned!");
            return false;
        };
        return true;
    }
}
