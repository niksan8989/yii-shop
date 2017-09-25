<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 25.09.2017
 * Time: 17:24
 */

namespace frontend\controllers\auth;


use shop\forms\auth\SignupForm;
use shop\services\auth\SignupService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class SignupController extends Controller
{
    private $signupService;

    public function __construct(
        $id,
        $module,
        SignupService $signupService,
        $config = [])
    {
        $this->signupService = $signupService;
        parent::__construct($id, $module, $config = []);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['request'],
                'rules' => [
                    [
                        'actions' => ['request'],
                        'allow' => true,
                        'roles' => ['?'],
                    ]
                ],
            ],
        ];
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionRequest()
    {
        $form = new SignupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->signupService->signup($form);
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('request', [
            'model' => $form,
        ]);
    }

    public function actionConfirm($token)
    {
        try {
            $this->signupService->confirm($token);
            Yii::$app->session->setFlash('success', 'Your email is confirmed');
            $this->redirect('login');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->goHome();
        }
    }
}