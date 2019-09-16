$(function(){
    $( "#tabs" ).tabs();

    $("#btnSearch").on("click", function(){
        SearchCltPros();
    });
     $("#datattlsigned").on("click", function(){
        $("#tabs").tabs("select", "#signed");
    });
    $("#datattlspi").on("click", function(){
        $("#tabs").tabs("select", "#signedissued");
    });
    $("#datattllost").on("click", function(){
        $("#tabs").tabs("select", "#lost");
    });

    

    $.blockUI({ 
		message: $('#preloader_image'), 
		fadeIn: 1000, 
		onBlock: function() {
			loadOpps();
		}
	});
});

function loadOpps(){
	var url = getAPIURL() + 'opportunities.php';
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
            // return false
            var opps = data['opps'];
            genOppsSigned(opps);
            genOppsSignedIssued(opps);
            genOppsLost(opps);
            //count data
            countOppsHeaders(data);
            $.unblockUI();
            // return false;
        }
        ,error: function(request, status, err){

        }
    });
}

function genOppsSigned(data){
	// var ttlopps = 0;
    // console.log(data);
    var rows = data['rows'];
    var html = "";
    var lastname = "return SortingOpps('lname');";
    var firstname = "return SortingOpps('fname');";
    var companyname = "return SortingOpps('companyname');";
    var ic = "return SortingOpps('ic');";
    var product = "return SortingOpps('prod');";
    var startrwdt = "return SortingOpps('startrwdt');";
    var prem = "return SortingOpps('prem');";
    var stat = "return SortingOpps('stat');";
    var sharewith = "return SortingOpps('sharewith');";
    html = '<table class="table table-striped jambo_table table-condensed table-hover table-bordered">';
        html += '<thead>';
        html += '<tr>';
			html += '<th style="cursor: pointer;" width="10%" onClick="' + lastname + '">LAST NAME </th>';
			html += '<th style="cursor: pointer;" width="10%" onClick="' + firstname + '">First Name </th>';
			html += '<th style="cursor: pointer;" width="10%" onClick="' + companyname + '">Company </th>';
			html += '<th style="cursor: pointer;" width="5%" onClick="' + ic + '">ica</th>';
			html += '<th style="cursor: pointer;" width="10%" onClick="' + product + '">Product</th>';
			html += '<th style="cursor: pointer;" width="10%" onClick="' + startrwdt + '">Start rw Target dt </th>';
			html += '<th width="5%">Currency</th>';
			html += '<th style="cursor: pointer;" width="5%" onClick="' + prem + '">Premium</th>';
            html += '<th width="5%">Premium HKD</th>';
			html += '<th width="5%">aba Rev %</th>';
            html += '<th width="5%">aba Rev HKD</th>';
			html += '<th style="cursor: pointer;" width="10%" onClick="' + sharewith + '">Shared With</th>';
            html += '<th width="5%">aba rev share</th>';
            html += '<th width="5%">Signed Date</th>';
			// html += '<th style="cursor: pointer;" width="5" onClick="' + stat + '">Status</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';
        var srwtargetdt = "";
        var goto = "";
        var signeddt = "";
        var comp = "";
        var sharedabaini = "";
        var abarevshare = 0;
        var abarevhkd =0;
        for(var i=0;i<rows.length;i++){
			sharedabaini = "";
            abarevshare = 0;
            abarevhkd = 0;
            srwtargetdt = rows[i]['srwtargetdt'] == "" || rows[i]['srwtargetdt'] == null ? "" : rows[i]['srwtargetdt'];
            signeddt = rows[i]['signeddt'] == "" || rows[i]['signeddt'] == null ? "" : rows[i]['signeddt'];
			sharedabaini = rows[i]['sharedabaini'] == "" || rows[i]['sharedabaini'] == null ? "" : rows[i]['sharedabaini'];
			abarevhkd = rows[i]['abarevhkd'] == "" || rows[i]['abarevhkd'] == null ? 0 : rows[i]['abarevhkd'];
            comp = rows[i]['companyname'] == "" || rows[i]['companyname'] == null ? "" : rows[i]['companyname'];
			
			if(sharedabaini != ""){
				abarevshare = Math.trunc(abarevhkd / 2);
			}else{
				abarevshare = abarevhkd;
			}
			
        	if(rows[i]['oppsstatus'] == 's'){
                // console.log(rows[i]['oppsstatus']);
                goto = "goto('"+ rows[i]['uid'] +"','"+ rows[i]['oppsid'] +"');";
	            html += '<tr style="cursor: pointer;" onClick="return '+goto+'">';
	                html += '<td>'+ rows[i]['lastname'] +'</td>';
	                html += '<td>'+ rows[i]['firstname'] +'</td>';
	                html += '<td>'+ comp +'</td>';
	                html += '<td class="text-center">'+ rows[i]['bustype'] +'</td>';
	                html += '<td>'+ rows[i]['prodtypedesc'] +'</td>';
	                html += '<td class="text-center">'+ srwtargetdt +'</td>';
	                html += '<td class="text-center">'+ rows[i]['ccy'].toUpperCase() +'</td>';
                    // html += '<td class="text-right">'+ rows[i]['potential'] +'%</td>';
                    html += '<td class="text-right">'+ addCommas(rows[i]['premium']) +'</td>';
                    html += '<td class="text-right">'+ addCommas(rows[i]['premiumhkd'])+'</td>';
                    html += '<td class="text-right">'+ rows[i]['comrate'] +'%</td>';
                    html += '<td class="text-right">'+ addCommas(rows[i]['abarevhkd']) +'</td>';
					html += '<td>'+ sharedabaini +'</td>';
                    html += '<td class="text-right">'+ addCommas(abarevshare) +'</td>';
                    html += '<td class="text-center">'+ signeddt +'</td>';
	                // html += '<td class="text-center">'+ rows[i]['statusdesc'] +'</td>';
	                // html += '<td class="text-center"><a href="cdm.php?id='+ rows[i]['uid'] +'"><i class="fa fa-pencil-square-o vieweditico"></i></a></td>';
	            html += '</tr>';
	            // ttlopps++;   
	        }
        }
        html += '</tbody>';
    html += '</table>';
    $("#tbloppssigned").html(html);

    // $("#datattlopps").html(ttlopps);
}

