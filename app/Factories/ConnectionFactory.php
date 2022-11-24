<?php

namespace App\Factories;

use App\Connections\FtpConnection;
use App\Connections\SQLiteConnection;

class ConnectionFactory
{
    public static function getFtpConnection(string $address,string $username, string $password){
        return new FtpConnection($address,$username,$password);
    }

    public static function getSQLiteConnection(){
        return new SQLiteConnection();
    }

}