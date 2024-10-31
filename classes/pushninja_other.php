<div id="pushninja_data" style="display: none;">
    <iframe onload="pushninja_form()" id="pushninja_view" name="pushninja_view" style="width:100%; height: 800px;" src="<?php echo $pushninja_url ?>"></iframe>
</div>
<script>
    /** To set the cookie **/
    function pushninja_setcookie(name, value, days) {
      var expires = "";
      if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}
/** To get the cookie **/
function pushninja_getcookie(name) {
  var cookie_name = name + "=";
  var cookies = document.cookie.split(';');
  for (var i = 0; i < cookies.length; i++) {
    var extracted_cookie = cookies[i];
    while (extracted_cookie.charAt(0) == ' ') extracted_cookie = extracted_cookie.substring(1, extracted_cookie.length);
    if (extracted_cookie.indexOf(cookie_name) == 0) return extracted_cookie.substring(cookie_name.length, extracted_cookie.length);
}
return null;
}
/** To get the token from infinity **/
function pushninja_form(){
    window.addEventListener('message',(event)=>{
        var script_values   = event.data;
        var api_key         = script_values['api_key'];
        var verify          = script_values['verify'];
        var region          = script_values['region'];
        if(api_key && !verify){
            console.log('here need to add script');
            var install_script  = 'true';
            var verify          = 'false';
            pushninja_save_website(api_key,region,install_script,verify);
            setTimeout(()=>{
                var z=document.getElementById('pushninja_view');
                z.contentWindow.postMessage({'pushninja_script':true},'*');
            },2000);
        }else if(verify){
            console.log('need to add verified value');
            var install_script = 'true';
            var verify = 'true';
            setTimeout(()=>{
                var z=document.getElementById('pushninja_view');
                pushninja_save_website(api_key,region,install_script,verify);
                z.contentWindow.postMessage({'pushninja_verify':true},'*');
            },2000);
        }
    })
}
</script>
<?php
include 'other_products.php';
?>