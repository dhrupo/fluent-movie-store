<?php

namespace NewProject\Database\Migrations;

class GenreMigrator
{
  static $tableName = 'fms_genres';

  public static function migrate()
  {
    global $wpdb;

    $charsetCollate = $wpdb->get_charset_collate();

    $table = $wpdb->prefix . static::$tableName;

    if ($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table) {
      $sql = "CREATE TABLE $table (
                `genre_id` BIGINT(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `genre_name` VARCHAR(100) NOT NULL,
                `created_at` TIMESTAMP NULL,
                `updated_at` TIMESTAMP NULL
            ) $charsetCollate;";
      dbDelta($sql);
    }
  }
}
