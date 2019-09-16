$(function(){
    $("#dataduetasks").on("click", function(){
        var headerval = "duetask";
        $("#headerclickval").val(headerval);
        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                filterSearch(headerval);
            }
        });
    });
    $("#dataduetoday").on("click", function(){
        var headerval = "duetodaytask";
        $("#headerclickval").val(headerval);
       $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                filterSearch(headerval);
            }
        });
    });
    $("#datattltasks").on("click", function(){
        var headerval = "ttltasks";
        $("#headerclickval").val(headerval);
        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                filterSearch(headerval);
            }
        });
    });
    $("#datattlcalls").on("click", function(){
        var headerval = "ttlcalls";
        $("#headerclickval").val(headerval);
        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                filterSearch(headerval);
            }
        });
    });
    $("#datattlmtgs").on("click", function(){
        var headerval = "ttlmtg";
        $("#headerclickval").val(headerval);
        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                filterSearch(headerval);
            }
        });
    });
    $("#datattlcm").on("click", function(){
        var headerval = "ttlcm";
        $("#headerclickval").val(headerval);
        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                filterSearch(headerval);
            }
        });
    });
    $("#btnSearch").on("click", function(){
        searchTask();
    });
    $("#txtDateReplace").datepicker({
        // minDate: -6,
        dateFormat: "D d M y",
        changeMonth: true,
        changeYear: true
    });

    $("#btnUpdateTaskDates").on("click", function(){
        var selectedfield = $('#txtField').val();
        var datereplace = $('#txtDateReplace').val();
        var result = $('input[name = "taskid"]:checked');
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
            getSelectedTasks(selecteddata);
          }
        });
        
    });

    $( "#tabs" ).tabs();

    $.blockUI({ 
		message: $('#preloader_image'), 
		fadeIn: 1000, 
		onBlock: function() {
			loadTasks();
		}
	});
});

function loadTasks(){
	var url = getAPIURL() + 'tasks.php';
    var f = "loadDefault";
    var id = $("#sesid").val();
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
            var tasks = data['tasks'];
            genTasksPending(tasks);
            genTasksPendingCheckBox(tasks);
            SelectAll(tasks);
            genTasksDone(tasks);
            countTaskHeaders(tasks);
            $.unblockUI();
            // return false;
        }
        ,error: function(request, status, err){

        }
    });
}

