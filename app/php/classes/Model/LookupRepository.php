<?php

namespace pedroac\whocalls\Model;
use \pedroac\whocalls\Model\PhoneNumber;
use \pedroac\whocalls\Model\Lookup;

/**
 * Phone numbers lookup repository.
 */
class LookupRepository
{
    /**
     * Database connection.
     *
     * @var \PDO
     */
    private $pdo;
    /**
     * Prepared statement to add entries.
     *
     * @var \PDOStatement
     */
    private $statementAdd;
    /**
     * Prepared statement to retrieve an entry.
     *
     * @var \PDOStatement
     */
    private $statementFindOne;

    /**
     * Create a repository.
     *
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Save a phone number lookup.
     *
     * @param Lookup $lookup
     * @return void
     */
    public function save(Lookup $lookup)
    {
        if (!$this->statementAdd) {
            $this->statementAdd = $this->pdo->prepare(
                'INSERT INTO `phone_number_lookup`(country_code, local_number, owner_name)'
                . ' VALUES(?, ?, ?, ?, ?)'
                . ' ON DUPLICATE KEY UPDATE owner_name = ?'
            );
        }
        $this->statementAdd->exec(
            [
                $lookup->getPhoneNumber()->getCountryCode(),
                $lookup->getPhoneNumber()->getLocalNumber(),
                $lookup->getOwnerName(),
                $lookup->getOwnerName(),
            ]
        );
    }

    /**
     * Find a lookup by a specified phone number.
     *
     * @param PhoneNumber $phoneNumber
     * @return Lookup|null
     */
    public function findByPhoneNumber(PhoneNumber $phoneNumber): ?Lookup
    {
        if (!$this->statementFindOne) {
            $this->statementFindOne = $this->pdo->prepare(
                'SELECT `country_code`, `local_number`, `owner_name`'
                . ' FROM `phone_number_lookup`'
                . ' WHERE `country_code` = :country_code AND `local_number` = :local_number'
                . ' LIMIT 1'
            );
        }
        $this->statementFindOne->execute(
            [
                'country_code' => $phoneNumber->getCountryCode(),
                'local_number' => $phoneNumber->getLocalNumber(),
            ]
        );
        $row = $this->statementFindOne->fetch(\PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return new Lookup(
            new PhoneNumber($row['country_code'], $row['local_number']),
            $row['owner_name']
        );
    }
}