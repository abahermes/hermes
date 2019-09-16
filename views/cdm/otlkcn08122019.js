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

        if( $("#txtAddress").val() == "" ){
          alert("Address is required! Please enter prospect address.");
          $("#txtAddress").focus();
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

  

  // ----------------------------------------------  DEFAULT -------------------------------------------------------------------------------

  // Check for browser support for sessionStorage
  if (typeof(Storage) === 'undefined') {
    render('#unsupportedbrowser');
    return;
  }

  // App configuration
  var authEndpoint = 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize?';
  // var redirectUri = 'http://localhost:81/jsotlkctcs/';
  // --- LIVE ---
  // var appId = '5c3bcb0d-e112-4c30-b324-730d1a0be625';
  // var redirectUri = 'https://www.abacare.com/jsotlkctcs/';
  // --- end LIVE ---
  // --- LOCAL ---
  var appId = otlk()['appid'];
  var redirectUri = otlk()['redirecturi'];
  // --- end LOCAL ---
  // var appId = '463971e5-6401-4a7c-9e77-d2e6e05c0ae5';
  // var scopes = 'openid profile User.Read Mail.Read Calendars.Read Contacts.Read';
  var scopes = 'openid profile User.Read Contacts.Read';

  // Check for browser support for crypto.getRandomValues
  var cryptObj = window.crypto || window.msCrypto; // For IE11
  if (cryptObj === undefined || cryptObj.getRandomValues === 'undefined') {
    render('#unsupportedbrowser');
    return;
  }

  render(window.location.hash);

  $(window).on('hashchange', function() {
    render(window.location.hash);
  });

  $("#sync-button").on("click", function(){
    alert("Development on going.");
    return false;
  })

  function render(hash) {

    var action = hash.split('=')[0];

    // Hide everything
    $('.main-container .page').hide();

    // var isAuthenticated = false;
    // Check for presence of access token
    var isAuthenticated = (sessionStorage.accessToken != null && sessionStorage.accessToken.length > 0);
    renderNav(isAuthenticated);
    renderTokens();

    var pagemap = {

      // Welcome page
      '': function() {
        // renderWelcome(isAuthenticated);
      },

      // Receive access token
      '#access_token': function() {
        handleTokenResponse(hash);             
      },

      // Signout
      '#signout': function () {
        clearUserState();

        // Redirect to home page
        window.location.hash = '#';
      },

      // Error display
      '#error': function () {
        var errorresponse = parseHashParams(hash);
        if (errorresponse.error === 'login_required' ||
            errorresponse.error === 'interaction_required') {
          // For these errors redirect the browser to the login
          // page.
          window.location = buildAuthUrl();
        } else {
          renderError(errorresponse.error, errorresponse.error_description);
        }
      },

      // Display inbox
      '#inbox': function () {
        if (isAuthenticated) {
          renderInbox();  
        } else {
          // Redirect to home page
          window.location.hash = '#';
        }
      },

      // Display calendar
      '#calendar': function () {
        if (isAuthenticated) {
          renderCalendar();  
        } else {
          // Redirect to home page
          window.location.hash = '#';
        }
      },

      // Display contacts
      '#contacts': function () {
        if (isAuthenticated) {
          renderContacts();  
        } else {
          // Redirect to home page
          window.location.hash = '#';
        }
      },

      // Shown if browser doesn't support session storage
      '#unsupportedbrowser': function () {
        $('#unsupported').show();
      }
    }

    if (pagemap[action]){
      pagemap[action]();
    } else {
      // Redirect to home page
      window.location.hash = '#';
    }
  }

  function setActiveNav(navId) {
    $('#navbar').find('li').removeClass('active');
    $(navId).addClass('active');
  }

  function renderNav(isAuthed) {
    if (isAuthed) {
      $('.authed-nav').show();
    } else {
      $('.authed-nav').hide();
    }
  }

  function renderTokens() {
    if (sessionStorage.accessToken) {
      // For demo purposes display the token and expiration
      var expireDate = new Date(parseInt(sessionStorage.tokenExpires));
      $('#token', window.parent.document).text(sessionStorage.accessToken);
      $('#expires-display', window.parent.document).text(expireDate.toLocaleDateString() + ' ' + expireDate.toLocaleTimeString());
      if (sessionStorage.idToken) {
        $('#id-token', window.parent.document).text(sessionStorage.idToken);
      }
      $('#token-display', window.parent.document).show();
    } else {
      $('#token-display', window.parent.document).hide();
    }
  }

  function renderError(error, description) {
    $('#error-name', window.parent.document).text('An error occurred: ' + decodePlusEscaped(error));
    $('#error-desc', window.parent.document).text(decodePlusEscaped(description));
    $('#error-display', window.parent.document).show();
  }

  function renderWelcome(isAuthed) {
    // console.log(isAuthed);
    if (isAuthed) {
      $('#username').text(sessionStorage.userDisplayName);
      // $('#logged-in-welcome').show();
      $("#connect-button").hide();
      $("#sync-button").show();
      // setActiveNav('#home-nav');
      $.blockUI({ 
        message: $('#preloader_image'), 
        fadeIn: 1000, 
        onBlock: function() {
          renderContacts();
        }
      });
    } else {
      $("#connect-button").show();
      $("#sync-button").hide();
      $('#connect-button').attr('href', buildAuthUrl());
      $('#signin-prompt').show();
    }
  }

  function renderInbox() {
    setActiveNav('#inbox-nav');
    $('#inbox-status').text('Loading...');
    $('#message-list').empty();
    $('#inbox').show();

    getUserInboxMessages(function(messages, error){
      if (error) {
        renderError('getUserInboxMessages failed', error);
      } else {
        $('#inbox-status').text('Here are the 10 most recent messages in your inbox.');
        var templateSource = $('#msg-list-template').html();
        var template = Handlebars.compile(templateSource);

        var msgList = template({messages: messages});
        $('#message-list').append(msgList);
      }
    });
  }

  // OAUTH FUNCTIONS =============================
  function buildAuthUrl() {
    // Generate random values for state and nonce
    sessionStorage.authState = guid();
    sessionStorage.authNonce = guid();

    var authParams = {
      response_type: 'id_token token',
      client_id: appId,
      redirect_uri: redirectUri,
      scope: scopes,
      state: sessionStorage.authState,
      nonce: sessionStorage.authNonce,
      response_mode: 'fragment'
    };

    return authEndpoint + $.param(authParams);
  }

  function handleTokenResponse(hash) {
    // If this was a silent request remove the iframe
    $('#auth-iframe').remove();

    // clear tokens
    sessionStorage.removeItem('accessToken');
    sessionStorage.removeItem('idToken');

    var tokenresponse = parseHashParams(hash);

    // Check that state is what we sent in sign in request
    if (tokenresponse.state != sessionStorage.authState) {
      sessionStorage.removeItem('authState');
      sessionStorage.removeItem('authNonce');
      // Report error
      window.location.hash = '#error=Invalid+state&error_description=The+state+in+the+authorization+response+did+not+match+the+expected+value.+Please+try+signing+in+again.';
      return;
    }

    sessionStorage.authState = '';
    sessionStorage.accessToken = tokenresponse.access_token;

    // Get the number of seconds the token is valid for,
    // Subract 5 minutes (300 sec) to account for differences in clock settings
    // Convert to milliseconds
    var expiresin = (parseInt(tokenresponse.expires_in) - 300) * 1000;
    var now = new Date();
    var expireDate = new Date(now.getTime() + expiresin);
    sessionStorage.tokenExpires = expireDate.getTime();

    sessionStorage.idToken = tokenresponse.id_token;

    // Redirect to home page
    validateIdToken(function(isValid) {
      if (isValid) {
        // Re-render token to handle refresh
        renderTokens();

        // Redirect to home page
        window.location.hash = '#';
      } else {
        clearUserState();
        // Report error
        window.location.hash = '#error=Invalid+ID+token&error_description=ID+token+failed+validation,+please+try+signing+in+again.';
      }
    });
  }

  function validateIdToken(callback) {
    // Per Azure docs (and OpenID spec), we MUST validate
    // the ID token before using it. However, full validation
    // of the signature currently requires a server-side component
    // to fetch the public signing keys from Azure. This sample will
    // skip that part (technically violating the OpenID spec) and do
    // minimal validation

    if (null == sessionStorage.idToken || sessionStorage.idToken.length <= 0) {
      callback(false);
    }

    // JWT is in three parts seperated by '.'
    var tokenParts = sessionStorage.idToken.split('.');
    if (tokenParts.length != 3){
      callback(false);
    }

    // Parse the token parts
    var header = KJUR.jws.JWS.readSafeJSONString(b64utoutf8(tokenParts[0]));
    var payload = KJUR.jws.JWS.readSafeJSONString(b64utoutf8(tokenParts[1]));

    // Check the nonce
    if (payload.nonce != sessionStorage.authNonce) {
      sessionStorage.authNonce = '';
      callback(false);
    }

    sessionStorage.authNonce = '';

    // Check the audience
    if (payload.aud != appId) {
      callback(false);
    }

    // Check the issuer
    // Should be https://login.microsoftonline.com/{tenantid}/v2.0
    if (payload.iss !== 'https://login.microsoftonline.com/' + payload.tid + '/v2.0') {
      callback(false);
    }

    // Check the valid dates
    var now = new Date();
    // To allow for slight inconsistencies in system clocks, adjust by 5 minutes
    var notBefore = new Date((payload.nbf - 300) * 1000);
    var expires = new Date((payload.exp + 300) * 1000);
    if (now < notBefore || now > expires) {
      callback(false);
    }

    // Now that we've passed our checks, save the bits of data
    // we need from the token.

    sessionStorage.userDisplayName = payload.name;
    sessionStorage.userSigninName = payload.preferred_username;

    // Per the docs at:
    // https://azure.microsoft.com/en-us/documentation/articles/active-directory-v2-protocols-implicit/#send-the-sign-in-request
    // Check if this is a consumer account so we can set domain_hint properly
    sessionStorage.userDomainType = 
      payload.tid === '9188040d-6c67-4c5b-b112-36a304b66dad' ? 'consumers' : 'organizations';

    callback(true);
  }

  function makeSilentTokenRequest(callback) {
    // Build up a hidden iframe
    var iframe = $('<iframe/>');
    iframe.attr('id', 'auth-iframe');
    iframe.attr('name', 'auth-iframe');
    iframe.appendTo('body');
    iframe.hide();

    iframe.load(function() {
      callback(sessionStorage.accessToken);
    });

    iframe.attr('src', buildAuthUrl() + '&prompt=none&domain_hint=' + 
      sessionStorage.userDomainType + '&login_hint=' + 
      sessionStorage.userSigninName);
  }

  // Helper method to validate token and refresh
  // if needed
  function getAccessToken(callback) {
    var now = new Date().getTime();
    var isExpired = now > parseInt(sessionStorage.tokenExpires);
    // Do we have a token already?
    if (sessionStorage.accessToken && !isExpired) {
      // Just return what we have
      if (callback) {
        callback(sessionStorage.accessToken);
      }
    } else {
      // Attempt to do a hidden iframe request
      makeSilentTokenRequest(callback);
    }
  }

  // OUTLOOK API FUNCTIONS =======================
  function getUserInboxMessages(callback) {
    getAccessToken(function(accessToken) {
      if (accessToken) {
        // Create a Graph client
        var client = MicrosoftGraph.Client.init({
          authProvider: (done) => {
            // Just return the token
            done(null, accessToken);
          }
        });

        // Get the 10 newest messages
        client
          .api('/me/mailfolders/inbox/messages')
          .top(10)
          .select('subject,from,receivedDateTime,bodyPreview')
          .orderby('receivedDateTime DESC')
          .get((err, res) => {
            if (err) {
              callback(null, err);
            } else {
              callback(res.value);
            }
          });
      } else {
        var error = { responseText: 'Could not retrieve access token' };
        callback(null, error);
      }
    });
  }

  // HELPER FUNCTIONS ============================
  function guid() {
    var buf = new Uint16Array(8);
    cryptObj.getRandomValues(buf);
    function s4(num) {
      var ret = num.toString(16);
      while (ret.length < 4) {
        ret = '0' + ret;
      }
      return ret;
    }
    return s4(buf[0]) + s4(buf[1]) + '-' + s4(buf[2]) + '-' + s4(buf[3]) + '-' +
      s4(buf[4]) + '-' + s4(buf[5]) + s4(buf[6]) + s4(buf[7]);
  }

  function parseHashParams(hash) {
    var params = hash.slice(1).split('&');

    var paramarray = {};
    params.forEach(function(param) {
      param = param.split('=');
      paramarray[param[0]] = param[1];
    });

    return paramarray;
  }

  function decodePlusEscaped(value) {
    // decodeURIComponent doesn't handle spaces escaped
    // as '+'
    if (value) {
      // return decodeURIComponent(value.replace(/\+/g, ' '));
      return decodeURIComponent(value);
    } else {
      return '';
    }
  }

  function clearUserState() {
    // Clear session
    sessionStorage.clear();
  }

  // Handlebars.registerHelper("formatDate", function(datetime){
  //   // Dates from API look like:
  //   // 2016-06-27T14:06:13Z

  //   var date = new Date(datetime);
  //   return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
  // });

  function renderCalendar() {
    setActiveNav('#calendar-nav');
    $('#calendar-status').text('Loading...');
    $('#event-list').empty();
    $('#calendar').show();

    getUserEvents(function(events, error){
      if (error) {
        renderError('getUserEvents failed', error);
      } else {
        $('#calendar-status').text('Here are the 10 most recently created events on your calendar.');
        var templateSource = $('#event-list-template').html();
        var template = Handlebars.compile(templateSource);

        var eventList = template({events: events});
        $('#event-list').append(eventList);
      }
    });
  }

  function getUserEvents(callback) {
    getAccessToken(function(accessToken) {
      if (accessToken) {
        // Create a Graph client
        var client = MicrosoftGraph.Client.init({
          authProvider: (done) => {
            // Just return the token
            done(null, accessToken);
          }
        });

        // Get the 10 newest events
        client
          .api('/me/events')
          .top(10)
          .select('subject,start,end,createdDateTime')
          .orderby('createdDateTime DESC')
          .get((err, res) => {
            if (err) {
              callback(null, err);
            } else {
              callback(res.value);
            }
          });
      } else {
        var error = { responseText: 'Could not retrieve access token' };
        callback(null, error);
      }
    });
  }

  function renderContacts() {
    // setActiveNav('#contacts-nav');
    // $('#contacts-status').text('Loading...');
    // $('#contact-list').empty();
    // $('#contacts').show();

    getUserContacts(function(contacts, error){
      if (error) {
        renderError('getUserContacts failed', error);
      } else {
        // $('#contacts-status').text('Here are your first 10 contacts.');
        // $('#contacts-status').text('Here are your list of contacts.');
        // var templateSource = $('#contact-list-template').html();
        // var template = Handlebars.compile(templateSource);

        // var contactList = template({contacts: contacts});
        // $('#contact-list').append(contactList);
        var url = getAPIURL() + 'clientprospect.php';
        var f = "loadDefault";

        var data = { "f":f };

        $.ajax({
          type: 'POST',
          url: url,
          data: JSON.stringify({ "data":data }),
          dataType: 'json'
          ,success: function(data){
            // console.log(data);
            var ees = data['ees'];
            var nats = data['nats']['rows'];
            var eths = data['eths']['rows'];
            var titles = data['titles'];
            // console.log(nats);
            var abainiofchtml = "";
            var sharehtml = "";
            var eename = "";
            var nathtml = "";
            var ethhtml = "";
            var titleshtml = "";

            titleshtml = '<label>Title</label>';
            titleshtml += '<select class="form-control" id="txtTitle" name="txtTitle">';
              titleshtml += '<option value="" selected></option>';
              for(var i=0;i<titles.length;i++){
                titleshtml += '<option value="'+ titles[i]['ddid'] +'">'+ titles[i]['dddescription'] +'</option>';
              }
            titleshtml += '</select>';
            // titleshtml += '<datalist id="dataLstTitles">';
            //   for(var i=0;i<titles.length;i++){
            //     titleshtml += '<option value="'+ titles[i]['ddid'] +'"></option>';
            //   }
            // titleshtml += '</datalist>';
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
            // $("#txtEthnicity").select2();

            sharehtml = '<label>Shared</label>';
            sharehtml += '<select class="form-control" id="txtShared" name="txtShared">';
              sharehtml += '<option value="" selected></option>';
              for(var i=0;i<ees.length;i++){
                eename = ees[i]['fname'] +' '+ ees[i]['lname'];
                sharehtml += '<option value="'+ ees[i]['abaini'] +'">'+ eename +'</option>';
              }
            sharehtml += '</select>';
            $("#divshared").html(sharehtml);
          }
          ,error: function(request, status, err){
            // console.log(request);
            // console.log(status);
            // console.log(err);
          }
        });
        // return false;
        renderCltProstTbl(contacts);
      }
    });
  }

  function getUserContacts(callback) {
    getAccessToken(function(accessToken) {
      if (accessToken) {
        // Create a Graph client
        var client = MicrosoftGraph.Client.init({
          authProvider: (done) => {
            // Just return the token
            done(null, accessToken);
          }
        });

        // Get the first 10 contacts in alphabetical order
        // by given name
        client
          .api('/me/contacts')
          // .api('/me/contacts/')
          .top(1000)
          // .select('givenName,surname,jobTitle,businessAddress,businessHomePage,businessPhones,companyName,displayName,emailAddresses,generation,givenName,initials,middleName,mobilePhone,surname,title')
          .select('*')
          .orderby('givenName ASC')
          .get((err, res) => {
            if (err) {
              callback(null, err);
            } else {
              console.log(res.value);
              callback(res.value);
            }
          });
      } else {
        var error = { responseText: 'Could not retrieve access token' };
        callback(null, error);
      }
    });
  }
});

