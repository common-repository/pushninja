<div class="push-websites">
    <div class="d-flex">
        <div class="ninja_media">
            <img class="mr-3" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/pushninja_logo.png'; ?>" alt="Generic placeholder image">

        </div>

        <div class="push_ninja">
            <h2 class="push_ninja_child">PushNinja</h2>
            <p class="push_ninja_child2">Push Notification Software To Engage Your Visitors.</p>
        </div>
    </div>
    <div class="push-form-area">
        <p>Visit <a href="https://pushninja.com" target="_blank">PushNinja</a> to find more about PushNinja.</p>
        <p>Engage your wordpress customers by creating intuitive push notifications using visual designer, run drip campaigns, analyse user behaviour data through powerful automation.</p>
        <p></p><br>
        <?php
        $token_value = sanitize_text_field($_COOKIE["token"]);
        if(isset($token_value)){
            $token = $token_value;
            add_option('user_token', $token, null, 'no');
            $db_token = get_option('user_token');
            if ($token == $db_token) {
                //$token = $_COOKIE['token'];
            }
            else{
                update_option( 'user_token', $token );
            }
        }
        else {
            $token = get_option('user_token');
        }
        $token         = get_option('user_token');
        $tokenParts    = explode(".", $token);
        $tokenHeader   = base64_decode($tokenParts[0]);
        $tokenPayload  = base64_decode($tokenParts[1]);
        $jwtHeader     = json_decode($tokenHeader);
        $jwtPayload    = json_decode($tokenPayload);
        $user_id       = $jwtPayload->user_id;
        $region        = $jwtPayload->env;
        $tenant_id     = $jwtPayload->tenant_id;
        
        $url1="https://api.$region.500apps.com/v2/push/domain/websites";
        $request_url    = $url1;
        $token          = $token;
        $headers        = array(
            'Content-type'  => 'application/json',
            'Accept'        => 'text/plain',
            'authorization' => 'Bearer '.$token
        );
        $args_get = array(
            'timeout'     => 10,
            'redirection' => 15,
            'httpversion' => '1.0',        
            'sslverify'   => false,
            'blocking'    => true,
            'headers'     => $headers,
            'cookies'     => array(),
        );
        $request    = wp_remote_get($request_url,$args_get);                    
        $result     = wp_remote_retrieve_body( $request );
        $json_array = json_decode($result);
        ?>
        <p>Select website from below dropdown to install script</p>
        <div class="push-form">
            <div>
                <select id="pushninja_websites" name="pushninja_websites">
                    <?php
                    $results = json_decode(get_option('pushninja_website'), true);
                    $website_name = $results['website_name'];
                    foreach ($json_array as $html_res) {
                        if ($html_res->name == $website_name) {
                            $selected = 'selected';
                        } else {
                            $selected = '';
                        }
                        echo '<option value="'.$html_res->name.'/'.$html_res->api_key.'"'.$selected.'>'.$html_res->name.'</option>';

                    } ?>
                </select>
            </div>
        </div>
    </div>
</div>
<p class="submit"><input type="submit" name="install" onclick="pushninja_save_website()" id="submit" class="button button-primary" value="Install">
    <div id="success_message" class="success_message_push" name="success_message"></div>
