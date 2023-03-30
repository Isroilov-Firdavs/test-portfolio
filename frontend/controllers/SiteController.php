<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm; 
use frontend\models\Posters;
use frontend\models\User;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['form'],
                'rules' => [
                    [
                        'actions' => ['form'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = Posters::find()->orderBy(['id'=> SORT_DESC])->limit(8)->all();
        $model_posters = Posters::find()->count();
        // Category count
        $count_real_estate = Posters::find()->where(['category' => 1])->count();
        $transport = Posters::find()->where(['category' => 2])->count();
        $electronics = Posters::find()->where(['category' => 3])->count();
        $jobs = Posters::find()->where(['category' => 4])->count();

        return $this->render('index', [ 
            'posters' => $model,
            'count' => $model_posters,
            'count_real_estate' => $count_real_estate,
            'transport' => $transport,
            'electronics' => $electronics,
            'jobs' => $jobs
        ]);
    }

    public function actionHome()
    {
        $model_posters = Posters::find()->count();
        $model_users = User::find()->count();
        return $this->render('home', [
            'model_posters' => $model_posters,
            'model_users' => $model_users
        ]);
    }


    public function actionForm()
    {
        $model = new Posters();
        $time = time();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->user_id = Yii::$app->user->id;
                $model->date = date("Y-m-d");
                $model->poster_id = $time; 


                $model->image = UploadedFile::getInstance($model, 'image');
                $model->image->saveAs(
                    Url::to('@frontend/web/images/').$time.".".$model->image->extension
                );
                $model->image = $time.".".$model->image->extension;
                $model->save();


                return $this->redirect(['/site/posters']);
            }
        }
 
        return $this->render('form', [
            'model' => $model,
        ]);
    }

    public function actionProfile($id)
    {
        $db = User::find()->where(['id' => $id])->all();
        $model = Posters::find()->where(['user_id'=> $id])->orderBy(['id'=> SORT_DESC])->all();
        $model_count = Posters::find()->where(['user_id' => $id])->count();
        // 
        return $this->render('profile', [
            'user'=> $db,
            'posters'=>$model,
            'count' => $model_count,
        ]);

    }
    public function actionPosters()
    {
        $db = Posters::find()->orderBy(['id'=> SORT_DESC]);

        $count_real_estate = Posters::find()->where(['category' => 1])->count();
        $transport = Posters::find()->where(['category' => 2])->count();
        $electronics = Posters::find()->where(['category' => 3])->count();
        $jobs = Posters::find()->where(['category' => 4])->count();

        $sahifa = new Pagination(
            [
                'totalCount' => $db -> count(),
                'defaultPageSize' => 10,
                // 'pageParam' => 'sahifa',
        ]);


        $test = $db -> offset($sahifa -> offset) ->limit($sahifa -> limit) -> all();
        return $this->render('posters', [
            'posters'=> $test,
            'sahifa' => $sahifa,

            'count_real_estate' => $count_real_estate,
            'transport' => $transport,
            'electronics' => $electronics,
            'jobs' => $jobs
        ]);
    }


    public function actionFilter($id)
    {
        $model = Posters::find()->where(['category' => $id])->orderBy(['id'=> SORT_DESC])->all();

        $count_real_estate = Posters::find()->where(['category' => 1])->count();
        $transport = Posters::find()->where(['category' => 2])->count();
        $electronics = Posters::find()->where(['category' => 3])->count();
        $jobs = Posters::find()->where(['category' => 4])->count();


        return $this->render('filter', [
            'posters' => $model,

            'count_real_estate' => $count_real_estate,
            'transport' => $transport,
            'electronics' => $electronics,
            'jobs' => $jobs
            ]);
    }

    public function actionOne($id)
    {
        $user = User::find()->all();
        $model = Posters::find()->where(['id'=> $id])->all();
        return $this->render('one', [
            'model'=> $model,
            'user'=> $user
            ]);
    }




    public function actionSearch($ser)
    {
        $model = Posters::find()->orFilterWhere(['like', 'title',$ser])->orFilterWhere(['like', 'description',  $ser])->all();



        // Category count
        $count_real_estate = Posters::find()->where(['category' => 1])->count();
        $transport = Posters::find()->where(['category' => 2])->count();
        $electronics = Posters::find()->where(['category' => 3])->count();
        $jobs = Posters::find()->where(['category' => 4])->count();
        
        return $this->render('search', [
            "model" => $model,
            'count_real_estate' => $count_real_estate,
            'transport' => $transport,
            'electronics' => $electronics,
            'jobs' => $jobs
        ]);
        // return $ser;   
    }

    public function actionSearchFilter($category, $country, $amount_from, $amount_to)
    {
        $model = Posters::find()
        ->andWhere(['category' => $category])
        ->orWhere(['address' => $country])
        ->andWhere(['>', 'price', $amount_from])
        ->orWhere(['<=', 'price', $amount_to])
        ->orderBy(['id'=> SORT_DESC])
        ->all();

        $count_real_estate = Posters::find()->where(['category' => 1])->count();
        $transport = Posters::find()->where(['category' => 2])->count();
        $electronics = Posters::find()->where(['category' => 3])->count();
        $jobs = Posters::find()->where(['category' => 4])->count();

        return $this->render('searchfilter', [
            'model' => $model,
            'count_real_estate' => $count_real_estate,
            'transport' => $transport,
            'electronics' => $electronics,
            'jobs' => $jobs
        ]);

    }
    public function actionDelete($id)
    {
        $checkPosters = Posters::findOne($id);
            if ( !Yii::$app->user->isGuest )
            {
                if ( (Yii::$app->user->identity->username == $checkPosters->user->username) || (Yii::$app->user->can('admin')) )
                {
                        $model = Posters::findOne($id);
                        $model->delete();
                        return $this->redirect(['/site/posters']);
                }
                else
                {
                    return $this->redirect(['/']);
                }
            }
            else
            {
                return $this->redirect(['/']);
            }
    }
    public function actionEdit($id)
    {
        $checkPosters = Posters::findOne($id);
            if ( !Yii::$app->user->isGuest )
            {
                if ( (Yii::$app->user->identity->username == $checkPosters->user->username) || (Yii::$app->user->can('admin')) )
                {
                        $model = Posters::findOne($id);

                        if ($model -> load(Yii::$app->request->post()))
                            {
                                $model->save();
                                return $this->redirect(['/site/one', 'id'=>$id]);
                            }
                        return $this->render('edit', ['model'=>$model]);
                }
                else
                {
                    return $this->redirect(['/']);
                }
            }
            else
            {
                return $this->redirect(['/']);
            }
    }



    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->redirect(['site/login']);
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
