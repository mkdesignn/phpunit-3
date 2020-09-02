<?php

namespace App\Models;

class User
{

    public function __construct(string $name, string $lastName, string $nationalId, string $birthDate, string $phoneNumber)
    {

        $this->name = $name;
        $this->lastName = $lastName;
        $this->nationalId = $nationalId;
        $this->birthDate = $birthDate;
        $this->phoneNumber = $phoneNumber;
    }

    public $name;
    public $lastName;
    public $nationalId;
    public $birthDate;
    public $phoneNumber;

}