</p>
<style>
    /** **/ 
    .push_ninja_child {
       margin-bottom: 5px;
       margin-top: 15px;
   }
   .push_ninja_child2 {
       margin-top: 10px;
   }
   .ninja_media{
    align-self: center;
    margin-right: 15px;
    width: 50px;
}
.ninja_media img{
    width: 50px;
}
.d-flex{
    display: flex;
}
/****/
.push-form-area {
    border: 1px solid #e4e0e0;
    padding: 20px;
    border-radius: 4px;
    background: white;
}
.push-form {
    display: flex;
    align-items: center;
    justify-content: flex-start;

}
.push-websites {
    width: 50%;
    margin-left: 30px;
    margin-top: 40px;    
}
.push-websites h2 {
    font-size: 25px;
}
.push-form h5 {
    font-size: 13px;
    margin-right: 19px;
}
p.submit {
    margin-left: 33px;
    margin-top: 11px;
}
.button-primary {
    padding: 5px 40px !important;
}
.success_message_push{
    padding: 5px 40px !important;
}
</style>
<div id="pushninjaModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="header-border-bottom">
            <span class="close">&times;</span>
            <p class="apps">Other Plugins In 500apps</p>
        </div>
        <div class="plugins">
            <div class="plugins-card">
                <div class="card lift">
                    <div class="card-body card-hover-animation">
                        <div class="mb-2 mx-auto">
                            <img src="<?php echo plugin_dir_url( __FILE__ ) . 'images/forms.svg'; ?>"/>
                        </div>
                        <div class="padding-left-right-15 d-flex-justify-content">
                           <h5 class="mt-3 font-weight-bold text-dark">Forms</h5>
                           <div class="btn-center"><a href="" class="btn-primary">Install</a></div>
                       </div>
                       <p class="mb-3 text-card-height multi-line-clamp-2 padding-left-right-15 padding-bottom-18 margin-0">
                        Build forms and manage responses like never before with a new-age form builder and response manager.
                    </p>

                </div>
            </div>
        </div>
        <div class="plugins-card">
            <div class="card lift">
                <div class="card-body card-hover-animation">
                    <div class="mb-2 mx-auto">
                        <img src="<?php echo plugin_dir_url( __FILE__ ) . 'images/ninjaseo.svg'; ?>"/>
                    </div>
                    <div class="padding-left-right-15 d-flex-justify-content">
                       <h5 class="mt-3 font-weight-bold text-dark">NinjaSEO</h5>
                       <div class="btn-center"><a href="" class="btn-primary">Install</a></div>
                   </div>
                   <p class="mb-3 text-card-height multi-line-clamp-2 padding-left-right-15 padding-bottom-18 margin-0">
                     NinjaSEO is an exclusive page grader, web crawler plugin with built in AI Linkbot and Position.
                 </p>

             </div>
         </div>
     </div>
 </div>
</div>
</div>
<style>
   #wpcontent {
    padding: 0px !important;
}
[id="toplevel_page_demo-classes-class.wpnf_admin"] .wp-first-item {
    display: none;
}
/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 99999;
    padding-top: 100px;
    left: 78px;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background: #0000002e;
}
/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #f1f1f1;
    width: 70%;
    border-radius: 8px;
}
/* The Close Button */
.header-border-bottom .close {
    color: #cbc8c8;
    float: right;
    font-size: 24px;
    position: relative;
    top: -5px;
}
.header-border-bottom .close:hover,
.header-border-bottom .close:focus {
    color: #cfcfcf;
    text-decoration: none;
    cursor: pointer;
}
.plugins {
    display: flex;
    flex-wrap: wrap;
    margin-right: -12px;
    margin-left: -12px;
    padding: 0px 10px;
}
.plugins-card {
    flex: 0 0 32%;
    max-width: 32%;
    padding-right: 5px;
    padding-left: 6px;
}

.header-border-bottom {
    border-bottom: 1px solid #f1f1f1;
    margin-bottom: 10px;
}
.header-border-bottom .apps {
    margin: 0px 0px 15px;
    font-size: 17px;
    font-weight: 500;

}
.plugins-card .card-body.card-hover-animation {
    padding: 0px;
}
.plugins-card .card {
    background-color: #ffffff;
    background-clip: border-box;
    border: 1px solid #edf2f9;
    border-radius: 0.5rem;
    border-color: #edf2f9;
    box-shadow: 0 0.75rem 1.5rem rgb(18 38 63 / 3%);
    padding: 0px;
}
.plugins-card .btn-center {
    text-align: center;
    padding-top: 16px;
}
.plugins-card .btn-center a {
    text-decoration: none;
    font-size: 14px;
}
.plugins-card .btn-center a:hover {
    color: #1b5df8;
    font-size: 14px;
}
.plugins-card .multi-line-clamp-2 {
    text-overflow: ellipsis !important;
    overflow: hidden !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 3 !important;
    -webkit-box-orient: vertical !important;
    color: #757677;
}
.plugins-card h5 {
    font-family: "Poppins", sans-serif;
    font-weight: 600 !important;
    font-size: 18px;
    line-height: 28px;
    margin-top: 8px;
    margin-bottom: 8px;
}
.plugins-card img {
 width: 100%;
 border-radius: 3px;
}
.lift {
    transition: box-shadow .25s ease, transform .25s ease;
}
.lift:hover, .lift:focus {
    box-shadow: 0 1rem 2.5rem rgba(18, 38, 63, 0.1), 0 0.5rem 1rem -0.75rem rgba(18, 38, 63, 0.1) !important;
    transform: translate3d(0, -3px, 0);
}
.padding-left-right-15{
    padding-left: 15px !important;
    padding-right: 15px !important;
}
.d-flex-justify-content{
    display: flex;
    justify-content: space-between;
}
.margin-0{
    margin: 0px !important;
}
.padding-bottom-18{
    padding-bottom: 18px !important;
}
</style>
