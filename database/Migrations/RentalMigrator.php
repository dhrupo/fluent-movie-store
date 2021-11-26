<?php

namespace NewProject\Database\Migrations;

class RentalMigrator
{
  static $tableName = 'fms_rentals';

  public static function migrate()
  {
    global $wpdb;

    $charsetCollate = $wpdb->get_charset_collate();

    $table = $wpdb->prefix . static::$tableName;

    if ($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table) {
      $sql = "CREATE TABLE $table (
                `rental_id` BIGINT(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `movie_id` BIGINT(20) UNSIGNED NOT NULL,
                `user_id` BIGINT(20) UNSIGNED NOT NULL,
                `rental_date_out` Date NOT NULL,
                `rental_date_return` Date NOT NULL,
                `created_at` TIMESTAMP NULL,
                `updated_at` TIMESTAMP NULL,
                UNIQUE KEY `rental_user_movie` (`user_id`,`movie_id`)
            ) $charsetCollate;";
      dbDelta($sql);
    }
  }
}