function genTasksPending(data){
    // console.log(data);
    var rows = data['rows'];
    var html = "";
    var today = ((new Date()).setHours(0, 0, 0, 0));
    var bgtaskdate = "";
    var taskdt = "";
    var taskdate = "return sortingTask('taskdate');";
    var tasktyp= "return sortingTask('tasktyp');";
    var lname = "return sortingTask('lname');";
    var fname = "return sortingTask('fname');";
    var company = "return sortingTask('company');";
    var ic = "return sortingTask('ic');";
    var resexpected = "return sortingTask('resexpected');";
    var specificres = "return sortingTask('specificres');";
    html = '<table class="table table-striped jambo_table table-condensed table-hover table-bordered">';
        html += '<thead>';
        html += '<tr>';
			html += '<th style="cursor: pointer;" width="10%" onClick="' + taskdate + '">Task Date</th>';
			html += '<th style="cursor: pointer;" width="10%" onClick="' + tasktyp + '">Task Type</th>';
			html += '<th style="cursor: pointer;" width="10%" onClick="' + lname + '">LAST NAME</th>';
			html += '<th style="cursor: pointer;" width="10%" onClick="' + fname + '">First Name</th>';
			html += '<th style="cursor: pointer;" width="10%" onClick="' + company + '">Company</th>';
			html += '<th style="cursor: pointer;" width="5%" onClick="' + ic + '">ica</th>';
            html += '<th width="5%">lob</th>';
            html += '<th width="5%">ot ppl</th>';
			html += '<th style="cursor: pointer;" width="15%" onClick="' + resexpected + '">Result Expected</th>';
			html += '<th style="cursor: pointer;" width="20%" onClick="' + specificres + '">Specific Result</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';
        var goto = "";
        for(var i=0;i<rows.length;i++){
        	if(rows[i]['status'] == 0){
                bgtaskdate = "";
                var lob = "";
                var medcnt = rows[i]['medcnt'] == "" || rows[i]['medcnt'] == null ? "" : rows[i]['medcnt'];
                var lifecnt = rows[i]['lifecnt'] == "" || rows[i]['lifecnt'] == null ? "" : rows[i]['lifecnt'];
                var gencnt = rows[i]['gencnt'] == "" || rows[i]['gencnt'] == null ? "" : rows[i]['gencnt'];
                var ttype = rows[i]['tasktypedesc'] == "" || rows[i]['tasktypedesc'] == null ? "" : rows[i]['tasktypedesc'];
                var lastname = rows[i]['lastname'] == "" || rows[i]['lastname'] == null ? "" : rows[i]['lastname'];
                var firstname = rows[i]['firstname'] == "" || rows[i]['firstname'] == null ? "" : rows[i]['firstname'];
                var companyname = rows[i]['companyname'] == "" || rows[i]['companyname'] == null ? "" : rows[i]['companyname'];
                var icc = rows[i]['bustype'] == "" || rows[i]['bustype'] == null ? "" : rows[i]['bustype'];
                var resultexpected = rows[i]['resultexpecteddesc'] == "" || rows[i]['resultexpecteddesc'] == null ? "" : rows[i]['resultexpecteddesc'];
                var specresult = rows[i]['specificresult'] == "" || rows[i]['specificresult'] == null ? "" : rows[i]['specificresult'];
                var othppl = rows[i]['cmpresent'] == "" || rows[i]['cmpresent'] == null ? "" : rows[i]['cmpresent']; 
                taskdt = ((new Date(rows[i]['taskdt'])).setHours(0, 0, 0, 0));
                if(taskdt < today){
                    bgtaskdate = "overduedt";
                    // duetasks++;
                }else if(taskdt == today){
                    bgtaskdate = "duetoday";
                    // duetoday++;
                }else{
                    bgtaskdate = "";
                }

                if(medcnt > 0){
                    lob +='med ';
                }
                if(lifecnt > 0){
                    lob +='li ';
                }
                if(gencnt > 0){
                    lob +='gi ';
                }
                // console.log(lob);

        		// switch(rows[i]['tasktype']){
        		// 	case "c": ttlcalls++; break;
        		// 	case "m": ttlmtgs++; break;
        		// 	case "cm": ttlcm++; break;
        		// 	default: break;
        		// }
                goto = "goto('"+ rows[i]['uid'] +"','"+ rows[i]['taskid'] +"');";
	            html += '<tr style="cursor: pointer;" onClick="return '+goto+'">';
	                html += '<td class="text-center '+ bgtaskdate +'">'+ rows[i]['taskdt'] +'</td>';
	                html += '<td class="text-center">'+ ttype +'</td>';
                    html += '<td>'+ lastname +'</td>';
	                html += '<td>'+ firstname +'</td>';
	                html += '<td>'+ companyname +'</td>';
	                html += '<td class="text-center">'+ icc +'</td>';
                    html += '<td class="text-center">'+ lob +'</td>';
                    html += '<td class="text-center">'+ othppl +'</td>';
	                html += '<td>'+ resultexpected +'</td>';
	                html += '<td>'+ specresult +'</td>';
	            html += '</tr>';
	            // ttltasks++;
	        }
        }
        html += '</tbody>';
    html += '</table>';
    $("#tbltaskspending").html(html);
    
}

