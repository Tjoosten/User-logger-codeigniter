<?php

  /**
   * The configuration file for the logger helper.
   *
   * @package Logge helper.
   * @copyright Tim Joosten
   * @since V1.0.0
   *
   * -----------------------------------------------------
   * EXPLANATION OF THE VARIABLES.
   * -----------------------------------------------------
   *
   * $config['chmod']       = The chmod rights.
   * $config['date_format'] = The date notification for the file name. (it will convert to timestamp).
   * $config['time_format'] = The time format for the time notifications in the file.
   *
   */

   $config['chmod']       = "777";

   $config['date_format'] = "Y/m/d";
   $config['time_format'] = "h:i:sa";
