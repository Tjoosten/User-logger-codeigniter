<?php defined('BASEPATH') OR exit('No Direct script access allowed');

/**
 * @package Logger
 * @author  Tim Joosten
 * @license MIT
 * @since   2015
 */
Class logger
{
    private $ci;

    /**
     * Class constructor.
     */
    function __construct()
    {
        parent::__construct();
        $this->ci =& get_instance();
        $this->ci->load->config('logger_config', TRUE);
    }

    /**
     * @param $user
     * @param $message
     * @return bool
     */
    function file_user_log($user, $message)
    {
        $data = strtotime(date($this->ci->config->item('date_format')));
        $file_path = './application/logs/log-' . $data . '.php';
        $log_message = '[' . date($this->ci->config->item('time_format')) . ']: ' . $user . ' --> ' . $message . "\n";

        if (!file_exists($file_path)) {
            $log_message = "<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>\n\n" . $log_message;
        }

        // Open the log file
        $log_file = fopen($file_path, "a");
        chmod($file_path, $this->ci->config->item('chmod'));

        // Write to the file.
        if (fwrite($log_file, $log_message)) {
            fclose($log_file);
            return TRUE;
        }

        return FALSE;
    }

    /**
     * @param $user
     * @param $message
     */
    function db_user_log($user, $message)
    {

    }

}
