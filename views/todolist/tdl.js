$(function(){
	$("#tabs").tabs();
    $("#btnCancelTask").on("click", function(){
        var actid = $('#actid').val();
        if(actid != ""){
            window.location = "todolist.php";
        }
        $("#actid").val("");
    });

    $("#ttlduetoday").on("click", function(){
        var headerval = "duetoday";
        $("#headerclickval").val(headerval);
        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                filterSearch(headerval);
            }
        });
    });
    $("#ttloverdue").on("click", function(){
        var headerval = "overdue";
        $("#headerclickval").val(headerval);
        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                filterSearch(headerval);
            }
        });
    });
    $("#ttltaskpending").on("click", function(){
        var headerval = "taskpending";
        $("#headerclickval").val(headerval);
        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                filterSearch(headerval);
            }
        });
    });
	$("#txtPSD,#txtPFU,#txtStartDate,#txtNextCtcDt,#txtDueDate,#txtDateReplace").datepicker({
        // minDate: -6,
        dateFormat: "D d M y",
        changeMonth: true,
        changeYear: true
    });
    
    $("#txtNextCtcDt").change(function(){
		var duedate=$("#txtDueDate").val(); 
		var nextctcdate=$("#txtNextCtcDt").val();
		var duedt = new Date(duedate);
		var nextctcdt = new Date(nextctcdate);
		if (nextctcdt > duedt){
			alert("Next contact date should be less than or equal to Due date.");
            $("#txtDueDate").click();
            return false;
		}
	});
	$("#btnSearch").on("click", function(){
		SearchTask();
	});
	$("#btnSaveTask").on("click", function(){
		var tid = $("#activityid").val();
        var taskType = $("#txtTaskType").val();
        var task = $("#txtTask").val();
        var nextctcdate=$("#txtNextCtcDt").val();
        var duedate=$("#txtDueDate").val();

        if(taskType == ""){
            alert("Task type is required! Please select task type.");
            $("#txtTaskType").click();
            return false;
        }
        if(task == ""){
            alert("Task or to do is required! Please enter task.");
            $("#txtTask").focus();
            return false;
        }
        if(nextctcdate == ""){
            alert("Next contact date is required! Please enter date.");
            $("#txtTask").focus();
            return false;
        }
        if(duedate == ""){
            alert("Due date is required! Please enter date.");
            $("#txtTask").focus();
            return false;
        }
        $.blockUI({ 
          message: $('#preloader_image'), 
          fadeIn: 1000, 
          onBlock: function() {
          	saveNewTDl();
          }
        });
    });
    $("#btnUpdateTask").on("click", function(){
        var tid = $("#activityid").val();
        var taskType = $("#txtTaskType").val();
        var task = $("#txtTask").val();
        var nextctcdate=$("#txtNextCtcDt").val();
        var duedate=$("#txtDueDate").val();

        if(taskType == ""){
            alert("Task type is required! Please select task type.");
            $("#txtTaskType").click();
            return false;
        }
        if(task == ""){
            alert("Task or to do is required! Please enter task.");
            $("#txtTask").focus();
            return false;
        }
        if(nextctcdate == ""){
            alert("Next contact date is required! Please enter date.");
            $("#txtTask").focus();
            return false;
        }
        if(duedate == ""){
            alert("Due date is required! Please enter date.");
            $("#txtTask").focus();
            return false;
        }
        $.blockUI({ 
          message: $('#preloader_image'), 
          fadeIn: 1000, 
          onBlock: function() {
          	updateToDo();
          }
        });
    });

    $("#btnSave").on("click", function(){
        var cat = $("#txtCat").val();
        
        if(cat == ""){
            alert("Category is required! Please select or enter category.");
            $("#txtCat").click();
            return false;
        }
        
        $.blockUI({ 
          message: $('#preloader_image'), 
          fadeIn: 1000, 
          onBlock: function() {
            saveUsefullink();
          }
        });
    });

    $("#btnUpdate").on("click", function(){
        var cat = $("#txtCat").val();
        
        if(cat == ""){
            alert("Category is required! Please select or enter category.");
            $("#txtCat").click();
            return false;
        }
        
        $.blockUI({ 
          message: $('#preloader_image'), 
          fadeIn: 1000, 
          onBlock: function() {
            updateUsefullink();
          }
        });
    });
    $("#btnUpdateTaskDates").on("click", function(){
        var selectedfield = $('#txtField').val();
        var datereplace = $('#txtDateReplace').val();
        var result = $('input[name = "activityid"]:checked');
        var selecteddata = [];
        if(result.length>0){
            result.each(function(){
                selecteddata.push($(this).val());
            });
        } else {
            alert("You have not selected any items on the list. Please select before updating.");
            return false;
        }

        if(selectedfield == null){
            alert("Please select field to bulk update.");
            $("#txtField").focus();
            return false;
        }
        if(datereplace == ""){
            alert("Please date to replace.");
            $("#txtDateReplace").focus();
            return false;
        }

        $.blockUI({ 
          message: $('#preloader_image'), 
          fadeIn: 1000, 
          onBlock: function() {
            getSelectedTDL(selecteddata);
          }
        });
        
    });

	$.blockUI({ 
      message: $('#preloader_image'), 
      fadeIn: 1000, 
      onBlock: function() {
        getDefaultData();
      }
    });

});

function getOffice(){
	var url = getAPIURL() + 'todolist.php';
    var f = "getOfc"; 
    var abaini = $("#txtFuw").val();

    var data ={"f":f, "abaini":abaini};
    // console.log(data);
	$.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify({ "data":data }),
        dataType: 'json'
        ,success: function(data){
            // console.log(data);
            // return false;
            var ofcrow = data['ofcdesignation'][0];
            var ofc = ofcrow['webhr_station'];
            $("#txtOfc").val(ofc);
            // $("#frmTask").dialog("close");
            $.unblockUI();            
        }
        ,error: function(request, status, err){

        }
    });
}
    
function newUL(){
    $("#btnSave").show();
    $("#btnUpdate").hide();
}

function newTDL(){
	var datenow = new Date();
	datenow.setDate(datenow.getDate()+1);
	var startdate = $.datepicker.formatDate('D d M y', new Date());
    var nextctcdate = $.datepicker.formatDate('D d M y', datenow);
    var duedate = $.datepicker.formatDate('D d M y', datenow);
    var psd = $.datepicker.formatDate('D d M y', new Date());

    $("#txtStartDate").val(startdate);
   	$("#txtNextCtcDt").val(nextctcdate);
    $("#txtDueDate").val(duedate);
    $("#txtPSD").val(psd);

}
function updateBulkDates(){
    $("#btnSave").show();
    $("#btnUpdate").hide();
}

