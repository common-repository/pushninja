jQuery(document).ready(function ($) {
        var webistes_menu= 0;
    jQuery("#pushninja_data").attr("style", "display:block"); 
    var id1= 0;
    /** To close the other apps popup **/
    jQuery("a").each(function(idx) {
      if (jQuery(this).attr('href') == "admin.php?page=Other") {                    
        jQuery(this).addClass('show_popup_push');
        jQuery(this).attr("href", "#");
        jQuery(this).attr('id', 'show_popup_push');            
        id1++;
        }
    });
    var s_id= 0;
    jQuery("a").each(function(idx) {
      if (jQuery(this).attr('href') == "admin.php?page=PushNinja/classes/class.pushninjaplugin_pushninja.php") {
        if(s_id == 1){
            jQuery(this).css("display", "none");
                }
            s_id++;
        }
    }); 
    var modal = document.getElementById("pushninjaModal");
    var btn = document.getElementById("show_popup_push");
    var span = document.getElementsByClassName("close")[0];
    btn.onclick = function() {
      modal.style.display = "block";
  }
  span.onclick = function() {
      modal.style.display = "none";
  }
  window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
    }
}
});

/** To save website names to DB **/
function pushninja_save_website(api_key,region,install_script,verify) {
    postData = {
        website_apikey: api_key,
        website_region: region,
        website_installscript: install_script,
        website_verify: verify,
        action: 'pushninja_save_website'
    };
    jQuery.post(ajaxurl, postData, function (response) {
        setTimeout(function () {
            var response_data = jQuery.trim(response);
            if (response_data == 'updated0') {
                //console.log('updated');
            }
            else
            {
                //console.log('not updated');
            }
        }, 2000);
    });
    return false;
}