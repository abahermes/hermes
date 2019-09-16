$(function(){
    tinymce.init({
      selector:'#txtCompanyLink',
      menubar: false,
      resize: false,
      statusbar: false,
      plugins : 'link',
      toolbar: 'link'
  });
    $("#txtBirthDate").datepicker({
        maxDate: -1,
        dateFormat: "D d M y",
        changeMonth: true,
        changeYear: true,
        yearRange: "1900:2020"
    });
    $("#datattlctcs").on("click", function(){
        var headerval = "ttlctcs";
        $("#headerclickval").val(headerval);
        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                filterSearch(headerval);
            }
        });
        
    });
     $("#datattlprosts").on("click", function(){
        var headerval = "ttlprosts";
        $("#headerclickval").val(headerval);
        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                filterSearch(headerval);
            }
        });
    });
      $("#datattlclts").on("click", function(){
        var headerval = "ttlclts";
        $("#headerclickval").val(headerval);
        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                filterSearch(headerval);
            }
        });
    });

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
        // if( $("#txtini").val() == "" ){
        //       alert("Initials is required! Please enter initials.");
        //       $("#txtini").focus();
        //       return false;
        // }
        if( $("input[name='rGender']:checked").length == 0 ){
          alert("Gender is required! Please select gender of the Client/Prospect.");
          return false;
        }
        sendEvent('#frmCtcDtls', 2);
    });
    $("#btnStep3").on("click", function(){
        if( $("#txtEmailAddress").val() == "" && $("#txtHomPhoneNo").val() == "" && $("#txtMobPhoneNo").val() == "" ){
          alert("One(1) of three(3) fields is required! Please enter either email address, home phone no or mobile phone no of prospect info.");
          // $("#txtLname").focus();
          return false;
        }
        sendEvent('#frmCtcDtls', 3);
    });
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
        $("#btnOthGalInfo").hide();
    });
    $("#btnNewGalInfo").on("click", function(){
     // if( $("#txtFumLink").val() == "" ){
     //      alert("FUM Link by is required! Please enter link.");
     //      $("#txtRecomBy").focus();
     //      return false;
     //    }
        sendEvent('#frmCtcDtls', 5);
    });
    $("#btnNewGalInfoItem").on("click", function(){
        var curCnt = $("#galInfoItemsCnt").val();
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

        $("#galInfoItemsCnt").val(newCnt);
        $("#divGalInfoItems").html(html);
    });

    $("#btnUpdateCtcDtls2").on("click", function(){
        // window.location="cdm1.php";
        //  if( $("#txtFumLink").val() == "" ){
        //   alert("FUM Link by is required! Please enter link.");
        //   $("#txtRecomBy").focus();
        //   return false;
        // }
        // updateCltProst();
        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                saveProst();
            }
        });
    });

    $("#btnUpdateCtcDtls").on("click", function(){
        // window.location="cdm1.php";
        //  if( $("#txtFumLink").val() == "" ){
        //   alert("FUM Link by is required! Please enter link.");
        //   $("#txtRecomBy").focus();
        //   return false;
        // }saveProst
        // updateCltProst();
        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                saveProst();
            }
        });
    });
	
	

    $("#btnClose").on("click", function(){
        clearCltProstFields();
        sendEvent('#frmCtcDtls', 1);
    });

    $("#txtEmailAddress,#txtHomPhoneNo,#txtMobPhoneNo").change(function(){
    $("#reqEAddr,#reqHomPh,#reqMobPh").show();
    if( $("#txtEmailAddress").val() != "" || $("#txtHomPhoneNo").val() != "" || $("#txtMobPhoneNo").val() != "" ){
            $("#reqEAddr,#reqHomPh,#reqMobPh").hide();
        }
    });

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

    $('input:radio[name=rBusinessType]').on("click",function(){
        var radioValue = $("input[name='rBusinessType']:checked").val();
        if(radioValue == "c"){
            if( $("#txtCompany").val() == "" ){
              alert("Company is required! Prospect does not have a company stated. Please go back to step2 to enter prospects company.");
              return false;
            }
        }
    });

    $('input:radio[name=rFumType]').on("click",function(){
        $("#divFumNew").show();
        $("#divFumExist").hide();
        var radioValue = $("input[name='rFumType']:checked").val();
        if(radioValue == "e"){
          $("#divFumNew").hide();
          $("#divFumExist").show();
        }
    });

    $( "#tabs,#tabs2" ).tabs();

    $.blockUI({ 
		message: $('#preloader_image'), 
		fadeIn: 1000, 
		onBlock: function() {
			loadCltsPosts();
		}
	});
});