function genTasksPendingCheckBox(data){
    // console.log(data);
    var rows = data['rows'];
    var html = "";
    var today = ((new Date()).setHours(0, 0, 0, 0));
    var bgtaskdate = "";
    var taskdt = "";
    var taskdate = "return sortingTask('taskdate');";
    var tasktyp= "return sortingTask('tasktyp');";
    var lname = "return sortingTask('lname');";
    var fname = "return sortingTask('fname');";
    var company = "return sortingTask('company');";
    var ic = "return sortingTask('ic');";
    var resexpected = "return sortingTask('resexpected');";
    var specificres = "return sortingTask('specificres');";
    html = '<table class="table table-striped jambo_table table-condensed table-hover table-bordered">';
        html += '<thead>';
        html += '<tr>';
            html += '<th class="row-1 row-taskno"><input type="checkbox" id = "selectall"></th>';
            html += '<th style="cursor: pointer;" width="10%" onClick="' + taskdate + '">Task Date</th>';
            html += '<th style="cursor: pointer;" width="10%" onClick="' + tasktyp + '">Task Type</th>';
            html += '<th style="cursor: pointer;" width="10%" onClick="' + lname + '">LAST NAME</th>';
            html += '<th style="cursor: pointer;" width="10%" onClick="' + fname + '">First Name</th>';
            html += '<th style="cursor: pointer;" width="10%" onClick="' + company + '">Company</th>';
            html += '<th style="cursor: pointer;" width="5%" onClick="' + ic + '">ica</th>';
            html += '<th width="5%">lob</th>';
            html += '<th width="5%">ot ppl</th>';
            html += '<th style="cursor: pointer;" width="15%" onClick="' + resexpected + '">Result Expected</th>';
            html += '<th style="cursor: pointer;" width="20%" onClick="' + specificres + '">Specific Result</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';
        var goto = "";
        for(var i=0;i<rows.length;i++){
            if(rows[i]['status'] == 0){
                bgtaskdate = "";
                var lob = "";
                var medcnt = rows[i]['medcnt'];
                var lifecnt = rows[i]['lifecnt'];
                var gencnt = rows[i]['gencnt'];
                var medcnt = rows[i]['medcnt'] == "" || rows[i]['medcnt'] == null ? "" : rows[i]['medcnt'];
                var lifecnt = rows[i]['lifecnt'] == "" || rows[i]['lifecnt'] == null ? "" : rows[i]['lifecnt'];
                var gencnt = rows[i]['gencnt'] == "" || rows[i]['gencnt'] == null ? "" : rows[i]['gencnt'];
                var ttype = rows[i]['tasktypedesc'] == "" || rows[i]['tasktypedesc'] == null ? "" : rows[i]['tasktypedesc'];
                var lastname = rows[i]['lastname'] == "" || rows[i]['lastname'] == null ? "" : rows[i]['lastname'];
                var firstname = rows[i]['firstname'] == "" || rows[i]['firstname'] == null ? "" : rows[i]['firstname'];
                var companyname = rows[i]['companyname'] == "" || rows[i]['companyname'] == null ? "" : rows[i]['companyname'];
                var icc = rows[i]['bustype'] == "" || rows[i]['bustype'] == null ? "" : rows[i]['bustype'];
                var resultexpected = rows[i]['resultexpecteddesc'] == "" || rows[i]['resultexpecteddesc'] == null ? "" : rows[i]['resultexpecteddesc'];
                var specresult = rows[i]['specificresult'] == "" || rows[i]['specificresult'] == null ? "" : rows[i]['specificresult'];
                var othppl = rows[i]['cmpresent'] == "" || rows[i]['cmpresent'] == null ? "" : rows[i]['cmpresent'];
                taskdt = ((new Date(rows[i]['taskdt'])).setHours(0, 0, 0, 0));
                if(taskdt < today){
                    bgtaskdate = "overduedt";
                    // duetasks++;
                }else if(taskdt == today){
                    bgtaskdate = "duetoday";
                    // duetoday++;
                }else{
                    bgtaskdate = "";
                }

                if(medcnt > 0){
                    lob +='med ';
                }
                if(lifecnt > 0){
                    lob +='li ';
                }
                if(gencnt > 0){
                    lob +='gi ';
                }
                // switch(rows[i]['tasktype']){
                //  case "c": ttlcalls++; break;
                //  case "m": ttlmtgs++; break;
                //  case "cm": ttlcm++; break;
                //  default: break;
                // }
                goto = "goto('"+ rows[i]['uid'] +"','"+ rows[i]['taskid'] +"');";
                html += '<tr >';
                    html += '<td class="text-center"><input type="checkbox" name = "taskid" value = "' + rows[i]['taskid'] + '"></td>';
                    html += '<td class="text-center '+ bgtaskdate +'" style="cursor: pointer;" onClick="return '+goto+'">'+ rows[i]['taskdt'] +'</td>';
                    html += '<td class="text-center" style="cursor: pointer;" onClick="return '+goto+'">'+ ttype +'</td>';
                    html += '<td style="cursor: pointer;" onClick="return '+goto+'">'+ lastname +'</td>';
                    html += '<td style="cursor: pointer;" onClick="return '+goto+'">'+ firstname +'</td>';
                    html += '<td style="cursor: pointer;" onClick="return '+goto+'">'+ companyname +'</td>';
                    html += '<td class="text-center">'+ icc +'</td>';
                    html += '<td class="text-center">'+ lob +'</td>';
                    html += '<td class="text-center">'+ othppl +'</td>';
                    html += '<td style="cursor: pointer;" onClick="return '+goto+'">'+ resultexpected +'</td>';
                    html += '<td style="cursor: pointer;" onClick="return '+goto+'">'+ specresult +'</td>';
                html += '</tr>';
                // ttltasks++;
            }
        }
        html += '</tbody>';
    html += '</table>';
    $("#tbltaskspendingcheckbox").html(html);
    
}

