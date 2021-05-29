<?php


namespace App\Message\Command;


class SignUpSms
{
    private string $phoneNumber;

    /**
     * SignUpSms constructor.
     */
    public function __construct( string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

}