function loadCltsPosts(){
	var url = getAPIURL() + 'accounts.php';
    var f = "loadDefault";
    var id = $("#sesid").val();
    var userid = $("#userid").val();
	var salesofc = $("#ofc").val(); 
	
    var data = { "f":f, "userid":userid, "salesofc":salesofc };
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
            var ees = data['ees'];
            var accts = data['accts'];
            var titles = data['titles'];
            var nats = data['nats']['rows'];
            var eths = data['eths']['rows'];
            var affinity =  data['cdmaffinity'];
            var salesofc = data['salesofc']['rows'];
			var salesofcid = data['salesofcid'];
            // console.log(data);

            titleshtml = '<label>Title</label>';
            titleshtml += '<select class="form-control" id="txtTitle" name="txtTitle">';
              titleshtml += '<option value="" selected></option>';
              for(var i=0;i<titles.length;i++){
                titleshtml += '<option value="'+ titles[i]['ddid'] +'">'+ titles[i]['dddescription'] +'</option>';
              }
            titleshtml += '</select>';
            $("#divTitles").html(titleshtml);

            abainiofchtml = '<label>abaini / ofc</label>';
            abainiofchtml += '<select class="form-control" id="txtabainiofc" name="txtabainiofc">';
            abainiofchtml += '<option value="" selected></option>';
            for(var i=0;i<ees.length;i++){
              eename = ees[i]['fname'] +' '+ ees[i]['lname'];
              abainiofchtml += '<option value="'+ ees[i]['userid'] +'">'+ eename +'</option>';
            }
            abainiofchtml += '</select>';
            $("#divabainiofc").html(abainiofchtml);

            nathtml = '<label>Nationality</label>';
            nathtml += '<select class="form-control" id="txtNationality" name="txtNationality">';
            nathtml += '<option value="" selected></option>';
            // nathtml += '<datalist id="dataLstNats">';
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

            var sharehtml = "";
            sharehtml = '<label>Shared</label>';
            sharehtml += '<select class="form-control" id="txtShared" name="txtShared">';
            sharehtml += '<option value="" selected></option>';
            for(var i=0;i<ees.length;i++){
              eename = ees[i]['fname'] +' '+ ees[i]['lname'];
              sharehtml += '<option value="'+ ees[i]['abaini'] +'">'+ eename +'</option>';
            }
            sharehtml += '</select>';
            $("#divshared").html(sharehtml);

            affhtml = '<label>Affinity Name</label>';
            affhtml += '<select class="form-control" id="txtAffinityName" name="txtAffinityName">';
              for(var i=0;i<affinity.length;i++){
                affhtml += '<option value="'+ affinity[i]['ddid'] +'">'+ affinity[i]['dddescription'] +'</option>';
              }
            affhtml += '</select>';
            $("#divAff").html(affhtml);

            salesofchtml = '<label>Sales Office</label>';
            salesofchtml += '<select class="form-control" id="txtSalesOfc" name="txtSalesOfc">';
			salesofchtml += '<option value="" selected></option>';
              for(var i=0;i<salesofc.length;i++){
                salesofchtml += '<option value="'+ salesofc[i]['salesofficeid'] +'">'+ salesofc[i]['description'] +'</option>';
              }
			 	salesofchtml += '<option value="SO0007" style="display: none;" >sscceb</option>';
            salesofchtml += '</select>';
            $("#divsalesofc").html(salesofchtml);
			
            genAccounts(accts);
            countCltProsHeaders(accts);
            if(salesofcid['rows'].length > 0){
    			genCltProsFileds(salesofcid);
            }
            $.unblockUI();
            // return false;
//			console.log($("#ofc").val());
        }
        ,error: function(request, status, err){

        }
    });
}