function saveNewTDl(){
	var url = getAPIURL() + 'todolist.php';
    var f = "saveNewTDl";
    var taskType = $("#txtTaskType").val();
    var task = $("#txtTask").val();
    var prio=$("#txtPriority").val();
    var cat=$("#txtCategory").val();
    var fuw=$("#txtFuw").val();
    var ofc=$("#txtOfc").val();
    var othppl=$("#txtOthppl").val();
    var psd=$("#txtPSD").val();
    var pfu=$("#txtPFU").val();
    var startdate=$("#txtStartDate").val();
    var nextctcdate=$("#txtNextCtcDt").val();
    var duedate=$("#txtDueDate").val();
    var fumtext=$("#txtFUMText").val();
    var fumlink=$("#txtFUMLink").val();
    var status = $("#txtStatus").val();
    var remarks=$("#txtTaskRemarks").val();
    var abaini=$("#abaini").val();
    var userid=$("#userid").val();
    var noofrevisions=$("#noofrevisions").val();

    var data = {"f":f, "taskType":taskType, "task":task, "prio":prio, "cat":cat, "fuw":fuw, "ofc":ofc,"othppl":othppl,"psd":psd, "pfu":pfu, "startdate":startdate, "nextctcdate":nextctcdate, "duedate":duedate,"fumtext":fumtext,"fumlink":fumlink,"status":status, "remarks":remarks, "abaini":abaini,"userid":userid,"noofrevisions":noofrevisions};
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
            var tasks = data['tasks'];
            loadTDLPending(tasks);
           	loadTDLDone(tasks);
            clearTDLFields();
            var actid = $('#actid').val();
            if(actid != ""){
                window.location = "todolist.php";
            }
            $('#actid').val("");
            $('#frmTask').modal('hide');   
            $.unblockUI(); 
                    
        }
        ,error: function(request, status, err){

        }
    });
}

function updateTDL(taskid){
    // console.log(taskid);
	$("#activityid").val(taskid);
	$("#btnSaveTask").hide();
    $("#btnUpdateTask").show();
    // $('#frmTask').modal('toggle'); 
    $('#frmTask').modal('show');

    $.blockUI({ 
      message: $('#preloader_image'), 
      fadeIn: 1000, 
      onBlock: function() {
        getTodoData(taskid);
      }
    });
}

function updateUL(id){
    // console.log(taskid);
    $("#usefullinkid").val(id);
    $("#btnSave").hide();
    $("#btnUpdate").show();
    // $('#frmTask').modal('toggle'); 
    $('#frmUsefulLinks').modal('show');
    getUsefulLink(id);
    // $.blockUI({ 
    //   message: $('#preloader_image'), 
    //   fadeIn: 1000, 
    //   onBlock: function() {
    //     getUsefulLink(id);
    //   }
    // });
}

function getDefaultData(){
	var url = getAPIURL() + 'todolist.php';
    var f="loadDefaults";
    var abaini = $('#abaini').val();
    var userid = $('#userid').val();

    var data={"f":f,"userid":userid};
    // console.log(data);
    // return false;
    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify({ "data":data }),
        dataType: 'json'
        ,success: function(data){
        	// console.log(data);
        	var tdl = data['tdl'];
			var ees = data['ees'];
			var eescnt=1;
			var eeshtml="";
			var eename="";
			var ofc = data['salesofc'];
			var cat = data['cat'];
			var status = data['status'];
			var tasktypes = data['tasktypes'];
            var usefullinks = data['usefullinks'];
            var ulcats = data['usefullinkcats'];
			// console.log(data);
			//get category for cat field

            eeshtml = '<select class="form-control" id="txtSearchBy" name="txtSearchBy">';
                eeshtml +='<option value="taskortodo" selected>Task or Todo</option>';
                eeshtml +='<option value="category">Category</option>';
                eeshtml +='<option value="fuw">fuw</option>';
                eeshtml +='<option value="tasktype">Type</option>';
                eeshtml +='<option value="ofc">ofc</option>';
            eeshtml +='</select>';
            $("#divSearchBy").html(eeshtml);


			eeshtml = '<select class="form-control" id="txtCategory" name="txtCategory">';
			eeshtml +='<option value="" selected></option>';
			for(var i=0;i<cat.length;i++){
			    eeshtml +='<option value="'+ cat[i]["ddid"] +'">'+ cat[i]["dddescription"] +'</option>';
			    eescnt++;
			}
			eeshtml +='</select>';
			$("#divCategory").html(eeshtml);

			//get abaini for FUW field
			// eeshtml = '<select class="form-control" id="txtFuw" name="txtFuw">';
			// eeshtml +='<option value="" selected></option>';
			eeshtml='<datalist id="dataFuw">';
			for(var i=0;i<ees.length;i++){
					// eename= ees[i]["fname"] + " " + ees[i]["lname"];
			    eeshtml +='<option class="form-control" value="'+ ees[i]["abaini"] +'"></option>';
			    eescnt++;
			}
			// eeshtml +='</select>';
			eeshtml+='</datalist>';
			$("#datalistFUW").html(eeshtml);

			// get task types
			eeshtml = '<select class="form-control" id="txtTaskType" name="txtTaskType">';
			eeshtml +='<option value="" selected></option>';
				for(var i=0;i<tasktypes.length;i++){
				   eeshtml +='<option value="'+ tasktypes[i]["ddid"] +'">'+ tasktypes[i]["dddescription"] +'</option>';
				   eescnt++;
				}
			eeshtml +='</select>';
			$("#divTaskType").html(eeshtml);

			//get abaini for Other people
			//       eeshtml = '<select class="form-control" id="txtOthppl" name="txtOthppl">';
			// eeshtml +='<option value="" selected></option>';
			eeshtml='<datalist id="dataOth">';
			for(var i=0;i<ees.length;i++){
					// eename= ees[i]["fname"] + " " + ees[i]["lname"];
			   	eeshtml +='<option class="form-control" value="'+ ees[i]["abaini"] +'"></option>';
			    eescnt++;
			}
			eeshtml +='</select>';
			$("#datalistOth").html(eeshtml);

			//get status percent for status field
			eeshtml = '<select class="form-control" id="txtStatus" name="txtStatus">';
			eeshtml +='<option value="" selected></option>';
			for(var i=0;i<status.length;i++){
			    eeshtml +='<option value="'+ status[i]["ddid"] +'">'+ status[i]["dddescription"] +'</option>';
			    eescnt++;
			}
			eeshtml +='</select>';
			$("#divStatus").html(eeshtml);
			$("#txtSearch").change(function(){
		    	var searchtext = $("#txtSearch").val();
		    	if(searchtext==""){
		    		SearchTask();
		    	}
		    });
            eeshtml='<datalist id="dataCat">';
            for(var i=0;i<ulcats.length;i++){
                    // eename= ees[i]["fname"] + " " + ees[i]["lname"];
                eeshtml +='<option value = "'+ ulcats[i]["dddescription"] + '"></option>';
                eescnt++;
            }
            eeshtml +='</select>';
            $("#datalistCat").html(eeshtml);

			$("#txtTaskType").change(function(){
				$("#txtPriority option[value='h']").prop('selected', true);
				$("#txtStatus option[value=0]").prop('selected', true);
				$("#noofrevisions").val("0");
			});
			$("#txtFuw").change(function(){
					getOffice();
			});

			loadTDLPending(tdl);
			loadTDLDone(tdl);
            loadUsefulLink(usefullinks);
            countTDLHeaders(tdl);
            loadTDLPendingCheckbox(tdl);
            SelectAll(tdl);

            var actid = $('#actid').val();
            // console.log(actid);
            if(actid != ""){
                $("#activityid").val(actid);
                getTodoData();
                $('#frmTask').modal('show');
                $("#btnSaveTask").hide();
                $("#btnUpdateTask").show();
            }
			$.unblockUI();
        }
        ,error: function(request, status, err){

        }
    });
}

