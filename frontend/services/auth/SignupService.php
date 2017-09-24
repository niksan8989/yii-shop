<?php

namespace frontend\services\auth;

use frontend\forms\SignupForm;
use common\entities\User;

class SignupService
{
    public function signup(SignupForm $form): User
    {
        $user = User::signup(
            $form->username,
            $form->email,
            $form->password
        );

        if(!$user->save()){
            throw new \RuntimeException('Saving error');
        }



        return $user;
    }
}