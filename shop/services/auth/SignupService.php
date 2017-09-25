<?php

namespace shop\services\auth;

use shop\forms\auth\SignupForm;
use shop\entities\User;
use Yii;
use yii\mail\MailerInterface;
use shop\repositories\UserRepository;

class SignupService
{
    private $mailer;
    private $users;

    public function __construct(
        MailerInterface $mailer,
        UserRepository $users
    )
    {
        $this->mailer = $mailer;
        $this->users = $users;
    }

    public function signup(SignupForm $form): User
    {
        $user = User::requestSignup(
            $form->username,
            $form->email,
            $form->password
        );

        $this->save($user);

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

        $user = $this->users->getByEmailConfirmToken($token);

        $user->confirmSignup();

        $this->save($user);
    }

    /**
     * @param $user
     */
    public function save(User $user): void
    {
        if (!$user->save()) {
            throw new \RuntimeException('Saving error');
        }
    }
}