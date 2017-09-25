<?php
namespace common\repositories;

use common\entities\User;
use frontend\forms\PasswordResetRequestForm;

class UserRepository {
    /**
     * @param $user
     * @return void
     */
    public function save(User $user): void
    {
        if (!$user->save()) {
            throw new \RuntimeException('Saving error');
        }
    }

    public function getByPasswordResetToken(string $token)
    {
        return $this->getBy(['password_reset_token' => $token]);
    }

    public function getByEmail($email)
    {
        return $this->getBy(['email' => $email]);
    }

    /**
     * @param $token
     * @return User $user
     */
    public function getByEmailConfirmToken($token): User
    {
        return $this->getBy(['email_confirm_token' => $token]);
    }

    public function existsByPasswordResetToken(string $token): bool
    {
        return (bool) User::findByPasswordResetToken($token);
    }

    /**
     * @param array $condition
     * @return User
     */
    private function getBy(array $condition): User
    {
        /** @var \common\entities\User $user */
        if (!$user = User::find()->andWhere($condition)->limit(1)->one()) {
           throw new NotFoundException('User not found.');
        }
        return $user;
    }
}