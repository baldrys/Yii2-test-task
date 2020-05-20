<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Replenishment;
use kartik\daterange\DateRangeBehavior;

/**
 * ReplenishmentSearch represents the model behind the search form of `app\models\Replenishment`.
 */
class ReplenishmentSearch extends Replenishment
{
    // public $createTimeRange;
    // public $createTimeStart;
    // public $createTimeEnd;

    const TIME_FORMAT = 'Y-m-d H:i:s';

    public $createTimeRange;
    public $createTimeStart;
    public $createTimeEnd;

    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'createTimeRange',
                'dateStartAttribute' => 'createTimeStart',
                'dateEndAttribute' => 'createTimeEnd',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['amount'], 'number'],
            [['user_id', 'date_start', 'date_end'], 'safe'],
            [['date'], 'safe'],
            [['createTimeRange'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Replenishment::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith(['user']);

        $query->andFilterWhere([
            'date' => $this->date,
            'amount' => $this->amount,

        ]);

        if (User::find()->where(['id' => $this->user_id])->exists()) {
            $query->andFilterWhere(['like', 'users.id', $this->user_id]);
        } else {
            $query->andFilterWhere(['like', 'users.phone_number', $this->user_id]);
        }

        if (!is_null($this->createTimeRange) && strpos($this->createTimeRange, ' - ') !== false) {
            list($start_date, $end_date) = explode(' - ', $this->createTimeRange);
            $query->andFilterWhere(['between', 'date', $start_date, $end_date]);
            // $this->date = null;
        }

        return $dataProvider;
    }
}