function genTasksDone(data){
    var rows = data['rows'];
    var html = "";
    html = '<table class="table table-striped jambo_table table-condensed table-hover table-bordered">';
        html += '<thead>';
        html += '<tr>';
			html += '<th width="10%">Task Date</th>';
			html += '<th width="10%">Task Type/th>';			
			html += '<th width="10%">LAST NAME</th>';
			html += '<th width="10%">First Name</th>';
			html += '<th width="10%">Company</th>';
			html += '<th width="5%">ica</th>';
            html += '<th width="5%">lob</th>';
            html += '<th width="5%">ot ppl</th>';
			html += '<th width="15%">Result Expected</th>';
			html += '<th width="20%">Specific Result</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';
        for(var i=0;i<rows.length;i++){
        	if(rows[i]['status'] == 1){
                var lob = "";
                var medcnt = rows[i]['medcnt'];
                var lifecnt = rows[i]['lifecnt'];
                var gencnt = rows[i]['gencnt'];
                var othppl = rows[i]['cmpresent'] == "" || rows[i]['cmpresent'] == null ? "" : rows[i]['cmpresent']; 
                if(medcnt > 0){
                    lob +='med ';
                }
                if(lifecnt > 0){
                    lob +='li ';
                }
                if(gencnt > 0){
                    lob +='gi ';
                }

	            html += '<tr>';
	                html += '<td class="text-center">'+ rows[i]['taskdt'] +'</td>';
	                html += '<td class="text-center">'+ rows[i]['tasktypedesc'] +'</td>';
                    html += '<td>'+ rows[i]['lastname'] +'</td>';
	                html += '<td>'+ rows[i]['firstname'] +'</td>';
	                html += '<td>'+ rows[i]['companyname'] +'</td>';
	                html += '<td class="text-center">'+ rows[i]['bustype'] +'</td>';
                    html += '<td class="text-center">'+ lob +'</td>';
                    html += '<td class="text-center">'+ othppl +'</td>';
	                html += '<td>'+ rows[i]['resultexpecteddesc'] +'</td>';
	                html += '<td>'+ rows[i]['specificresult'] +'</td>';
	            html += '</tr>';
	        }
        }
        html += '</tbody>';
    html += '</table>';
    $("#tbltasksdone").html(html);
}

function goto(id,tid){
    window.location="cdm.php?id="+ id +"&taskid="+tid;
}

function sortingTask(sortby){
    var url = getAPIURL() + 'tasks.php';
    var f = "sortingTask";
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

    var data = { "f":f, "userid":userid, "sortby":sortby, "sortin":sortin };
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
                    var tasks = data['tasks'];
                    genTasksPending(tasks);
                    genTasksDone(tasks);
                    $.unblockUI();
                    // return false;
                }
                ,error: function(request, status, err){

                }
            });
        }
    });     
}

