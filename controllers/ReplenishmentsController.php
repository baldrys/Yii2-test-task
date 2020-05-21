<?php

namespace app\controllers;

use Yii;
use app\models\Replenishment;
use app\models\ReplenishmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\Response;
use app\models\User;

/**
 * ReplenishmentsController implements the CRUD actions for Replenishment model.
 */
class ReplenishmentsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Replenishment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReplenishmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $totalAmount = $dataProvider->query->sum('amount');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalAmount' => $totalAmount ? $totalAmount : 0
        ]);
    }

    /**
     * Creates a new Replenishment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Replenishment();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        } elseif (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post();
            $id = $postData['Replenishment']['user_id'];
            $userById = User::find()->where(['id' => $id]);
            $userByphone = User::find()->where(['phone_number' => $id]);
            if (!$userById->exists() && $userByphone->exists()) {
                $postData['Replenishment']['user_id'] = $userByphone->one()->id;
            }
            $model->load($postData) && $model->save();
            return $this->redirect(['users/index']);
        }

        return $this->redirect(['users/index']);
    }


    /**
     * Deletes an existing Replenishment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Replenishment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Replenishment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Replenishment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