function getTodoData(){
	var url = getAPIURL() + 'todolist.php';
    var f="getTodoData";
    var taskid = $("#activityid").val();

    var data={ "f":f, "taskid":taskid };
    // console.log(data);
    // return false;
    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify({ "data":data }),
        dataType: 'json'
        ,success: function(data){
            // console.log(data);
		    var task = data['task'][0];
		    var taskType=task['tasktype'];
		    var tasktodo=task['taskortodo'];
		    var prio=task['priority'];
		    var cat=task['category'];
		    var fuw=task['fuw'];
		    var ofc=task['ofc'];
		    var othppl=task['othppl'];
		    var psd=task['psdt'];
		    var pfu=task['pfudt'];
		    var startdate=task['startdt'];
		    var nextctcdate=task['nextctcdt'];
		    var duedate=task['duedt'];
		    var fumlink=task['fumlink'];
		    var status = task['statuspercent'];
		    var remarks=task['remarks'];
		    var noofrevisions=task['noofrevisions'];
		    var fumtext=task['fumtext'];

		    $("#txtTaskType option[value='" + taskType + "']").prop('selected', true);
		    $("#txtTask").val(tasktodo);
		    $("#txtPriority option[value='" + prio + "']").prop('selected', true);
		    $("#txtCategory option[value='" + cat + "']").prop('selected', true);
		    // $("#txtFuw  option[value='" + fuw + "']").prop('selected', true);
		    $("#txtFuw").val(fuw);
		    $("#txtOfc").val(ofc);
		    $("#txtOthppl").val(othppl);
		    $("#txtPSD").val(psd);
		    $("#txtPFU").val(pfu);
		    $("#txtStartDate").val(startdate);
		    $("#txtNextCtcDt").val(nextctcdate);
		    $("#txtDueDate").val(duedate);
		    $("#txtFUMLink").val(fumlink);
		    $("#txtStatus").val(status);
		    $("#txtTaskRemarks").val(remarks);
		    $("#noofrevisions").val(noofrevisions);
		    $("#duedate").val(duedate);
		    $("#txtFUMText").val(fumtext);
            // $("#frmTask").dialog("close");
            // $("#divResutlAchieve").hide();
            $.unblockUI();
            // return false;
            
        }
        ,error: function(request, status, err){

        }
    });
}

function updateToDo(){
	var url = getAPIURL() + 'todolist.php';
    var f = "updateTodoData";
    var taskid = $("#activityid").val();
    var taskType = $("#txtTaskType").val();
    var task = $("#txtTask").val();
    var prio=$("#txtPriority").val();
    var cat=$("#txtCategory").val();
    var fuw=$("#txtFuw").val();
    var ofc=$("#txtOfc").val();
    var othppl=$("#txtOthppl").val() == "" || $("#txtOthppl").val() == null ? "" : $("#txtOthppl").val();
    var psd=$("#txtPSD").val() == "" || $("#txtPSD").val() == null ? null : $("#txtPSD").val();
    var pfu=$("#txtPFU").val()== "" || $("#txtPFU").val() == null ? null : $("#txtPFU").val();
    var startdate=$("#txtStartDate").val()== "" || $("#txtStartDate").val() == null ? "" : $("#txtStartDate").val();
    var nextctcdate=$("#txtNextCtcDt").val()== "" || $("#txtNextCtcDt").val() == null ? "" : $("#txtNextCtcDt").val();
    var duedate=$("#txtDueDate").val()== "" || $("#txtDueDate").val() == null ? "" : $("#txtDueDate").val();
    var fumtext=$("#txtFUMText").val()== "" || $("#txtFUMText").val() == null ? "" : $("#txtFUMText").val();
    var fumlink=$("#txtFUMLink").val()== "" || $("#txtFUMLink").val() == null ? "" : $("#txtFUMLink").val();
    var status = $("#txtStatus").val()== "" || $("#txtStatus").val() == null ? "" : $("#txtStatus").val();
    var remarks=$("#txtTaskRemarks").val()== "" || $("#txtTaskRemarks").val() == null ? "" : $("#txtTaskRemarks").val();
    var abaini=$("#abaini").val();
    var userid=$("#userid").val();
    var hiddenduedate=$('#duedate').val();
    var noofrevisions=parseInt($('#noofrevisions').val());
    var duedt = ((new Date(duedate)).setHours(0, 0, 0, 0));
    var hidduedt = ((new Date(hiddenduedate)).setHours(0, 0, 0, 0));
    var cnt=1;

    if (duedt!=hidduedt){
    	noofrevisions=noofrevisions+cnt;
    }

    var data = { "f":f, "taskid":taskid, "taskType":taskType, "task":task, "prio":prio, "cat":cat, "fuw":fuw, "ofc":ofc,"othppl":othppl,"psd":psd, "pfu":pfu, "startdate":startdate, "nextctcdate":nextctcdate, "duedate":duedate,"noofrevisions":noofrevisions,"fumtext":fumtext,"fumlink":fumlink,"status":status, "remarks":remarks, "abaini":abaini,"userid":userid};

    // console.log(data);
    // return false;

    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify({ "data":data }),
        dataType: 'json'
        ,success: function(data){
            // return false;
            // var task = data['ttask'];
            var sortby=$('#sortby').val();
            clearTDLFields();
            // console.log(sortby);
            if(sortby==""){
                getDefaultData();
            } else {
                SortingTDL(sortby);
            }
            var actid = $('#actid').val();
            if(actid != ""){
                window.location = "todolist.php";
            }
            $("#actid").val("");
            $('#frmTask').modal('hide');    
            // $.unblockUI();
            // return false;
        }
        ,error: function(request, status, err){

        }
    });
}

function clearTDLFields(){
	$("#activityid").val("");
    $("#txtTaskType").val("");
    $("#txtTask").val("");
    $("#txtPriority").val("");
    $("#txtCategory").val("");
    $("#txtFuw").val("");
    $("#txtOfc").val("");
    $("#txtOthppl").val("");
    $("#txtPSD").val("");
    $("#txtPFU").val("");
    $("#txtStartDate").val("");
    $("#txtNextCtcDt").val("");
    $("#txtDueDate").val("");
    $("#txtStatus").val("");
    $("#txtFUMText").val("");
    $("#txtFUMLink").val("");
    $("#txtTaskRemarks").val("");
    $("#btnSaveTask").show();
    $("#btnUpdateTask").hide();
}

