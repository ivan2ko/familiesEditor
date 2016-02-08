<?php

namespace app\controllers;

use app\models\Family;
use Yii;
use app\models\Human;
use app\models\HumanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class HumansController
 * @package app\controllers
 */
class HumansController extends Controller
{
    /**
     * Lists all Human models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HumanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Human model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, ['ancestryFamily', 'descendantFamily']),
        ]);
    }

    /**
     * Creates a new Human model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $idFamily integer|null - ancestry family id
     * @return mixed
     */
    public function actionCreate($idFamily = null)
    {
        $model = new Human();
        $model->id_ancestry_family = $idFamily;

        if ( $model->load(Yii::$app->request->post()) && $model->save() ) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Human model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ( $model->load(Yii::$app->request->post()) && $model->save() ) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Генеалогическое древо
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionGenealogy($id)
    {
        $model = $this->findModel($id);

        return $this->render('genealogy', [
            'model' => $model
        ]);
    }

    /**
     * Finds the Human model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param null|array $with
     * @return Human the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $with = null)
    {
        $query = Human::find()->where(['id' => $id]);
        if ( is_array($with) ) { $query->with($with); }

        if ( ($model = $query->one()) !== null ) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
