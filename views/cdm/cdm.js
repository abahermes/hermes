$(function(){
    tinymce.init({
        selector:'#txtImpNotes',
        menubar: false,
        resize: false,
        statusbar: false,
        plugins : 'link lists',
        toolbar: 'styleselect | bold italic underline | alignleft alignright aligncenter alignjustify | numlist bullist outdent indent | link blockquote'
    });
    tinymce.init({
        selector:'#txtCompanyLink',
        menubar: false,
        resize: false,
        statusbar: false,
        plugins : 'link',
        toolbar: 'link'
    });

	$('#frmCtcDtls, #frmTask, #frmOpps, #frmCmts, #frmCltsProsts').draggable();
	
	$("#tabs").tabs();
    $("#txtBirthDate").datepicker({
        maxDate: -1,
        dateFormat: "D d M y",
        changeMonth: true,
        changeYear: true,
        yearRange: "1900:2020"
    });
    $("#txtTaskDate").datepicker({
        minDate: -6,
        dateFormat: "D d M y",
        changeMonth: true,
        changeYear: true
    });
    $("#txtStartRWTargetDt, #txtPolIssuedDate,#txtSignedDate,#txtLostDate").datepicker({
        dateFormat: "D d M y",
        changeMonth: true,
        changeYear: true
    });

    $("#btnCloseTask").on("click", function(){
        var id = $("#sesid").val();
        if( $("#refresh").val() > 0 ){
            window.location = "cdm.php?id="+id;
        }
    });
    
    $("#btnCloseOpps").on("click", function(){
        var id = $("#sesid").val();
        if( $("#refresh").val() > 0 ){
            window.location = "cdm.php?id="+id;
        }
    });

    $("#btnBSLType").on("click", function(){
        $("#lblBSLType").html("( corporate )");
        $("#btnBSLType").hide();
        $("#dataTask").hide();
        $("#dataTaskNone").show();
        $("#dataOpps").hide();
        $("#dataOppsNone").show();
    });

    $('#txtPremium').on('change', function() {
        var x = $('#txtPremium').val();
        $('#txtPremium').val(addCommas(x));
    });

    $("#btnClose").on("click", function(){
        sendEvent('#frmCtcDtls', 1);
    });

	$("#btnCancelTask").on("click", function(){
		clearTaskFields();
		$("#frmTask").dialog("close");
	});

	$("#btnCancelOpps").on("click", function(){
		clearOppsFields();
		$("#frmOpps").dialog("close");
	});

    $("#btnCancelCmts").on("click", function(){
        $("#txtCmts").val("");
        $("#frmCmts").dialog("close");
    });

    $("#btnUpdateCtcDtls2").on("click", function(){
        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 150, 
            onBlock: function() {
                updateCltProst();
            }	
        });
    });

    $("#btnUpdateCtcDtls").on("click", function(){
        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 150, 
            onBlock: function() {
                updateCltProst();
            }
        });
    });

    $("#txtSTime").on("change", function(){
        if( $("#txtETime").val() != "" && $("#txtSTime").val() != "" ){
            var stime = $("#txtSTime").val();
            var etime = $("#txtETime").val();
            var cstime = stime.replace(":","");
            var cetime = etime.replace(":","");

            if(cstime >= cetime){
                alert("Start time cannot be greater than or equal to end time.");
                $('#txtSTime option').prop('selected', function() { return this.defaultSelected; });
                return false;
            }
        }
    });

    $("#txtETime").on("change", function(){
        if( $("#txtSTime").val() != "" && $("#txtETime").val() != "" ){
            var stime = $("#txtSTime").val();
            var etime = $("#txtETime").val();
            var cstime = stime.replace(":","");
            var cetime = etime.replace(":","");

            if(cetime <= cstime){
                alert("End time cannot be less than or equal to start time.");
                $('#txtETime option').prop('selected', function() { return this.defaultSelected; });
                return false;
            }
        }
    });

    $("#btnSaveTask").on("click", function(){
        var tid = $("#tid").val();
        var taskType = $("#txtTaskType").val();
        var taskDate = $("#txtTaskDate").val();
        var otppl = $("#txtotPpl").val();
        var stime = $("#txtSTime").val();
        var etime = $("#txtETime").val();
        var noofmtg = $("#txtNoOfMtg").val();
        var re = $("#txtResultExpected").val();
        var sr = $("#txtSpecificResult").val();
        var rem = $("#txtTaskRemarks").val();

        if(taskType == ""){
            alert("Task type is required! Please select task type.");
            $("#txtTaskType").click();
            return false;
        }

        if(taskDate == ""){
            alert("Task date is required! Please enter task date.");
            $("#txtTaskDate").focus();
            return false;
        }

        if(taskType == "m" || taskType == "cm"){
            if(stime == ""){
                alert("Start time is required! Please select start time.");
                $("#txtSTime").focus();
                return false;
            }
            if(etime == ""){
                alert("End time is required! Please select end time.");
                $("#txtETime").focus();
                return false;
            }
        }

        if(stime != "" && etime == ""){
            alert("End time is required! Please select end time.");
            $("#txtETime").focus();
            return false;
        }else
        if(stime == "" && etime != ""){
            alert("Start time is required! Please select start time.");
            $("#txtSTime").focus();
            return false;
        }else{ }

        if(re == ""){
            alert("Result expected is required! Please select result expected.");
            $("#txtResultExpected").focus();
            return false;
        }
        
        $.blockUI({ 
          message: $('#preloader_image'), 
          fadeIn: 150, 
          onBlock: function() {
            if(tid != ""){
                updateTask();
            }else{
                saveTask();
            }
          }
        });
    });

    $("#btnDoneTask").on("click", function(){
        var tid = $("#tid").val();
        var taskType = $("#txtTaskType").val();
        var taskDate = $("#txtTaskDate").val();
        var otppl = $("#txtotPpl").val();
        var stime = $("#txtSTime").val();
        var etime = $("#txtETime").val();
        var noofmtg = $("#txtNoOfMtg").val();
        var re = $("#txtResultExpected").val();
        var sr = $("#txtSpecificResult").val();
        var rem = $("#txtTaskRemarks").val();

        if(taskType == ""){
            alert("Task type is required! Please select task type.");
            $("#txtTaskType").click();
            return false;
        }

        if(taskDate == ""){
            alert("Task date is required! Please enter task date.");
            $("#txtTaskDate").focus();
            return false;
        }

        if(taskType == "m" || taskType == "cm"){
            if(stime == ""){
                alert("Start time is required! Please select start time.");
                $("#txtSTime").focus();
                return false;
            }
            if(etime == ""){
                alert("End time is required! Please select end time.");
                $("#txtETime").focus();
                return false;
            }
        }

        if(re == ""){
            alert("Result expected is required! Please select result expected.");
            $("#txtResultExpected").focus();
            return false;
        }

        if( $("input[name='rResultAchieve']:checked").length == 0 ){
          alert("Result achieved (Y/N)! Please choose result achieved.");
          return false;
        }
        
        $.blockUI({ 
          message: $('#preloader_image'), 
          fadeIn: 150, 
          onBlock: function() {
            $("#txtTaskDone").val(1);
            updateTask();
          }
        });
    });

    // step 2 button clicked
    $("#btnStep2").on("click", function(){
        if( $("#txtFname").val() == "" ){
          alert("First name is required! Please enter prospect first name.");
          $("#txtFname").focus();
          return false;
        }
        if( $("#txtLname").val() == "" ){
          alert("Last name is required! Please enter prospect last name.");
          $("#txtLname").focus();
          return false;
        }
        if( $("input[name='rGender']:checked").length == 0 ){
          alert("Gender is required! Please select gender of the Client/Prospect.");
          return false;
        }
        sendEvent('#frmCtcDtls', 2);
       
    });
    // step 3 button clicked
    $("#btnStep3").on("click", function(){
        if( $("#txtEmailAddress").val() == "" && $("#txtHomPhoneNo").val() == "" && $("#txtMobPhoneNo").val() == "" ){
          alert("One(1) of three(3) fields is required! Please enter either email address, home phone no or mobile phone no of prospect info.");
          return false;
        }
        sendEvent('#frmCtcDtls', 3);
    });
    // step 4 button clicked
    $("#btnStep4").on("click", function(){
        if( $("input[name='rBusinessType']:checked").length == 0 ){
          alert("Business type is required! Please select business type.");
          return false;
        }
        if( $("#txtRecomBy ").val() == "" ){
          alert("Recommended by is required! Please select recommended by.");
          $("#txtRecomBy").focus();
          return false;
        }
        if( $("#txtRecomBy").val() == "" ){
          alert("Recommended by is required! Please select recommended by.");
          $("#txtRecomBy").focus();
          return false;
        }
        sendEvent('#frmCtcDtls', 4);
        $("#btnOthGalInfo").show();
    });

    $("#btnOthGalInfo").on("click", function(){
        sendEvent('#frmCtcDtls', 6);
    });

    $("#btnNewGalInfo").on("click", function(){
        sendEvent('#frmCtcDtls', 5);
        $("#btnOthGalInfo").hide();
    });

    $("#btnNewGalInfoItem").on("click", function(){
        var curCnt = $("#NewgalInfoItemsCnt").val();
        var html = "";
        var cnt = 1;
        var newCnt = 0;
        var quest = "";
        var ans = "";

        for(var i=0;i<curCnt;i++){
          quest = $("#txtGalInfoQuestion"+cnt).val();
          ans = $("#txtGalInfoAnswer"+cnt).val();
          html += '<div class="row"><label>Q#'+cnt+'</label><textarea class="form-control" rows="2" cols="" id="txtGalInfoQuestion'+cnt+'" name="txtGalInfoQuestion'+cnt+'" placeholder="Question here">'+ quest +'</textarea></div>';
          html += '<div class="row"><label>A#'+cnt+'</label><textarea class="form-control" rows="2" cols="" id="txtGalInfoAnswer'+cnt+'" name="txtGalInfoAnswer'+cnt+'" placeholder="Answer here">'+ ans +'</textarea></div>';
          cnt++;
        }

        curCnt++;
        newCnt = curCnt;
        html += '<div class="row"><label>Q#'+newCnt+'</label><textarea class="form-control" rows="2" cols="" id="txtGalInfoQuestion'+newCnt+'" name="txtGalInfoQuestion'+newCnt+'" placeholder="Question here"></textarea></div>';
        html += '<div class="row"><label>A#'+newCnt+'</label><textarea class="form-control" rows="2" cols="" id="txtGalInfoAnswer'+newCnt+'" name="txtGalInfoAnswer'+newCnt+'" placeholder="Answer here"></textarea></div>';
        
        $("#NewgalInfoItemsCnt").val(newCnt);
        $("#divGalInfoItems").html(html);
    });

    $("#btnSubmitCmts").on("click", function(){
        var cmts = $("#txtComments").val();

        if(cmts == ""){
            alert("Your comments is required! Please enter your comments to client / prospect.");
            $("#txtComments").focus();
            return false;
        }

        $.blockUI({ 
          message: $('#preloader_image'), 
          fadeIn: 150, 
          onBlock: function() {
            $("#txtTaskDone").val(1);
            saveComments();
          }
        });
    });

    $("#txtOppsStatus").change(function(){
        var oppsstatus = $("#txtOppsStatus").val();
        var lblStartDate = '<span id = "lblStartOrTargetDate">Start Date </span>';
        var lblTargetDate = '<span id = "lblStartOrTargetDate">Target Date </span>';
        switch(oppsstatus){
            case "s": case "l": case "x": case "sp": 
                // $("#divSuppliers,#divRemarks").show(); 
                if(oppsstatus == "s"){
                    $("#reqStartRWTargetDt,#reqPremAmnt,#reqabaRev,#divSigned,#reqOppsSup,#divSignedDate").show();
                    $("#reqOppsRemarks,#divPotential,#divLostDate").hide();
                    $("#lblStartOrTargetDate").html(lblTargetDate);
                }else if(oppsstatus == "sp"){
                    $("#reqStartRWTargetDt,#reqPremAmnt,#reqabaRev,#reqOppsSup,#divSigned,#divSignedDate").show();
                    $("#reqOppsRemarks,#divPotential,#divLostDate").hide();
                    $("#lblStartOrTargetDate").html(lblStartDate);
                }else if(oppsstatus == "l"){
                    $("#reqOppsRemarks,#divLostDate").show();
                    $("#reqStartRWTargetDt,#reqPremAmnt,#reqabaRev,#reqOppsSup,#divSigned,#divSignedDate,#divPotential").hide();
                    $("#lblStartOrTargetDate").html(lblTargetDate);
                }else if(oppsstatus == "x"){
                    $("#reqOppsSup,#divPotential,#reqOppsRemarks").show();
                    $("#reqStartRWTargetDt,#reqPremAmnt,#reqabaRev,#reqOppsRemarks,#divSigned,#divSignedDate,#divLostDate").hide();
                    $("#lblStartOrTargetDate").html(lblTargetDate);
                }else{
                    $("#reqOppsRemarks").hide();
                    $("#lblStartOrTargetDate").html(lblTargetDate);
                }
                break;
            default:   $("#lblStartOrTargetDate").html(lblTargetDate); $("#divPotential").show(); $("#reqOppsRemarks,#reqStartRWTargetDt,#reqPremAmnt,#reqabaRev,#reqOppsSup,#divSigned,#divSignedDate,#divLostDate").hide(); 
            break;
        }
    });
	
    $("#btnSaveOpps").on("click", function(){
        var accttypec = '';
        var accttypep = '';
        var accttype = '';
        if( $('#chkAccountTypec').prop('checked') ){
            accttypec = 'c';
        }
        if( $('#chkAccountTypep').prop('checked') ){
            accttypep = 'p';
        }
        accttype = accttypec + accttypep;
        if(accttype == ""){
            alert("Account type is required! Please select accounts type (client / prospect).");
            return false;
        }
        
        var prodtype = $("#txtProdType").val();
        var srwtargetdt = $("#txtStartRWTargetDt").val();
        var cur = $("#txtCCY").val();
        var prem = $("#txtPremium").val();
        var comrate = $("#txtComRate").val();
        var pot = $("#txtPotential").val();
        var stat = $("#txtOppsStatus").val();
        var sup = $("#txtSupplier").val();
        var rem = $("#txtOppsRemarks").val();
        var oppsid = $("#oppsid").val();
        // console.log(oppsid);
        if(srwtargetdt == ""){
            alert("Target date is required! Please enter target date.");
            $("#txtStartRWTargetDt").focus();
            return false;
        }
        switch( $("#txtOppsStatus").val() ){
            case "s":
                    if(cur == ""){
                        alert("Currency is required! Please select Currency type.");
                        $("#txtCCY").select();
                        return false;
                    }
                    if(prem == ""){
                        alert("Premium is required! Please enter premium amount.");
                        $("#txtPremium").focus();
                        return false;
                    }
                    if(comrate == ""){
                        alert("aba Revenue is required! Please enter aba revenue.");
                        $("#txtComRate").focus();
                        return false;
                    }
                    if(sup == ""){
                        alert("Supplier is required! Please select supplier.");
                        $("#txtSupplier").focus();
                        return false;
                    }
                break;
            case "l": 
                    if(rem == ""){
                        alert("Remarks is required! Please enter remarks.");
                        $("#txtOppsRemarks").focus();
                        return false;
                    }
                break;
            case "x":
                    if(sup == ""){
                        alert("Supplier is required! Please select supplier.");
                        $("#txtSupplier").select();
                        return false;
                    }
                    if(rem == ""){
                        alert("Remarks is required! Please enter remarks.");
                        $("#txtOppsRemarks").focus();
                        return false;
                    }
                break;
            default:
                break;
        }

        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 150, 
            onBlock: function() {
                if(oppsid == ""){
                    saveOpps();
                }else{
                    updateOpps();
                }
            }
        });
    });

    $("#txtTaskType").change(function(){
        $("#reqSTime,#reqETime").hide();
        if($("#txtTaskType").val() == "m" || $("#txtTaskType").val() == "cm"){
            $("#reqSTime,#reqETime").show();
        }
    });

    if($("#txtCtcId").val() == ""){
        newContactDetails();
    }

    $("#txtRecomBy").change(function(){
        var recomby = $("#txtRecomBy").val();
        switch(recomby){
          // abaini/ofc
          case '2':
              $("#divRecomName,#divIntroducer").hide();
              $("#divabainiofc").show();
            break;
          // association, facebook, friend, linkedin, personal contact, wechat, whaatsapp
          case '3': case '10': case '11': case '14': case '17': case '18': case '19':
              $("#divabainiofc,#divIntroducer").hide();
              $("#divRecomName").show();

            break;
          // introducer
          case '13':
              $("#divRecomName,#divabainiofc").hide();
              $("#divIntroducer").show();
            break;
          // default
          default:
              $("#divabainiofc,#divIntroducer,#divRecomName").hide();
            break;
        }
        $("#txtRecomName,#txtIntroducer").val("");
        // resetabainiofcList();
        $('#txtabainiofc option').prop('selected', function() { return this.defaultSelected; });
    });

    $("#txtPremium,#txtStartRWTargetDt,#txtComRate").on("blur", function(){
        computePremiumHKD();
    });

    $("#txtCCY").change(function(){
        computePremiumHKD();
    });

    $("#btnSubmitNotes").on("click", function(){
        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 150, 
            onBlock: function() {
                saveNotes();
            }
        });
    });

    $.blockUI({ 
        message: $('#preloader_image'), 
        fadeIn: 150, 
        onBlock: function() {
            cltProstInfoData();
        }
    });
});

