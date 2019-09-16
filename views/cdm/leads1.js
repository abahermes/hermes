$(function() {
  var dt = new Date();
  $("#txtBirthDate").datepicker({
    maxDate: -1,
    dateFormat: "D d M y",
    changeMonth: true,
    changeYear: true,
    yearRange: "1900:2020"
  });

  // step 1 button clicked
  $("#btnStep1").on("click", function(){
    if( $("#txtini").val() == "" ){
      alert("Initials is required! Please enter initials.");
      $("#txtini").focus();
      return false;
    }
    $("#btnStep1,#btnStep3,#secondstep").hide();
    $("#btnStep2,#firststep").show();
    $("#btnStep2").val("Next");
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
         if( $("#txtini").val() == "" ){
              alert("Initials is required! Please enter initials.");
              $("#txtini").focus();
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
          // $("#txtLname").focus();
          return false;
        }

        // if( $("#txtHomPhoneNo").val() == "" ){
        //   alert("Home Phone no is required! Please enter phone no.");
        //   $("#txtHomPhoneNo").focus();
        //   return false;
        // }

        // if( $("#txtMobPhoneNo").val() == "" ){
        //   alert("Mobile phone no is required! Please enter phone no.");
        //   $("#txtMobPhoneNo").focus();
        //   return false;
        // }

        // if( $("#txtAddress").val() == "" ){
        //   alert("Address is required! Please enter prospect address.");
        //   $("#txtAddress").focus();
        //   return false;
        // }

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
      $("#btnOthGalInfo").hide();
  });

  $("#btnNewGalInfo").on("click", function(){
     if( $("#txtFumLink").val() == "" ){
          alert("FUM Link by is required! Please enter link.");
          $("#txtRecomBy").focus();
          return false;
        }
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
         if( $("#txtFumLink").val() == "" ){
          alert("FUM Link by is required! Please enter link.");
          $("#txtRecomBy").focus();
          return false;
        }
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
         if( $("#txtFumLink").val() == "" ){
          alert("FUM Link by is required! Please enter link.");
          $("#txtRecomBy").focus();
          return false;
        }
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

  $("#btnYes").on("click", function(){
    $("#otlk2ndstep,#btnYes1,#btnNo1").show();
    $("#otlk1ststep,#btnYes,#btnNo").hide();
    // $("#frmpopupmsg").modal('show');
  });

  $.blockUI({ 
    message: $('#preloader_image'), 
    fadeIn: 1000, 
    onBlock: function() {
      renderContacts();
    }
  });

});

// ----------------------------------------------------  ADDITIONAL FUNCTIONS CREATED  ---------------------------------------------------- 

function renderContacts() {
  var url = getAPIURL() + 'leads.php';
  var f = "loadDefault";
  var userid = $("#userid").val();

  var data = { "f":f, "userid":userid };
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
      
      var ees = data['ees'];
      var affs = data['affs'];
      var nats = data['nats']['rows'];
      var eths = data['eths']['rows'];
      var titles = data['titles'];
      var leads = data['leads']['rows'];
      var leadscnt = leads.length;
      // if(leadscnts == 0){
      //   $("#btnImport").show();
      // }
      // console.log(nats);
      var abainiofchtml = "";
      var eename = "";
      var nathtml = "";
      var titleshtml = "";

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
          abainiofchtml += '<option value="'+ ees[i]['abaini'] +'">'+ eename +'</option>';
        }
      abainiofchtml += '</select>';
      $("#divabainiofc").html(abainiofchtml);

      nathtml = '<label>Nationality</label>';
      nathtml += '<select class="form-control" id="txtNationality" name="txtNationality">';
      nathtml += '<option value=""></option>';
        for(var i=0;i<nats.length;i++){
          nathtml += '<option value="'+ nats[i]['nationalityid'] +'">'+ nats[i]['description'] +'</option>';
        }
      nathtml += '</select>';
      $("#divNationality").html(nathtml);

      var ethhtml = "";
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

      var affhtml = "";
      affhtml = '<label>Affinity <span class="text-red">*</span></label>';
      affhtml += '<select class="form-control" id="txtAffinityName" name="txtAffinityName">';
        for(var i=0;i<affs.length;i++){
          affhtml += '<option value="'+ affs[i]['ddid'] +'">'+ affs[i]['dddescription'] +'</option>';
        }
      affhtml += '</select>';
      $("#divAff").html(affhtml);

      // $.unblockUI();
      if(leadscnt > 0){
        renderCltProstTbl(leads);
        
      }else{
        $.unblockUI();
        $("#frmpopupmsg").modal('show');
      }
    }
    ,error: function(request, status, err){
      // console.log(request);
      // console.log(status);
      // console.log(err);
    }
  });
}

