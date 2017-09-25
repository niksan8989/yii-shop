<?php
namespace frontend\tests\unit\forms;

use shop\entities\User\User;


class ConfirmSignupTest extends \Codeception\Test\Unit
{
    public function testSuccess()
    {
        $user = new User();
        $user->status = User::STATUS_WAIT;
        $user->email_confirm_token = 'token';

        $user->confirmSignup();

        $this->assertEmpty($user->email_confirm_token);
        $this->assertFalse($user->isWait());
        $this->assertTrue($user->isActive());
    }

    public function testAlreadyActive(){
        $user = new User();
        $user->status = User::STATUS_ACTIVE;
        $user->email_confirm_token = null;

        $this->expectExceptionMessage('User is already active');
    }

}