<?php
/**
 * Base Model: every model gets a database connection to query against.
 */
abstract class Model
{
    protected mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }
}
