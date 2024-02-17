<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Incomes;
use app\models\Settings;

/**
 * PagesSearch represents the model behind the search form of `common\models\Costs`.
 */
class IncomesSearch extends Incomes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'income', 'category', 'income_default', 'score', 'date'], 'safe'],
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
        $query = Incomes::find()->orderBy(['id' => SORT_DESC]);
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


        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}