function clearCtcDtlsFields(){
  $("#txtCname").val("");
  $("#txtFname").val("");
  $("#txtLname").val("");
  $("#txtMname").val("");
  $("#txtini").val("");
  $("#txtBirthDate").val("");
  $("input:radio[name=rGender]").attr("checked",false);
  $("#txtCompany").val("");
  $("#txtJobTitle").val("");
  $("#txtEmailAddress").val("");
  $("#txtHomPhoneNo").val("");
  $("#txtMobPhoneNo").val("");
  $("#txtAddress").val("");
  $("#txtRecomName").val("");
  $("input:radio[name=rBusinessType]").attr("checked",false);
  $("input:radio[name=rBusinessType]").attr("disabled",false);
  $("input:radio[name=rFumType]").attr("checked",false);
  $("#rFumTypen").attr("checked",true);
  $("#divabainiofc,#divIntroducer").hide();
  $("#divRecomName").show();
  $('#txtTitle option, #txtNationality option, #txtEthnicity option, #txtAffinityName option, #txtRecomBy option, #txtabainiofc option, #txtShared option').prop('selected', function() { return this.defaultSelected; });
}

function clearTaskFields(){
    $("#txtTaskDate").datepicker("setDate",1);
    $("#btnSaveTask").show();
    $("#btnDoneTask").hide();
    $("#txtotPpl").val("");
    $("#txtSpecificResult").val("");
    $("#txtTaskRemarks").val("");
    $('#txtTaskType option,#txtETime option,#txtSTime option,#txtResultExpected option').prop('selected', function() { return this.defaultSelected; });
    $("#txtNoOfMtg").val("");
    $("#su").val("");
    $("#tid").val("");
    $("#reqSTime,#reqETime,#divResutlAchieve").hide();
    $("#txtTaskDone").val(0);
    $("input:radio[name=rResultAchieve]").attr("checked",false);
    var id = $("#sesid").val();
    if( $("#refresh").val() > 0 ){
        window.location = "cdm.php?id="+id;
    }
}

