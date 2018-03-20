<?php

namespace pedroac\whocalls\Model;

/**
 * Countries codes repository.
 */
class CountryCodesRepository
{
    /**
     * Default instance.
     *
     * @var self
     */
    static private $defaultInstance;
    /**
     * Keys should be integers representing country calling codes.
     * Values should be two characters strings representing country abbreviations name
     * (eg: "us").
     *
     * @var string[]
     */
    private $codesCountriesMap;

    public function __construct(array $codesCountriesMap)
    {
        $this->codesCountriesMap = $codesCountriesMap;
    }

    /**
     * Return the default instation.
     *
     * @return self
     */
    static public function getDefault(): self
    {
        if (!static::$defaultInstance) {
            static::$defaultInstance = new static(
                include(ROOT_DIR . '/data/country_codes.php')
            );
        }
        return static::$defaultInstance;
    }

    /**
     * Check if a country calling code exists.
     *
     * @param integer $code Country calling code that should be checked.
     * @return boolean
     */
    public function hasCode(int $code): bool
    {
        return isset($this->codesCountriesMap[$code]);
    }

    /**
     * Fetch the country abbreviation name from the country calling number.
     *
     * @param integer $code Country calling code.
     * @return string A two character string country abbreviation name.
     */
    public function getCountry(int $code): string
    {
        return $this->codesCountriesMap[$code];
    }
}