<?php

namespace NewProject\Database\Migrations;

class MovieMigrator
{
  static $tableName = 'fms_movies';

  public static function migrate()
  {
    global $wpdb;

    $charsetCollate = $wpdb->get_charset_collate();

    $table = $wpdb->prefix . static::$tableName;

    if ($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table) {
      $sql = "CREATE TABLE $table (
                `movie_id` BIGINT(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `movie_name` VARCHAR(100) NOT NULL,
                `director` VARCHAR(100) NOT NULL,
                `in_stock` BIGINT(20) UNSIGNED NOT NULL,
                `rental_rate` BIGINT(20) UNSIGNED NOT NULL,
                `genre_id` BIGINT(20) UNSIGNED NOT NULL,
                `created_at` TIMESTAMP NULL,
                `updated_at` TIMESTAMP NULL
            ) $charsetCollate;";
      dbDelta($sql);
    }
  }
}