function clearOppsFields(){
    $('#txtProdType option,#txtCCY option,#txtPotential option,#txtOppsStatus option,#txtSupplier option, #txtShared option').prop('selected', function() { return this.defaultSelected; });
    $("#txtStartRWTargetDt").val("");
    $("#txtPremium").val("");
    $("#txtComRate").val("");
    $("#txtOppsRemarks").val("");
    $("#txtPremiuminHKD").val("");
    $("#txtComRateinHKD").val("");
	$("#txtShared").val("");
	$("#txtAbaRevShare").val("");
    $("#txtSignedDate").val("");
    $("#txtLostDate").val("");
    $("#txtPolIssuedDate").val("");
    $("#txtPolicyNo").val("");
    $("#divSignedDate,#divLostDate,#divSigned").hide();
    $("#divPotential").show();
    var id = $("#sesid").val();
    if( $("#refresh").val() > 0 ){
        window.location = "cdm.php?id="+id;
    }
}

function newContactDetails(){
    $('html').css('overflow','hidden');
    $("#frmCtcDtls").css('zIndex',1040);
    $("#frmCtcDtls").dialog({
        autoOpen: true,
        draggable: false,
        width: 550,
        modal: true,
        title: "New Contact Details",
        close: function(){
            $('html').css('overflow','auto');
            $(this).dialog("close");
        }
    });
}

function editContactDetails(){

}

function newTask(){
    clearTaskFields();
    $("#su").val("s");
}

function editTask(taskid){
    $("#tid").val(taskid);
    
    $.blockUI({ 
        message: $('#preloader_image'), 
        fadeIn: 150, 
        onBlock: function() {
            getTask(taskid);
        }
    });
}

function newOpps(){
    $("#chkAccountTypep").prop("checked", true);
    $("#oppsid").val("");
    $("#divSigned").hide(); 
    $("#divOpps").show();   
}

function editOpps(oppsid){
    $("#oppsid").val(oppsid);
    $.blockUI({ 
        message: $('#preloader_image'), 
        fadeIn: 150, 
        onBlock: function() {
            getOpps(oppsid);
        }
    });
}

function newCmts(){
    $('html').css('overflow','hidden');
    $("#frmCmts").css('zIndex',1040);
    $("#frmCmts").dialog({
        autoOpen: true,
        draggable: false,
        width: 500,
        modal: true,
        title: "New Comment Details",
        close: function(){
            $('html').css('overflow','auto');
            $(this).dialog("close");
        }
    });
}

function cltProstInfoData(){
    var url = getAPIURL() + 'clientprospect.php';
    var f = "loadCltProstDataInfo";
    var id = $("#sesid").val();
    var abaini = $("#abaini").val();
    var salesofc = $("#salesofc").val();

    var data = { "f":f, "abaini":abaini, "id":id, "salesofc":salesofc };
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
            var today = data['dttoday'];
            $("#txtTaskDate").val(today);
            var val = [];
            var acct = data['acct'];
            if(acct['rows'].length == 0){
                alert("Invalid URL!");
                window.location = getBaseURL() + "dashboardcdm.php";
            }
            var act = data['act'];
            var ctc = data['ctc'];
            var task = data['task'];
            var opps = data['opps'];
            var signedopps = data['signedopps'];
            var ees = data['ees'];
            var sup = data['sup']['rows'];
            var nats = data['nats']['rows'];
            var eths = data['eths']['rows'];
            var galinfos = data['galinfos']['rows'];
            var titles = data['titles'];
            var tasktypes = data['cdmtasktypes'];
            var resultsexpected = data['cdmresultexpected'];
            var affinity =  data['cdmaffinity'];
            var salesofc = data['salesofc']['rows'];
            var notes = data['notes'];
            var titleshtml = "";
            var bsl =  data['cdmbsl'];
            val['acct'] = acct;
            val['ctc'] = ctc;
            $("#chkAccountTypec").prop("checked", false);

            if(acct['rows'][0]['status'] == 1){
                $("#chkAccountTypec").prop("checked", true);
            } 
            else {
                $("#chkAccountTypec").prop("checked", false);
            }

            nathtml = '<label>Nationality</label>';
            nathtml += '<select class="form-control" id="txtNationality" name="txtNationality">';
            nathtml += '<option value="" selected></option>';
              for(var i=0;i<nats.length;i++){
                nathtml += '<option value="'+ nats[i]['nationalityid'] +'">'+ nats[i]['description'] +'</option>';
              }
            nathtml += '</select>';
            $("#divNationality").html(nathtml);

            ethhtml = '<label>Ethnicity</label>';
            ethhtml += '<select class="form-control" id="txtEthnicity" name="txtEthnicity">';
              ethhtml += '<option value="" selected></option>';
              for(var i=0;i<eths.length;i++){
                ethhtml += '<option value="'+ eths[i]['ethnicityid'] +'">'+ eths[i]['description'] +'</option>';
              }
            ethhtml += '</select>';
            $("#divEthnicity").html(ethhtml);

            titleshtml = '<label>Title</label>';
            titleshtml += '<select class="form-control" id="txtTitle" name="txtTitle">';
              titleshtml += '<option value="" selected></option>';
              for(var i=0;i<titles.length;i++){
                titleshtml += '<option value="'+ titles[i]['ddid'] +'">'+ titles[i]['dddescription'] +'</option>';
              }
            titleshtml += '</select>';
            $("#divTitles").html(titleshtml);

            affhtml = '<label>Affinity Name</label>';
            affhtml += '<select class="form-control" id="txtAffinityName" name="txtAffinityName">';
              affhtml += '<option value="" selected></option>';
              for(var i=0;i<affinity.length;i++){
                affhtml += '<option value="'+ affinity[i]['ddid'] +'">'+ affinity[i]['dddescription'] +'</option>';
              }
            affhtml += '</select>';
            $("#divAff").html(affhtml);

            var tasktypehtml = "";
            tasktypehtml = '<select class="form-control" id="txtTaskType" name="txtTaskType">';
                tasktypehtml += '<option value="" selected></option>';
                for(var i=0;i<tasktypes.length;i++){
                    tasktypehtml += '<option value="'+ tasktypes[i]['ddid'] +'">'+ tasktypes[i]['dddescription'] +'</option>';
                }
            tasktypehtml += '</select>';
            $("#divTaskType").html(tasktypehtml);

            var resexpectedehtml = "";
            resexpectedehtml = '<select class="form-control" id="txtResultExpected" name="txtResultExpected">';
                resexpectedehtml += '<option value="" selected></option>';
                for(var i=0;i<resultsexpected.length;i++){
                    resexpectedehtml += '<option value="'+ resultsexpected[i]['ddid'] +'">'+ resultsexpected[i]['dddescription'] +'</option>';
                }
            resexpectedehtml += '</select>';
            $("#divResultExpected").html(resexpectedehtml);

            switch(acct['rows'][0]['recommendedby']){
                // abaini/ofc
                case '2':
                        $("#divRecomName,#divIntroducer").hide();
                        $("#divabainiofc").show();
                    break;
                // association, facebook, friend, linkedin, personal contact, wechat, whaatsapp
                case '3': case '10': case '11': case '14': case '17': case '18': case '19':
                        $("#divabainiofc,#divIntroducer").hide();
                        $("#divRecomName").show();
                    break;
                // introducer
                case '13':
                        $("#divRecomName,#divabainiofc").hide();
                        $("#divIntroducer").show();
                    break;
                // default
                default:
                        $("#divabainiofc,#divIntroducer,#divRecomName").hide();
                    break;
            }

            var abainiofchtml = "";
            abainiofchtml = '<label>abaini / ofc</label>';
            abainiofchtml += '<select class="form-control" id="txtabainiofc" name="txtabainiofc">';
              abainiofchtml += '<option value="" selected></option>';
              for(var i=0;i<ees.length;i++){
                eename = ees[i]['fname'] +' '+ ees[i]['lname'];
                abainiofchtml += '<option value="'+ ees[i]['abaini'] +'">'+ eename +'</option>';
              }
            abainiofchtml += '</select>';
            $("#divabainiofc").html(abainiofchtml);

            sharehtml = '<label>Shared</label>';
            sharehtml += '<select class="form-control" id="txtShared" name="txtShared">';
              sharehtml += '<option value="" selected></option>';
              for(var i=0;i<ees.length;i++){
                eename = ees[i]['fname'] +' '+ ees[i]['lname'];
                sharehtml += '<option value="'+ ees[i]['userid'] +'">'+ eename +'</option>';
              }
              for(var i=0;i<salesofc.length;i++){
                sharehtml += '<option value="'+ salesofc[i]['salesofficeid'] +'">'+ salesofc[i]['description'] +'</option>';
              }
            sharehtml += '</select>';
            $("#divsharedwith").html(sharehtml);

            $("#txtShared").change(function(){
               computePremiumHKD ();
            });

            var suphtml = "";
            suphtml += '<select class="form-control" id="txtSupplier" name="txtSupplier">';
              suphtml += '<option value="" selected></option>';
              for(var i=0;i<sup.length;i++){
                suphtml += '<option value="'+ sup[i]['supplierid'] +'">'+ sup[i]['name'] +'</option>';
              }
            suphtml += '</select>';
            $("#dataSupplier").html(suphtml);
			
			salesofchtml = '<label>Sales Office</label>';
            salesofchtml += '<select class="form-control" id="txtSalesOfc" name="txtSalesOfc">';
			salesofchtml += '<option value="" selected></option>';
              for(var i=0;i<salesofc.length;i++){
                salesofchtml += '<option value="'+ salesofc[i]['salesofficeid'] +'">'+ salesofc[i]['description'] +'</option>';
              }
				salesofchtml += '<option value="SO0007" style="display: none;">sscceb</option>';
            salesofchtml += '</select>';
            $("#divsalesofc").html(salesofchtml);

            var bslhtml = "";
            var bustype = data['acct']['rows'][0];
            if(bustype['businesstype'] == "i"){
                bslhtml = '<label>Product Type</label>';
                bslhtml += '<select class="form-control" id="txtProdType" name="txtProdType">';
                bslhtml += '<option value="" selected></option>';
                  for(var i=0;i<bsl.length;i++){
                    if(bsl[i]['ddid'] == 'm' || bsl[i]['ddid'] == 'l' || bsl[i]['ddid'] == 'g' || bsl[i]['ddid'] == 'mpf'){
                        bslhtml += '<option value="'+ bsl[i]['ddid'] +'">'+ bsl[i]['dddescription'] +'</option>';
                    }
                  }
                bslhtml += '</select>';
                $("#dataBSL").html(bslhtml);
            }else{
                bslhtml = '<label>Product Type</label>';
                bslhtml += '<select class="form-control" id="txtProdType" name="txtProdType">';
                bslhtml += '<option value="" selected></option>';
                  for(var i=0;i<bsl.length;i++){
                    bslhtml += '<option value="'+ bsl[i]['ddid'] +'">'+ bsl[i]['dddescription'] +'</option>';
                  }
                bslhtml += '</select>';
                $("#dataBSL").html(bslhtml);
            }

            genAcct(val);
            genActivities(act);
            genTasks(task);
            genOpps(opps);
            genOppsSigned(signedopps);
            genOppsSignedPolIssued(signedopps);
            genGalInfos(galinfos);
            genNotes(notes);

            if( $("#tid").val() != ""){
                $("#refresh").val(1);
                getTask($("#tid").val());
            }

            if( $("#oppsid").val() != ""){
                $("#refresh").val(1);
                getOpps($("#oppsid").val());
                $('#frmOpps').modal('show');
            }
            
            $.unblockUI();
        }
        ,error: function(request, status, err){

        }
    });
}

