<?php

namespace NewProject\Database\Migrations;

class TransactionMigrator
{
  static $tableName = 'fms_transactions';

  public static function migrate()
  {
    global $wpdb;

    $charsetCollate = $wpdb->get_charset_collate();

    $table = $wpdb->prefix . static::$tableName;

    if ($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table) {
      $sql = "CREATE TABLE $table (
                `transaction_id` BIGINT(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `rental_id` BIGINT(20) UNSIGNED NOT NULL,
                `user_id` BIGINT(20) UNSIGNED NOT NULL,
                `transaction_date` DATE NOT NULL,
                `transaction_amount` BIGINT(20) UNSIGNED NOT NULL,
                `created_at` TIMESTAMP NULL,
                `updated_at` TIMESTAMP NULL
            ) $charsetCollate;";
      dbDelta($sql);
    }
  }
}
