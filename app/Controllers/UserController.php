<?php

namespace App\Controllers;

use App\Helpers\Services\Account;
use App\Models\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController
{
    /**
     * @var Account
     */
    private $account;


    /**
     * UserController constructor.
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function store(Request $request)
    {
        $userInfo = $this->account->getInfo($request->request->get('request_id'));

        $userInfo = json_decode($userInfo);

        $user = new User($request->get('name'), $request->get('lastName'),
            $userInfo->nationalId, $userInfo->birthDate, $request->get('phoneNumber'));

        return new JsonResponse($user);
    }

}