function loadTDLPending(data){
    var rows = data['rows'];
    var html = "";
    var taskType="return SortingTDL('tasktype');";
    var tasktodo="return SortingTDL('taskortodo');";
    var prio="return SortingTDL('priority');";
    var cat="return SortingTDL('category');";
    var fuw="return SortingTDL('fuw');";
    var ofc="return SortingTDL('ofc');";
    var othppl="return SortingTDL('othppl');";
    var psd="return SortingTDL('psd');";
    var pfu="return SortingTDL('pfu');";
    var startdate="return SortingTDL('startdate');";
    var nextctcdate="return SortingTDL('nextctcdate');";
    var duedate="return SortingTDL('duedate');";
    var status = "return SortingTDL('status');";
    html='<table class="table table-striped jambo_table table-condensed table-hover table-bordered tdlcolwidth">';
	    html+='<thead>';
	       html+='<tr>';
	            // html+='<th class="row-1 row-taskno checkheader" ><input type="checkbox" id = "selectall" value = "selectall"></th>';   
                html+='<th class="row-1 row-default" style="cursor: pointer;" onClick="' + taskType + '">type</th>';
                html+='<th style="cursor: pointer;" onClick="' + tasktodo + '">task or to do (use telegraphic style w abvts)</th>';
                html+='<th class="hide-on-mobile row-1 row-default" style="cursor: pointer;" onClick="' + prio + '">p </th>';
                html+='<th class="hide-on-mobile row-1 row-default" style="cursor: pointer;" onClick="' + cat + '">cat </th>';
                html+='<th class="hide-on-mobile row-1 row-default" style="cursor: pointer;" onClick="' + fuw + '">fuw </th>';
                html+='<th class="hide-on-mobile row-1 row-default" style="cursor: pointer;" onClick="' + ofc + '">ofc </th>';
                html+='<th class="hide-on-mobile row-1 row-default" style="cursor: pointer;" onClick="' + othppl + '">oth ppl </th>';
                //html+='<th class="hide-on-mobile row-1 row-default" style="cursor: pointer;" onClick="' + psd + '">psd</th>';
                //html+='<th class="hide-on-mobile row-1 row-default" style="cursor: pointer;" onClick="' + pfu + '">pfu</th>';
                html+='<th class="hide-on-mobile col-date" style="cursor: pointer;" onClick="' + startdate + '">start date</th>';
                html+='<th class="col-date" style="cursor: pointer;" onClick="' + nextctcdate + '">next ctc date </th>';
                html+='<th class="col-date" style="cursor: pointer;" onClick="' + duedate + '">due dt </th>';
                html+='<th class="hide-on-mobile row-1 row-taskno"># of Rev </th>';
                html+='<th class="hide-on-mobile row-1 row-taskno" style="cursor: pointer;" name="status">status</th>';
                html+='<th class="hide-on-mobile colfixedwidth col-link-th">link </th>';
                html+='<th class="hide-on-mobile colfixedwidth col-remarks">remarks </th>';
                // html+='<th width="4">View / Edit</th>';
	       html+='</tr>';
	     html+='</thead>';

	     html+='<tbody>';
	     var cnt=1;
	     var cntdue=1;
	     var cntover=1
	     var edittdl="";
	     var tasktype="";
	     var priority="";
	     var ofc="";
	     var othppl="";
	     var psd ="";
	     var pfu="";
	     var startdate="";
	     var nextctcdate="";
	     var duedate="";
	     var statuspercent="";
	     var remarks="";
	     var fumlink="";
	     var today = ((new Date()).setHours(0, 0, 0, 0));
	     var duedt="";
	     var nxtctcdt="";
	     var bgcolorduedt="";
	     var bgcolornextctcdt="";
	     var activityid="";
	     var noofrevisions="";
	     var fumtext="";
         var values=[];
	     for(var i=0;i<rows.length;i++){
	     	activityid="return updateTDL('"+ rows[i]['activityid'] +"')";
	     	tasktype=rows[i]["tasktype"]=="" || rows[i]["tasktype"]==null ? "" : rows[i]["tasktype"];
	     	ofc=rows[i]["ofc"]=="" || rows[i]["ofc"]==null ? "" : rows[i]["ofc"];
	     	othppl=rows[i]["othppl"]=="" || rows[i]["othppl"]==null ? "" : rows[i]["othppl"];
	     	psd=rows[i]["psdt"]=="" || rows[i]["psdt"]==null ? "" : rows[i]["psdt"];
	     	pfu=rows[i]["pfudt"]=="" || rows[i]["pfudt"]==null ? "" : rows[i]["pfudt"];
	     	startdate=rows[i]["startdt"]=="" || rows[i]["startdt"]==null ? "" : rows[i]["startdt"];
	     	nextctcdate=rows[i]["nextctcdt"]=="" || rows[i]["nextctcdt"]==null ? "" : rows[i]["nextctcdt"];
	     	duedate=rows[i]["duedt"]=="" || rows[i]["duedt"]==null ? "" : rows[i]["duedt"];
	     	statuspercent=rows[i]["statuspercent"]=="" || rows[i]["statuspercent"]==null ? "" : rows[i]["statuspercent"];
	     	remarks=rows[i]["remarks"]=="" || rows[i]["remarks"]==null ? "" : rows[i]["remarks"];
	     	fumlink=rows[i]["fumlink"]=="" || rows[i]["fumlink"]==null ? "" : rows[i]["fumlink"];
	     	priority=rows[i]['priority'];
	     	duedt = ((new Date(rows[i]['duedate'])).setHours(0, 0, 0, 0));
	     	nxtctcdt = ((new Date(rows[i]['nextctcdate'])).setHours(0, 0, 0, 0));
	     	bgcolor ="";
	     	noofrevisions=rows[i]["noofrevisions"] == "" || rows[i]["noofrevisions"]==null ? "" : rows[i]["noofrevisions"];
	     	fumtext=rows[i]["fumtext"]=="" || rows[i]["fumtext"]==null ? "" : rows[i]["fumtext"];

	     	if (statuspercent < 100){
	     		if (priority=="med"){
	     		priority="m";
		     	}
		     	if(duedate == ''){
                    bgcolorduedt ="";
                }else{
                    if (duedt < today){
                        bgcolorduedt = 'overduedt';
                        // cntover++;
                    } else if (duedt == today) {
                        bgcolorduedt ='duetoday';
                        // cntdue++;
                    } else {
                        bgcolorduedt ="";
                    }
                }

                if(nextctcdate == ''){
                    bgcolornextctcdt ="";
                }else{
                    if (nxtctcdt < today){
                        bgcolornextctcdt = 'overduedt';
                    } else if (nxtctcdt == today) {
                        bgcolornextctcdt ='duetoday';
                    } else {
                        bgcolornextctcdt ="";
                    }
                }
		     	html+='<tr style="cursor: pointer;">';
		         	// html+='<td class="text-center" ><input type="checkbox" name = "activityid" value = "' + rows[i]['activityid'] + '"></td>';
                    html+='<td class="text-center" onClick="' + activityid + '";>'+ tasktype +'</td>';
                    html+='<td class="text-left" onClick="' + activityid + '";>'+ rows[i]['taskortodo'] +'</td>';
                    html+='<td class=" text-center hide-on-mobile" onClick="' + activityid + '";>'+ priority +'</td>';
                    html+='<td class="text-center hide-on-mobile" onClick="' + activityid + '";>'+ rows[i]['category'] +'</td>';
                    html+='<td class="text-center hide-on-mobile" onClick="' + activityid + '";>'+ rows[i]['fuw'] +'</td>';
                    html+='<td class="text-center hide-on-mobile" onClick="' + activityid + '";>'+ ofc +'</td>';
                    html+='<td class="text-center hide-on-mobile" onClick="' + activityid + '";>'+ othppl +'</td>';
                    //html+='<td class="text-center hide-on-mobile" onClick="' + activityid + '";>'+ psd +'</td>';
                    //html+='<td class="text-center hide-on-mobile" onClick="' + activityid + '";>'+ pfu +'</td>';
                    html+='<td class="text-center hide-on-mobile" onClick="' + activityid + '";>'+ startdate +'</td>';
                    html+='<td class="text-center '+ bgcolornextctcdt +'" onClick="' + activityid + '";>'+ nextctcdate +'</td>';
                    html+='<td class="text-center '+ bgcolorduedt +'"onClick="' + activityid + '";>'+ duedate +'</td>';
                    html+='<td class="text-center hide-on-mobile" onClick="' + activityid + '";>' + noofrevisions +'</td>';
                    html+='<td class="text-center hide-on-mobile" onClick="' + activityid + '";>'+ statuspercent +'</td>';
                    html+='<td class="text-center hide-on-mobile col-link-td"><a href=" ' + fumlink + ' " title="'+ fumlink +'" target="_blank"> ' + fumtext + ' </a></td>';
                    html+='<td class="text-left hide-on-mobile col-remarks" onClick="' + activityid + '";>'+ remarks +'</td>';
		            // edittdl="return updateTDL('"+ rows[i]['activityid'] +"')";
		            // html+='<td class="text-center"><a href="#" onClick="'+edittdl+'"><i class="fa fa-pencil-square-o vieweditico"></i></a></td>';
		       html+='</tr>';
		       cnt++;
		      }
	     }
	     html+='</tbody>';
	  html+='</table>';
	  // console.log(cntover);
	  $("#datatblTDLPending").html(html);
	  
}

