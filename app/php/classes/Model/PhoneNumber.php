<?php

namespace pedroac\whocalls\Model;

/**
 * Phone number value object.
 */
class PhoneNumber
{
    /**
     * Country code.
     *
     * @var integer
     */
    private $countryCode;
    /**
     * Local number.
     *
     * @var integer
     */
    private $localNumber;
    /**
     * Cached string representation.
     *
     * @var string
     */
    private $stringCache = null;

    /**
     * Create a phone number value object.
     *
     * @param integer $countryCode Country code.
     * @param integer $localNumber Local number.
     */
    public function __construct(int $countryCode, int $localNumber)
    {
        $this->countryCode = $countryCode;
        $this->localNumber = $localNumber;
    }

    /**
     * Create a phone number value object from a string.
     *
     * @param string $phoneNumber The phone number as a string.
     * @param integer $defaultCountryCode The default country code.
     * @return self
     */
    static public function fromString(
        string $phoneNumber,
        int $defaultCountryCode = null
    ): self {
        // TODO: refactor
        $countryCode = $defaultCountryCode;
        $localNumber = null;
        $isGlobal = trim($phoneNumber)[0] == '+';
        $phoneNumber = str_replace(
            [' ', '-', '.', '(', ')', '+', '/', '\\'],
            '',
            $phoneNumber
        );
        if (!ctype_digit($phoneNumber)) {
            throw new InvalidPhoneNumberException(
                "Invalid phone number: $phoneNumber."
            );
        }
        if ($isGlobal) {
            $countriesCodes = CountryCodesRepository::getDefault();
            for ($codeLength = 3; $codeLength > 0; --$codeLength) {
                $code = (int)substr($phoneNumber, 0, $codeLength);
                if ($countriesCodes->hasCode($code)) {
                    $countryCode = $code;
                    break;
                }
            }
            $localNumber = (int)substr($phoneNumber, strlen($code));
        }
        if (!$countryCode || !$localNumber) {
            throw new InvalidPhoneNumberException(
                "Invalid phone number: $phoneNumber."
            );
        }
        return new static($countryCode, $localNumber);
    }

    /**
     * Return the international phone number representation.
     *
     * @return string
     */
    public function __toString()
    {
        if (!$this->stringCache) {
            $this->stringCache = 
                '+' 
                . $this->countryCode 
                . ' ' 
                . rtrim(chunk_split($this->localNumber, 3, ' '));
        }
        return $this->stringCache;
    }

    /**
     * Return the country code.
     *
     * @return integer
     */
    public function getCountryCode(): int
    {
        return $this->countryCode;
    }

    /**
     * Return the local number.
     *
     * @return integer
     */
    public function getLocalNumber(): int
    {
        return $this->localNumber;
    }
}