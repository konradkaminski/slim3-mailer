<?php

namespace Anddye\Mailer;

use Anddye\Interfaces\MailableInterface;
use Anddye\Interfaces\MessageBuilderInterface;
use DateTimeInterface;

/**
 * Class Mailable
 * 
 * @author Andrew Dyer <andrewdyer@outlook.com>
 * @category Mail
 * @see https://github.com/andrewdyer/slim3-restful-api-web-seed
 */
abstract class Mailable implements MailableInterface, MessageBuilderInterface
{

    /** @var array */
    protected $attachments = [];

    /** @var array */
    protected $bcc = [];

    /** @var array */
    protected $cc = [];

    /** @var DateTimeInterface */
    protected $dateTime;

    /** @var array */
    protected $from = [];

    /** @var integer */
    protected $priority;

    /** @var array */
    protected $to = [];

    /** @var string */
    protected $subject;

    /** @var string */
    protected $view;

    /** @var array */
    protected $viewData = [];

    /** @var array */

    /**
     * 
     * @param string $path
     * @return $this
     */
    public function attachFile(string $path)
    {
        $this->attachments[] = $path;

        return $this;
    }

    /**
     * 
     * @param string $path
     * @return $this
     */
    public function detachFile(string $path)
    {
        if (($key = array_search($path, $this->attachments)) !== false) {
            unset($this->attachments[$key]);
        }

        return $this;
    }

    /**
     * 
     * @param Mailer $mailer
     */
    public function sendMessage(Mailer $mailer)
    {
        $this->build();

        $mailer->sendMessage($this->view, $this->viewData, function ($message) {
            $message->setTo($this->to["address"], $this->to["name"]);
            $message->setSubject($this->subject);

            if ($this->from) {
                $message->setFrom($this->from['address'], $this->from['name']);
            }

            if ($this->bcc) {
                $message->setBcc($this->bcc['address'], $this->bcc['name']);
            }

            if ($this->cc) {
                $message->setBcc($this->cc['address'], $this->cc['name']);
            }

            if ($this->priority) {
                $message->setPriority($this->priority);
            }

            foreach ($this->attachments as $path) {
                $message->attachFile($path);
            }
        });
    }

    /**
     * 
     * @param string $address
     * @param string $name optional
     * @return $this
     */
    public function setBcc(string $address, string $name = "")
    {
        $this->bcc = compact('address', 'name');

        return $this;
    }

    /**
     * 
     * @param mixed $body
     * @return $this
     */
    public function setBody($body)
    {
        // TODO: Merge this and set view together
    }

    /**
     * 
     * @param string $address
     * @param string $name optional
     * @return $this
     */
    public function setCc(string $address, string $name = "")
    {
        $this->cc = compact('address', 'name');

        return $this;
    }

    /**
     * 
     * @param DateTimeInterface $dateTime
     * @return $this
     */
    public function setDate(DateTimeInterface $dateTime)
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    /**
     * 
     * @param string $address
     * @param string $name optional
     * @return $this
     */
    public function setFrom(string $address, string $name = "")
    {
        $this->from = compact('address', 'name');

        return $this;
    }

    /**
     * 
     * @param integer $priority
     * @return $this
     */
    public function setPriority(int $priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * 
     * @param type $address
     * @param type $name optional
     * @return $this
     */
    public function setTo(string $address, string $name = "")
    {
        $this->to = compact('address', 'name');

        return $this;
    }

    /**
     * 
     * @param string $subject
     * @return $this
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * 
     * @param string $view
     * @param array $viewData optional
     * @return $this
     */
    public function setView(string $view, array $viewData = [])
    {
        $this->view = $view;
        $this->viewData = $viewData;

        return $this;
    }

}