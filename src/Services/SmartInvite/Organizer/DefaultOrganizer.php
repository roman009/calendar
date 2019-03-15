<?php

namespace App\Services\SmartInvite\Organizer;

class DefaultOrganizer
{
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $mailboxUrl;
    /**
     * @var string
     */
    private $mailboxUsername;
    /**
     * @var string
     */
    private $mailboxPassword;

    public function __construct(string $email, string $mailboxUrl, string $mailboxUsername, string $mailboxPassword)
    {
        $this->email = $email;
        $this->mailboxUrl = $mailboxUrl;
        $this->mailboxUsername = $mailboxUsername;
        $this->mailboxPassword = $mailboxPassword;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getMailboxUrl(): string
    {
        return $this->mailboxUrl;
    }

    /**
     * @return string
     */
    public function getMailboxUsername(): string
    {
        return $this->mailboxUsername;
    }

    /**
     * @return string
     */
    public function getMailboxPassword(): string
    {
        return $this->mailboxPassword;
    }
}
