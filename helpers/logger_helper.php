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

      $Date = strtotime(date($CI->config->item('date_format')));

      $Filepath =  './application/logs/log-'. $Date .'.php';
     
      $LogMessage = '['. date($CI->config->item('time_format')). ']: '. $user .' --> '. $message ."\n";
      
      if(! file_exists($Filepath)) {
        // File doesn't exists so we need to first write it.
        $LogMessage = "<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>\n\n".$LogMessage;
      }
      // Open the log file
      $Logfile = fopen($Filepath, "a");
      chmod($Filepath, $CI->config->item('chmod'));
      // Write to the file.
      if(fwrite($Logfile, $LogMessage))
      {
        fclose($Logfile)
        return TRUE;
      }
      return FALSE;
    }
  }
