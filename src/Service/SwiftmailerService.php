<?php

namespace App\Service;


use Swift_Attachment;
use Swift_Message;

class SwiftmailerService
{
    protected $_swift_mailer;

    public function __construct(\Swift_Mailer $swift_mailer) {
        $this->_swift_mailer = $swift_mailer;
    }

    public function sendEmail($email,$filename) {
        $message = (new \Swift_Message('report'))
            ->setTo($email)
            ->setFrom('stest7434@gmail.com')
            ->setBody('report', 'text/html')
            ->attach(Swift_Attachment::fromPath($filename));
        $result = $this->_swift_mailer->send($message);
        return $result;
    }
}