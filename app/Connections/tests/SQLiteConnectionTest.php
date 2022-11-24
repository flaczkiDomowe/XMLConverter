<?php

namespace App\Connections\tests;



use App\Factories\ConnectionFactory;
use PHPUnit\Framework\TestCase;

class SQLiteConnectionTest extends TestCase
{

    public function testCreateTable()
    {
        $sqliteConn=ConnectionFactory::getSQLiteConnection();
        $sqliteConn->createTable('zuch',['kako','mako']);

        $rawConn=$sqliteConn->getConnection();
        $stmt = $rawConn->prepare("SELECT name FROM sqlite_master WHERE type='table' AND name='zuch';");
        $row=$stmt->fetch($rawConn::FETCH_ASSOC);
        var_dump($row);

    }
}
