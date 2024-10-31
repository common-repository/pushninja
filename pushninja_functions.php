<?php

/**
 * @param $class_name
 * To include the class Pushninja
 */
function pushninja_class_loader($class_name)
{
  $class_file = pushninja_DIR . 'classes/class.'
  . trim(strtolower(str_replace('\\', '_', $class_name)), '\\') . '.php';

  if (is_file($class_file)) {
    require_once $class_file;
  }
}

/**
 * To save the website name
 */
function pushninja_save_website() {
  $website_region = sanitize_text_field($_POST['website_region']);
  $pushninja_website_key = sanitize_text_field($_POST['website_apikey']);
  $pushninja_installscript = sanitize_text_field($_POST['website_installscript']);
  $pushninja_verify = sanitize_text_field($_POST['website_verify']);
  if($_POST && isset($pushninja_website_key)){
    $results = json_decode(get_option('pushninja_website'), true);
    if ( ! is_array($results)) {
      $results = array();
    }
    $results['website_region'] = $website_region;
    $results['website_apikey'] = $pushninja_website_key;
    $results['website_installscript'] = $pushninja_installscript;
    $results['website_verify'] = $pushninja_verify;
    update_option('pushninja_website', json_encode($results));
    echo "updated";
  }
  else {
    echo "not update";
  }
}

/**
 * To add the token to DB
 */
function pushninja_addtoken() {

  $token_value = $_POST['token_value'];
    if(get_option('user_token')){
      add_option('user_token', $token_value, null, 'no');
      echo "added";
    }
    else {
      update_option('user_token', $token_value);
      echo "updated";
    }
}

/**
 * To append the pushninja script to footer
 */
function pushninja_script() {
  $results = json_decode(get_option('pushninja_website'), true);
  $website_apiKey = $results['website_apikey'];
  $website_region = $results['website_region'];

    // end

  ?>
  <script type="text/javascript">
    ((p,u,s,h,l,y)=>{
     p._push={"apiKey": '<?php echo $website_apiKey ?>'};
     p._pushfcm = {
       apiKey: "",
       location:'<?php echo $website_region ?>',
       authDomain: "",
       databaseURL: "",
       projectId: "",
       storageBucket: "",
       messagingSenderId: "",
       appId: ""
     };
     l = u.getElementsByTagName('head')[0];
     y = u.createElement('script');
     y.async = 1;
     y.src = s+h;
     l.appendChild(y);})(window,document,'https://infinity-public-js.500apps.com/push/','push.min.js');
   </script>
   <?php
 }