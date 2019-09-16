$(function(){
    $( "#tabs" ).tabs();

    $("#pendingTDLCnt").on("click", function(){
        window.location="todolist.php";
    });

    $("#pipelineCnt").on("click", function(){
        window.location="opportunities.php";
    });

    $.blockUI({ 
		message: $('#preloader_image'), 
		fadeIn: 1000, 
		onBlock: function() {
			loadDefault();
		}
	});
});

function loadDefault(){
	var url = getAPIURL() + 'dashboard.php';
    var f = "loadDefault";
    // var id = $("#sesid").val();
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
        	console.log(data);
         //    return false;
            var tasks = data['tasks'];
            var tdl =data['tdl'];
            var opps =data['opps'];
            var acts = data['act'];
            genTask(tasks);
            genTDL(tdl);
            genOpps(opps);
            genActivities(acts);
            countDashboardHeaders(data);
            $.unblockUI();
            // return false;
        }
        ,error: function(request, status, err){

        }
    });

}

function genTask(data){
	var rows = data['rows'];
	var html = "";
	var today = ((new Date()).setHours(0, 0, 0, 0));
	var taskdt="";
	var bgtaskdate="";
	var taskdate ="";
	var tasktype ="";
	var lname = "";
	var fname = "";
	var companyname = "";
	var bustype = "";
	var resexpected = "";
	var speccres ="";

	html = '<table class="table table-striped jambo_table table-condensed table-hover table-bordered">';
        html += '<thead>';
        html += '<tr>';
			html += '<th width = "100">Task Date</th>';
			html += '<th>Task Type </th>';
			html += '<th>LAST NAME </th>';
			html += '<th>First Name </th>';
			html += '<th>Company </th>';
			html += '<th>ic </th>';
			html += '<th width = "80">lob </th>';
			html += '<th>Result Expected</th>';
			html += '<th>Specific Result</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';
        var goto = "";
        for(var i=0;i<rows.length;i++){
        	taskdate = rows[i]["taskdt"]=="" || rows[i]["taskdt"]==null ? "" : rows[i]["taskdt"];
        	tasktype = rows[i]["tasktypedesc"]=="" || rows[i]["tasktypedesc"]==null ? "" : rows[i]["tasktypedesc"];
        	lname = rows[i]["lastname"]=="" || rows[i]["lastname"]==null ? "" : rows[i]["lastname"];
        	fname = rows[i]["firstname"]=="" || rows[i]["firstname"]==null ? "" : rows[i]["firstname"];
        	companyname = rows[i]["companyname"]=="" || rows[i]["companyname"]==null ? "" : rows[i]["companyname"];
        	bustype = rows[i]["bustype"]=="" || rows[i]["bustype"]==null ? "" : rows[i]["bustype"];
        	resexpected = rows[i]["resultexpecteddesc"]=="" || rows[i]["resultexpecteddesc"]==null ? "" : rows[i]["resultexpecteddesc"];
        	speccres = rows[i]["specificresult"]=="" || rows[i]["specificresult"]==null ? "" : rows[i]["specificresult"];

        	if(rows[i]['status'] == 0){
                bgtaskdate = "";
                var lob = "";
	            var medcnt = rows[i]['medcnt'];
	            var lifecnt = rows[i]['lifecnt'];
	            var gencnt = rows[i]['gencnt'];

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

                if(taskdt <= today){
	                goto = "gotoTask('"+ rows[i]['uid'] +"','"+ rows[i]['taskid'] +"');";
		            html += '<tr style="cursor: pointer;" onClick="return '+goto+'">';
		                html += '<td class="text-center '+ bgtaskdate +'">'+ taskdate +'</td>';
		                html += '<td class="text-center">'+ tasktype +'</td>';
	                    html += '<td>'+ lname +'</td>';
		                html += '<td>'+ fname +'</td>';
		                html += '<td>'+ companyname +'</td>';
		                html += '<td class="text-center">'+ bustype +'</td>';
		                html += '<td class="text-center">'+ lob +'</td>';
		                html += '<td>'+ resexpected +'</td>';
		                html += '<td>'+ speccres +'</td>';
		            html += '</tr>';
	        	}
	            // ttltasks++;
	        }
        }
        html += '</tbody>';
    html += '</table>';
	$("#tlbclttasks").html(html);
// 	// console.log(rows);
	// console.log(data);
}

