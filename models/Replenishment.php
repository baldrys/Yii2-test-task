<?php

namespace app\models;

use Yii;
use \yii\db\Expression;
use app\models\User;
use app\components\ReplenishmentValidator;

/**
 * This is the model class for table "replenishments".
 *
 * @property int $id
 * @property int $user_id
 * @property float $amount
 * @property string|null $date
 *
 * @property User $user
 */
class Replenishment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'replenishments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'amount'], 'required'],
            [['user_id'], 'integer'],
            [['user_id'], ReplenishmentValidator::className()],
            [['amount'], 'number', 'min' => 0.0],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'amount' => 'Amount',
            'date' => 'Date',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord)
            $this->date = new Expression('NOW()');

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->getUser()->one()->addBalance($this->amount)->save();
        return parent::afterSave($insert, $changedAttributes);
    }

    public function beforeDelete()
    {
        $this->getUser()->one()->addBalance(-$this->amount)->save();
        return parent::beforeDelete();
    }

    public function validateStatus($attribute, $params)
    {
        print_r($attribute, $params);
        die;

        if ($this->getUser()->status == 1) {
            $this->addError('amount', 'User is banned!');
        }
    }
}
