<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 23.09.2017
 * Time: 21:57
 */

namespace shop\services\contact;


use shop\forms\ContactForm;
use Yii;
use yii\mail\MailerInterface;

class ContactService
{
    private $adminEmail;
    private $mailer;

    public function __construct(
        $adminEmail,
        MailerInterface $mailer
    )
    {
       $this->adminEmail = $adminEmail;
       $this->mailer = $mailer;
    }
    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param \shop\forms\ContactForm $form
     * @return void
     */
    public function send(ContactForm $form): void
    {
        $sent = $this->mailer->compose()
            ->setTo($this->adminEmail)
            ->setFrom([$form->email => $form->name])
            ->setSubject($form->subject)
            ->setTextBody($form->body)
            ->send();

        if(!$sent) {
            throw new \RuntimeException("Sending error");
        }
    }
}