function genCltProsFileds(data){
	var salesofcid = data['rows'][0]['salesofficeid'];
	$("#txtSalesOfc option[value='"+ salesofcid +"']").prop('selected',true);
}

function genAccounts(data){
    // console.log(data);
    var rows = data['rows'];
    var html = "";
    var fumlink = '#';
    var fumname = "01 fumclt ";
    var fullname = "return sortingCltPros('fullname');";  
    var cnname = "return sortingCltPros('cnname');";
    var initials = "return sortingCltPros('initials');";  
    var company = "return sortingCltPros('company');";
    var eadd = "return sortingCltPros('eadd');";
    var jobt = "return sortingCltPros('jobt');";
    var ic = "return sortingCltPros('ic');";
    var acttype = "return sortingCltPros('acttype');";

    html = '<table class="table table-striped jambo_table table-condensed table-hover table-bordered">';
        html += '<thead>';
        html += '<tr>';
            html += '<th style="cursor: pointer;" width="15%" onClick="' + fullname + '">Name</th>';
            // html += '<th style="cursor: pointer;" width="5%" onClick="' + initials + '">ini</th>';
            html += '<th style="cursor: pointer;" width="15%" onClick="' + company + '">Company</th>';
            // html += '<th style="cursor: pointer;" width="15%" onClick="' + eadd + '">Email Address</th>';
            html += '<th style="cursor: pointer;" width="15%" onClick="' + jobt + '">Job Title</th>';
            html += '<th style="cursor: pointer;" width="10%" onClick="' + ic + '">ica</th>';
            html += '<th style="cursor: pointer;" width="10%" onClick="' + acttype + '">Account Type </th>';
            html += '<th width="15%">FUM </th>';
            html += '<th width="10%">Nationality</th>';
            html += '<th width="10%">Introducer</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';
        var srwtargetdt = "";
        var goto = "";
        var target = "";
        var ini = "";
        var name = "";
        var titledesc = "";
        var cnname = "";
        var lname = "";
        var fname = "";
        var comp = "";
        var eaddr = "";
        var jobtitle = "";
        var natdesc = "";
        var introducer = "";
        for(var i=0;i<rows.length;i++){
            fumlink = '#';
            fumname = "not available";
            ini = rows[i]['initials'] == "" || rows[i]['initials'] == null ? "" : rows[i]['initials'];
            titledesc = rows[i]['titledesc'] == null || rows[i]['titledesc'] == "" ? "" : rows[i]['titledesc'] + ' ';
            lname = rows[i]['lastname'] == "" || rows[i]['lastname'] == null ? "" : rows[i]['lastname'] +' ';
            fname = rows[i]['firstname'] == "" || rows[i]['firstname'] == null ? "" : rows[i]['firstname'];
            name = titledesc + lname + fname;
            cnname = rows[i]['chinesename'] == "" || rows[i]['chinesename'] == null ? "" : rows[i]['chinesename'];
            comp = rows[i]['companyname'] == "" || rows[i]['companyname'] == null ? "" : rows[i]['companyname'];
            eaddr = rows[i]['emailaddress'] == "" || rows[i]['emailaddress'] == null ? "" : rows[i]['emailaddress'];
            jobtitle = rows[i]['jobtitle'] == "" || rows[i]['jobtitle'] == null ? "" : rows[i]['jobtitle'];
            natdesc = rows[i]['natdesc'] == "" || rows[i]['natdesc'] == null ? "" : rows[i]['natdesc'];
            introducer = rows[i]['introducer'] == "" || rows[i]['introducer'] == null ? "" : rows[i]['introducer'];

            goto = "goto('"+ rows[i]['sesid'] +"');";
            html += '<tr>';
                html += '<td style="cursor: pointer;" onClick="return '+goto+'">'+ name +' '+ cnname +'</td>';
                // html += '<td style="cursor: pointer;" onClick="return '+goto+'" class="text-center">'+ ini +'</td>';
                html += '<td style="cursor: pointer;" onClick="return '+goto+'">'+ comp +'</td>';
                // html += '<td style="cursor: pointer;" onClick="return '+goto+'">'+ eaddr +'</td>';
                html += '<td style="cursor: pointer;" onClick="return '+goto+'">'+ jobtitle +'</td>';
                html += '<td style="cursor: pointer;" onClick="return '+goto+'" class="text-center">'+ rows[i]['bustype'] +'</td>';
                html += '<td style="cursor: pointer;" onClick="return '+goto+'" class="text-center">'+ rows[i]['accounttypedesc'] +'</td>';
                if(rows[i]['fumlink'] == "" || rows[i]['fumlink'] == null){ target = ""; }else{
                    fumname = "01 fumclt ";
                    switch(rows[i]['businesstype']){
                        case "i": fumname += lname +' '+ fname; fumlink = rows[i]['fumlink']; target = 'target="_blank"'; break;
                        case "c": fumname += rows[i]['companyname']; fumlink = rows[i]['fumlink']; target = 'target="_blank"'; break;
                        default: break;
                    }
                }
                html += '<td><a href='+ fumlink +' '+ target +' >'+ fumname +'</a></td>';
                html += '<td class="text-center">'+ natdesc +'</td>';
                html += '<td>'+ introducer +'</td>';
            html += '</tr>';
            // ttlctcs++;
        }
        html += '</tbody>';
    html += '</table>';
    $("#tblcltsprosts").html(html);
}

