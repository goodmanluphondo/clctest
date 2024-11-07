<?php

namespace Models;

use PDO;

class CodingLanguage
{
    /**
     * @param $pdo
     * @return array
     */
    public static function getAll($pdo): array
    {
        $query = "SELECT id, name FROM coding_languages";
        $statement = $pdo->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}