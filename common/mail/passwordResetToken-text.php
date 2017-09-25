<?php

/* @var $this yii\web\View */
/* @var $user \shop\entities\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/reset/reset', 'token' => $user->password_reset_token]);
?>
Hello <?= $user->username ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