function genAcct(data){
    var acct = data['acct']['rows'][0];
    var ctc = data['ctc']['rows'][0];
    var name = "";

    $("#txtEmailAddress").val(ctc['emailaddress']);
    $("#txtHomPhoneNo").val(ctc['homephoneno']);
    $("#txtMobPhoneNo").val(ctc['mobilephoneno']);
    var title = ctc['title'] == "" || ctc['title'] == null ? "" : ctc['title'];
    var titledesc = ctc['titledesc'] == "" || ctc['titledesc'] == null ? "" : ctc['titledesc'] +' ';
    var mname = ctc['middlename'] == "" || ctc['middlename'] == null ? "" : ctc['middlename'] +' ';
    var fum = acct['fumlink'] == "" || acct['fumlink'] == null ? "fum link unavailable" : '<a href ="' + acct["fumlink"] + '" target="_blank">'+ acct['fumname'] +'</a>';
    var jobtitle = ctc['jobtitle'] == "" || ctc['jobtitle'] == null ? "NA" : ctc['jobtitle'];
    var mphno = ctc['mobilephoneno']= "" || ctc['mobilephoneno'] == null ? "" : '<a href="tel:'+ ctc['mobilephoneno'] +'">'+ ctc['mobilephoneno'] +'</a>';
    var hphno = ctc['homephoneno']= "" || ctc['homephoneno'] == null ? "" : '<a href="tel:'+ ctc['homephoneno'] +'">'+ ctc['homephoneno'] +'</a>';
    var bphno = ctc['businessphoneno']= "" || ctc['businessphoneno'] == null ? "" : '<a href="tel:'+ ctc['businessphoneno'] +'">'+ ctc['businessphoneno'] +'</a>';
    var ctcname = name = title.charAt(0).toUpperCase() + title.slice(1) + ' ' + ctc['firstname'] +' '+ mname + ctc['lastname'];
    var initials = ctc['initials'] = "" || ctc['initials'] == null ? "" : ctc['initials'];
    var bustype = "";
    var eaddr = '<a href ="mailto:' + ctc['emailaddress'] + '" target="_blank">'+ ctc['emailaddress'] +'</a>' ;
    switch(acct['businesstype']){
        case "c": 
            bustype = "Corporate"; name = ctc['companyname']; 
            $("#labelContactName").show();
            break;
        case "i": 
            bustype = "Individual"; name = title.charAt(0).toUpperCase() + title.slice(1) + ' ' + ctc['firstname'] +' '+ mname + ctc['lastname'] + ' ' + initials; 
            $("#labelContactName").hide();
            break;
        default: 
            break;
    }

    var galinfo1 = 'NONE';
    var galinfo2 = 'NONE';
    var galinfo3 = 'NONE';
    var galinfo4 = 'NONE';
    var galinfo5 = 'NONE';
    if(acct['galinfo1'] != ""){
        galinfo1 = acct['galinfo1'];
    }
    if(acct['galinfo2'] != ""){
        galinfo2 = acct['galinfo2'];
    }
    if(acct['galinfo3'] != ""){
        galinfo3 = acct['galinfo3'];
    }
    if(acct['galinfo4'] != ""){
        galinfo4 = acct['galinfo4'];
    }
    if(acct['galinfo5'] != ""){
        galinfo5 = acct['galinfo5'];
    }
    $("#dataGalInfo1").html(galinfo1);
    $("#dataGalInfo2").html(galinfo2);
    $("#dataGalInfo3").html(galinfo3);
    $("#dataGalInfo4").html(galinfo4);
    $("#dataGalInfo5").html(galinfo5);

    $("#dataBusType").html(bustype);
    $("#dataJobTitle").html(jobtitle);
    $("#dataCltProstName").html(name);
    $("#cltprost").val(name);
    $("#dataContactName").html(ctcname);
    $("#dataCompanyName").html(ctc['companyname']);
    $("#dataEAddr").html(eaddr);
    if(ctc['birthdate'] != "1900-01-01 00:00:00" && ctc['birthdate'] != ""){
        $("#dataBDt").html(ctc['bdt']);
        $("#dataAge").html(ctc['cltage']);
        $("#labelbdt").show();
    }
    $("#dataWebsite").html(ctc['website']);
    $("#dataAddr").html(ctc['address']);
    $("#dataMobNo").html(mphno);
    $("#dataHomNo").html(hphno);
    $("#dataBusNo").html(bphno);
    $("#dataFUM").html(fum);
    $("#acctid").val(acct['acctid']);
    $("#ctcid").val(ctc['ctcid']);
    $("#txtini").val(ctc['initials']);

    var nat = ctc['nationality'];
    var eth = ctc['ethnicity'];
    var aff = acct['affinity'];
    var recomby = acct['recommendedby'];
    $("#txtCname").val(ctc['chinesename']);
    $("#txtFname").val(ctc['firstname']);
    $("#txtMname").val(ctc['middlename']);
    $("#txtLname").val(ctc['lastname']);
    $("#txtRecomName").val(ctc['recommendedname']);
    $("#txtTitle option[value='"+ title +"']").prop('selected',true);
    $("#txtabainiofc option[value='"+ acct['abainiofc'] +"']").prop('selected',true);
    $("#txtShared option[value='"+ acct['sharedwith'] +"']").prop('selected',true);
	$("#txtSalesOfc option[value='"+ acct['salesoffice'] +"']").prop('selected',true);
    $("#txtBirthDate").val(ctc['bdt']);
    switch(ctc['gender']){
        case 'm': $("#rGenderm").attr("checked",true); break;
        case 'f': $("#rGenderf").attr("checked",true); break;
        default: break;
    }
    $("#txtCompany").val(ctc['companyname']);
    $("#txtJobTitle").val(ctc['jobtitle']);
    
    $("#txtAddress").val(ctc['address']);
    $("#txtNationality option[value='"+ nat +"']").prop('selected',true);
    $("#txtEthnicity option[value='"+ eth +"']").prop('selected',true);
    switch(acct['businesstype']){
        case 'i': $("#rBusinessTypei").attr("checked",true); break;
        case 'c': $("#rBusinessTypec").attr("checked",true); break;
        default: break;
    }
    $("#txtAffinityName option[value='"+ aff +"']").prop('selected',true);
    $("#txtRecomBy option[value='"+ recomby +"']").prop('selected',true);
    $("#txtIntroduced").val(acct['galinfo1']);
    tinyMCE.get('txtCompanyLink').setContent(acct['galinfo2']);
    $("#txtBroker").val(acct['galinfo3']);
    $("#txtpplInvolved").val(acct['galinfo4']);
    $("#txtGalInfoRemarks").val(acct['galinfo5']);
    $("#txtFumLink").val(acct['fumlink']);
    $("#btnSaveCtcDtls").hide();
}

function genTasks(data){
    var rows = data['rows'];
    var html = "";
    var today = ((new Date()).setHours(0, 0, 0, 0));
    var taskdate = "";
    var tasktype = "";
    var resexpected = "";
    var specificres = "";
    html = '<table class="table table-striped jambo_table table-condensed table-hover table-bordered">';
        html += '<thead>';
        html += '<tr>';
            html += '<th width="15%">Task Date</th>';
            html += '<th width="15%">Task Type</th>';
            html += '<th width="30%">Result</th>';
            html += '<th width="40%">Specific Result</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';
        var cnt = 1;
        var edittask = "";
        var bgtaskdate = "";
        var taskdt = "";
        if(rows.length > 0){
            for(var i=0;i<rows.length;i++){
                taskdate = rows[i]['taskdt'] == "" || rows[i]['taskdt'] == null ? "" : rows[i]['taskdt'];
                tasktype = rows[i]['tasktypedesc'] == "" || rows[i]['tasktypedesc'] == null ? "" : rows[i]['tasktypedesc'];
                resexpected = rows[i]['resultexpecteddesc'] == "" || rows[i]['resultexpecteddesc'] == null ? "" : rows[i]['resultexpecteddesc'];
                specificres = rows[i]['specificresult'] == "" || rows[i]['specificresult'] == null ? "" : rows[i]['specificresult'];
                bgtaskdate = "";
                taskdt = ((new Date(rows[i]['taskdt'])).setHours(0, 0, 0, 0));
                if(taskdt < today){
                    bgtaskdate = "overduedt";
                }else if(taskdt == today){
                    bgtaskdate = "duetoday";
                }else{
                    bgtaskdate = "";
                }
                edittask = "return editTask('"+ rows[i]['taskid'] +"');";
                html += '<tr style="cursor: pointer;" onClick="'+ edittask +'" >';
                    html += '<td class="text-center '+ bgtaskdate +'">'+ taskdate +'</td>';
                    html += '<td class="text-center">'+ tasktype +'</td>';
                    html += '<td>'+ resexpected +'</td>';
                    html += '<td>'+ specificres +'</td>';
                html += '</tr>';
                cnt++;
            }
        }else{
            html += '<tr>';
                html += '<td colspan="4" class="text-center">No Pending Tasks</td>';
            html += '</tr>';
        }
        html += '</tbody>';
    html += '</table>';
    $("#taskstbldata").html(html);
}

