<?php

namespace Models;

use BaseModel;

class User
{
    public $id;

    public $first_name;

    public $last_name;

    public $username;

    public function __construct(
        int $id,
        string $first_name,
        string $last_name,
        string $username
    )
    {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->username = $username;
    }

    public function vote() {
        global $pdo;
        $query = "SELECT * FROM votes WHERE user_id = :user_id";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':user_id', $this->id);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }
}