function genOppsSignedIssued(data){
	// var ttlsigned = 0;
	// var ttllost = 0;
	// var ttlcancel = 0;
    var rows = data['rows'];
    var html = "";
    var srwtargetdt = "";
    
    html = '<table class="table table-striped jambo_table table-condensed table-hover table-bordered">';
        html += '<thead>';
        html += '<tr>';
			html += '<th width="10%">LAST NAME </th>';
			html += '<th width="10%">First Name </th>';
			html += '<th width="10%">Company </th>';
			html += '<th width="5%">ica</th>';
			html += '<th width="10%">Product</th>';
			html += '<th width="10%">Start Date </th>';
			html += '<th width="5%">Currency</th>';
			html += '<th width="5%">Premium</th>';
            html += '<th width="5%">Premium HKD</th>';
            html += '<th width="5%">aba Rev %</th>';
            html += '<th width="5%">aba Rev HKD</th>';
            html += '<th width="5%">Signed Date</th>';
			html += '<th width="10%">Shared With</th>';
            html += '<th width="5%">aba rev share</th>';
            html += '<th width="5%">Pol Issued Date</th>';
            html += '<th width="5%">Policy No</th>';
			// html += '<th width="5">Status</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';
        
        for(var i=0;i<rows.length;i++){
            var polnumber = rows[i]['polnumber'] == "" || rows[i]['polnumber'] == null ? "" : rows[i]['polnumber']; 
            var polissueddate = rows[i]['polissueddt'] == "" || rows[i]['polissueddt'] == null ? "" :rows[i]['polissueddt'];
            var signeddt = "";
            var goto = "";
			var sharedabaini = "";
			var abarevshare = 0;
			var abarevhkd = 0;
            var comp = "";
        	if(rows[i]['oppsstatus'] == 'sp'){
                if(polissueddate != null || polissueddate != ""){
            		srwtargetdt = rows[i]['srwtargetdt'] == "" || rows[i]['srwtargetdt'] == null ? "" : rows[i]['srwtargetdt'];
                    signeddt = rows[i]['signeddt'] == "" || rows[i]['signeddt'] == null ? "" : rows[i]['signeddt'];
                    goto = "goto('"+ rows[i]['uid'] +"','"+ rows[i]['oppsid'] +"');";
					sharedabaini = rows[i]['sharedabaini'] == "" || rows[i]['sharedabaini'] == null ? "" : rows[i]['sharedabaini'];
					abarevhkd = rows[i]['abarevhkd'] == "" || rows[i]['abarevhkd'] == null ? 0 : rows[i]['abarevhkd'];
                    comp = rows[i]['companyname'] == "" || rows[i]['companyname'] == null ? "" : rows[i]['companyname'];
			
					if(sharedabaini != ""){
						abarevshare = Math.trunc(abarevhkd / 2);
					}else{
						abarevshare = abarevhkd;
					}
					
    	            html += '<tr style="cursor: pointer;" onClick="return '+goto+'">';
    	                html += '<td>'+ rows[i]['lastname'] +'</td>';
    	                html += '<td>'+ rows[i]['firstname'] +'</td>';
    	                html += '<td>'+ comp +'</td>';
    	                html += '<td class="text-center">'+ rows[i]['bustype'] +'</td>';
    	                html += '<td>'+ rows[i]['prodtypedesc'] +'</td>';
    	                html += '<td class="text-center">'+ srwtargetdt +'</td>';
    	                html += '<td class="text-center">'+ rows[i]['ccy'].toUpperCase() +'</td>';
    	                html += '<td class="text-right">'+ addCommas(rows[i]['premium']) +'</td>';
                        html += '<td class="text-right">'+ addCommas(rows[i]['premiumhkd'])+'</td>';
                        html += '<td class="text-right">'+ rows[i]['comrate'] +'%</td>';
                        html += '<td class="text-right">'+ addCommas(abarevhkd) +'</td>';
                        html += '<td class="text-center">'+ signeddt +'</td>';
						html += '<td>'+ sharedabaini +'</td>';
                    	html += '<td class="text-right">'+ addCommas(abarevshare) +'</td>';
                        html += '<td class="text-center">'+ polissueddate +'</td>';
                        html += '<td>'+ polnumber +'</td>';
    	                // html += '<td class="text-center">'+ rows[i]['statusdesc'] +'</td>';
    	            html += '</tr>';
                }
	        }
        }
        html += '</tbody>';
    html += '</table>';
    $("#tbloppssignedpoissued").html(html);
    // $("#datattlsigned").html(ttlsigned);
    // $("#datattllost").html(ttllost);
}
function genOppsLost(data){
    // var ttlsigned = 0;
    // var ttllost = 0;
    // var ttlcancel = 0;
    var rows = data['rows'];
    var html = "";
    var srwtargetdt = "";
    var lostdt = "";
    var comp = "";
    html = '<table class="table table-striped jambo_table table-condensed table-hover table-bordered">';
        html += '<thead>';
        html += '<tr>';
            html += '<th width="15%">LAST NAME </th>';
            html += '<th width="15%">First Name </th>';
            html += '<th width="20%">Company </th>';
            html += '<th width="5%">ica</th>';
            html += '<th width="10%">Product</th>';
            html += '<th width="10%">Start rw Target dt </th>';
            html += '<th width="5%">Potential </th>';
            html += '<th width="5%">Currency</th>';
            html += '<th width="5%">Premium</th>';
            html += '<th width="5%">aba Rev %</th>';
            html += '<th width="5%">Lost Date</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';
        
        for(var i=0;i<rows.length;i++){
            if(rows[i]['oppsstatus'] == 'l'){
                srwtargetdt = rows[i]['srwtargetdt'] == "" || rows[i]['srwtargetdt'] == null ? "" : rows[i]['srwtargetdt'];
                lostdt = rows[i]['lostdt'] == "" || rows[i]['lostdt'] == null ? "" : rows[i]['lostdt'];
                comp = rows[i]['companyname'] == "" || rows[i]['companyname'] == null ? "" : rows[i]['companyname'];

                html += '<tr>';
                    html += '<td>'+ rows[i]['lastname'] +'</td>';
                    html += '<td>'+ rows[i]['firstname'] +'</td>';
                    html += '<td>'+ comp +'</td>';
                    html += '<td class="text-center">'+ rows[i]['bustype'] +'</td>';
                    html += '<td>'+ rows[i]['prodtypedesc'] +'</td>';
                    html += '<td class="text-center">'+ srwtargetdt +'</td>';
                    html += '<td class="text-right">'+ rows[i]['potential'] +'%</td>';
                    html += '<td class="text-center">'+ rows[i]['ccy'].toUpperCase() +'</td>';
                    html += '<td class="text-right">'+ addCommas(rows[i]['premium']) +'</td>';
                    html += '<td class="text-right">'+ rows[i]['comrate'] +'%</td>';
                    html += '<td class="text-center">'+ lostdt +'</td>';
                html += '</tr>';
            }
        }
        html += '</tbody>';
    html += '</table>';
    $("#tbllost").html(html);
    // $("#datattlsigned").html(ttlsigned);
    // $("#datattllost").html(ttllost);
}


