<?php

namespace App;

class Config
{
    const SQLITE_PATH=__DIR__.'\database\sqlite_database.db';
    const SQLITE_GUEST_USERNAME='username113'; //aren't used
    const SQLITE_GUEST_PASSWORD='113113'; //not used

    const TEST_API_ADDRESS='http://restapi.adequateshop.com/api/Traveler?page=1';
    const TEST_API_ITEM_NAME='Travelerinformation';
}