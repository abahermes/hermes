$(document).ready(function(){
    $("#txtUsername").focus();
	$("#btnLogin").on("click", function(){
        var u = $("#txtUsername").val();
        var p = $("#txtPassword").val();

        if(u == ""){
            alert("Username is required! Please enter your username.");
            $("#txtUsername").focus();
            return false;
        }
        if(p == ""){
            alert("Password is required! Please enter your password.");
            $("#txtPassword").focus();
            return false;
        }

		$.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                // console.log('OK');
                // return false;
                logMeIn();
                // var url = getBaseURL();
                // window.location = url;
                // console.log(url);
            }
        });
	});

    $('#txtUsername,#txtPassword').keydown(function(event){ 
        var keyCode = (event.keyCode ? event.keyCode : event.which);   
        if (keyCode == 13) {
            if( $("#txtUsername").val() == ""){
                $("#txtUsername").focus();
                return false;
            }
            if( $("#txtPassword").val() == ""){
                $("#txtPassword").focus();
                return false;
            }
            $.blockUI({ 
                message: $('#preloader_image'), 
                fadeIn: 1000, 
                onBlock: function() {
                    // console.log('OK');
                    // return false;
                    logMeIn();
                    // var url = getBaseURL();
                    // window.location = url;
                    // console.log(url);
                }
            });
        }
    });

    $("#btnForgot").on("click", function(){
        var u = $("#txtUsername1").val();
        if(u == ""){
            alert("Username is required! Please enter your username.");
            $("#txtUsername1").focus();
            return false;
        }
        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                // console.log('OK');
                // return false;
                forgotPassword();
                // var url = getBaseURL();
                // window.location = url;
                // console.log(url);
            }
        });
    });
});

function logMeIn(){
    var url = getAPIURL() + 'abauser.php';
    var f = "logMeIn";
    var u = $("#txtUsername").val();
    var p = $("#txtPassword").val();

	var data = { "f":f, "u":u, "p":p };

    // console.log(data);
    // return false;

	$.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify({ "data":data }),
        dataType: 'json'
        ,success: function(data){
            // console.log(data);
            // return false;
            if(data['err'] == 0){
                var res = data['login']['rows'][0];
                // console.log(res);
                var eename = res['fname'] +' '+ res['lname']
                $("#abaini").val(res['abaini']);
                $("#abaemail").val(res['emailaddress']);
                $("#userid").val(res['userid']);
                $("#eename").val(eename);
                $("#eejobtitle").val(res['webhr_designation']);
                $("#ofc").val(res['webhr_station']);
                $("#pw").val(res['password']);
                // return false;
                $("#frmLogin").submit();
                // window.location = getBaseURL() + 'dashboardcdm.php';
                return false;
            }
            alert(data['errmsg']);
            // return false;
            // var url = getBaseURL();
            // console.log(url);
            // window.location = url;
            $.unblockUI();
        }
        ,error: function(request, status, err){

        }
    });
}

function forgotPassword(){
    var url = getAPIURL() + 'abauser.php';
    var f = "forgotPassword";
    var u = $("#txtUsername1").val();

    var data = { "f":f, "u":u };

    // console.log(data);
    // return false;

    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify({ "data":data }),
        dataType: 'json'
        ,success: function(data){
            console.log(data);
            return false;
            
            alert(data['errmsg']);
            gotoLogin();
            $.unblockUI();
        }
        ,error: function(request, status, err){

        }
    });
}

function gotoForgotPW(){
    $("#divLogin").hide();
    $("#divForgotPW").show();
    $("#txtUsername1").focus();
}

function gotoLogin(){
    $("#divLogin").show();
    $("#divForgotPW").hide();
    $("#txtUsername").focus();
}