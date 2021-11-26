<?php

namespace NewProject\Database;

use NewProject\Database\Migrations\MovieMigrator;
use NewProject\Database\Migrations\GenreMigrator;
use NewProject\Database\Migrations\RentalMigrator;
use NewProject\Database\Migrations\TransactionMigrator;

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

class DBMigrator
{
    protected static $migrators = [
        MovieMigrator::class,
        GenreMigrator::class,
        TransactionMigrator::class,
        RentalMigrator::class,
    ];
    public static function run($network_wide = false)
    {
        self::migrate();
    }

    public static function migrate()
    {
        foreach (static::$migrators as $class) {
            $class::migrate();
        }
    }
}
