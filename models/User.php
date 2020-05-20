<?php

namespace app\models;

use Yii;
use app\models\UserStatusEnum;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $phone_number
 * @property string $name
 * @property float|null $balance
 * @property int|null $status
 *
 * @property Replenishments[] $replenishments
 */
class User extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 0;
    const STATUS_BANNED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone_number', 'name'], 'required'],
            [['balance'], 'number'],
            [['status'], 'required'],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_BANNED]],
            //['status', 'default', 'value' => UserStatusEnum::ACTIVE],
            // ['status', 'in', 'range' => UserStatusEnum::getConstantsByName()],
            [['phone_number', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone_number' => 'Phone Number',
            'name' => 'Name',
            'balance' => 'Balance',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Replenishments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReplenishments()
    {
        return $this->hasMany(Replenishment::className(), ['user_id' => 'id']);
    }

    public function getStatusLabels()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_BANNED => 'Banned',
        ];
    }

    public function addBalance($amount)
    {
        $this->balance += $amount;
        return $this;
    }
}
