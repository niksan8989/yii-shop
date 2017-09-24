<?php
namespace common\bootstrap;

use frontend\services\auth\PasswordResetService;
use frontend\services\contact\ContactService;
use Yii;
use yii\di\Instance;
use yii\mail\MailerInterface;

class setUp implements \yii\base\BootstrapInterface {
    public function bootstrap($app)
    {
        $container = Yii::$container;

        /* Определяем зависимости через анонимую функцию. Используем для более сложной логики
         * $container->setSingleton(PasswordResetService::class, function() use ($app){
            return new PasswordResetService([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot']);
        });*/

        $container->setSingleton(MailerInterface::class, function () use ($app) {
            return $app->mailer;
        });

        $container->setSingleton(PasswordResetService::class, [Instance::of(MailerInterface::class)]);

        $container->setSingleton(ContactService::class, [], [
            Yii::$app->params['adminEmail'],
            Instance::of(MailerInterface::class)
        ]);
    }
}