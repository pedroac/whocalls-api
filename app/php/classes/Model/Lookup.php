<?php

namespace pedroac\whocalls\Model;

/**
 * Undocumented class
 */
class Lookup
{
    /**
     * The phone number.
     *
     * @var PhoneNumber
     */
    private $phoneNumber;
    /**
     * The phone number owner name.
     *
     * @var string
     */
    private $ownerName;

    /**
     * Create a phone number lookup.
     *
     * @param PhoneNumber $phoneNumber The phone number.
     * @param string $ownerName The phone number owner name.
     */
    public function __construct(
        PhoneNumber $phoneNumber,
        string $ownerName
    ) {
        $this->phoneNumber = $phoneNumber;
        $this->ownerName = $ownerName;
    }

    /**
     * Return the phone number.
     *
     * @return PhoneNumber
     */
    public function getPhoneNumber(): PhoneNumber
    {
        return $this->phoneNumber;
    }

    /**
     * Return the phone number owner name.
     *
     * @return string
     */
    public function getOwnerName(): string
    {
        return $this->ownerName;
    }

    /**
     * Change the phone number owner name.
     *
     * @param string $ownerName The new owner name.
     * @return void
     */
    public function setOwnerName(string $ownerName)
    {
        $this->ownerName = $ownerName;
    }
}