// ----------------------------------------------------  ADDITIONAL FUNCTIONS CREATED  ---------------------------------------------------- 

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
        street = data[i]['businessAddress']['street'] == "" ? "" : data[i]['businessAddress']['street'];
        street = street == undefined ? "" : street;
        city = data[i]['businessAddress']['city'] || data[i]['businessAddress']['city'] != "" ? data[i]['businessAddress']['city'] : "";
        city = city == undefined ? "" : city;
        state = data[i]['businessAddress']['state'] == "" ? "" : data[i]['businessAddress']['state'];
        state = state == undefined ? "" : state;
        countryOrRegion = data[i]['businessAddress']['countryOrRegion'] == "" ? "" : data[i]['businessAddress']['countryOrRegion'];
        countryOrRegion = countryOrRegion == undefined ? "" : countryOrRegion;
        address = street +' '+ city +' '+ state +' '+ countryOrRegion; // business address
        address = address.replace(/'/g,"");
        address = address.replace(/(\r\n|\n|\r)/gm, "");
        jobtitle = data[i]['jobTitle'] == null ? "" : data[i]['jobTitle'];

        id = "'" + data[i]['id'] + "'";
        param = data[i]['id'] +'::';
        param += data[i]['title'] +'::'; // salutation
        param += data[i]['givenName'] +'::'; // first name
        param += data[i]['surname'] +'::'; // last name
        param += data[i]['middleName'] +'::'; // middle name
        param += data[i]['generation'] +'::'; // suffix or CN name
        param += data[i]['companyName'] +'::'; // company name
        param += address +'::';
        param += data[i]['businessPhones'] +'::'; // business phone no
        param += data[i]['mobilePhone'] +'::'; // mobile phone no
        param += data[i]['emailAddresses'][0]['address'] +'::'; // business email address
        param += jobtitle +'::'; // job title
        etag = data[i]['@odata.etag']; // etag
        param += etag.replace(/"/g,'');
        param = "'"+ param +"'";

        html += '<tr onClick="return createPipeline('+ param +');" data-toggle="modal" data-target="#frmCtcDtls" style="cursor: pointer;">';
          html += '<td class="text-center">'+ cnt +'</td>';
          html += '<td>'+ data[i]['displayName'] +'</td>';
          html += '<td>'+ jobtitle +'</td>';
          html += '<td>'+ data[i]['companyName'] +'</td>';
          html += '<td>'+ data[i]['emailAddresses'][0]['address'] +'</td>';
          html += '<td>'+ data[i]['businessPhones'] +'</td>';
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

function createPipeline(data){
  var prost = [];
  prost = data.split('::');
  // console.log(prost);

  var uid = prost[0];
  var title = prost[1];
  var fn = prost[2];
  var ln = prost[3];
  var mn = prost[4] == "" || prost[4] == null || prost[4] == 'null' ? "" : prost[4];
  var cnn = prost[5] == "" || prost[5] == null || prost[5] == 'null' ? "" : prost[5];
  var comp = prost[6] != "" ? prost[6] : "";
  var addr =  prost[7] != "" ? prost[7] : "";
  var homphno = prost[8] != "" ? prost[8] : "";
  var mobphno = prost[9] != "" ? prost[9] : "";
  var eaddr = prost[10] != "" ? prost[10] : "";
  var jt = prost[11] != "" ? prost[11] : "";
  var etag = prost[12];
  var cltfld = "";
  var cltfum = "";

  if(title != ""){
    var titlehtml = "";
    var selectmr = "";
    var selectmrs = "";
    var selectms = "";
    var selectmiss = "";

    switch(title.toLowerCase()){
      case "mr": case "mr.":
          selectmr = 'selected';
        break;
      case "mrs": case "mrs.":
          selectmrs = 'selected';
        break;
      case "ms": case "ms.":
          selectms = 'selected';
        break;
      case "miss": case "miss.":
          selectmiss = 'selected';
        break;
      default: break;
    }
    
    titlehtml = '<select class="form-control" id="txtTitle" name="txtTitle">';
      titlehtml += '<option value=""></option>';
      titlehtml += '<option value="Mr." '+ selectmr +'>Mr.</option>';
      titlehtml += '<option value="Mrs." '+ selectmrs +'>Mrs.</option>';
      titlehtml += '<option value="Ms." '+ selectms +'>Ms.</option>';
      titlehtml += '<option value="Miss" '+ selectmiss +'>Miss.</option>';
    titlehtml += '</select>';
    $("#dataTitle").html(titlehtml);
  }

  if(comp == ""){
    $("#rBusinessTypec").attr("checked",false);
    $("#rBusinessTypec").attr("disabled",true);
  }
  $("#rFumTypen").attr("checked",true);

  $("#uid").val(uid);
  $("#etag").val(etag);
  $("#txtFname").val(UCFirst(fn));
  $("#txtMname").val(mn);
  $("#txtLname").val(ln.toUpperCase());
  $("#txtCname").val(cnn);
  $("#txtCompany").val(comp);
  $("#txtJobTitle").val(jt);

  cltfld = ln.toUpperCase() +' '+ UCFirst(fn);
  cltfum = '01 fumclt '+ cltfld +'.docx';
  $("#txtCltProstFld").val(cltfld);
  $("#txtCltProstName").val(cltfum);
  
  $("#reqEAddr,#reqHomPh,#reqMobPh").show();
  if( eaddr != "" || homphno != "" || mobphno != "" ){
    $("#reqEAddr,#reqHomPh,#reqMobPh").hide();
  }

  $("#txtEmailAddress").val(eaddr);
  $("#txtHomPhoneNo").val(homphno);
  $("#txtMobPhoneNo").val(mobphno);
  $("#txtAddress").val(addr);

  // chk clt prost here
  // $.blockUI({ 
  //   message: $('#preloader_image'), 
  //   fadeIn: 1000, 
  //   onBlock: function() {
  //     chkCltProstExist(uid,etag);
  //   }
  // });

//  $('html').css('overflow','hidden');
//  $("#frmCtcDtls").css('zIndex',1040);
//  $("#frmCtcDtls").dialog({
//      autoOpen: true,
//      draggable: false,
//      width: 500,
//      modal: true,
//      title: "Prospect Details",
//      close: function(){
//          $('html').css('overflow','auto');
//          clearCltProstFields();
//          $("#btnStep1,#btnStep3,#btnStep4,#btnSaveCtcDtls,#secondstep,#thirdstep,#fourthstep,#divFumExist").hide();
//          $("#btnStep2,#firststep,#divFumNew").show();
//          $(this).dialog("close");
//      }
//  });
  // var title = prost[0];
  
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
  var data = { "f": f, "abauser":abauser, "assignedto":assignedto, "userid":userid, "ini":ini,
              "uid":uid, "etag":etag, "title":title, "firstname":fn, "lastname":ln, "middlename":mn, "chinesename":cnn, "birthdate":bdt, "gender":gender, 
              "companyname":comp, "jobtitle":jt, "eaddr":eaddr, "homphno":homphno, "mobphno":mobphno, "addr":addr, "nationality":nat, "ethnicity":eth, 
              "businesstype":businesstype, "affinity":aff, "recomby":recomby, "recomname":recomname, "abainiofc":abainiofc, "introducer":intro, "shared":shared, 
              "fumlink":fumlink, "galinfo1":gal1, "galinfo2":gal2, "galinfo3":gal3, "galinfo4":gal4, "galinfo5":gal5 , "galinfos":galinfoitems 
            };
  // console.log(data);
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