<?php
namespace frontend\services\auth;

use common\entities\User;
use frontend\forms\PasswordResetRequestForm;
use frontend\forms\ResetPasswordForm;
use Yii;
use yii\mail\MailerInterface;

class PasswordResetService {
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function request(PasswordResetRequestForm $form): void
    {
        /* @var $user \common\entities\User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $form->email,
        ]);

        if (!$user) {
            throw new \DomainException('User is not found');
        }

        $user->requestPasswordReset();

        if (!$user->save()) {
            throw new \RuntimeException('Saving error');
        }

        $sent = $this->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setTo($form->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();

        if(!$sent) {
            throw new \RuntimeException('Sending error');
        }
    }

    /**
     * @param $token
     * @throws \DomainException if token is empty or not valid
     */
    public function validateToken($token)
    {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Password reset token cannot be blank.');
        }

        if (!User::findByPasswordResetToken($token)) {
            throw new \DomainException('Wrong password reset token.');
        }
    }

    public function reset(string $token, ResetPasswordForm $form): void
    {
        $user = User::findByPasswordResetToken($token);

        if (!$user) {
            throw new \DomainException('User is not found.');
        }

        $user->resetPassword($form->password);

        if (!$user->save()) {
                throw new \RuntimeException('Saving error.');
        }
    }
}