function goto(id){
    window.location="cdm.php?id="+id;
}

function sortingCltPros(sortby){
    var url = getAPIURL() + 'accounts.php';
    var f = "sortingCltPros";
    var id = $("#sesid").val();
    var userid = $("#userid").val();
    var sortin = $("#sortin").val()
    var sortbyprev = $("#sortby").val()
    if (sortbyprev == sortby){
        if(sortin == "DESC"){
            sortin = "ASC";
            $('#sortin').val(sortin);
        } else {
            sortin = "DESC";
            $('#sortin').val(sortin);
        }
    } else {
        sortin = "ASC";
        $('#sortin').val(sortin);
    }
    $('#sortby').val(sortby);
    var data = { "f":f, "userid":userid, "sortby":sortby, "sortin":sortin};
    // console.log(data);
    // return false;
    $.blockUI({ 
        message: $('#preloader_image'), 
        fadeIn: 1000, 
        onBlock: function() {
            $.ajax({
                type: 'POST',
                url: url,
                data: JSON.stringify({ "data":data }),
                dataType: 'json'
                ,success: function(data){
                    // console.log(data);
                    // return false
                    var accts = data['cltpros'];
                    genAccounts(accts);
                    $.unblockUI();
                    // return false;
                }
                ,error: function(request, status, err){

                }
            });
        }
    }); 
}

function searchCltPros(){
    var url = getAPIURL() + 'accounts.php';
    var f = "searchCltPros";
    var id = $("#sesid").val();
    var userid = $("#userid").val();
    var searchtext=$("#txtSearch").val();

    var data = { "f":f, "userid":userid,"searchtext":searchtext};

    // console.log(data);
    // return false;
     $.blockUI({ 
        message: $('#preloader_image'), 
        fadeIn: 1000, 
        onBlock: function() {
            $.ajax({
                type: 'POST',
                url: url,
                data: JSON.stringify({ "data":data }),
                dataType: 'json'
                ,success: function(data){
                    // console.log(data);
                    // return false;
                    var accts = data['search'];
                    genAccounts(accts);
                    $.unblockUI();
                    // return false;
                }
                ,error: function(request, status, err){

                }
            });
        }
    });     
}

