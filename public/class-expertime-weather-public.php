<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/Salem-gg
 * @since      1.0.0
 *
 * @package    Expertime_Weather
 * @subpackage Expertime_Weather/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Expertime_Weather
 * @subpackage Expertime_Weather/public
 * @author     Salem <jules.edelin@gmail.com>
 */
class Expertime_Weather_Public
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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/expertime-weather-public.css', array(), $this->version, 'all');
        wp_enqueue_style("ew-bootstrap", EXPERTIME_WEATHER_URI . 'assets/css/bootstrap.min.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script("jquery");
        wp_enqueue_script("ew-bootstrap-js", EXPERTIME_WEATHER_URI . 'assets/js/bootstrap.min.js', array( 'jquery' ), $this->version, false);
        wp_enqueue_script("ew-validate-js", EXPERTIME_WEATHER_URI . 'assets/js/jquery.validate.min.js', array( 'jquery' ), $this->version, false);
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/expertime-weather-public.js', array( 'jquery' ), $this->version, false);
        wp_localize_script($this->plugin_name, "expertime_weather", [
            "ajaxurl" => admin_url("admin-ajax.php")
        ]);
    }
        
    public function expertime_weather_layout()
    {
        global $post;
                
        if ($post->post_name == "weather") {
            $page_template = EXPERTIME_WEATHER_PATH . "public/partials/expertime-weather-public-display.php";
        }

        return $page_template;
    }

    public function load_plugin()
    {
        ob_start();

        include_once(EXPERTIME_WEATHER_PATH . "public/partials/expertime-weather-public-display-tmpl.php");

        $template = ob_get_contents();

        ob_end_clean();

        echo $template;
    }

    public function handle_ajax_requests_public()
    {
        $param = isset($_REQUEST['param']) ? $_REQUEST['param'] : null;

        if ($param != null) {
            if ($param == "weather_country") {
                global $wpdb;
                $endpoint = $wpdb->get_var("SELECT endpoint FROM " . $wpdb->prefix . EXPERTIME_WEATHER_TABLE_NAME . " WHERE id = (SELECT MAX(id) FROM " . $wpdb->prefix . EXPERTIME_WEATHER_TABLE_NAME . ")");
                $response = wp_remote_get($endpoint . $_REQUEST['adress-input']);
                $data = json_decode($response['body']);

                if (empty($data->errors)) {
                    echo json_encode([
                        "status" => 1,
                        "message" => "weather fetched !",
                        "data" => $data
                    ]);
                } else {
                    echo json_encode([
                        "status" => 0,
                        "message" => "error fetching weather"
                    ]);
                }
            } elseif ($param == "weather_localization") {
                global $wpdb;
                $endpoint = $wpdb->get_var("SELECT endpoint FROM " . $wpdb->prefix . EXPERTIME_WEATHER_TABLE_NAME . " WHERE id = (SELECT MAX(id) FROM " . $wpdb->prefix . EXPERTIME_WEATHER_TABLE_NAME . ")");
                $response = wp_remote_get($endpoint . ($_REQUEST['lat'] . "/" . $_REQUEST['lng']));
                $data = json_decode($response['body']);

                // if (empty($data->errors)) {
                echo json_encode([
                        "status" => 1,
                        "message" => "weather fetched !",
                        "data" => $response
                    ]);
                // } else {
                //     echo json_encode([
                //         "status" => 0,
                //         "message" => "error fetching weather"
                //     ]);
                // }
            }
        }
        
        wp_die();
    }
}
