<?php

namespace Core;

use PDO;

class Model
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
}