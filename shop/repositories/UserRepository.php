<?php
namespace shop\repositories;

use shop\entities\User;

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


    public function findByUsernameOrEmail($value)
    {
        return User::find()->andWhere(['or', ['username' => $value], ['email' => $value]])->one();
    }

    /**
     * @param array $condition
     * @return \shop\entities\User
     */
    private function getBy(array $condition): User
    {
        /** @var \shop\entities\User $user */
        if (!$user = User::find()->andWhere($condition)->limit(1)->one()) {
           throw new NotFoundException('User not found.');
        }
        return $user;
    }
}