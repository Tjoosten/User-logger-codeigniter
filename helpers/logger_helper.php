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

       if(! file_exists($Filepath)) {
         // File doesn't exists so we need to first write it.
         $Fileheader = "<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>\n\n";
         $LogMessage = '['. date($CI->config->item('time_format')). ']: '. $user .' --> '. $message ."\n";

         // Open the log file
         $Logfile = fopen($Filepath, "a");

         // Write to the file.
         fwrite($Logfile, $Fileheader);
         fwrite($Logfile, $LogMessage);
         // Close file
         fclose($Logfile);

         // Setting rights to the file
         chmod($Filepath, $CI->config->item('chmod'));

         return TRUE;
       } else {
         // The file exists sp we are write te log message only.
         $LogMessage = '['. date($CI->config->item('time_format')). ']: '. $user .' --> '. $message ."\n";

         // Open the log file
         $Logfile = fopen($Filepath, "a");

         // Write to the file.
         fwrite($Logfile, $LogMessage);
         // Close file
         fclose($Logfile);
       }
    }
  }
