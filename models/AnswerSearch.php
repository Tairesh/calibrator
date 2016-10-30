<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Answer;

/**
 * AnswerSearch represents the model behind the search form about `app\models\Answer`.
 */
class AnswerSearch extends Answer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userId', 'questionId', 'isCorrect', 'dateSubmitted'], 'integer'],
            [['fiftyStart', 'fiftyEnd', 'ninetyStart', 'ninetyEnd', 'score'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Answer::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fiftyStart' => $this->fiftyStart,
            'fiftyEnd' => $this->fiftyEnd,
            'ninetyStart' => $this->ninetyStart,
            'ninetyEnd' => $this->ninetyEnd,
            'score' => $this->score,
            'userId' => $this->userId,
            'questionId' => $this->questionId,
            'isCorrect' => $this->isCorrect,
            'dateSubmitted' => $this->dateSubmitted,
        ]);

        return $dataProvider;
    }
}
