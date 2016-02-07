<?php
namespace app\controllers;

use app\models\FamilyForm;
use app\models\FamilySearch;
use app\models\Family;
use Yii;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class FamiliesController
 * @package app\controllers
 */
class FamiliesController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FamilySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $familyForm = new FamilyForm();

        if ( $familyForm->load(Yii::$app->request->post()) ) {
            /** AJAX validation */
            if ( Yii::$app->request->isAjax ) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($familyForm);
            }

            if ( $familyForm->createFamily() ) {
                return $this->redirect(['families/view', 'id' => $familyForm->family->id]);
            }
        }

        return $this->render('create', [
            'model' => $familyForm
        ]);
    }

    /**
     * Finds the Family model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Family the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if ( ($model = Family::findOne($id)) !== null ) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}