function filterSearch(headerval){
    var url = getAPIURL() + 'accounts.php';
    var f = "filterHeaderSearch";
    var id = $("#sesid").val();
    var userid = $("#userid").val();
    

    var data = { "f":f, "userid":userid, "headerval":headerval};
    //console.log(data);
    // return false;

    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify({ "data":data }),
        dataType: 'json'
        ,success: function(data){
            //console.log(data);
            // return false;
            var accts = data['search'];
            genAccounts(accts);
            
            $.unblockUI();
            // return false;
        }
        ,error: function(request, status, err){

        }
    });
}

function countCltProsHeaders(data){
    var ttlctcs = 0;
    var ttlprosts = 0;
    var ttlclts = 0;
    var rows = data['rows'];
    // console.log(rows);
    for(var i=0;i<rows.length;i++){
        ttlctcs++;
        // ttlprosts++;
        // ttlclts++;
        if(rows[i]['accounttypedesc'] == "Prospect"){
            ttlprosts++;
        }
        else if (rows[i]['accounttypedesc'] == "Client"){
            ttlclts++;
        }
    }

    $("#datattlctcs").html(ttlctcs);
    $("#datattlclts").html(ttlclts);
    $("#datattlprosts").html(ttlprosts);
}

function clearCltProstFields(){
  // resetTitle();
  $("#txtCname").val("");
  $("#txtFname").val("");
  $("#txtLname").val("");
  $("#txtMname").val("");
  $("#txtBirthDate").val("");
  $("#txtini").val("");
  $("input:radio[name=rGender]").attr("checked",false);
  $("#txtCompany").val("");
  $("#txtJobTitle").val("");
  $("#txtEmailAddress").val("");
  $("#txtHomPhoneNo").val("");
  $("#txtMobPhoneNo").val("");
  $("#txtAddress").val("");
  $("#txtRecomName").val("");
  // resetNationality();
  // resetEthnicity();
  $("input:radio[name=rBusinessType]").attr("checked",false);
  $("input:radio[name=rBusinessType]").attr("disabled",false);
  $("input:radio[name=rFumType]").attr("checked",false);
  $("#rFumTypen").attr("checked",true);
  // resetRecommendedBy();
  $("#txtFumLink").val("");
  $("#divabainiofc,#divIntroducer").hide();
  $("#divRecomName").show();
  // resetabainiofcList();
  // resetShared();
  resetFumType();
  $('#txtTitle option, #txtNationality option, #txtEthnicity option, #txtAffinityName option, #txtRecomBy option, #txtabainiofc option, #txtShared option').prop('selected', function() { return this.defaultSelected; });
}

function resetabainiofcList(){
  var html = "";
  html = '<label>abaini / ofc</label>';
  html += '<select class="form-control" id="txtabainiofc" name="txtabainiofc">';
    html += '<option value="" selected></option>';
    html += '<option value="pmhe">pmhe</option>';
    html += '<option value="robc">robc</option>';
    html += '<option value="loam">loam</option>';
    html += '<option value="jacl">jacl</option>';
    html += '<option value="joga">joga</option>';
    html += '<option value="reca">reca</option>';
    html += '<option value="vive">vive</option>';
  html += '</select>';
  $("#divabainiofc").html(html);
}

function resetNationality(){
  var html = "";
  html = '<label>Nationality</label>';
  html += '<select class="form-control" id="txtNationality" name="txtNationality">';
      html += '<option value="" selected></option>';
      html += '<option value="p">POTENTIAL</option>';
  html += '</select>';
  $("#divNationality").html(html);
}