function loadTDLPendingCheckbox(data){
    var rows = data['rows'];
    var html = "";
    var taskType="return SortingTDL('tasktype');";
    var tasktodo="return SortingTDL('taskortodo');";
    var prio="return SortingTDL('priority');";
    var cat="return SortingTDL('category');";
    var fuw="return SortingTDL('fuw');";
    var ofc="return SortingTDL('ofc');";
    var othppl="return SortingTDL('othppl');";
    var psd="return SortingTDL('psd');";
    var pfu="return SortingTDL('pfu');";
    var startdate="return SortingTDL('startdate');";
    var nextctcdate="return SortingTDL('nextctcdate');";
    var duedate="return SortingTDL('duedate');";
    var status = "return SortingTDL('status');";
    html='<table class="table table-striped jambo_table table-condensed table-hover table-bordered tdlcolwidth">';
        html+='<thead>';
           html+='<tr>';
                html+='<th class="row-1 row-taskno " ><input class = "v-align-bot" type="checkbox" id = "selectall"></th>';   
                html+='<th class="row-1 row-default" style="cursor: pointer;" onClick="' + taskType + '">type</th>';
                html+='<th style="cursor: pointer;" onClick="' + tasktodo + '">task or to do (use telegraphic style w abvts)</th>';
                html+='<th class="hide-on-mobile row-1 row-default" style="cursor: pointer;" onClick="' + prio + '">p </th>';
                html+='<th class="hide-on-mobile row-1 row-default" style="cursor: pointer;" onClick="' + cat + '">cat </th>';
                html+='<th class="hide-on-mobile row-1 row-default" style="cursor: pointer;" onClick="' + fuw + '">fuw </th>';
                html+='<th class="hide-on-mobile row-1 row-default" style="cursor: pointer;" onClick="' + ofc + '">ofc </th>';
                html+='<th class="hide-on-mobile row-1 row-default" style="cursor: pointer;" onClick="' + othppl + '">oth ppl </th>';
                //html+='<th class="hide-on-mobile row-1 row-default" style="cursor: pointer;" onClick="' + psd + '">psd</th>';
               // html+='<th class="hide-on-mobile row-1 row-default" style="cursor: pointer;" onClick="' + pfu + '">pfu</th>';
                html+='<th class="hide-on-mobile col-date" style="cursor: pointer;" onClick="' + startdate + '">start date</th>';
                html+='<th class="col-date" style="cursor: pointer;" onClick="' + nextctcdate + '">next ctc date </th>';
                html+='<th class="col-date" style="cursor: pointer;" onClick="' + duedate + '">due dt </th>';
                html+='<th class="hide-on-mobile row-1 row-taskno"># of Rev </th>';
                html+='<th class="hide-on-mobile row-1 row-taskno" style="cursor: pointer;" name="status">status</th>';
                html+='<th class="hide-on-mobile col-link-th">link </th>';
                html+='<th class="hide-on-mobile col-remarks">remarks </th>';
                // html+='<th width="4">View / Edit</th>';
           html+='</tr>';
         html+='</thead>';

         html+='<tbody>';
         var cnt=1;
         var cntdue=1;
         var cntover=1
         var edittdl="";
         var tasktype="";
         var priority="";
         var ofc="";
         var othppl="";
         var psd ="";
         var pfu="";
         var startdate="";
         var nextctcdate="";
         var duedate="";
         var statuspercent="";
         var remarks="";
         var fumlink="";
         var today = ((new Date()).setHours(0, 0, 0, 0));
         var duedt="";
         var nxtctcdt="";
         var bgcolorduedt="";
         var bgcolornextctcdt="";
         var activityid="";
         var noofrevisions="";
         var fumtext="";
         var values=[];
         for(var i=0;i<rows.length;i++){
            activityid="return updateTDL('"+ rows[i]['activityid'] +"')";
            tasktype=rows[i]["tasktype"]=="" || rows[i]["tasktype"]==null ? "" : rows[i]["tasktype"];
            ofc=rows[i]["ofc"]=="" || rows[i]["ofc"]==null ? "" : rows[i]["ofc"];
            othppl=rows[i]["othppl"]=="" || rows[i]["othppl"]==null ? "" : rows[i]["othppl"];
            psd=rows[i]["psdt"]=="" || rows[i]["psdt"]==null ? "" : rows[i]["psdt"];
            pfu=rows[i]["pfudt"]=="" || rows[i]["pfudt"]==null ? "" : rows[i]["pfudt"];
            startdate=rows[i]["startdt"]=="" || rows[i]["startdt"]==null ? "" : rows[i]["startdt"];
            nextctcdate=rows[i]["nextctcdt"]=="" || rows[i]["nextctcdt"]==null ? "" : rows[i]["nextctcdt"];
            duedate=rows[i]["duedt"]=="" || rows[i]["duedt"]==null ? "" : rows[i]["duedt"];
            statuspercent=rows[i]["statuspercent"]=="" || rows[i]["statuspercent"]==null ? "" : rows[i]["statuspercent"];
            remarks=rows[i]["remarks"]=="" || rows[i]["remarks"]==null ? "" : rows[i]["remarks"];
            fumlink=rows[i]["fumlink"]=="" || rows[i]["fumlink"]==null ? "" : rows[i]["fumlink"];
            priority=rows[i]['priority'];
            duedt = ((new Date(rows[i]['duedate'])).setHours(0, 0, 0, 0));
            nxtctcdt = ((new Date(rows[i]['nextctcdate'])).setHours(0, 0, 0, 0));
            bgcolor ="";
            noofrevisions=rows[i]["noofrevisions"] == "" || rows[i]["noofrevisions"]==null ? "" : rows[i]["noofrevisions"];
            fumtext=rows[i]["fumtext"]=="" || rows[i]["fumtext"]==null ? "" : rows[i]["fumtext"];

            if (statuspercent < 100){
                if (priority=="med"){
                priority="m";
                }
                if(duedate == ''){
                    bgcolorduedt ="";
                }else{
                    if (duedt < today){
                        bgcolorduedt = 'overduedt';
                        // cntover++;
                    } else if (duedt == today) {
                        bgcolorduedt ='duetoday';
                        // cntdue++;
                    } else {
                        bgcolorduedt ="";
                    }
                }

                if(nextctcdate == ''){
                    bgcolornextctcdt ="";
                }else{
                    if (nxtctcdt < today){
                        bgcolornextctcdt = 'overduedt';
                    } else if (nxtctcdt == today) {
                        bgcolornextctcdt ='duetoday';
                    } else {
                        bgcolornextctcdt ="";
                    }
                }
                html+='<tr style="cursor: pointer;">';
                    html+='<td class="text-center" ><input class = "v-align-bot" type="checkbox" name = "activityid" value = "' + rows[i]['activityid'] + '"></td>';
                    html+='<td class="text-center" onClick="' + activityid + '";>'+ tasktype +'</td>';
                    html+='<td class="text-left" onClick="' + activityid + '";>'+ rows[i]['taskortodo'] +'</td>';
                    html+='<td class=" text-center hide-on-mobile" onClick="' + activityid + '";>'+ priority +'</td>';
                    html+='<td class="text-center hide-on-mobile" onClick="' + activityid + '";>'+ rows[i]['category'] +'</td>';
                    html+='<td class="text-center hide-on-mobile" onClick="' + activityid + '";>'+ rows[i]['fuw'] +'</td>';
                    html+='<td class="text-center hide-on-mobile" onClick="' + activityid + '";>'+ ofc +'</td>';
                    html+='<td class="text-center hide-on-mobile" onClick="' + activityid + '";>'+ othppl +'</td>';
                    //html+='<td class="text-center hide-on-mobile" onClick="' + activityid + '";>'+ psd +'</td>';
                    //html+='<td class="text-center hide-on-mobile" onClick="' + activityid + '";>'+ pfu +'</td>';
                    html+='<td class="text-center hide-on-mobile" onClick="' + activityid + '";>'+ startdate +'</td>';
                    html+='<td class="text-center '+ bgcolornextctcdt +'" onClick="' + activityid + '";>'+ nextctcdate +'</td>';
                    html+='<td class="text-center '+ bgcolorduedt +'"onClick="' + activityid + '";>'+ duedate +'</td>';
                    html+='<td class="text-center hide-on-mobile" onClick="' + activityid + '";>' + noofrevisions +'</td>';
                    html+='<td class="text-center hide-on-mobile" onClick="' + activityid + '";>'+ statuspercent +'</td>';
                    html+='<td class="text-center hide-on-mobile col-link-td"><a href=" ' + fumlink + ' " title="'+ fumlink +'" target="_blank"> ' + fumtext + ' </a></td>';
                    html+='<td class="text-left hide-on-mobile col-remarks" onClick="' + activityid + '";>'+ remarks +'</td>';
                    // edittdl="return updateTDL('"+ rows[i]['activityid'] +"')";
                    // html+='<td class="text-center"><a href="#" onClick="'+edittdl+'"><i class="fa fa-pencil-square-o vieweditico"></i></a></td>';
               html+='</tr>';
               cnt++;
              }
         }
         html+='</tbody>';
      html+='</table>';
      // console.log(cntover);
      $("#datatblTDLPendingCheckbox").html(html);
      
}

