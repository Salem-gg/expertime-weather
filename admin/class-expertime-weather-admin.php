<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/Salem-gg
 * @since      1.0.0
 *
 * @package    Expertime_Weather
 * @subpackage Expertime_Weather/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Expertime_Weather
 * @subpackage Expertime_Weather/admin
 * @author     Salem <jules.edelin@gmail.com>
 */
class Expertime_Weather_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        $valid_pages = ["weather"];

        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : null;

        if (in_array($page, $valid_pages)) {
            wp_enqueue_style("ew-bootstrap", EXPERTIME_WEATHER_URI . 'assets/css/bootstrap.min.css', array(), $this->version, 'all');
        }
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        $valid_pages = ["weather"];

        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : null;

        if (in_array($page, $valid_pages)) {
            wp_enqueue_script("jquery");
            wp_enqueue_script("ew-bootstrap-js", EXPERTIME_WEATHER_URI . 'assets/js/bootstrap.min.js', array( 'jquery' ), $this->version, false);
            wp_enqueue_script("ew-validate-js", EXPERTIME_WEATHER_URI . 'assets/js/jquery.validate.min.js', array( 'jquery' ), $this->version, false);
            wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/expertime-weather-admin.js', array( 'jquery' ), $this->version, false);
            wp_localize_script($this->plugin_name, "expertime_weather", [
                "ajaxurl" => admin_url("admin-ajax.php")
            ]);
        }
    }

    /**
     * Install back office menu section
     *
     * @since   1.0.0
     */
    public function menus_sections()
    {
        add_menu_page("Configuration", "Météo", "manage_options", "weather", [$this, "expertime_weather_settings"], "dashicons-star-filled", 80);
    }

    public function expertime_weather_settings()
    {
        global $wpdb;

        $endpoint = $wpdb->get_var("SELECT endpoint FROM " . $wpdb->prefix . EXPERTIME_WEATHER_TABLE_NAME . " WHERE id = (SELECT MAX(id) FROM " . $wpdb->prefix . EXPERTIME_WEATHER_TABLE_NAME . ")");

        ob_start();

        include_once(EXPERTIME_WEATHER_PATH . "admin/partials/expertime-weather-admin-display.php");

        $template = ob_get_contents();

        ob_end_clean();

        echo $template;
    }

    public function handle_ajax_requests_admin()
    {
        $param = isset($_REQUEST['param']) ? $_REQUEST['param'] : null;

        if ($param != null) {
            if ($param == "update_endpoint") {
                global $wpdb;
                $endpoint = isset($_REQUEST['endpoint-input']) ? $_REQUEST['endpoint-input'] : null;
                
                $wpdb->delete($wpdb->prefix . EXPERTIME_WEATHER_TABLE_NAME, ["id" => $wpdb->get_var("SELECT id FROM " . $wpdb->prefix . EXPERTIME_WEATHER_TABLE_NAME . " WHERE id = (SELECT MAX(id) FROM " . $wpdb->prefix . EXPERTIME_WEATHER_TABLE_NAME . ")")]);
                $wpdb->insert($wpdb->prefix . EXPERTIME_WEATHER_TABLE_NAME, ["endpoint" => $endpoint]);

                if ($wpdb->insert_id > 0) {
                    echo json_encode([
                        "status" => 1,
                        "message" => "endpoint sauvegardé avec succès"
                    ]);
                } else {
                    echo json_encode([
                        "status" => 0,
                        "message" => "echec de la sauvegarde"
                    ]);
                }
            }
        }
    }
}