function resetEthnicity(){
  var html = "";
  html = '<label>Ethnicity</label>';
  html += '<select class="form-control" id="txtEthnicity" name="txtEthnicity">';
      html += '<option value="" selected></option>';
      html += '<option value="p">POTENTIAL</option>';
  html += '</select>';
  $("#divEthnicity").html(html);
}

function resetTitle(){
  var html = "";
  html = '<label>Title</label>';
  html += '<select class="form-control" id="txtTitle" name="txtTitle">';
      html += '<option value="mr">Mr.</option>';
      html += '<option value="mrs">Mrs.</option>';
      html += '<option value="ms">Ms.</option>';
      html += '<option value="miss">Miss.</option>';
  html += '</select>';
  $("#divEthnicity").html(html);
}

function resetAffinity(){
  var html = "";
  html = '<label>Title</label>';
  html += '<select class="form-control" id="txtTitle" name="txtTitle">';
      html += '<option value="" selected>NONE</option>';
      html += '<option value="1">POTENTIAL</option>';
      html += '<option value="2">BAR ASSOCIATION</option>';
      html += '<option value="3">BETTER LIFE GROUP</option>';
      html += '<option value="4">HBSA</option>';
      html += '<option value="5">HKRU</option>';
      html += '<option value="6">TGSL</option>';
  html += '</select>';
  $("#divEthnicity").html(html);
}

function resetRecommendedBy(){
  var html = "";
  html = '<label>Recommended By <span class="text-red">*</span></label>';
  html += '<select class="form-control" id="txtRecomBy" name="txtRecomBy">';
      html += '<option value="" selected></option>';
      html += '<option value="1">aba Website</option>';
      html += '<option value="2">abac/ofc</option>';
      html += '<option value="3">Association</option>';
      html += '<option value="4">Chamber Com</option>';
      html += '<option value="5">Client/Lead</option>';
      html += '<option value="6">Cold Call</option>';
      html += '<option value="7">Cross Sell Opportunities</option>';
      html += '<option value="8">Database</option>';
      html += '<option value="9">Direct Inquiry</option>';
      html += '<option value="10">Facebook</option>';
      html += '<option value="11">Friend</option>';
      html += '<option value="12">Internet</option>';
      html += 'option value="13">Introducer</option>';
      html += '<option value="14">LinkedIn</option>';
      html += '<option value="15">Networking Event</option>';
      html += '<option value="16">Other</option>';
      html += '<option value="17">Personal Contact</option>';
      html += '<option value="18">WeChat</option>';
      html += '<option value="19">WhatsApp</option>';
  html += '</select>';
  $("#divRecomBy").html(html);
}

function resetShared(){
  var html = "";
  html = '<label>Shared</label>';
  html += '<select class="form-control" id="txtShared" name="txtShared">';
    html += '<option value="" selected></option>';
    html += '<option value="pmhe">pmhe</option>';
    html += '<option value="robc">robc</option>';
    html += '<option value="loam">loam</option>';
    html += '<option value="jacl">jacl</option>';
    html += '<option value="joga">joga</option>';
    html += '<option value="reca">reca</option>';
    html += '<option value="vive">vive</option>';
  html += '</select>';
  $("#divshared").html(html);
}

function resetFumType(){
  var html = "";
  html = '<div class="col-md-3 col-sm-3 col-xs-12"><div class="row">FUM Type</div></div>';
    html += '<div class="col-md-9 col-sm-9 col-xs-12">';
      html += '<div class="row">';
        html += '<input type="radio" id="rFumTypen" name="rFumType" value="n" checked /> New &nbsp; ';
        html += '<input type="radio" id="rFumTypee" name="rFumType" value="e" /> Exist';
      html += '</div>';
    html += '</div>';
  $("#divFumType").html(html);
}