function genOpps(data){
    var rows = data['rows'];
    var html = "";
    html = '<table class="table table-striped jambo_table table-condensed table-hover table-bordered">';
        html += '<thead>';
        html += '<tr>';
            html += '<th width="10%">bsl</th>';
            html += '<th width="10%">Target Date</th>';
            html += '<th width="5%">Potential</th>';
            html += '<th width="5%">ccy</th>';
            html += '<th width="15%">Premium</th>';
            html += '<th width="15%">Premium HKD</th>';
            html += '<th width="10%">aba rev%</th>';
            html += '<th width="10%">aba rev HKD</th>';
			html += '<th width="10%">Shared With</th>';
            html += '<th width="10%">aba rev share</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';
        var cnt = 1;
        var editopps = "";
        var srwtargetdt = "";
        var prem = "";
        var premhkd = "";
        var abarevhkd = "";
        var opsstatus = "";
        var ccy = "";
        if(rows.length > 0){
            for(var i=0;i<rows.length;i++){
				var sharedabaini = "";
				var abarevshare = 0;
				var abarevhkd =0;
                srwtargetdt = rows[i]['srwtargetdt'] == "0000-00-00 00:00:00" || rows[i]['srwtargetdt'] == "" || rows[i]['srwtargetdt'] == null ? "" : rows[i]['srwtargetdt'];
                prem = rows[i]['premium'] == "" || rows[i]['premium'] == null ? 0 : rows[i]['premium'];
                premhkd = rows[i]['premiumhkd'] == "" || rows[i]['premiumhkd'] == null ? 0 : rows[i]['premiumhkd'];
                abarevhkd = rows[i]['abarevhkd'] == "" || rows[i]['abarevhkd'] == null ? 0 : rows[i]['abarevhkd'];
                ccy = rows[i]['ccy'] == "" || rows[i]['ccy'] == null ? "" : rows[i]['ccy'];
                editopps = "return editOpps('"+ rows[i]['oppsid'] +"');";     
                opsstatus = rows[i]['oppsstatus'];
				sharedabaini = rows[i]['sharedabaini'] == "" || rows[i]['sharedabaini'] == null ? "" : rows[i]['sharedabaini'];
				if(sharedabaini != ""){
					abarevshare = Math.trunc(abarevhkd / 2);
				}else{
					abarevshare = abarevhkd;
				}
                if(opsstatus == 'p' || opsstatus == 'q' || opsstatus == 'c'){
                    html += '<tr style="cursor: pointer;" onClick="'+ editopps +'" data-toggle="modal" data-target="frmOpps">';
                        html += '<td>'+ rows[i]['prodtypedesc'] +'</td>';
                        html += '<td class="text-center">'+ srwtargetdt +'</td>';
                        html += '<td class="text-right">'+ rows[i]['potential'] +'%</td>';
                        html += '<td class="text-center">'+ ccy +'</td>';
                        html += '<td class="text-right">'+ addCommas(prem) +'</td>';
                        html += '<td class="text-right">'+ addCommas(premhkd) +'</td>';
                        html += '<td class="text-right">'+ rows[i]['comrate'] +'</td>';
                        html += '<td class="text-right">'+ addCommas(abarevhkd) +'</td>';
						html += '<td class="text-center">'+ sharedabaini +'</td>';
						html += '<td class="text-right">'+ addCommas(abarevshare) +'</td>';
						html += '</tr>';
                    cnt++;
                }
            }
        }else{
            html += '<tr>';
                html += '<td colspan="10" class="text-center">No Pending Opportunities</td>';
            html += '</tr>';
        }
        html += '</tbody>';
    html += '</table>';
    $("#oppstbldata").html(html);
}
function genOppsSigned(data){
    var rows = data['rows'];
    var html = "";
    html = '<table class="table table-striped jambo_table table-condensed table-hover table-bordered">';
        html += '<thead>';
        html += '<tr>';
            html += '<th width="5%">bsl</th>';
            html += '<th width="10%">Target Date</th>';
            html += '<th width="5%">ccy</th>';
            html += '<th width="15%">Premium</th>';
            html += '<th width="15%">Premium HKD</th>';
            html += '<th width="10%">aba rev %</th>';
            html += '<th width="10%">aba rev HKD</th>';
			html += '<th width="10%">Shared With</th>';
            html += '<th width="10%">aba rev share</th>';
            html += '<th width="10%">Signed Date</th>';            
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';
        var cnt = 1;
        var editopps = "";
        var srwtargetdt = "";
        var prem = "";
        var premhkd = "";
        var abarevhkd = "";
        var polissueddt = "";
        var polnumber = "";
        if(rows.length > 0){
            for(var i=0;i<rows.length;i++){
				var abarevshare = 0;
				var abarevhkd =0;
                srwtargetdt = rows[i]['srwtargetdt'] == "0000-00-00 00:00:00" || rows[i]['srwtargetdt'] == "" || rows[i]['srwtargetdt'] == null ? "" : rows[i]['srwtargetdt'];
                prem = rows[i]['premium'] == "" || rows[i]['premium'] == null ? 0 : rows[i]['premium'];
                premhkd = rows[i]['premiumhkd'] == "" || rows[i]['premiumhkd'] == null ? 0 : rows[i]['premiumhkd'];
                abarevhkd = rows[i]['abarevhkd'] == "" || rows[i]['abarevhkd'] == null ? 0 : rows[i]['abarevhkd'];
                signeddt = rows[i]['signeddt'] == "" || rows[i]['signeddt'] == null ? "" : rows[i]['signeddt'];
                polnumber = rows[i]['polnumber'] == "" || rows[i]['polnumber'] == null ? 0 : rows[i]['polnumber'];
                editopps = "return editOpps('"+ rows[i]['oppsid'] +"');";
                opsstatus = rows[i]['oppsstatus'];
				sharedabaini = rows[i]['sharedabaini'] == "" || rows[i]['sharedabaini'] == null ? "" : rows[i]['sharedabaini'];
				if(sharedabaini != ""){
					abarevshare = Math.trunc(abarevhkd / 2);
				}else{
					abarevshare = abarevhkd;
				}
				
                if(opsstatus == 's'){
                    html += '<tr style="cursor: pointer;" onClick="'+ editopps +'" data-toggle="modal" data-target="frmOpps">';
                        html += '<td>'+ rows[i]['prodtypedesc'] +'</td>';
                        html += '<td class="text-center">'+ srwtargetdt +'</td>';
                        html += '<td class="text-center">'+ rows[i]['ccy'] +'</td>';
                        html += '<td class="text-right">'+ addCommas(prem) +'</td>';
                        html += '<td class="text-right">'+ addCommas(premhkd) +'</td>';
                        html += '<td class="text-right">'+ rows[i]['comrate'] +'</td>';
                        html += '<td class="text-right">'+ addCommas(abarevhkd) +'</td>';
						html += '<td class="text-center">'+ sharedabaini +'</td>';
						html += '<td class="text-right">'+ addCommas(abarevshare) +'</td>';
                        html += '<td class="text-right">'+ signeddt +'</td>';
                    html += '</tr>';
                    cnt++;
                }
            }
        }else{
            html += '<tr>';
                html += '<td colspan="10" class="text-center">No Signed Opportunities</td>';
            html += '</tr>';
        }
        html += '</tbody>';
    html += '</table>';
    $("#sdoppstbldata").html(html);
}
function genOppsSignedPolIssued(data){
    var rows = data['rows'];
    var html = "";
    html = '<table class="table table-striped jambo_table table-condensed table-hover table-bordered">';
        html += '<thead>';
        html += '<tr>';
            html += '<th width="5%">bsl</th>';
            html += '<th width="10%">Start Date</th>';
            html += '<th width="5%">ccy</th>';
            html += '<th width="15%">Premium</th>';
            html += '<th width="15%">Premium HKD</th>';
            html += '<th width="10%">aba rev %</th>';
            html += '<th width="10%">aba rev HKD</th>';
			html += '<th width="5%">Shared With</th>';
            html += '<th width="5%">aba rev share</th>';
            html += '<th width="10%">Pol Issued Date</th>';
            html += '<th width="10%">Policy number</th>';   
            
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';
        var cnt = 1;
        var editopps = "";
        var srwtargetdt = "";
        var prem = "";
        var premhkd = "";
        var abarevhkd = "";
        var polissueddt = "";
        var polnumber = "";
        if(rows.length > 0){
            for(var i=0;i<rows.length;i++){
				var abarevshare = 0;
				var abarevhkd =0;
                srwtargetdt = rows[i]['srwtargetdt'] == "0000-00-00 00:00:00" || rows[i]['srwtargetdt'] == "" || rows[i]['srwtargetdt'] == null ? "" : rows[i]['srwtargetdt'];
                prem = rows[i]['premium'] == "" || rows[i]['premium'] == null ? 0 : rows[i]['premium'];
                premhkd = rows[i]['premiumhkd'] == "" || rows[i]['premiumhkd'] == null ? 0 : rows[i]['premiumhkd'];
                abarevhkd = rows[i]['abarevhkd'] == "" || rows[i]['abarevhkd'] == null ? 0 : rows[i]['abarevhkd'];
                polissueddt = rows[i]['polissueddt'] == "" || rows[i]['polissueddt'] == null ? "" : rows[i]['polissueddt'];
                polnumber = rows[i]['polnumber'] == "" || rows[i]['polnumber'] == null ? 0 : rows[i]['polnumber'];
                editopps = "return editOpps('"+ rows[i]['oppsid'] +"');";
                opsstatus = rows[i]['oppsstatus'];     
				sharedabaini = rows[i]['sharedabaini'] == "" || rows[i]['sharedabaini'] == null ? "" : rows[i]['sharedabaini'];
				if(sharedabaini != ""){
					abarevshare = Math.trunc(abarevhkd / 2);
				}else{
					abarevshare = abarevhkd;
				}
                if(opsstatus == 'sp'){
                    html += '<tr style="cursor: pointer;" onClick="'+ editopps +'" data-toggle="modal" data-target="frmOpps">';
                        html += '<td>'+ rows[i]['prodtypedesc'] +'</td>';
                        html += '<td class="text-center">'+ srwtargetdt +'</td>';
                        html += '<td class="text-center">'+ rows[i]['ccy'] +'</td>';
                        html += '<td class="text-right">'+ addCommas(prem) +'</td>';
                        html += '<td class="text-right">'+ addCommas(premhkd) +'</td>';
                        html += '<td class="text-right">'+ rows[i]['comrate'] +'</td>';
                        html += '<td class="text-right">'+ addCommas(abarevhkd) +'</td>';
						html += '<td class="text-center">'+ sharedabaini +'</td>';
						html += '<td class="text-right">'+ addCommas(abarevshare) +'</td>';
                        html += '<td class="text-right">'+ polissueddt +'</td>';
                        html += '<td class="text-right">'+ polnumber +'</td>';
                    html += '</tr>';
                    cnt++;
                }
            }
        }else{
            html += '<tr>';
                html += '<td colspan="11" class="text-center">No Signed and Policy Issued</td>';
            html += '</tr>';
        }
        html += '</tbody>';
    html += '</table>';
    $("#sptabledata").html(html);
}