function genTDL(data){
	var rows=data['rows'];
	var html = "";
	var today = ((new Date()).setHours(0, 0, 0, 0));
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
	var fuw = "";
	var countrows = 0;
	html='<table class="table table-striped jambo_table table-condensed table-hover table-bordered tdlcolwidth">';
	    html+='<thead>';
	        html+='<tr>';
	            // html+='<th class="row-1 row-taskno">#</th>';
	            html+='<th>type</th>';
	            html+='<th>task or to do</th>';
	            html+='<th>priority </th>';
	            html+='<th>category </th>';
	            html+='<th>fuw </th>';
	            html+='<th>ofc </th>';
	            html+='<th>oth ppl </th>';
	            // html+='<th">psd</th>';
	            // html+='<th>pfu</th>';
	            html+='<th>start date</th>';
	            html+='<th>next ctc date </th>';
	            html+='<th>due dt </th>';
	            // html+='<th class="row-1 row-taskno"># of Rev </th>';
	            html+='<th name="status">status</th>';
	            // html+='<th class="colfixedwidth">FUM link </th>';
	            // html+='<th>remarks </th>';
	            // html+='<th width="4">View / Edit</th>';
	        html+='</tr>';
	    html+='</thead>';
	    html+='<tbody>';
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
		     	fuw=rows[i]['fuw']=="" || rows[i]['fuw']==null ? "" : rows[i]['fuw'];
		     	priority=rows[i]['priority'];
		     	duedt = ((new Date(duedate)).setHours(0, 0, 0, 0));
		     	nxtctcdt = ((new Date(nextctcdate)).setHours(0, 0, 0, 0));
		     	bgcolor ="";
		     	noofrevisions=rows[i]['noofrevisions'];
		     	fumtext=rows[i]["fumtext"]=="" || rows[i]["fumtext"]==null ? "" : rows[i]["fumtext"];

		     	if (statuspercent < 100){
		     		if (priority=="med"){
		     		priority="m";
			     	}
			     	if (duedt < today){
			     		bgcolorduedt = 'overduedt';
			     		// cntover++;
			     	} else if (duedt == today) {
			     		bgcolorduedt ='duetoday';
			     		// cntdue++;
			     	} else {
			     		bgcolorduedt ="";
			     	}

			     	if (nxtctcdt < today){
			     		bgcolornextctcdt = 'overduedt';
			     	} else if (nxtctcdt == today) {
			     		bgcolornextctcdt ='duetoday';
			     	} else {
			     		bgcolornextctcdt ="";
			     	}
			     	if(nxtctcdt<=today){
			     		// var goto ="";
			     		goto = "gotoTDL('"+ rows[i]['activityid'] +"');";
			     		// console.log(rows[i]['activityid']);
				     	html+='<tr style="cursor: pointer;" onClick = "' + goto +'">';
				         	// html+='<td class="text-center " onClick="' + activityid + '";>'+ cnt +'</td>';
				            html+='<td class="text-center" >'+ tasktype +'</td>';
				            html+='<td class="text-left" >'+ rows[i]['taskortodo'] +'</td>';
				            html+='<td class=" text-center" >'+ priority +'</td>';
				            html+='<td class="text-center" >'+ rows[i]['category'] +'</td>';
				            html+='<td class="text-center" >'+ fuw +'</td>';
				            html+='<td class="text-center" >'+ ofc +'</td>';
				            html+='<td class="text-center" >'+ othppl +'</td>';
				            // html+='<td class="text-center" >'+ psd +'</td>';
				            // html+='<td class="text-center" >'+ pfu +'</td>';
				            html+='<td class="text-center" >'+ startdate +'</td>';
				            html+='<td class="text-center '+ bgcolornextctcdt +'" >'+ nextctcdate +'</td>';
				            html+='<td class="text-center '+ bgcolorduedt +'">'+ duedate +'</td>';
				            // html+='<td class="text-center" onClick="' + activityid + '";>' + noofrevisions +'</td>';
				            html+='<td class="text-center" >'+ statuspercent +'</td>';
				            // html+='<td class="text-center"><a href=" ' + fumlink + ' " title="'+ fumlink +'" target="_blank"> ' + fumtext + ' </a></td>';
				            // html+='<td class="text-left" onClick="' + activityid + '";>'+ remarks +'</td>';
				            // edittdl="return updateTDL('"+ rows[i]['activityid'] +"')";
				            // html+='<td class="text-center"><a href="#" onClick="'+edittdl+'"><i class="fa fa-pencil-square-o vieweditico"></i></a></td>';
				        html+='</tr>';
			   		} 
			    }
    		}
	    html+='<tbody>';
	html +='</table>';
	$('#tbltodolist').html(html);
	// console.log(countrows);
}

