<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/Salem-gg
 * @since      1.0.0
 *
 * @package    Expertime_Weather
 * @subpackage Expertime_Weather/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Expertime_Weather
 * @subpackage Expertime_Weather/includes
 * @author     Salem <jules.edelin@gmail.com>
 */
class Expertime_Weather_Activator
{
    /**
       * Short Description. (use period)
       *
       * Long Description.
       *
       * @since    1.0.0
       */
    public static function activate()
    {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        
        global $wpdb;
        
        $table_name = $wpdb->prefix . "expertime_weather";
        $charset_collate = $wpdb->get_charset_collate();

        if ($wpdb->get_var("Show tables like $table_name") === null) {
            $sql = "CREATE TABLE $table_name (
                id INT NOT NULL AUTO_INCREMENT, 
                endpoint VARCHAR(255) NOT NULL,
                PRIMARY KEY  (id)
            ) ". $charset_collate .";";

            dbDelta($sql);
        }
    }
}
