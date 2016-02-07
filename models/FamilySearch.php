<?php
namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class FamilySearch
 * @package app\models
 */
class FamilySearch extends Family
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = static::find()->with(['spouses', 'children']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $dataProvider;
    }
}