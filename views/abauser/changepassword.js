$(document).ready(function(){
	$("#btnChangePW").on("click", function(){
		var abaini = $("#abaini").val();
		var oldP = $("#txtOldPass").val();
		var newP = $("#txtNewPass").val();
		var conP = $("#txtConPass").val();

		if(oldP == ""){
			alert("Old/current password is required! Please enter your old password.");
			$("#txtOldPass").focus();
			return false;
		}
		if(newP == ""){
			alert("New password is required! Please enter your new password.");
			$("#txtOldPass").focus();
			return false;
		}
		if(newP != conP){
			alert("New and confirm password does not matched! Please enter correct new password.");
			$("#txtOldPass").focus();
			return false;
		}

		$.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                changePassword();
            }
        });
	});	
});

function changePassword(){
	var abaini = $("#abaini").val();
	var oldP = $("#txtOldPass").val();
	var newP = $("#txtNewPass").val();
	var conP = $("#txtConPass").val();
	var url = getAPIURL() + 'abauser.php';
  	var f = "changePassword";

  	var data = { "f":f, "abaini":abaini, "opw":oldP, "npw":newP, "cpw":conP };
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

	    	$.unblockUI();
	    	if(data['err'] > 0){
	    		alert(data['errmsg']);
	    		return false;
	    	}
	    	alert("Password successfully changed.");
	    	window.location="dashboardcdm.php";
	    }
	    ,error: function(request, status, err){

	    }
	  });
}