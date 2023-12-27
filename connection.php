<?php

class Connection {

    private $databaseFile;
    private $connection;

    public function __construct()
    {
        $this->databaseFile = realpath(__DIR__ . "/database/db.sqlite");
        $this->connect();
    }

    private function connect()
    {
        $this->connection = new PDO("sqlite:{$this->databaseFile}");
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $this->connection;
    }

    public function getConnection()
    {
        return $this->connection ?: $this->connection = $this->connect();
    }

    public function query($query)
    {
        $result = $this->getConnection()->query($query);

        $result->setFetchMode(PDO::FETCH_INTO, new stdClass);

        return $result;
    }

    public function exec($query)
    {
        return $this->getConnection()->exec($query);
    }
}