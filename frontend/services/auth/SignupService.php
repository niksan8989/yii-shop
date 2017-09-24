<?php

namespace frontend\services\auth;

use frontend\forms\SignupForm;
use common\entities\User;
use Yii;
use yii\mail\MailerInterface;

class SignupService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function signup(SignupForm $form): User
    {
        $user = User::requestSignup(
            $form->username,
            $form->email,
            $form->password
        );

        if(!$user->save()){
            throw new \RuntimeException('Saving error');
        }

        $sent = $this->mailer
            ->compose(
                ['html' => 'emailConfirmToken-html', 'text' => 'emailConfirmToken-text'],
                ['user' => $user]
            )
            ->setTo($form->email)
            ->setSubject('Signup confirm for ' . Yii::$app->name)
            ->send();

        if(!$sent) {
            throw new \RuntimeException('Sending error');
        }

        return $user;
    }

    public function confirm($token)
    {
        if (!$token){
            throw new \DomainException('Empty confirm token');
        }

        $user = User::findOne(['email_confirm_token' => $token]);

        if (!$user) {
            throw new \DomainException('User is not found');
        }

        $user->confirmSignup();

        if (!$user->save()) {
            throw new \RuntimeException('Saving error');
        }
    }
}