function searchTask(){
    var url = getAPIURL() + 'tasks.php';
    var f = "searchTask";
    var id = $("#sesid").val();
    var userid = $("#userid").val();
    var searchtext=$("#txtSearch").val();
    var searchby=$("#txtSearchBy").val();

    var data = { "f":f, "userid":userid,"searchtext":searchtext,"searchby":searchby};
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
                    genTasksPending(tasks);
                    genTasksDone(tasks);
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
    var url = getAPIURL() + 'tasks.php';
    var f = "filterHeaderSearch";
    var id = $("#sesid").val();
    var userid = $("#userid").val();
    

    var data = { "f":f, "userid":userid, "headerval":headerval};
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
            var tasks = data['search'];
            genTasksPending(tasks);
            genTasksDone(tasks);
            $.unblockUI();
            // return false;
        }
        ,error: function(request, status, err){

        }
    });
}

function countTaskHeaders(data){
    // console.log(data);
    var rows = data['rows'];
    var duetasks = 0;
    var duetoday = 0;
    var ttltasks = 0;
    var ttlcalls = 0;
    var ttlmtgs = 0;
    var ttlcm = 0;
    var today = ((new Date()).setHours(0, 0, 0, 0));
    var taskdt = "";

    for(var i=0;i<rows.length;i++){
        if(rows[i]['status'] == 0){
            ttltasks++;
            if(rows[i]['tasktype'] == 'c'){
                ttlcalls++;
            } else if(rows[i]['tasktype'] == 'm'){
                ttlmtgs++;
            } else if(rows[i]['tasktype'] == 'cm'){
                ttlcm++;
            }

            taskdt = ((new Date(rows[i]['taskdate'])).setHours(0, 0, 0, 0));
            if(taskdt < today){
                duetasks++;
            }else if(taskdt == today){
                duetoday++;
            }
        }
    }

    // for(var i=0;i<rows.length;i++){
    //     taskdt = ((new Date(rows[i]['taskdate'])).setHours(0, 0, 0, 0));
    //     if(taskdt < today){
    //         duetasks++;
    //     }else if(taskdt == today){
    //         duetoday++;
    //     }
    // }

    $("#datattltasks").html(ttltasks);
    $("#datattlcalls").html(ttlcalls);
    $("#datattlmtgs").html(ttlmtgs);
    $("#datattlcm").html(ttlcm);
    $("#dataduetasks").html(duetasks);
    $("#dataduetoday").html(duetoday);
    // console.log(rows);  
}
function bulkUpdateSwitch(){
    var bulkupdate = $("#bulkupdate").val();
    var column = "table ." + $(this).attr("");
    $("#tabs").tabs("select", "#tasks");
    if(bulkupdate == 'Off'){
        $("#bulkupdate").val('On');
        $("#divBulkUpdate").show();
        $("#tbltaskspendingcheckbox").show();
        $("#tbltaskspending").hide();        
    } else {
        $("#bulkupdate").val('Off');
         $("#divBulkUpdate").hide();
        $("#tbltaskspendingcheckbox").hide();
        $("#tbltaskspending").show();
        clearUpdateTaskDates();
    }
   
}
function SelectAll(data){
    var rows = data['rows'];
    var rowcount = 0;
    var checkboxes =  document.getElementsByName("taskid");
    var checkall = $('input[name = "taskid"]:checked');
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

function getSelectedTasks(selecteddata){
    var url = getAPIURL() + 'tasks.php';
    var result = $('input[name = "taskid"]:checked');
    var fieldname = $("#txtField").val();
    var datereplace = $("#txtDateReplace").val();
   
    var f = "BulkUpdateTaskDates";
    var data = { "f":f, "fieldname":fieldname, "datereplace":datereplace, "selecteddata":selecteddata };

    // console.log(data);
    // return false;

    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify({ "data":data }),
        dataType: 'json'
        ,success: function(data){
        // console.log(data);
        loadTasks();
        $.unblockUI(); 
        }
        ,error: function(request, status, err){

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