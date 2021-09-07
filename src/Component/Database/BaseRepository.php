<?php

namespace App\Component\Database;

use App\Component\Core\DIContainer;
use PDO;

abstract class BaseRepository
{
    public static BaseRepository|null $instance = null;
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public static function build(): BaseRepository
    {
        if(static::$instance === null)
        {
            static::$instance = new static(DIContainer::getContainer()->get(PDO::class));
        }

        return static::$instance;
    }
}