function genOpps(data){
	var rows=data['rows'];
	var html = "";
	var lname = "";
	var fname ="";
	var companyname = "";
	var bustype = "";
	var prodtype = "";
	var ccy = "";
	var status = "";
	var prem = 0;
	html = '<table class="table table-striped jambo_table table-condensed table-hover table-bordered">';
        html += '<thead>';
        html += '<tr>';
			html += '<th>LAST NAME </th>';
			html += '<th>First Name </th>';
			html += '<th>Company </th>';
			html += '<th>ic</th>';
			html += '<th>Product</th>';
			html += '<th>Start rw Target dt </th>';
			html += '<th width="5">Currency</th>';
			html += '<th width="5">Premium</th>';
            html += '<th width="10">Premium HKD</th>';
			html += '<th width="5">aba Rev %</th>';
            html += '<th width="5">aba Rev HKD</th>';
			html += '<th width="5">Status</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';
        var srwtargetdt = "";
        var goto = "";
        var ttlPrem=0;
        for(var i=0;i<rows.length;i++){
            srwtargetdt = rows[i]['srwtargetdt'] == "" || rows[i]['srwtargetdt'] == null ? "" : rows[i]['srwtargetdt'];
            lname = rows[i]['lastname'] == "" || rows[i]['lastname'] == null ? "" : rows[i]['lastname'];
            fname = rows[i]['firstname'] == "" || rows[i]['firstname'] == null ? "" : rows[i]['firstname'];
            companyname = rows[i]['companyname'] == "" || rows[i]['companyname'] == null ? "" : rows[i]['companyname'];
            bustype = rows[i]['bustype'] == "" || rows[i]['bustype'] == null ? "" : rows[i]['bustype'];
            prodtype = rows[i]['prodtypedesc'] == "" || rows[i]['prodtypedesc'] == null ? "" : rows[i]['prodtypedesc'];
            ccy = rows[i]['ccy'] == "" || rows[i]['ccy'] == null ? "" : rows[i]['ccy'];
            status = rows[i]['statusdesc'] == "" || rows[i]['statusdesc'] == null ? "" : rows[i]['statusdesc'];
            prem = rows[i]['premium'] == "" || rows[i]['premium'] == null ? 0 : rows[i]['premium'];
        	if(rows[i]['oppsstatus'] == 'p' || rows[i]['oppsstatus'] == 'q' || rows[i]['oppsstatus'] == 'c'){
                goto = "gotoOpps('"+ rows[i]['uid'] +"','"+ rows[i]['oppsid'] +"');";
	            html += '<tr style="cursor: pointer;" onClick="return '+goto+'">';
	                html += '<td>'+lname +'</td>';
	                html += '<td>'+ fname +'</td>';
	                html += '<td>'+ companyname +'</td>';
	                html += '<td class="text-center">'+ bustype +'</td>';
	                html += '<td>'+ prodtype+'</td>';
	                html += '<td class="text-center">'+ srwtargetdt +'</td>';
	                html += '<td class="text-center">'+ ccy +'</td>';
                    // html += '<td class="text-right">'+ rows[i]['potential'] +'%</td>';
                    html += '<td class="text-right">'+ addCommas(prem) +'</td>';
                    html += '<td class="text-right">'+ addCommas(rows[i]['premiumhkd'])+'</td>';
                    html += '<td class="text-right">'+ rows[i]['comrate'] +'%</td>';
                    html += '<td class="text-right">'+ addCommas(rows[i]['abarevhkd']) +'</td>';
	                html += '<td class="text-center">'+ status +'</td>';
	                // html += '<td class="text-center"><a href="cdm.php?id='+ rows[i]['uid'] +'"><i class="fa fa-pencil-square-o vieweditico"></i></a></td>';
	            html += '</tr>';
	            // ttlopps++;

	            ttlPrem += parseInt(rows[i]['abarevhkd']);   
	        }
        }
        // html += '<tr>';
        // 	html += '<td colspan = "9" class = "text-right">Total:' + addCommas(ttlPrem) + '</td>';
        // html += '</tr>';
        // html += '</tbody>';
    html += '</table>';
    $("#tblpipeline").html(html);
 // console.log(data)
}
function genActivities(data){
    var acts = data['rows'];
    var html = "";
    var curcreadt = "";
    var crcdate="";
    var acttype = "";
    var curr = new Date;
    var firstdaywk = new Date(new Date(curr.setDate(curr.getDate() - curr.getDay()))).setHours(0, 0, 0, 0);
    var lastdaywk = new Date(new Date(curr.setDate(curr.getDate() - curr.getDay()+6))).setHours(0, 0, 0, 0);
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
function gotoTask(id,tid){
    window.location="cdm.php?id="+ id +"&taskid="+tid;
}
function gotoTDL(activityid){
	// console.log(activityid);
    window.location="todolist.php?activityid="+activityid;
}
function gotoOpps(id,oppsid){
    window.location="cdm.php?id="+id+"&oppsid="+oppsid;
}

function SearchCltPros(){
    var url = getAPIURL() + 'opportunities.php';
    var f = "SearchCltPros";
    var id = $("#sesid").val();
    var userid = $("#userid").val();
    var searchtext=$("#txtSearch").val();

    var data = { "f":f, "userid":userid,"searchtext":searchtext};

    // console.log(data);
    // return false;

    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify({ "data":data }),
        dataType: 'json'
        ,success: function(data){
            var rows = [];
            rows = data['search'];
            // console.log(rows);
             // return false;
            genOpps(rows);
        }
        ,error: function(request, status, err){

        }
    });
}

