<?php

namespace Models;

use PDO;

class Vote
{
    /**
     * @return array
     */
    public static function tally($pdo): array
    {
        $query = "SELECT cl.name, COUNT(v.coding_language_id) AS votes FROM coding_languages cl LEFT JOIN votes v ON cl.id = v.coding_language_id GROUP BY cl.id";
        $statement = $pdo->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }
}