<?php
namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;

class FamilyForm extends Model
{
    public $firstSpouseId;
    public $secondSpouseId;
    public $family;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstSpouseId', 'secondSpouseId'], 'required'],
            [['firstSpouseId', 'secondSpouseId'], 'integer'],
            [['secondSpouseId'], 'validateSecondSpouse']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'firstSpouseId' => 'Человек 1',
            'secondSpouseId' => 'Человек 2'
        ];
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function createFamily()
    {
        if ( !$this->validate() ) { return false; }

        $spouses = Human::find()->where([
            'id' => [$this->firstSpouseId, $this->secondSpouseId],
            'id_descendant_family' => null
        ])->all();
        if ( !is_array($spouses) || count($spouses) !== 2 ) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $family = new Family();
            $family->setAttribute('name', $spouses[0]->surname .'-'. $spouses[1]->surname);
            if ( !$family->save() ) {
                throw new Exception('Family creation error');
            }
            foreach( $spouses as $human ) {
                $human->setAttribute('id_descendant_family', $family->id);
                if ( !$human->update(true, ['id_descendant_family']) ) {
                    throw new Exception('Spouses updating error');
                }
            }
        } catch( Exception $e ) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('danger', 'Произошла ошибка');
            return false;
        }

        $transaction->commit();
        $this->family = $family;

        return true;
    }

    public function validateSecondSpouse($attribute, $params)
    {
        if ( $this->$attribute === $this->firstSpouseId ) {
            $this->addError($attribute, 'Человека нельзя женить на самом себе');
        }
    }
}