function chkCltProstExist(uid,etag){
  var url = getAPIURL() + 'clientprospect.php';
  var f = "chkCltProstExist";

  $.ajax({
    type: 'POST',
    url: url,
    data: JSON.stringify({ "data":data }),
    dataType: 'json'
    ,success: function(data){
      $.unblockUI();
    }
    ,error: function(request, status, err){

    }
  });
}

function saveProst(){
  var url = getAPIURL() + 'clientprospect.php';
  var f = "saveCltProst";
  var abauser = $("#userid").val();
  var assignedto = abauser;
  var uid = $("#uid").val();
  var etag = $("#etag").val();
  var leadid = "";
  var title = $("#txtTitle").val() == "" || $("#txtTitle").val() == null ? "" : $("#txtTitle").val();
  var fn = $("#txtFname").val() == "" || $("#txtFname").val() == null ? "" : $("#txtFname").val();
  var ln = $("#txtLname").val() == "" || $("#txtLname").val() == null ? "" : $("#txtLname").val();
  var mn = $("#txtMname").val() == "" || $("#txtMname").val() == null ? "" : $("#txtMname").val();
  var cnn = $("#txtCname").val() == "" || $("#txtCname").val() == null ? "" : $("#txtCname").val();
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
  var shared = $("#txtSharedx").val() == "" || $("#txtSharedx").val() == null ? "" : $("#txtSharedx").val();
  var gal1 = $("#txtIntroduced").val() == "" || $("#txtIntroduced").val() == null ? "" : $("#txtIntroduced").val();
  var gal2 = tinyMCE.get('txtCompanyLink').getContent();
  var gal3 = $("#txtBroker").val() == "" || $("#txtBroker").val() == null ? "" : $("#txtBroker").val();
  var gal4 = $("#txtpplInvolved").val() == "" || $("#txtpplInvolved").val() == null ? "" : $("#txtpplInvolved").val();
  var gal5 = $("#txtGalInfoRemarks").val() == "" || $("#txtGalInfoRemarks").val() == null ? "" : $("#txtGalInfoRemarks").val();
  var fumlink = $("#txtFumLink").val() == "" || $("#txtFumLink").val() == null ? "" : $("#txtFumLink").val();
  var userid = $("#userid").val();
  var ini = $("#txtini").val();
  var salesofc = $("#txtSalesOfc").val() == "" || $("#txtSalesOfc").val() == null ? "" : $("#txtSalesOfc").val();

  var galinfoscnt = $("#galInfoItemsCnt").val();
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
  
  // var galinfos = { "cnt":galinfoscnt, "items":galinfoitems };
  var data = { "f": f, "abauser":abauser, "assignedto":assignedto, "userid":userid, "ini":ini, "leadid":leadid,
              "uid":uid, "etag":etag, "title":title, "firstname":fn, "lastname":ln, "middlename":mn, "chinesename":cnn, "birthdate":bdt, "gender":gender, 
              "companyname":comp, "jobtitle":jt, "eaddr":eaddr, "homphno":homphno, "mobphno":mobphno, "addr":addr, "nationality":nat, "ethnicity":eth, 
              "businesstype":businesstype, "affinity":aff, "recomby":recomby, "recomname":recomname, "abainiofc":abainiofc, "introducer":intro, "shared":shared, 
              "fumlink":fumlink, "galinfo1":gal1, "galinfo2":gal2, "galinfo3":gal3, "galinfo4":gal4, "galinfo5":gal5 , "galinfos":galinfoitems , "salesofc":salesofc 
            };
 // console.log(data);
  // console.log(url);
  // return false;

  $.ajax({
    type: 'POST',
    url: url,
    data: JSON.stringify({ "data":data }),
    dataType: 'json'
    ,success: function(data){
      console.log(data);
      // return false;
      id = data['acct']['sesid'];
      // clearCltProstFields();
      // $("#frmCtcDtls").modal("hide");
       window.location = "cdm.php?id="+id;
      // $.unblockUI();

    
    }
    ,error: function(request, status, err){

    }
  });
}