function goto(id,oppsid){
    window.location="cdm.php?id="+id+"&oppsid="+oppsid;
}

function SortingOpps(sortby){
    var url = getAPIURL() + 'opportunities.php';
    var f = "SortingOpps";
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
                    // return false;
                    var opps = data['opps'];
                    genOppsSigned(opps);
                    genOppsSignedIssued(opps);
                    genOppsLost(opps);
                    $.unblockUI();
                    // return false;
                }
                ,error: function(request, status, err){

                }
            });
        }
    });
    
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
                    var opps = data['search'];
                    genOppsSigned(opps);
                    genOppsSignedIssued(opps);
                    genOppsLost(opps);
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
    var url = getAPIURL() + 'opportunities.php';
    var f = "filterHeaderSearch";
    var id = $("#sesid").val();
    var userid = $("#userid").val();
    

    var data = { "f":f, "userid":userid, "headerval":headerval };
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
            var opps = data['search'];
            genOppsSigned(opps);
            genOppsSignedIssued(opps);
            genOppsLost(opps);
            $.unblockUI();
            // return false;
        }
        ,error: function(request, status, err){

        }
    });
}

function countOppsHeaders(data){
    var rows = data['opps']['rows'];
    var ppl = data['ppl'][0];
    var ttlopps = 0;
    var ttlmedins = 0;
    var ttllins = 0;
    var ttlgenins = 0;
    var ttlsigned = 0;
    var ttllost = 0;
    var ttlspi = 0;
    var ttlSignedYTD = 0;
    var ttlSignedNextYTD = 0;
    var ttlSPIYTD = 0;
    var date = new Date();
    var year = date.getFullYear();
    var month = date.getMonth();
    var firstDay = (new Date(new Date().getFullYear(), 0, 1,0,0,0)).setHours(0, 0, 0, 0);
    var lastDay = (new Date(new Date().getFullYear(), 11, 31,0,0,0)).setHours(0, 0, 0, 0);
    var jan1 =   (new Date(new Date().getFullYear(), 12, 1,0,0,0)).setHours(0, 0, 0, 0);
    // console.log(jan1);
    var abarev = 0;

    var curr = new Date;
    var firstdaywk = new Date(new Date(curr.setDate(curr.getDate() - curr.getDay()))).setHours(0, 0, 0, 0);
    var lastdaywk = new Date(new Date(curr.setDate(curr.getDate() - curr.getDay()+6))).setHours(0, 0, 0, 0);

    var ytdtarget =  ppl['ytdtarget'] == "" || ppl['ytdtarget'] == null ? 0 : ppl['ytdtarget'];

    for(var i=0;i<rows.length;i++){
        var abarev = rows[i]['abarevhkd'];
        var targetdt = rows[i]['srwtargetdt'];
        var signeddt = rows[i]['signeddate'];
        var polissueddt = rows[i]['polissueddt'];
        targetdt=((new Date(targetdt)).setHours(0, 0, 0, 0));
        signeddt=((new Date(signeddt)).setHours(0, 0, 0, 0));
        polissueddt=((new Date(polissueddt)).setHours(0, 0, 0, 0));
        if (rows[i]['oppsstatus'] == 'p' || rows[i]['oppsstatus'] == 'q' || rows[i]['oppsstatus'] == 'c'){
            ttlopps++;
            if (rows[i]['producttype'] == 'm'){
                ttlmedins++;
            } else if (rows[i]['producttype'] == 'l'){
                ttllins++;
            } else if (rows[i]['producttype'] == 'g'){
                ttlgenins++;
            }
        } else if (rows[i]['oppsstatus'] == 's'){
            if(targetdt>=firstDay && targetdt<=lastDay){
                ttlSignedYTD+=parseFloat(rows[i]['abarevhkd']);
                ttlsigned++;
            }
            if(targetdt == jan1){
                ttlSignedNextYTD+=parseFloat(rows[i]['abarevhkd']);
            }
        } else if (rows[i]['oppsstatus'] == 'sp'){
          
           if(polissueddt>=firstDay && polissueddt<=lastDay){
                ttlSPIYTD += parseFloat(rows[i]['abarevhkd']);
                 ttlspi++;
                // ttlSignedYTD += parseFloat(rows[i]['abarevhkd']);
            }
        } else if (rows[i]['oppsstatus'] == 'l'){
            ttllost++;
        }
    }

    // console.log(ttlSPIYTD);

    $("#datattlmedins").html(ttlmedins);
    $("#datattllins").html(ttllins);
    $("#datattlgenins").html(ttlgenins);
    $("#datattlsigned").html(ttlsigned);
    $("#datattlspi").html(ttlspi);
    $("#datattllost").html(ttllost);
	$("#abaRevTotalSignedYTD").html(addCommas(ttlSignedYTD));
    $("#abaRevTotalSignedNextYTD").html(addCommas(ttlSignedNextYTD));
    $("#abaRevTotalSPIYTD").html(addCommas(ttlSPIYTD));
    $("#targetBDYTD").html(addCommas(ytdtarget));
}
