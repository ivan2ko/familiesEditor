<?php

namespace app\models;

use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "human".
 *
 * @property integer $id
 * @property integer $id_ancestry_family
 * @property integer $id_descendant_family
 * @property string $name
 * @property string $surname
 * @property string $ancestry
 *
 * @property Family $idAncestryFamily
 * @property Family $idDescendantFamily
 */
class Human extends \yii\db\ActiveRecord
{
    public $generation;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'human';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ancestry_family', 'id_descendant_family'], 'integer'],
            [['name', 'surname'], 'required'],
            [['ancestry'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['surname'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_ancestry_family' => 'Семья родителей',
            'id_descendant_family' => 'Собственная семья',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'ancestry' => 'Ancestry',
        ];
    }

    public function beforeSave($insert)
    {
        if ( !parent::beforeSave($insert) ) { return false; }
        if ( empty($this->id_ancestry_family) ) {
            $this->id_ancestry_family = null;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ( $insert ) {//save genealogy
            $family = $this->getAncestryFamily()->with('spouses')->one();
            $ancestry = '';
            if ( $family ) {
                foreach( $family->spouses as $p ) {
                    if ( !empty($ancestry) ) { $ancestry .= '.'; }
                    $ancestry .= $p->ancestry;
                }
            }
            $this->ancestry = ($ancestry ? $ancestry .'.' : ''). $this->id;
            $this->update(true, ['ancestry']);
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAncestryFamily()
    {
        return $this->hasOne(Family::className(), ['id' => 'id_ancestry_family']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescendantFamily()
    {
        return $this->hasOne(Family::className(), ['id' => 'id_descendant_family']);
    }

    /**
     * Поиск всех предков человека, реализован немного криво
     * с помощью ltree
     * @return \app\models\Human[]
     */
    public function getGenealogy()
    {
        $nestedQuery = static::find()->select('ancestry as anc')
            ->where(['id' => $this->id])->createCommand()->sql;
        return static::find()->select('*, nlevel(ancestry) AS generation')
            ->from(static::tableName() .', ('. $nestedQuery .') AS man')
            ->where('(id::text||\'.*\')::lquery ~ man.anc')
            ->orWhere('(\'*.\'||id||\'.*\')::lquery ~ man.anc')
            ->andWhere(['!=', 'id', $this->id])->orderBy([
                'generation' => SORT_ASC,
                'id_descendant_family' => SORT_ASC
            ])->all();
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->surname .' '. $this->name;
    }

    /**
     * @return array
     */
    public static function getUnmarriedDropDown()
    {
        $humans = static::find()->select(['name', 'surname', 'id'])
            ->where(['id_descendant_family' => null])
            ->orderBy(['surname' => SORT_ASC, 'name' => SORT_ASC])->all();
        $asArr = [];
        foreach( $humans as $h ) {
            $asArr[$h->id] = $h->toString();
        }

        return $asArr;
    }
}
