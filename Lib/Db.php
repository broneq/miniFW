<?php

namespace MiniFw\Lib;


use SQLite3;
use SQLite3Result;

/**
 * Class Db
 * @package MiniFw\Lib
 */
class Db
{
    private $handle;

    /**
     * Db constructor.
     * @param string $location path to SQLLite database file
     */
    public function __construct(string $location)
    {
        $this->handle = new SQLite3($location);
    }

    /**
     * Perform SQLLite query statement
     * @param string $query
     * @param array $params
     * @return SQLite3Result
     */
    public function query(string $query, array $params = []): SQLite3Result
    {
        $statement = $this->handle->prepare($query);
        foreach ($params as $param => $value) {
            $statement->bindValue(':' . $param, $value);
        }
        return $statement->execute();
    }

    /**
     * Perform SQLLite query SELECT statement
     * @param string $query
     * @param array $params
     * @return array
     */
    public function getQuery(string $query, array $params = []): array
    {
        $results = $this->query($query, $params);
        $rows = [];
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }
}