function renderCltProstTbl(data){
  var html = "";
  var cnt = 1;
  var rownum = "";
  var address = "";
  var id = "";
  var param = "";
  var etag = "";
  var address = "";
  var street = "";
  var city = ""
  var state = "";
  var countryOrRegion = "";
  var leadid = "";
  var name = "";
  // console.log(data);
  // return false;

  rownum += '<p><b>'+ data.length +'</b> Leads contact found</p>';
  html += '<table class="table table-striped jambo_table table-condensed table-hover table-bordered">';
    html += '<thead>';
      html += '<tr>';
        html += '<th width="3">#</th>';
        html += '<th width="20">Name</th>';
        html += '<th width="12">Job Title</th>';
        html += '<th width="20">Company</th>';
        html += '<th width="10">e-Address</th>';
        html += '<th width="10">Phone No</th>';
        html += '<th width="25">Address</th>';
      html += '</tr>';
    html += '</thead>';
    html += '<tbody>';
      
      for(var i=0; i<data.length;i++){
        street = data[i]['street'] == "" ? "" : data[i]['street'];
        street = street == undefined ? "" : street;
        city = data[i]['city'] || data[i]['city'] != "" ? data[i]['city'] : "";
        city = city == undefined ? "" : city;
        state = data[i]['state'] == "" ? "" : data[i]['state'];
        state = state == undefined ? "" : state;
        countryOrRegion = data[i]['countryorregion'] == "" ? "" : data[i]['countryorregion'];
        countryOrRegion = countryOrRegion == undefined ? "" : countryOrRegion;
        address = street +' '+ city +' '+ state +' '+ countryOrRegion; // business address
        address = address.replace(/'/g,"");
        address = address.replace(/(\r\n|\n|\r)/gm, "");
        jobtitle = data[i]['jobtitle'] == null ? "" : data[i]['jobtitle'];

        // id = "'" + data[i]['id'] + "'";
        // param = data[i]['id'] +'::';
        // param += data[i]['title'] +'::'; // salutation
        // param += data[i]['givenName'] +'::'; // first name
        // param += data[i]['surname'] +'::'; // last name
        // param += data[i]['middleName'] +'::'; // middle name
        // param += data[i]['generation'] +'::'; // suffix or CN name
        // param += data[i]['companyName'] +'::'; // company name
        // param += address +'::';
        // param += data[i]['businessPhones'] +'::'; // business phone no
        // param += data[i]['mobilePhone'] +'::'; // mobile phone no
        // param += data[i]['emailAddress'] +'::'; // business email address
        // param += jobtitle +'::'; // job title
        // etag = data[i]['etag']; // etag
        // param += etag.replace(/"/g,'');
        // param = "'"+ param +"'";
        leadid = "'"+ data[i]['leadid'] + "'";
        name = data[i]['firstname'] +' '+ data[i]['lastname'];


        html += '<tr onClick="return getLead('+ leadid +');" data-toggle="modal" data-target="#frmCtcDtls" style="cursor: pointer;">';
          html += '<td class="text-center">'+ cnt +'</td>';
          html += '<td>'+ name +'</td>';
          html += '<td>'+ jobtitle +'</td>';
          html += '<td>'+ data[i]['companyname'] +'</td>';
          html += '<td>'+ data[i]['emailaddress'] +'</td>';
          html += '<td>'+ data[i]['businessphoneno'] +'</td>';
          html += '<td>'+ address +'</td>';
        html += '</tr>';
        cnt++;
      }

    html += '</tbody>';
  html += '</table>';
  $("#contacts").html(html);
  $("#rownum").html(rownum);
  $.unblockUI();
}

function getLead(leadid){
  var url = getAPIURL() + 'leads.php';
  var f = "getLead";
  var userid = $("#userid").val();
  $("#leadid").val(leadid);

  var data = { "f":f, "userid":userid, "leadid":leadid };
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
          var lead = data['lead']['rows'][0];
          createPipeline(lead);
        }
        ,error: function(request, status, err){
          // console.log(request);
          // console.log(status);
          // console.log(err);
        }
      });
    }
  });
}