function loadTDLDone(data){
    var rows = data['rows'];
    var html = "";
    var taskType="return SortingTDL('tasktype');";
    var tasktodo="return SortingTDL('taskortodo');";
    var prio="return SortingTDL('priority');";
    var cat="return SortingTDL('category');";
    var fuw="return SortingTDL('fuw');";
    var ofc="return SortingTDL('ofc');";
    var othppl="return SortingTDL('othppl');";
    var psd="return SortingTDL('psd');";
    var pfu="return SortingTDL('pfu');";
    var startdate="return SortingTDL('startdate');";
    var nextctcdate="return SortingTDL('nextctcdate');";
    var duedate="return SortingTDL('duedate');";

    html='<table class="table table-striped jambo_table table-condensed table-hover table-bordered">';
	    html+='<thead>';
	       html+='<tr>';
	         // html+='<th width="4">#</th>';
                html+='<th style="cursor: pointer;" width="4" onClick="' + taskType + '">type</th>';
                html+='<th style="cursor: pointer;" width="100" onClick="' + tasktodo + '">task or to do (use telegraphic style w abvts)</th>';
                html+='<th class="hide-on-mobile" style="cursor: pointer;" width="4" onClick="' + prio + '">priority </th>';
                html+='<th class="hide-on-mobile" style="cursor: pointer;" width="4" onClick="' + cat + '">category </th>';
                html+='<th class="hide-on-mobile" style="cursor: pointer;" width="10" onClick="' + fuw + '">fuw </th>';
                html+='<th class="hide-on-mobile" style="cursor: pointer;" width="4" onClick="' + ofc + '">ofc </th>';
                html+='<th class="hide-on-mobile" style="cursor: pointer;" width="4" onClick="' + othppl + '">oth ppl </th>';
                //html+='<th class="hide-on-mobile" style="cursor: pointer;" width="4" onClick="' + psd + '">psd</th>';
                //html+='<th class="hide-on-mobile" style="cursor: pointer;" width="4" onClick="' + pfu + '">pfu</th>';
                html+='<th class="hide-on-mobile" style="cursor: pointer;" width="4" onClick="' + startdate + '">start date</th>';
                html+='<th style="cursor: pointer;" width="4" onClick="' + nextctcdate + '">next ctc date </th>';
                html+='<th style="cursor: pointer;" width="4" onClick="' + duedate + '">due dt </th>';
                html+='<th class="hide-on-mobile" width="10">FUM link </th>';
                html+='<th class="hide-on-mobile" width="10">remarks </th>';
	       html+='</tr>';
	     html+='</thead>';

	     html+='<tbody>';
	     var cnt=1;
	     var edittdl="";
	     var ofc="";
	     var othppl="";
	     var psd ="";
	     var pfu="";
	     var startdate="";
	     var nextctcdate="";
	     var duedate="";
	     var statuspercent="";
	     var remarks="";
	     var fumlink="";
	     for(var i=0;i<rows.length;i++){
	     	ofc=rows[i]["ofc"]=="" || rows[i]["ofc"]==null ? "" : rows[i]["ofc"];
	     	othppl=rows[i]["othppl"]=="" || rows[i]["othppl"]==null ? "" : rows[i]["othppl"];
	     	psd=rows[i]["psdt"]=="" || rows[i]["psdt"]==null ? "" : rows[i]["psdt"];
	     	pfu=rows[i]["pfudt"]=="" || rows[i]["pfudt"]==null ? "" : rows[i]["pfudt"];
	     	startdate=rows[i]["startdt"]=="" || rows[i]["startdt"]==null ? "" : rows[i]["startdt"];
	     	nextctcdate=rows[i]["nextctcdt"]=="" || rows[i]["nextctcdt"]==null ? "" : rows[i]["nextctcdt"];
	     	duedate=rows[i]["duedt"]=="" || rows[i]["duedt"]==null ? "" : rows[i]["duedt"];
	     	remarks=rows[i]["remarks"]=="" || rows[i]["remarks"]==null ? "" : rows[i]["remarks"];
	     	statuspercent=rows[i]["statuspercent"]=="" || rows[i]["statuspercent"]==null ? "" : rows[i]["statuspercent"];
	     	fumlink=rows[i]["fumlink"]=="" || rows[i]["fumlink"]==null ? "" : rows[i]["fumlink"];
            fumtext=rows[i]["fumtext"]=="" || rows[i]["fumtext"]==null ? "" : rows[i]["fumtext"];
	     	priority=rows[i]['priority'];
	     	if (priority=="med"){
	     		priority="m";
	     	}
	     	if(statuspercent == 100){
		     	html+='<tr>';
		         	// html+='<td class="text-center">'+ cnt +'</td>';
                    html+='<td class="text-center ">'+ rows[i]['tasktype'] +'</td>';
                    html+='<td class="text-left">'+ rows[i]['taskortodo'] +'</td>';
                    html+='<td class="hide-on-mobile text-center">'+ priority +'</td>';
                    html+='<td class="hide-on-mobile text-center">'+ rows[i]['category'] +'</td>';
                    html+='<td class="hide-on-mobile text-center">'+ rows[i]['fuw'] +'</td>';
                    html+='<td class="hide-on-mobile text-center">'+ ofc +'</td>';
                    html+='<td class="hide-on-mobile text-center">'+ othppl +'</td>';
                    //html+='<td class="hide-on-mobile text-center">'+ psd +'</td>';
                    //html+='<td class="hide-on-mobile text-center">'+ pfu +'</td>';
                    html+='<td class="hide-on-mobile text-center">'+ startdate +'</td>';
                    html+='<td class="text-center">'+ nextctcdate +'</td>';
                    html+='<td class="text-center">'+ duedate +'</td>';
                    html+='<td class="hide-on-mobile text-center"><a href=" ' + fumlink + ' " title="FUM" target="_blank"> ' + fumtext + ' </a></td>';
                    html+='<td class="hide-on-mobile text-left">'+ remarks +'</td>';
		       html+='</tr>';
		       cnt++;
		      }
	     }
	     html+='</tbody>';
	  html+='</table>';
	  $("#datatblTDLDone").html(html);
}

