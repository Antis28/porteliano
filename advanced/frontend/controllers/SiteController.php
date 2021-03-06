<?php
namespace frontend\controllers;

use app\models\Section;
use frontend\models\QuestionForm;
use GuzzleHttp\Psr7\Request;
use Yii;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Product;
use common\models\User;


/*Для тестов*/
use app\models\EntryForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
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
        $session = Yii::$app->session;
        $session->open();

        $questionForm = new QuestionForm();
        $modelProduct = new Product();
        $request = Yii::$app->request;

        $products = $modelProduct->getProductsBySection($request->get('section'),'6' ); /// 6 картинки на страницу
        $novelty = $modelProduct->getProducts(null,'6' );
        $doorsIn = $modelProduct->getProducts('3','6' );
        $doorsOut = $modelProduct->getProducts('4','6' );
        $septum = $modelProduct->getProducts('2','6' );

        $fabrics = (new \app\models\Manufacturer())->getManufacturersByClasses();

//        $sectionNames = ArrayHelper::map(Section::findAll(['1','2']),'id','title_main');
//        $sectionNames['novelty'] = 'Новинки';

        $postParams = Yii::$app->request->post();
        if ($questionForm->load($postParams)) {

            try {
                Yii::$app->mailer->compose('email', ['postParams' => $postParams])
                    ->setFrom('porteliano@mail.ru')
                    ->setTo(User::findByUsername('admin')->email)
                    ->setSubject('Обратная связь ' . $questionForm->username)
                    ->send();
            }
            catch (Exception $e) {

            }

            return $this->refresh();
        }
        return $this->render('index',
            [
                'products' => $products,
                'questionForm' => $questionForm,
//                'sectionNames' => $sectionNames,
                'doorsIn' => $doorsIn,
                'doorsOut' => $doorsOut,
                'novelty' => $novelty,
                'septum' => $septum,
                'fabrics' => $fabrics,
                'wish' => (isset($session['wish'])) ? $session['wish'] : null
            ]);

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
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
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
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
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
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
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
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /*Тест начало*/
    public function actionSay($message = 'Привет')
    {

        return $this->renderAjax('say', ['message' => $message]);
        //return $this->render('say', ['message' => $message]);
    }

    public function actionEntry()
    {
        $model = new EntryForm();

        $postParams = Yii::$app->request->post();

        if ($model->load($postParams) && $model->validate()) {

            try {

                Yii::$app->mailer->compose('email', ['postParams' => $postParams, 'model' => $model])
                    ->setFrom('porteliano@mail.ru')
                    ->setTo(User::findByUsername('admin')->email)
                    ->setSubject('Вопрос ' . $model->name)
                    ->send();
            }
            catch (Exception $e){

            }

            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            // либо страница отображается первый раз, либо есть ошибка в данных
            return $this->renderAjax('entry', ['model' => $model]);
        }
    }
    /*Тест конец*/
}
