<?php

namespace App\Factories;

use App\Connections\FtpConnection;

class ConnectionFactory
{
    public static function getFtpConnection(string $address,string $username, string $password){
        return new FtpConnection($address,$username,$password);
    }
}