function SearchTask(){
	var url = getAPIURL() + 'todolist.php';
	var searchtext = $("#txtSearch").val();
	var searchby = $("#txtSearchBy").val();
	var abaini=$('#abaini').val();
	var userid=$('#userid').val();

    if (searchby == "usefullink" || searchby == "category"){
        var f = "SearchULs";
    }
    else {
        var f="SearchTask";
    }
	
	var data = { "f":f,"searchtext":searchtext,"userid":userid,"searchby":searchby}
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
                    var searchbyval = $("#txtSearchBy").val();
                    // console.log(searchbyval);

                    if(searchbyval == "usefullink" || searchbyval == "category"){
                        var usefullinks = data['usefullinks'];
                        loadUsefulLink(usefullinks);
                    }
                    else {
                        var tasks=data['tasks'];
                        loadTDLPending(tasks);
                        loadTDLDone(tasks);
                    } 
                    // $("#frmTask").dialog("close");
                    $.unblockUI();
                    // return false;
                }
                ,error: function(request, status, err){

                }
            });
        }
    });
	
}

function SortingTDL(sortby){
	var url = getAPIURL() + 'todolist.php';
	var f="SortingTDL";
	var abaini=$('#abaini').val();
	var userid=$('#userid').val();
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
	var data = { "f":f,"sortby":sortby,"userid":userid,"sortin":sortin}
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
                    var tasks = data['tasks'];
                    // console.log(tasks);
                    loadTDLPending(tasks);
                    loadTDLDone(tasks);
                    // // $("#frmTask").dialog("close");
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
    var url = getAPIURL() + 'todolist.php';
    var f = "filterHeaderSearch";
    var id = $("#sesid").val();
    var userid = $("#userid").val();
    

    var data = { "f":f, "userid":userid, "headerval":headerval};
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
                        var tasks = data['search'];
                        loadTDLPending(tasks);
                        loadTDLDone(tasks);
                        $.unblockUI();
                        // return false;
                    }
                    ,error: function(request, status, err){

                    }
                });
            }
        });

    
}

function countTDLHeaders(data){
    // console.log(data);
    var ttlduetoday=0;
    var ttloverdue=0;
    var ttltaskpending=0;
    var nxtctcdt="";
    var today = ((new Date()).setHours(0, 0, 0, 0));
    var rows = data['rows'];

    for(var i=0;i<rows.length;i++){
        nxtctcdt=((new Date(rows[i]["nextctcdate"])).setHours(0, 0, 0, 0));
        statuspercent=rows[i]["statuspercent"];
        if (statuspercent < 100){
            if(nxtctcdt<today){
                ttloverdue++;
            } else if (nxtctcdt == today){
                ttlduetoday++;
            }
            ttltaskpending++;
        }
    }

    // console.log(rows);
    $("#ttlduetoday").html(ttlduetoday);
    $("#ttloverdue").html(ttloverdue);
    $("#ttltaskpending").html(ttltaskpending);
}

