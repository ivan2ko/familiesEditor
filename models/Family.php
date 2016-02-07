<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "family".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Human[] $spouses
 * @property Human[] $children
 */
class Family extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'family';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Фамилии'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpouses()
    {
        return $this->hasMany(Human::className(), ['id_descendant_family' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(Human::className(), ['id_ancestry_family' => 'id']);
    }

    public static function getFamiliesDropDown()
    {
        return static::find()->select(['name', 'id'])
            ->orderBy('id')->indexBy('id')->column();
    }
}
