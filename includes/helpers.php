<?php

    /**
     * helpers.php
     * Helper functions.
     */

    require_once("config.php");

    /**
     * abbreviation function for htmlspecialchars
     */

    function h($string) {
      return htmlspecialchars($string);
    }



    /**
     * safe check to use every time php variables are sent via link (injection prevention)
     */
    function u($string="") {
      return urlencode($string);
    }

    /**
     * POST REQUEST FUNCTION
     */
    function is_post_request() {
      return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

  /**
     * GET REQUEST FUNCTION
     */
  function is_get_request() {
    return $_SERVER['REQUEST_METHOD'] == 'GET';
  }

    /**
     * REDIRECTING TO PAGE (NOTE EXIT IS IMPORTANT!)
     */
    function redirect_to($location) {
      header("Location: " . $location);
      exit;
    }


    /**
     * Facilitates debugging by dumping contents of argument(s)
     * to browser.
     */
    function dump()
    {
      $arguments = func_get_args();
      require(VIEWS_PATH . "dump.php");
      exit;
    }

    /**
     * Logs out current user, if any.  Based on Example #1 at
     * http://us.php.net/manual/en/function.session-destroy.php.
     */
    function logout()
    {
        // unset any session variables
      $_SESSION = [];

        // expire cookie
      if (!empty($_COOKIE[session_name()]))
      {
        setcookie(session_name(), "", time() - 42000);
      }

        // destroy session
      session_destroy();
    }

    /**
     * Redirects user to location, which can be a URL or
     * a relative path on the local host.
     *
     *
     * Because this function outputs an HTTP header, it
     * must be called before caller outputs any HTML.
     */
    function redirect($location)
    {
      if (headers_sent($file, $line))
      {
        trigger_error("HTTP headers already sent at {$file}:{$line}", E_USER_ERROR);
      }
      header("Location: {$location}");
      exit;
    }

    /**
     * Renders view, passing in values.
     */
    function render($view, $values = [])
    {
        // if view exists, render it
      if (file_exists(VIEWS_PATH . "/{$view}"))
      {
            // extract variables into local scope
        extract($values);

            // render view (between header and footer)

        if($view == "register_form.php" || $view == "login_form.php" || $view == "apology.php")
        {
          require(VIEWS_PATH . "/global_views/header.php");  
        } 
        else 
        {
          require(VIEWS_PATH . "/global_views/header_2.php");  

        }
        
        require(VIEWS_PATH . "/{$view}");


        if ($view == "register_form.php" || $view == "login_form.php" || $view == "apology.php")
        {
          require(VIEWS_PATH . "/global_views/footer.php");
        }
        else
        {
          require(VIEWS_PATH . "/global_views/footer_2.php");    
        }   
        exit;
      }

        // else err
      else
      {
        trigger_error("Invalid view: {$view}", E_USER_ERROR);
      }
    }

    function url_for($script_path) {
  // add the leading '/' if not present
      if($script_path[0] != '/') {
        $script_path = "/" . $script_path;
      }
      return WWW_ROOT . $script_path;
    }


// ***************** HELPERS FOR VALIDATION ********************

// is_blank('abcd')
  // * validate data presence
  // * uses trim() so empty spaces don't count
  // * uses === to avoid false positives
  // * better than empty() which considers "0" to be empty
    function is_blank($value) {
      return !isset($value) || trim($value) === '';
    }

  // has_presence('abcd')
  // * validate data presence
  // * reverse of is_blank()
  // * I prefer validation names with "has_"
    function has_presence($value) {
      return !is_blank($value);
    }

  // has_length_greater_than('abcd', 3)
  // * validate string length
  // * spaces count towards length
  // * use trim() if spaces should not count
    function has_length_greater_than($value, $min) {
      $length = strlen($value);
      return $length > $min;
    }

  // has_length_less_than('abcd', 5)
  // * validate string length
  // * spaces count towards length
  // * use trim() if spaces should not count
    function has_length_less_than($value, $max) {
      $length = strlen($value);
      return $length < $max;
    }

  // has_length_exactly('abcd', 4)
  // * validate string length
  // * spaces count towards length
  // * use trim() if spaces should not count
    function has_length_exactly($value, $exact) {
      $length = strlen($value);
      return $length == $exact;
    }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  // * validate string length
  // * combines functions_greater_than, _less_than, _exactly
  // * spaces count towards length
  // * use trim() if spaces should not count
    function has_length($value, $options) {
      if(isset($options['min']) && !has_length_greater_than($value, $options['min'] - 1)) {
        return false;
      } elseif(isset($options['max']) && !has_length_less_than($value, $options['max'] + 1)) {
        return false;
      } elseif(isset($options['exact']) && !has_length_exactly($value, $options['exact'])) {
        return false;
      } else {
        return true;
      }
    }

  // has_inclusion_of( 5, [1,3,5,7,9] )
  // * validate inclusion in a set
    function has_inclusion_of($value, $set) {
      return in_array($value, $set);
    }

  // has_exclusion_of( 5, [1,3,5,7,9] )
  // * validate exclusion from a set
    function has_exclusion_of($value, $set) {
      return !in_array($value, $set);
    }

  // has_string('nobody@nowhere.com', '.com')
  // * validate inclusion of character(s)
  // * strpos returns string start position or false
  // * uses !== to prevent position 0 from being considered false
  // * strpos is faster than preg_match()
    function has_string($value, $required_string) {
      return strpos($value, $required_string) !== false;
    }

 // * takes an array of errors and outputs a string list of errors
// * to be used in html directly -> echo display_errors($errors);
    function display_errors($errors=array()) {
      $output = '';
      if(!empty($errors)) {
        foreach($errors as $error) {
          $output .= h($error) . "<br>";
        }
      }
      return $output;
    }

    ?>
