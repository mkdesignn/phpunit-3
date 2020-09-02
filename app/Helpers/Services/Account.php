<?php

namespace App\Helpers\Services;

use GuzzleHttp\Client;
use function PHPUnit\Framework\throwException;

class Account
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Account constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {

        $this->client = $client;
    }

    public function getInfo(int $requestId): string
    {

        try{
            return $this->client->get('https://ps.account.info/'.$requestId)->getBody()->getContents();
        } catch (\Throwable $exception)
        {
            new \Exception('There is a problem in connecting to account server');
        }

    }
}