function genActivities(data){
    var acts = data['rows'];
    var html = "";
    var curcreadt = "";
    var acttype = "";

    html += '<ul class="list-unstyled timeline widget">';
        html += '<li>';
            html += '<div class="block">';
                html += '<div class="block_content">';
                for(var i=0;i<acts.length;i++){
                    if(curcreadt != acts[i]['creadt']){
                        html += '<h2 class="title">'+ acts[i]['createddt'] +'</h2>';
                        html += '<p class="excerpt"><span class="byline">'+ acts[i]['createdtm'] +' - '+ acts[i]['actdetails'] +'</p>';
                    }else{
                        html += '<p class="excerpt"><span class="byline">'+ acts[i]['createdtm'] +' - '+ acts[i]['actdetails'] +'</p>';
                    }
                    curcreadt = acts[i]['creadt'];
                }
                html += '</div>';
            html += '</div>';
        html += '</li>';
    html += '</ul>';
    $("#dataActivities").html(html);
}

function genGalInfos(data){
    var rows = data;
    var galinfohtml = "";
    var galinfoids = "";
    var html = "";
    var cnt = 1;

    for(var i=0;i<rows.length;i++){
        galinfohtml += '<div class="row"><label>Q#'+cnt+'</label> <textarea class="form-control" rows="2" cols="" id="txtGalInfoQ'+rows[i]['galinfoid']+'" name="txtGalInfoQ'+rows[i]['galinfoid']+'" placeholder="Question here">'+rows[i]['galinfoask']+'</textarea></div>';
        galinfohtml += '<div class="row"><label>A#'+cnt+'</label> <textarea class="form-control" rows="2" cols="" id="txtGalInfoA'+rows[i]['galinfoid']+'" name="txtGalInfoA'+rows[i]['galinfoid']+'" placeholder="Answer here">'+rows[i]['galinfoans']+'</textarea></div>';
        cnt++;
        galinfoids += rows[i]['galinfoid'] +':';
    }
    if(galinfoids != ""){
        galinfoids = galinfoids.substring(0,galinfoids.length - 1);
    }
    galinfohtml += '<input type="hidden" name="txtGalInfoIds" id="txtGalInfoIds" value="'+galinfoids+'">';
    $("#divGalInfoItemsLoad").html(galinfohtml);
    $("#galInfoItemsCnt").val(cnt);
}

function saveTask(){
    var url = getAPIURL() + 'clientprospect.php';
    var f = "saveTask";
    var id = $("#sesid").val();
    var userid = $("#userid").val();
    var abaini = $("#abaini").val();
    var acctid = $("#acctid").val();
    var taskType = $("#txtTaskType").val();
    var taskDate = $("#txtTaskDate").val();
    var otppl = $("#txtotPpl").val();
    var stime = $("#txtSTime").val();
    var etime = $("#txtETime").val();
    var noofmtg = $("#txtNoOfMtg").val();
    var re = $("#txtResultExpected").val();
    var sr = $("#txtSpecificResult").val();
    var rem = $("#txtTaskRemarks").val();
    var cltprost = $("#cltprost").val();
    var sesid = $("#sesid").val();

    var data = { "f":f, "assignedto":abaini, "sesid":sesid, "abaini":abaini, "id":id, "acctid":acctid, "cltprost":cltprost, "tasktype":taskType, "taskdate":taskDate, 
                "otppl":otppl, "starttime":stime, "endtime":etime, "noofmtg":noofmtg, "resultexpected":re, "specificresult":sr, "taskremarks":rem, "userid":userid 
            };
    // console.log(data);
    // return false;

    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify({ "data":data }),
        dataType: 'json'
        ,success: function(data){
            // console.log(data);
            var tasks = data['tasks'];
            var acts = data['acts'];
            genTasks(tasks);
            genActivities(acts);
            var id = $("#sesid").val();
            if( $("#refresh").val() > 0){
                window.location = "cdm.php?id="+id;
            }
            $("#frmTask").modal("hide");
            $.unblockUI();
        }
        ,error: function(request, status, err){

        }
    });
}

function updateTask(){
    var url = getAPIURL() + 'clientprospect.php';
    var f = "updateTask";
    var id = $("#sesid").val();
    var userid = $("#userid").val();
    var taskid = $("#tid").val();
    var abaini = $("#abaini").val();
    var acctid = $("#acctid").val();
    var taskType = $("#txtTaskType").val();
    var taskDate = $("#txtTaskDate").val();
    var otppl = $("#txtotPpl").val();
    var stime = $("#txtSTime").val();
    var etime = $("#txtETime").val();
    var noofmtg = $("#txtNoOfMtg").val();
    var re = $("#txtResultExpected").val();
    var sr = $("#txtSpecificResult").val();
    var rem = $("#txtTaskRemarks").val();
    var cltprost = $("#cltprost").val();
    var resultachieve = "";
    if( $("#txtTaskDone").val() > 0){
        resultachieve = $("input[name='rResultAchieve']:checked").val() == "" || $("input[name='rResultAchieve']:checked").val() == null ? "" : $("input[name='rResultAchieve']:checked").val();
    }

    var data = { "f":f, "assignedto":abaini, "abaini":abaini, "id":id, "taskid":taskid, "acctid":acctid, "cltprost":cltprost, "tasktype":taskType, "taskdate":taskDate, 
                "otppl":otppl, "starttime":stime, "endtime":etime, "noofmtg":noofmtg, "resultexpected":re, "specificresult":sr, "taskremarks":rem, "resultachieve":resultachieve, 
                "userid":userid
            };
    // console.log(data);
    // return false;

    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify({ "data":data }),
        dataType: 'json'
        ,success: function(data){
            //console.log(data);
            var task = data['task'];
            var tasks = data['tasks'];
            var acts = data['acts'];
            genTasks(tasks);
            genActivities(acts);
            var id = $("#sesid").val();
            if( $("#refresh").val() > 0 ){
                window.location = "cdm.php?id="+id;
            }
            $("#frmTask").modal("hide");
            $("#divResutlAchieve").hide();
            $.unblockUI();
        }
        ,error: function(request, status, err){

        }
    });
}

function getTask(){
    var url = getAPIURL() + 'clientprospect.php';
    var f = "getTask";
    var taskid = $("#tid").val();

    var data = { "f":f, "taskid":taskid };
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
            var id = $("#sesid").val();
            var task = data['task']['rows'][0];
            if(task['status'] > 0){
                $("#frmTask").modal('hide');
                window.location = "cdm.php?id="+id;
                return false;
            }

            var tasktype = task['tasktype'];
            var taskdate = task['taskdt'];
            var otppl = task['cmpresent'];
            var stime = task['starttime'];
            var etime = task['endtime'];
            var noofmtgs = task['noofmtgs'];
            var resultexpected = task['resultexpected'];
            var specificresult = task['specificresult'];
            var taskrem = task['remarks'];
            $("#txtTaskType option[value='"+ tasktype +"']").prop('selected',true);
            $("#txtTaskDate").val(taskdate);
            $("#txtotPpl").val(otppl);
            $("#txtSTime option[value='"+ stime +"']").prop('selected',true);
            $("#txtETime option[value='"+ etime +"']").prop('selected',true);
            $("#txtNoOfMtg").val(noofmtgs);
            $("#txtResultExpected option[value='"+ resultexpected +"']").prop('selected',true);
            $("#txtSpecificResult").val(specificresult);
            $("#txtTaskRemarks").val(taskrem);
            $("#divResutlAchieve").show();
            $("#btnDoneTask").show();
            $("#frmTask").modal('show');
            $.unblockUI();
        }
        ,error: function(request, status, err){

        }
    });
}

