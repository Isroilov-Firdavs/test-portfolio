<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Posters;
use frontend\models\PostersSerch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * PostersController implements the CRUD actions for Posters model.
 */
class PostersController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Posters models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PostersSerch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Posters model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Posters model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $time = time();
        if (Yii::$app->user->can('admin')) {
            $model = new Posters();

            if ($this->request->isPost) {
                if ($model->load($this->request->post())) {

                    $model->user_id = Yii::$app->user->id;
                    $model->date = date("Y-m-d");
                    $model->poster_id = $time; 


                    $model->image = UploadedFile::getInstance($model, 'image');
                    $model->image->saveAs(
                        Url::to('@frontend/web/images/').$time.".".$model->image->extension
                    );
                    // form inputs are valid, do something here
                    $model->image = $time.".".$model->image->extension;


                    $model->save();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $model->loadDefaultValues();
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
        else
        {
            throw new \yii\web\ForbiddenHttpException("Страница не найдена.");
        }
    }

    /**
     * Updates an existing Posters model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('admin')) {
            $model = $this->findModel($id);

            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
        else
        {
            throw new \yii\web\ForbiddenHttpException("Страница не найдена.");
        }
    }

    /**
     * Deletes an existing Posters model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('admin')) {
            // code...
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }
        else
        {
            throw new \yii\web\ForbiddenHttpException("Страница не найдена.");
        }
    }

    /**
     * Finds the Posters model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Posters the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Posters::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
