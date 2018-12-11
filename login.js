function loginValidate() {
    jQuery("#loginErrors").html("");
    if(!jQuery("#user").val()){
        jQuery("#loginErrors").append("<p>Please enter your Username</p>");
    }
    if(!jQuery("#pass").val()){
        jQuery("#loginErrors").append("<p>Please enter your Password</p>");
    }
    if(jQuery("#pass").val()&&jQuery("#user").val()){
        jQuery("#loginForm").submit();
    }
}
function loginErrors()  {
    jQuery("#loginErrors").html("");
    if(window.GETparams["loginErrors"]!= "" && window.GETparams["loginErrors"] != null){ 
        if(window.GETparams["loginErrors"]=="password"){
            jQuery("#loginErrors").append("<p>Invalid Password</p>");
            window.GETparams["loginErrors"] = window.GETparams["loginErrors"] - 2;
        }else if(window.GETparams["loginErrors"]=="username"){
            jQuery("#loginErrors").append("<p>Invalid Username</p>");
        }else if(window.GETparams["loginErrors"]=="loggedout"){
            jQuery("#loginErrors").append("<p>Logged out successfully</p>");
        }else{
            jQuery("#loginErrors").append("<p>"+decodeURI(window.GETparams["loginErrors"])+"</p>");
        }
    }
}