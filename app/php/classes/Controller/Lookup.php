<?php

namespace pedroac\whocalls\Controller;
use \pedroac\whocalls\HttpException;
use \pedroac\whocalls\Model as Model;
use \pedroac\whocalls\View as View;

/**
 * Phone numbers lookup controller.
 */
class Lookup
{
    /**
     * Phone numbers lookup view.
     *
     * @var View\Lookup
     */
    private $view;
    /**
     * Phone numbers lookup repository.
     *
     * @var Model\LookupRepository
     */
    private $repository;

    public function __construct(View\Lookup $view)
    {
        $pdo = include(ROOT_DIR . '/database.php');
        $this->repository = new Model\LookupRepository($pdo);
        $this->view = $view;
    }

    /**
     * Apply the GET method.
     * Show a phone number lookup.
     *
     * @param string $phoneNumber A phone number.
     * @return void
     */
    public function get(string $phoneNumber)
    {
        $lookup = $this->repository->findByPhoneNumber(
            Model\PhoneNumber::fromString($phoneNumber)
        );
        if (!$lookup) {
            throw new HttpException(
                'The phone number was not found.',
                408
            );
        }
        $this->view->show($lookup);
    }

    /**
     * Apply the POST method.
     * Save a phone number lookup.
     *
     * @param string $phoneNumber A phone number.
     * @param array $params Available keys: "owner".
     * @return void
     */
    public function post(string $phoneNumber, array $params)
    {
        if (!isset($params['owner'])) {
            return;      
        }
        $lookup = $this->repository->save(
            new PhoneNumberLookup(
                PhoneNumber::fromString($phoneNumber),
                $params['owner']
            )
        );
        $this->view->show($lookup);
    }
}