function countDashboardHeaders(data){
	var tasks = data['tasks']['rows'];
	var tdl = data['tdl']['rows'];
	var opps = data['opps']['rows'];
	var ppl = data['ppl'][0];
	var today = ((new Date()).setHours(0, 0, 0, 0));
	var nextctcdt = "";
	var taskdt = "";
	var ttltaskpending = 0;
	var ttltdlpending = 0;
	var ttlopps = 0;
	var ttlabarevOpsYTD = 0;
	var ttlabarevOpsNextYTD = 0;
	var ttlSignedYTD = 0;
	var ttlSignedNextYTD = 0;
	var ttlSPIYTD = 0;
	
	var firstDay = (new Date(new Date().getFullYear(), 0, 1,0,0,0)).setHours(0, 0, 0, 0);
    var lastDay = (new Date(new Date().getFullYear(), 11, 31,0,0,0)).setHours(0, 0, 0, 0);
    var jan1 =   (new Date(new Date().getFullYear(), 12, 1,0,0,0)).setHours(0, 0, 0, 0);
	
	//var firstdaywk = new Date(new Date(curr.setDate(curr.getDate() - curr.getDay()))).setHours(0, 0, 0, 0);
    //var lastdaywk = new Date(new Date(curr.setDate(curr.getDate() - curr.getDay()+6))).setHours(0, 0, 0, 0);
	var ytdtarget = ppl['ytdtarget'] == 0 || ppl['ytdtarget'] == null ? 0 : ppl['ytdtarget'];
	 //console.log(ytdtarget);
	for(var i=0;i<tasks.length;i++){
		taskdt = ((new Date(tasks[i]['taskdt'])).setHours(0, 0, 0, 0));
		if(tasks[i]['status']==0){
			if(taskdt <= today){
        		ttltaskpending++;
    		}
		}
  	}

  	for(var i=0;i<tdl.length;i++){
		nextctcdt = ((new Date(tdl[i]['nextctcdt'])).setHours(0, 0, 0, 0));
		if (tdl[i]['statuspercent'] < 100){
			if(nextctcdt <= today){
	        	ttltdlpending++;
	    	}
    	}
  	}
	
  	for(var i=0;i<opps.length;i++){
  		var targetdt = opps[i]['srwtargetdt'];
  		// var polissueddt = opps[i]['polissueddate'];
  		var signeddt = opps[i]['signeddt'];
  		var polissueddt = opps[i]['polissueddt'];

        targetdt=((new Date(targetdt)).setHours(0, 0, 0, 0));
        signeddt=((new Date(signeddt)).setHours(0, 0, 0, 0));
        polissueddt=((new Date(polissueddt)).setHours(0, 0, 0, 0));
        

		if (opps[i]['oppsstatus'] == 'p' || opps[i]['oppsstatus'] == 'q' || opps[i]['oppsstatus'] == 'c'){
            ttlopps++;
            //get ttl opps YTD
            if(targetdt >= firstDay && targetdt <= lastDay){
            	ttlabarevOpsYTD += parseInt(opps[i]['abarevhkd']);
            }
            //get ttl opps for next year
			if(targetdt == jan1){
	            ttlabarevOpsNextYTD+=parseInt(opps[i]['abarevhkd']);
	        }
        }
        else if(opps[i]['oppsstatus'] == 's') {
        	//get ttl signed YTD
        	if(targetdt >= firstDay && targetdt <= lastDay){
	 			ttlSignedYTD += parseInt(opps[i]['abarevhkd']);
        	}
        	 //get ttl signed for next year
			if(targetdt == jan1){
	            ttlSignedNextYTD += parseInt(opps[i]['abarevhkd']);
	        }
        }
        else if(opps[i]['oppsstatus'] == 'sp'){
        	if(polissueddt >= firstDay && polissueddt <= lastDay){
        		ttlSPIYTD += parseInt(opps[i]['abarevhkd']);
        	}
        }
  	}
  	
	$("#pendingTaskCnt").html(ttltaskpending);
	$("#pendingTDLCnt").html(ttltdlpending);
	$("#pipelineCnt").html(ttlopps);
	$("#abaRevTotalOpsYTD").html(addCommas(ttlabarevOpsYTD));
	$("#abaRevTotalOpsNextYTD").html(addCommas(ttlabarevOpsNextYTD));
	$("#abaRevTotalSignedYTD").html(addCommas(ttlSignedYTD));
	$("#abaRevTotalSignedNextYTD").html(addCommas(ttlSignedNextYTD));
	$("#abaRevTotalSPIYTD").html(addCommas(ttlSPIYTD));
	$("#targetBDYTD").html(addCommas(ytdtarget));
	

	// var curdate = new Date();
	// var year = curdate.getFullYear();
	// var yr2digits = year.toString().substr(-2);
	// var monthshort = curdate.toLocaleString('default', { month: 'short' });
	// var firstdayoftheyear = (new Date(new Date().getFullYear(), 0, 1,0,0,0));
	// console.log(firstdayoftheyear);
	
}