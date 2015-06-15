<?php defined('BASEPATH') OR exit('No direct script access allowed');

  /**
   * @package Logger
   * @author Tim Joosten
   * @license MIT
   * @since 2015
   */

   /**
    * log_user
    *
    * Log the user handling to the file.
    *
    * @param $user,    string, the user doing the handle.
    * @param $message, string, the handling the user is doing.
    */
  if (! function_exists('user_log')) {
    function user_log($user, $message) {
      // Set instance and load config.
      $CI =& get_instance();
      $CI->load->config('logger_config', TRUE);

      $date = strtotime(date($CI->config->item('date_format')));

      $file_path =  './application/logs/log-'. $date .'.php';
     
      $log_message = '['. date($CI->config->item('time_format')). ']: '. $user .' --> '. $message ."\n";
      
      if(! file_exists($file_path)) {
        // File doesn't exists so we need to first write it.
        $log_message = "<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>\n\n".$log_message;
      }
      // Open the log file
      $log_file = fopen($file_path, "a");
      chmod($file_path, $CI->config->item('chmod'));
      // Write to the file.
      if(fwrite($log_file, $log_message))
      {
        fclose($log_file)
        return TRUE;
      }
      return FALSE;
    }
  }