function getOpps(){
    var url = getAPIURL() + 'clientprospect.php';
    var f = "getOpps";
    var oppsid = $("#oppsid").val();

    var data = { "f":f, "oppsid":oppsid };
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
            var opps = data['opps']['rows'][0];
            var prodtype = opps['producttype'];
            var ccy = opps['ccy'];
            var pot = opps['potential'];
            var srwtargetdt = opps['srwtargetdt'] == "" || opps['srwtargetdt'] == null ? "" : opps['srwtargetdt'];
            var prem = addCommas(opps['premium']);
            var comrate = opps['comrate'];
            var stat = opps['oppsstatus'];
            var sup = opps['supplier'];
            var rem = opps['remarks'];
            var preminhkd = opps['premiumhkd'] == "" || opps['premiumhkd'] == null ? "" : opps['premiumhkd'];
            var abarevhkd = opps['abarevhkd'] == "" ||  opps['abarevhkd'] == null ? "" : opps['abarevhkd'];
            var polissueddt = opps['polissueddt'] == "" || opps['polissueddt'] == null ? "" : opps['polissueddt'];
            var polno = opps['polnumber'] == "" || opps['polnumber'] == null ? "" :opps['polnumber'];
            var signeddt = opps['signeddt'] == "" || opps['signeddt'] == null ? "" : opps['signeddt'];
			var shared = opps['sharedwith'] == "" || opps['sharedwith'] == null ? "" : opps['sharedwith'];
            $('#chkAccountTypep').prop('checked',true);
            $("#txtPremium").val(prem);
            $("#txtComRate").val(comrate);
            $("#txtOppsRemarks").val(rem);
            $("#txtStartRWTargetDt").val(srwtargetdt);
            $("#txtProdType option[value='"+ prodtype +"']").prop('selected',true);
            $("#txtCCY option[value='"+ ccy +"']").prop('selected',true);
            $("#txtPotential option[value='"+ pot +"']").prop('selected',true);
            $("#txtOppsStatus option[value='"+ stat +"']").prop('selected',true);
            $("#txtSupplier option[value='"+ sup +"']").prop('selected',true);
            $("#txtPremiuminHKD").val(addCommas(preminhkd));
            $("#txtComRateinHKD").val(addCommas(abarevhkd));
            $("#txtPolIssuedDate").val(polissueddt);
            $("#txtPolicyNo").val(polno);
            $("#txtSignedDate").val(signeddt);
			$("#txtShared option[value='"+ shared +"']").prop('selected',true);
            if(stat == "s" ){
                $("#divSigned,#divSignedDate").show(); 
                $("#divPotential").hide(); 
            }
            else if(stat == "sp"){
                $("#divSigned,#divSignedDate").show(); 
                $("#divPotential").hide(); 
            }
            else {
                $("#divSigned,#divSignedDate").hide(); 
                $("#divPotential").show(); 
            }
            computePremiumHKD();
            $("#frmOpps").modal('show');
            $.unblockUI();
        }
        ,error: function(request, status, err){

        }
    });
}

function updateCltProst(){
    var url = getAPIURL() + 'clientprospect.php';
    var f = "updateCltProst";
    var id = $("#sesid").val();
    var userid = $("#userid").val();
    var abauser = $("#userid").val();
    var assignedto = abauser;
    var acctid = $("#acctid").val();
    var ctcid = $("#ctcid").val();
    var title = $("#txtTitle").val() == "" || $("#txtTitle").val() == null ? "" : $("#txtTitle").val();
    var fn = $("#txtFname").val() == "" || $("#txtFname").val() == null ? "" : $("#txtFname").val();
    var ln = $("#txtLname").val() == "" || $("#txtLname").val() == null ? "" : $("#txtLname").val();
    var mn = $("#txtMname").val() == "" || $("#txtMname").val() == null ? "" : $("#txtMname").val();
    var cnn = $("#txtCname").val() == "" || $("#txtCname").val() == null ? "" : $("#txtCname").val();
    var ini = $("#txtini").val() == "" || $("#txtini").val() == null ? "" : $("#txtini").val();
    var bdt = $("#txtBirthDate").val() == "" || $("#txtBirthDate").val() == null ? "" : $("#txtBirthDate").val();
    var gender = $("input[name='rGender']:checked").val() == "" || $("input[name='rGender']:checked").val() == null ? "" : $("input[name='rGender']:checked").val();
    var comp = $("#txtCompany").val() == "" || $("#txtCompany").val() == null ? "" : $("#txtCompany").val();
    var jt = $("#txtJobTitle").val() == "" || $("#txtJobTitle").val() == null ? "" : $("#txtJobTitle").val();
    var eaddr = $("#txtEmailAddress").val() == "" || $("#txtEmailAddress").val() == null ? "" : $("#txtEmailAddress").val();  
    var homphno = $("#txtHomPhoneNo").val() == "" || $("#txtHomPhoneNo").val() == null ? "" : $("#txtHomPhoneNo").val();
    var mobphno = $("#txtMobPhoneNo").val() == "" || $("#txtMobPhoneNo").val() == null ? "" : $("#txtMobPhoneNo").val();
    var addr =  $("#txtAddress").val() == "" || $("#txtAddress").val() == null ? "" : $("#txtAddress").val();
    var nat = $("#txtNationality").val() == "" || $("#txtNationality").val() == null ? "" : $("#txtNationality").val();
    var eth = $("#txtEthnicity").val() == "" || $("#txtEthnicity").val() == null ? "" : $("#txtEthnicity").val();
    var businesstype = $("input[name='rBusinessType']:checked").val() == "" || $("input[name='rBusinessType']:checked").val() == null ? "" : $("input[name='rBusinessType']:checked").val();
    var aff = $("#txtAffinityName").val() == "" || $("#txtAffinityName").val() == null ? "" : $("#txtAffinityName").val();
    var recomby = $("#txtRecomBy").val() == "" || $("#txtRecomBy").val() == null ? "" : $("#txtRecomBy").val();
    var recomname = $("#txtRecomName").val() == "" || $("#txtRecomName").val() == null ? "" : $("#txtRecomName").val();
    var abainiofc = $("#txtabainiofc").val() == "" || $("#txtabainiofc").val() == null ? "" : $("#txtabainiofc").val();
    var intro = $("#txtIntroducer").val() == "" || $("#txtIntroducer").val() == null ? "" : $("#txtIntroducer").val();
    var shared = $("#txtShared").val() == "" || $("#txtShared").val() == null ? "" : $("#txtShared").val();
    var gal1 = $("#txtIntroduced").val() == "" || $("#txtIntroduced").val() == null ? "" : $("#txtIntroduced").val();
    var gal2 = tinyMCE.get('txtCompanyLink').getContent();
    var gal3 = $("#txtBroker").val() == "" || $("#txtBroker").val() == null ? "" : $("#txtBroker").val();
    var gal4 = $("#txtpplInvolved").val() == "" || $("#txtpplInvolved").val() == null ? "" : $("#txtpplInvolved").val();
    var gal5 = $("#txtGalInfoRemarks").val() == "" || $("#txtGalInfoRemarks").val() == null ? "" : $("#txtGalInfoRemarks").val();
    var fumlink = $("#txtFumLink").val() == "" || $("#txtFumLink").val() == null ? "" : $("#txtFumLink").val();
	var salesofc = $("#txtSalesOfc").val() == "" || $("#txtSalesOfc").val() == null ? "" : $("#txtSalesOfc").val();

    var galinfoscnt = $("#NewgalInfoItemsCnt").val();
    var galinfoitems = [];
    var gal = "";

    for(var i=1;i<=galinfoscnt;i++){
    if(i>1){
      if( $("#txtGalInfoQuestion"+i).val() == "" ){
        alert("Please enter additional info question item #"+i);
        $("#txtGalInfoQuestion"+i).focus();
        return false;
      }
      if( $("#txtGalInfoAnswer"+i).val() == "" ){
        alert("Please enter additional info answer item #"+ i);
        return false;
      }
    }
        gal = { "question":$("#txtGalInfoQuestion"+i).val(), "answer":$("#txtGalInfoAnswer"+i).val() }
        galinfoitems.push(gal);
    }

    var data = { "f": f, "abauser":abauser, "assignedto":assignedto, "userid":userid,
              "acctid":acctid, "ctcid":ctcid, "title":title, "firstname":fn, "lastname":ln, "middlename":mn, "chinesename":cnn, "ini":ini, "birthdate":bdt, "gender":gender, 
              "companyname":comp, "jobtitle":jt, "eaddr":eaddr, "homphno":homphno, "mobphno":mobphno, "addr":addr, "nationality":nat, "ethnicity":eth, 
              "businesstype":businesstype, "affinity":aff, "recomby":recomby, "recomname":recomname, "abainiofc":abainiofc, "introducer":intro, "shared":shared, 
              "fumlink":fumlink, "galinfo1":gal1, "galinfo2":gal2, "galinfo3":gal3, "galinfo4":gal4, "galinfo5":gal5, "galinfos":galinfoitems , "salesofc":salesofc 
            };

     //console.log(data);
    // return false;

    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify({ "data":data }),
        dataType: 'json'
        ,success: function(data){
          // console.log(data);
          // return false;
          $("#frmCtcDtls").modal("hide");
          sendEvent('#frmCtcDtls', 1);
          cltProstInfoData();
        }
        ,error: function(request, status, err){

        }
    });
}

