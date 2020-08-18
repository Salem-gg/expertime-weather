<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/Salem-gg
 * @since      1.0.0
 *
 * @package    Expertime_Weather
 * @subpackage Expertime_Weather/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Expertime_Weather
 * @subpackage Expertime_Weather/includes
 * @author     Salem <jules.edelin@gmail.com>
 */
class Expertime_Weather_Deactivator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate()
    {
        global $wpdb;
                
        $table_name = $wpdb->prefix . "expertime_weather";

        $wpdb->query("Drop table IF EXISTS $table_name");
    }
}
