<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FindDrons;

/**
 * FindDronsSearch represents the model behind the search form of `app\models\FindDrons`.
 */
class FindDronsSearch extends FindDrons
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'drone_id'], 'integer'],
            [['name', 'surname', 'thirdname', 'email', 'drone_reg_number', 'date', 'x_coords', 'y_coords', 'created_at'], 'safe'],
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
        // var_dump($query)
        $query = FindDrons::find()->joinWith(['drons','phones']);
        //var_dump($query);die;

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
            'drone_id' => $this->drone_id,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'thirdname', $this->thirdname])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'drone_reg_number', $this->drone_reg_number])
            ->andFilterWhere(['like', 'x_coords', $this->x_coords])
            ->andFilterWhere(['like', 'y_coords', $this->y_coords])
            ->andFilterWhere(['like', 'model', $this->drons->model])
            ->andFilterWhere(['like', 'created_at', $this->created_at]);

        //var_dump($dataProvider);die;
        return $dataProvider;
    }
}