function saveOpps(){
    var url = getAPIURL() + 'clientprospect.php';
    var f = "saveOpportunity";
    var sesid = $("#sesid").val();
    var abauser = $("#userid").val();
    var userid = $("#userid").val();
    var acctid = $("#acctid").val();
    var cltprost = $("#cltprost").val();
    var assignedto = abauser;
    var accttypec = '';
    var accttypep = '';
    var accttype = '';
    if( $('#chkAccountTypec').prop('checked') ){
        accttypec = 'c';
    }
    if( $('#chkAccountTypep').prop('checked') ){
        accttypep = 'p';
    }
    accttype = accttypec + accttypep;
    var prodtype = $("#txtProdType").val();
    var srwtargetdt = $("#txtStartRWTargetDt").val();
    var cur = $("#txtCCY").val();
    var prem = $("#txtPremium").val() == "" || $("#txtPremium").val() == null ? 0 : $("#txtPremium").val();
    var comrate = $("#txtComRate").val() == "" || $("#txtComRate").val() == null ? 0 : $("#txtComRate").val();
    var pot = $("#txtPotential").val();
    var stat = $("#txtOppsStatus").val();
    var sup = $("#txtSupplier").val();
    var rem = $("#txtOppsRemarks").val();
    var premhkd = $("#txtPremiuminHKD").val() == "" || $("#txtPremiuminHKD").val() == null ? 0 : $("#txtPremiuminHKD").val();
    var abarevhkd = $("#txtComRateinHKD").val() == "" || $("#txtComRateinHKD").val()== null ? 0 : $("#txtComRateinHKD").val();
    var prodtypedesc = "";
    var polissueddate = $("#txtPolIssuedDate").val() == "" || $("#txtPolIssuedDate").val() == null ? "" : $("#txtPolIssuedDate").val();
    var polnumber = $("#txtPolicyNo").val();
    var signeddate = $("#txtSignedDate").val() == "" || $("#txtSignedDate").val() == null ? "" : $("#txtSignedDate").val();
    var lostdate =  $("#txtLostDate").val();
	var shared = $("#txtShared").val() == "" || $("#txtShared").val() == null ? "" : $("#txtShared").val();
    switch(prodtype){
        case 'm': prodtypedesc="Medical Insurance"; break;
        case 'l': prodtypedesc="Life Insurance"; break;
        case 'g': prodtypedesc="General Insurance"; break;
        default: break;
    }
    if(stat == 's'){
        if(polissueddate != ""){
            stat = "sp";
        }
    }
    var data = { "f": f, "abaini":abauser, "assignedto":assignedto, "acctid":acctid, "cltprost":cltprost, "sesid":sesid, "userid":userid,
                "accttype":accttype, "prodtype":prodtype, "srwtargetdt":srwtargetdt, "ccy":cur, "premium":prem, "comrate":comrate, "potential":pot, "status":stat,
                "supplier":sup, "remarks":rem, "premhkd":premhkd, "abarevhkd":abarevhkd, "prodtypedesc":prodtypedesc, "polissueddate":polissueddate, "polnumber":polnumber, "signeddate":signeddate, "lostdate":lostdate, "shared":shared };
//     console.log(data);
//     return false;

    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify({ "data":data }),
        dataType: 'json'
        ,success: function(data){
//             console.log(data);
            // return false;
            var opps = data['opps'];
            var signedopps = data['signedopps'];
            var acts = data['acts'];
            genOpps(opps);
            genOppsSigned(signedopps);
            genOppsSignedPolIssued(signedopps);
            genActivities(acts);
            if( $("#refresh").val() > 0){
                window.location = "cdm.php?id="+id;
            }
            $("#frmOpps").modal("hide");
            clearOppsFields();
            $.unblockUI();
        }
        ,error: function(request, status, err){

        }
    });
}

function saveComments(){
    var url = getAPIURL() + 'clientprospect.php';
    var f = "saveComments";
    var sesid = $("#sesid").val();
    var userid = $("#userid").val();
    var abauser = $("#userid").val();
    var acctid = $("#acctid").val();
    var cltprost = $("#cltprost").val();
    var assignedto = abauser;

    var cmts = $("#txtComments").val();

    var data = { "f": f, "abaini":abauser, "assignedto":assignedto, "acctid":acctid, "cltprost":cltprost, "sesid":sesid, "userid":userid, "comments":cmts };
    // console.log(data);
    // return false;

    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify({ "data":data }),
        dataType: 'json'
        ,success: function(data){
            $("#txtComments").val("");
            // console.log(data);
            // return false;
            var acts = data['acts'];
            genActivities(acts);
            $.unblockUI();
        }
        ,error: function(request, status, err){

        }
    });
}

function updateOpps(){
    var url = getAPIURL() + 'clientprospect.php';
    var f = "updateOpps";
    var sesid = $("#sesid").val();
    var userid = $("#userid").val();
    var oppsid = $("#oppsid").val();
    var oppsid = $("#oppsid").val();
    var abaini = $("#abaini").val();
    var acctid = $("#acctid").val();
    var abauser = $("#userid").val();
    var cltprost = $("#cltprost").val();
    var assignedto = abauser;
    var accttypec = '';
    var accttypep = '';
    var accttype = '';
    if( $('#chkAccountTypec').prop('checked') ){
        accttypec = 'c';
    }
    if( $('#chkAccountTypep').prop('checked') ){
        accttypep = 'p';
    }
    accttype = accttypec + accttypep;
    var prodtype = $("#txtProdType").val();
    var srwtargetdt = $("#txtStartRWTargetDt").val();
    var cur = $("#txtCCY").val();
    var prem = $("#txtPremium").val() == "" || $("#txtPremium").val() == null ? 0 : $("#txtPremium").val();
    var comrate = $("#txtComRate").val() == "" || $("#txtComRate").val() == null ? 0 : $("#txtComRate").val();
    var pot = $("#txtPotential").val();
    var stat = $("#txtOppsStatus").val();
    var sup = $("#txtSupplier").val();
    var rem = $("#txtOppsRemarks").val();
    var premhkd = $("#txtPremiuminHKD").val() == "" || $("#txtPremiuminHKD").val() == null ? 0 : $("#txtPremiuminHKD").val();
    var abarevhkd = $("#txtComRateinHKD").val() == "" || $("#txtComRateinHKD").val()== null ? 0 : $("#txtComRateinHKD").val();
    var prodtypedesc = "";
    var polissueddt = $("#txtPolIssuedDate").val() == "" || $("#txtPolIssuedDate").val() == null ? "" : $("#txtPolIssuedDate").val();
    var polnumber = $("#txtPolicyNo").val();
    var signeddate =  $("#txtSignedDate").val();
    var lostdate =  $("#txtLostDate").val();
	var shared = $("#txtShared").val() == "" || $("#txtShared").val() == null ? "" : $("#txtShared").val();
    switch(prodtype){
        case 'm': prodtypedesc="Medical Insurance"; break;
        case 'l': prodtypedesc="Life Insurance"; break;
        case 'g': prodtypedesc="General Insurance"; break;
        default: break;
    }
    if(stat == 's'){
        if(polissueddt != ""){
            stat = "sp";
        }
    }
    var data = { "f": f, "abaini":abauser, "oppsid":oppsid, "assignedto":assignedto, "acctid":acctid, "cltprost":cltprost, "sesid":sesid, "userid":userid, 
                "accttype":accttype, "prodtype":prodtype, "srwtargetdt":srwtargetdt, "ccy":cur, "premium":prem, "comrate":comrate, "potential":pot, "status":stat, 
                "supplier":sup, "remarks":rem, "premhkd":premhkd, "abarevhkd":abarevhkd, "prodtypedesc":prodtypedesc, "polissueddt":polissueddt, "polnumber":polnumber, "signeddate":signeddate, "lostdate":lostdate, "shared":shared };
//     console.log(data);
    // return false;

    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify({ "data":data }),
        dataType: 'json'
        ,success: function(data){
            // console.log(data);
            // return false
            var opps = data['opps'];
            var signedopps = data['signedopps'];
            var acts = data['acts'];
            genOpps(opps);
            genOppsSigned(signedopps);
            genOppsSignedPolIssued(signedopps);
            genActivities(acts);
            if( $("#refresh").val() > 0){
                window.location = "cdm.php?id="+sesid;
            }
            $("#frmOpps").modal("hide");
            clearOppsFields();
            $.unblockUI();
        }
        ,error: function(request, status, err){

        }
    });
}

function computePremiumHKD(){
    var url = getAPIURL() + 'clientprospect.php';
    var f = "computePremiumHKD";
    var targetdt = $("#txtStartRWTargetDt").val();
    var ccy = $("#txtCCY").val();

    var data = { "f": f, "targetdate":targetdt, "ccy":ccy };
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

            var prem = 0;
            var abarev = 0;
            var premhkd = 0;
            var abarevhkd = 0;
            var abarevshare = 0;
		
            var fxrates = data['fxrates'];
            prem = $("#txtPremium").val() == "" ? '0' : $("#txtPremium").val();
            prem = prem.replace(/\,/g,'');
            abarev = $("#txtComRate").val() == "" ? '0' : $("#txtComRate").val();

            premhkd = Math.trunc((prem * fxrates['rate']));
            abarevhkd = Math.trunc((premhkd * (abarev / 100)));
            abarevshare = Math.trunc(abarevhkd / 2);

            $("#txtPremiuminHKD").val( addCommas(premhkd) );
            $("#txtComRateinHKD").val( addCommas(abarevhkd) );

            var sharedwith = $("#txtShared").val();
            if(sharedwith != ""){
                $("#txtAbaRevShare").val( addCommas(abarevshare) );
            }
        }
        ,error: function(request, status, err){

        }
    });
}

function computeAbaRevShare(){
	var abarev = 0;
	var abarevshare = 0;
	abarev = $("#txtComRate").val() == "" ? '0' : $("#txtComRate").val();
	
	abarevshare = Math.trunc(abarevhkd / 2);
	$("#txtAbaRevShare").val( addCommas(abarevshare) );
}

function saveNotes(){
    var url = getAPIURL() + 'clientprospect.php';
    var f = "saveNotes";
    var userid = $("#userid").val();
    var acctid = $("#acctid").val();
    var cltprost = $("#cltprost").val();
    var notes = tinyMCE.get('txtImpNotes').getContent();
    var noteslength = $("#noteslength").val();
    if(noteslength > 0){
        f = "updateNotes";
    }

    var data = { "f": f, "userid":userid, "notes":notes, "acctid":acctid, "cltprost":cltprost };
    // console.log(data);
    // return false;

    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify({ "data":data }),
        dataType: 'json'
        ,success: function(data){
            // //console.log(data);
            // return false;
            var note = data['note'];
            var notes = data['notes'];
            var acts = data['acts'];
            genNotes(notes);
            genActivities(acts);
            $.unblockUI();
        }
        ,error: function(request, status, err){

        }
    });
}

function genNotes(data){
    var notes = data['rows'];
    // console.log(data);
    var html = "";
    var curcreadt = "";
    var acttype = "";
    $("#noteslength").val(notes.length);
    if(notes.length > 0){
        for(var i=0;i<notes.length;i++){
            tinyMCE.get('txtImpNotes').setContent(notes[i]['notes']);
        }
    }
}
