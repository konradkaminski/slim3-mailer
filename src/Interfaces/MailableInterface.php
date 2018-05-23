<?php

namespace Anddye\Interfaces;

use App\Mail\Mailer\Mailer;

/**
 * Interface MailableInterface
 * 
 * @author Andrew Dyer <andrewdyer@outlook.com>
 * @category Interfaces
 * @see https://github.com/andrewdyer/slim3-restful-api-web-seed
 */
interface MailableInterface
{

    /**
     * 
     */
    public function build();

    /**
     * 
     * @param Mailer $mailer
     */
    public function sendMessage(Mailer $mailer);
}