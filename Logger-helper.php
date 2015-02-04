<?php defined('BASEPATH') OR exit('No direct script access allowed');

  /**
   * @package Logger
   * @author Tim Joosten
   * @license Closed source license
   * @since 2015
   *
   * This Helper requires the Zip Encoding library.
   *
   * @todo Setting up system that creates a logged_in session for the server (cronjobs)
   * @todo Create function for the cronjob
   */
   function __construct() {
     parent::__construct();
   }

   /**
    * log_user
    *
    * @param $user,    string, the user ding the handle.
    * @param $message, string, the handling the user is doing.
    */
   if (! function_exists('user_log')) {
     function user_log($user, $message) {
       $Date = strtotime(date("Y/m/d"));

       $Filepath =  './application/logs/log-'. $Date .'.php';

       if(! file_exists($Filepath)) {
         // File doesn't exists so we need to first write it.
         $Fileheader = "<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>\n\n";
         $LogMessage = '['. date("h:i:sa"). ']: '. $user .' --> '. $message ."\n";

         // Open the log file
         $Logfile = fopen($Filepath, "a");

         // Write to the file.
         fwrite($Logfile, $Fileheader);
         fwrite($Logfile, $LogMessage);
         // Close file
         fclose($Logfile);

         // Database
         $CI =& get_instance();
         $CI->load->model('Model_logger', 'Database');
         $CI->load->model('Model_log_user', 'Database2');

         $CI->Database->Insert($Filepath);
         $CI->Database2->Insert($user, $message);

         return TRUE;
       } else {
         // The file exists sp we are write te log message only.
         $LogMessage = '['. date("h:i:sa"). ']: '. $user .' --> '. $message ."\n";

         // Open the log file
         $Logfile = fopen($Filepath, "a");

         // Write to the file.
         fwrite($Logfile, $LogMessage);
         // Close file
         fclose($Logfile);

         // Database
         $CI =& get_instance();
         $CI->load->model('Model_log_user', 'Database2');
         $CI->Database2->Insert($user, $message);
       }
    }
  }

  /**
   * Helper to get the logs for download
   */
  if(! function_exists('download_logs')) {
    function download_logs() {
      // Database
      $CI =& get_instance();

      // Library loading
      $CI->load->library(array('zip'));

      // Database
      $CI->load->model('Model_logger', 'Database');
      $Files = $CI->Database->Get();

      // Zip
      foreach($Files as $File) {
        $CI->zip->add_data($File->Log_file, file_get_contents($File->Log_file));
        unlink($File->Log_file);
      }

      $CI->zip->download('logs.zip');
    }
  }
