<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Costs;
use app\models\Settings;

/**
 * PagesSearch represents the model behind the search form of `common\models\Costs`.
 */
class CostsSearch extends Costs
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'category', 'score', 'date'], 'string'],
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
        $set = new Settings();
        //$query = Costs::find()->where(['>=', 'date', $set->beginDate])->andWhere(['<', 'date', ($set->endDate + 86399)])->orderBy(['id' => SORT_DESC]);
        $query = Costs::find()->orderBy(['id' => SORT_DESC]);
        if(!$params) {
            $query->where(['>=', 'date', $set->beginDate])->andWhere(['<', 'date', ($set->endDate + 86399)]);
        }


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>[
                'pageSize' => 10
            ],
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
            'score' => $this->searchScore,
            'category' => $this->searchCategory,

            'date' => $this->searchDate,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
    public function getSearchScore()
    {
        if($this->score) {
            if($id = Scores::find()->where(['like', 'name', $this->score])->one()->id) return $id;
        }
        return $this->score;
    }
    public function getSearchCategory()
    {
        if($this->category) {
            if($id = Categories::find()->where(['like', 'name', $this->category])->one()->id) return $id;
        }
        return $this->category;
    }
    public function getSearchDate()
    {
        if($this->date) {
            return $this->date;
        }
        return $this->date;
    }
}