function createPipeline(data){
  // var prost = [];
  // prost = data.split('::');
  // console.log(data);
  // return false;

  var title = data['title'];
  var ln = data['lastname'];
  var comp = data['companyname'];
  var addr =  data['address'];
  var homphno = data['homephoneno'];
  var mobphno = data['mobilephoneno'];
  var eaddr = data['emailaddress'];
  // var jt = prost[11] != "" ? prost[11] : "";
  // var etag = prost[12];
  // var cltfld = "";
  // var cltfum = "";

  // if(title != ""){
  //   var titlehtml = "";
  //   var selectmr = "";
  //   var selectmrs = "";
  //   var selectms = "";
  //   var selectmiss = "";

  //   switch(title.toLowerCase()){
  //     case "mr": case "mr.":
  //         selectmr = 'selected';
  //       break;
  //     case "mrs": case "mrs.":
  //         selectmrs = 'selected';
  //       break;
  //     case "ms": case "ms.":
  //         selectms = 'selected';
  //       break;
  //     case "miss": case "miss.":
  //         selectmiss = 'selected';
  //       break;
  //     default: break;
  //   }
    
  //   titlehtml = '<select class="form-control" id="txtTitle" name="txtTitle">';
  //     titlehtml += '<option value=""></option>';
  //     titlehtml += '<option value="Mr." '+ selectmr +'>Mr.</option>';
  //     titlehtml += '<option value="Mrs." '+ selectmrs +'>Mrs.</option>';
  //     titlehtml += '<option value="Ms." '+ selectms +'>Ms.</option>';
  //     titlehtml += '<option value="Miss" '+ selectmiss +'>Miss.</option>';
  //   titlehtml += '</select>';
  //   $("#dataTitle").html(titlehtml);
  // }

  if(comp == ""){
    $("#rBusinessTypec").attr("checked",false);
    $("#rBusinessTypec").attr("disabled",true);
  }
  // $("#rFumTypen").attr("checked",true);

  $("#txtTitle option[value='"+ title +"']").prop('selected',true);
  // $("#uid").val(uid);
  // $("#etag").val(etag);
  $("#txtFname").val(data['firstname']);
  $("#txtMname").val(data['middlename']);
  $("#txtLname").val(ln);
  $("#txtCname").val(data['chinesename']);
  $("#txtCompany").val(data['companyname']);
  $("#txtJobTitle").val(data['jobtitle']);
  
  $("#reqEAddr,#reqHomPh,#reqMobPh").show();
  if( eaddr != "" || homphno != "" || mobphno != "" ){
    $("#reqEAddr,#reqHomPh,#reqMobPh").hide();
  }

  $("#txtEmailAddress").val(eaddr);
  $("#txtHomPhoneNo").val(homphno);
  $("#txtMobPhoneNo").val(mobphno);
  $("#txtAddress").val(addr);

  $.unblockUI();
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

function chkCltProstFields(){
  if( $("#txtFname").val() == "" ){
    alert("Client/prospect data saving interupted! First name is required. Please enter prospect first name.");
    $("#txtFname").focus();
    return false;
  }
  if( $("#txtLname").val() == "" ){
    alert("Client/prospect data saving interupted! Last name is required. Please enter prospect last name.");
    $("#txtLname").focus();
    return false;
  }
  if( $("#txtEmailAddress").val() == "" && $("#txtHomPhoneNo").val() == "" && $("#txtMobPhoneNo").val() == "" ){
    alert("Client/prospect data saving interupted! One(1) of three(3) fields is required. Please enter either email address, home phone no or mobile phone no of prospect info.");
    // $("#txtLname").focus();
    return false;
  }

  if( $("#txtAddress").val() == "" ){
    alert("Client/prospect data saving interupted! Address is required. Please enter prospect address.");
    $("#txtAddress").focus();
    return false;
  }
}

function saveProst(){
  var url = getAPIURL() + 'clientprospect.php';
  var f = "saveCltProst";
  var abauser = $("#userid").val();
  var assignedto = abauser;
  var uid = $("#uid").val();
  var etag = $("#etag").val();
  var leadid = $("#leadid").val();
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
  var shared = $("#txtShared").val() == "" || $("#txtShared").val() == null ? "" : $("#txtShared").val();
  var gal1 = $("#txtIntroduced").val() == "" || $("#txtIntroduced").val() == null ? "" : $("#txtIntroduced").val();
  var gal2 = $("#txtCompanyLink").val() == "" || $("#txtCompanyLink").val() == null ? "" : $("#txtCompanyLink").val();
  var gal3 = $("#txtBroker").val() == "" || $("#txtBroker").val() == null ? "" : $("#txtBroker").val();
  var gal4 = $("#txtpplInvolved").val() == "" || $("#txtpplInvolved").val() == null ? "" : $("#txtpplInvolved").val();
  var gal5 = $("#txtGalInfoRemarks").val() == "" || $("#txtGalInfoRemarks").val() == null ? "" : $("#txtGalInfoRemarks").val();
  var fumlink = $("#txtFumLink").val() == "" || $("#txtFumLink").val() == null ? "" : $("#txtFumLink").val();
  var userid = $("#userid").val();
  var ini = $("#txtini").val();

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
              "fumlink":fumlink, "galinfo1":gal1, "galinfo2":gal2, "galinfo3":gal3, "galinfo4":gal4, "galinfo5":gal5 , "galinfos":galinfoitems 
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
      // console.log(data);
      // return false;
      id = data['acct']['sesid'];
      // clearCltProstFields();
      // $("#btnStep1,#btnStep3,#btnStep4,#btnSaveCtcDtls,#secondstep,#thirdstep,#fourthstep,#divFumExist").hide();
      // $("#btnStep2,#firststep,#divFumNew").show();
      // $("#frmCtcDtls").dialog("close");
      window.location = "cdm.php?id="+id;
    }
    ,error: function(request, status, err){

    }
  });
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