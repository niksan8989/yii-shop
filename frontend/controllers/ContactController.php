<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 25.09.2017
 * Time: 17:11
 */

namespace frontend\controllers;


use shop\forms\ContactForm;
use shop\services\contact\ContactService;
use Yii;
use yii\web\Controller;

class ContactController extends Controller
{
    private $contactService;

    public function __construct(
        $id,
        $module,
        ContactService $contactService,
        $config = [])
    {
        $this->contactService = $contactService;
        parent::__construct($id, $module, $config = []);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $form = new ContactForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->contactService->send($form);
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('index', [
                'model' => $form,
            ]);
        }
    }
}