function loadUsefulLink(data){
    var rows = data['rows'];
    var html = "";
    // console.log(rows);
    html = '<table id ="tblUsefullinks" class="table table-striped jambo_table table-condensed table-hover table-bordered">';
        html +='<thead>';
            html +='<tr>';
                html +='<th>category</th>';
                html +='<th>link </th>';
            html +='</tr>';
        html +='<thead>';
        html +='<tbody>';
            for(var i=0;i<rows.length;i++){
                var fumtext ="";
                var fumlink = "";
                var ulid = "";
                fumtext = rows[i]['fumname'];
                fumlink = rows[i]['fumlink'];
                ulid ="return updateUL('"+ rows[i]['id'] +"')";;
                html +='<tr>';
                    html+='<td class="text-center " style="cursor: pointer;" onClick="'+ ulid +'">'+ rows[i]['category'] +'</td>';
                    html+='<td class="text-left"><a href=" ' + fumlink + ' " title="'+ fumlink +'" target="_blank"> ' + fumtext + ' </a></td>';
                html +='</tr>';
            }
         html +='</tbody>';
    html +='</table>'; 
     $("#datatblUsefullinks").html(html);
}

function saveUsefullink(){
    var url = getAPIURL() + 'todolist.php';
    var f = "SaveUsefulLink";
    var category = $("#txtCat").val();
    var fumtext = $("#txtFUMTextUL").val();
    var fumlink = $("#txtFUMLinkUL").val();
    var userid =$('#userid').val();

    var data = { "f":f, "userid":userid, "cat":category, "fumtext":fumtext, "fumlink":fumlink };

    // console.log(data);

    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify({ "data":data }),
        dataType: 'json'
        ,success: function(data){
            // console.log(data);
            // return false;
            var sortby=$('#sortby').val();
            if(sortby==""){
                getDefaultData();
            } else {
                SortingTDL(sortby);
            }
            clearUsefulLinkFields();
            $('#frmUsefulLinks').modal('hide');   
            $.unblockUI(); 
        }
        ,error: function(request, status, err){

        }
    });
}

function getUsefulLink($id){
    var url = getAPIURL() + 'todolist.php';
    var f="getUsefulLink";
    var usefullinkid = $("#usefullinkid").val();
    var userid = $('#userid').val();

    var data={ "f":f, "usefullinkid":usefullinkid, "userid":userid };

    // console.log(data);

    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify({ "data":data }),
        dataType: 'json'
        ,success: function(data){
            var uldata = data['usefullink']['rows'][0];
            var fumtext = uldata['fumname'];
            var fumlink = uldata['fumlink'];
            var cat = uldata['category'];
            // console.log(uldata);
            
            $('#txtCat').val(cat);
            $('#txtFUMTextUL').val(fumtext);
            $('#txtFUMLinkUL').val(fumlink);

            // $.unblockUI(); 
        }
        ,error: function(request, status, err){

        }
    });

}

function updateUsefullink(){
    var url = getAPIURL() + 'todolist.php';
    var f = "updateUsefulLink";
    var ulid = $("#usefullinkid").val();
    var category = $("#txtCat").val();
    var fumtext = $("#txtFUMTextUL").val();
    var fumlink = $("#txtFUMLinkUL").val();
    var userid = $('#userid').val();

    var data = { "f":f, "ulid":ulid, "userid":userid, "cat":category, "fumtext":fumtext, "fumlink":fumlink };

    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify({ "data":data }),
        dataType: 'json'
        ,success: function(data){
            // console.log(data);
            // return false;
            var sortby=$('#sortby').val();
            if(sortby==""){
                getDefaultData();
            } else {
                SortingTDL(sortby);
            }
            clearUsefulLinkFields();
            $('#frmUsefulLinks').modal('hide');   
            $.unblockUI(); 
        }
        ,error: function(request, status, err){

        }
    });
}
function clearUsefulLinkFields(){
    $('#usefullinkid').val("");
    $('#txtCat').val("");
    $('#txtFUMTextUL').val("");
    $('#txtFUMLinkUL').val("");
}

function dropDownTodo(){
    var eeshtml = "";
    eeshtml = '<select class="form-control" id="txtSearchBy" name="txtSearchBy">';
        eeshtml +='<option value="taskortodo" selected>Task or Todo</option>';
        eeshtml +='<option value="category">Category</option>';
        eeshtml +='<option value="fuw">fuw</option>';
        eeshtml +='<option value="tasktype">Type</option>';
        eeshtml +='<option value="ofc">ofc</option>';
    eeshtml +='</select>';
    $("#divSearchBy").html(eeshtml);
            
            // eeshtml = '<select class="form-control" id="txtSearchBy" name="txtSearchBy">';
            //     eeshtml +='<option value="usefullink" selected>Useful Links</option>';
            // eeshtml +='</select>';
            // $("#divSearchBy").html(eeshtml);
}
function dropDownUsefulLink(){
    var eeshtml = "";
    eeshtml = '<select class="form-control" id="txtSearchBy" name="txtSearchBy">';
        eeshtml +='<option value="usefullink" selected>Useful Links</option>';
        eeshtml +='<option value="category" >Category</option>';
    eeshtml +='</select>';
    $("#divSearchBy").html(eeshtml);
}

function getSelectedTDL(selecteddata){
    var url = getAPIURL() + 'todolist.php';
    var result = $('input[name = "activityid"]:checked');
    var fieldname = $("#txtField").val();
    var datereplace = $("#txtDateReplace").val();
   
    var f = "BulkUpdate";
    var data = { "f":f, "fieldname":fieldname, "datereplace":datereplace, "selecteddata":selecteddata };

    // console.log(selecteddata);
    // return false;

    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify({ "data":data }),
        dataType: 'json'
        ,success: function(data){
            // console.log(data);
        var sortby=$('#sortby').val();
        // console.log(sortby);
        if(sortby==""){
            getDefaultData();
        } else {
            SortingTDL(sortby);
        }
        clearUpdateTaskDates();
        // $.unblockUI(); 
        }
        ,error: function(request, status, err){

        }
    });    
}  
function bulkUpdateSwitch(){
    var bulkupdate = $("#bulkupdate").val();
    var column = "table ." + $(this).attr("");
    $("#tabs").tabs("select", "#tasks");
    if(bulkupdate == 'Off'){
        $("#bulkupdate").val('On');
        $("#divBulkUpdate").show();
        $("#datatblTDLPendingCheckbox").show();
        $("#datatblTDLPending").hide();
    } else {
        $("#bulkupdate").val('Off');
         $("#divBulkUpdate").hide();
        $("#datatblTDLPendingCheckbox").hide();
        $("#datatblTDLPending").show();
        clearUpdateTaskDates();

    }
   
}
function SelectAll(data){
    var rows = data['rows'];
    var rowcount = 0;
    var checkboxes =  document.getElementsByName("activityid");
    var checkall = $('input[name = "activityid"]:checked');
    var checkedval = $(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status

    //select all checkboxes
    $("#selectall").change(function(){
        if ($(this).is(':checked')) {
            $('input[type=checkbox]').each(function() {
                $(this).prop("checked", true); 
            });
        }
        else {
            $('input[type=checkbox]').each(function() {
                $(this).prop("checked", false); 
            });
        }
    });
}


function clearUpdateTaskDates(){
    $('#txtField option').prop('selected', function() { return this.defaultSelected; });
    $('#txtDateReplace').val("");
    $('input[type=checkbox]').each(function() {
        $(this).prop("checked", false); 
    });
}


