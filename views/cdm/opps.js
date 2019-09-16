$(function(){
    $( "#tabs,#tabs2" ).tabs();

    $("#btnSearch").on("click", function(){
        SearchCltPros();
    });
    $("#datattlopps").on("click", function(){
        $("#tabs").tabs("select", "#opps");
        var headerval = "ttlops";
        $("#headerclickval").val(headerval);
        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                filterSearch(headerval);
            }
        });
    });
    $("#datattlmedins").on("click", function(){
        // $("#divttlmedins").addClass("active-header");
        $("#tabs").tabs("select", "#opps");
        var headerval = "ttlmedins";
        $("#headerclickval").val(headerval);
        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                filterSearch(headerval);
            }
        });
    });
    $("#datattllins").on("click", function(){
        $("#tabs").tabs("select", "#opps");
        var headerval = "ttllins";
        $("#headerclickval").val(headerval);
        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                filterSearch(headerval);
            }
        });
    });

    $("#datattlgenins").on("click", function(){
        $("#tabs").tabs("select", "#opps");
        var headerval = "ttlgenins";
        $("#headerclickval").val(headerval);
        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                filterSearch(headerval);
            }
        });
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
//             console.log(data);
            // return false
            var opps = data['opps'];
            genOppsPending(opps);
            // genOppsSigned(opps);

            //count data
            countOppsHeaders(opps);
            $.unblockUI();
            // return false;
        }
        ,error: function(request, status, err){

        }
    });
}

function genOppsPending(data){
	// var ttlopps = 0;
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
			html += '<th style="cursor: pointer;" width="8%" onClick="' + lastname + '">LAST NAME </th>';
			html += '<th style="cursor: pointer;" width="8%" onClick="' + firstname + '">First Name </th>';
			html += '<th style="cursor: pointer;" width="9%" onClick="' + companyname + '">Company </th>';
			html += '<th style="cursor: pointer;" width="5%" onClick="' + ic + '">ica</th>';
			html += '<th style="cursor: pointer;" width="10%" onClick="' + product + '">Product</th>';
			html += '<th style="cursor: pointer;" width="10%" onClick="' + startrwdt + '">Target dt </th>';
			html += '<th width="5%">Currency</th>';
			html += '<th style="cursor: pointer;" width="5%" onClick="' + prem + '">Premium</th>';
            html += '<th width="10%">Premium HKD</th>';
			html += '<th width="5%">aba Rev %</th>';
            html += '<th width="10%">aba Rev HKD</th>';
			html += '<th style="cursor: pointer;" width="5%" onClick="' + sharewith + '">Shared With</th>';
            html += '<th width="10%">aba rev share</th>';
			html += '<th style="cursor: pointer;" width="5%" onClick="' + stat + '">Status</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';
        var srwtargetdt = "";
        var goto = "";
        var prem = 0;
        var premhkd = 0;
        var abarevhkd = 0;
        var comp = "";
        var lname = "";
        var fname = "";
        var ccy = "";
        for(var i=0;i<rows.length;i++){
			var sharedabaini = "";
			var abarevshare = 0;
			
            srwtargetdt = rows[i]['srwtargetdt'] == "" || rows[i]['srwtargetdt'] == null ? "" : rows[i]['srwtargetdt'];
            prem = rows[i]['premium'] == "" || rows[i]['premium'] == null ? 0 : rows[i]['premium'];
            premhkd = rows[i]['premiumhkd'] == "" || rows[i]['premiumhkd'] == null ? 0 : rows[i]['premiumhkd'];
            abarevhkd = rows[i]['abarevhkd'] == "" || rows[i]['abarevhkd'] == null ? 0 : rows[i]['abarevhkd'];
            comp = rows[i]['companyname'] == "" || rows[i]['companyname'] == null ? "" : rows[i]['companyname'];
            lname = rows[i]['lastname'] == "" || rows[i]['lastname'] == null ? "" : rows[i]['lastname'];
            fname = rows[i]['firstname'] == "" || rows[i]['firstname'] == null ? "" : rows[i]['firstname'];
            ccy = rows[i]['ccy'] == "" || rows[i]['ccy'] == null ? "" : rows[i]['ccy'];
			sharedabaini = rows[i]['sharedabaini'] == "" || rows[i]['sharedabaini'] == null ? "" : rows[i]['sharedabaini'];
			
			if(sharedabaini != ""){
				abarevshare = Math.trunc(abarevhkd / 2);
			}else{
				abarevshare = abarevhkd;
			}
				
        	if(rows[i]['oppsstatus'] == 'p' || rows[i]['oppsstatus'] == 'q' || rows[i]['oppsstatus'] == 'c'){
                goto = "goto('"+ rows[i]['uid'] +"','"+ rows[i]['oppsid'] +"');";
	            html += '<tr style="cursor: pointer;" onClick="return '+goto+'">';
	                html += '<td>'+ lname +'</td>';
	                html += '<td>'+ fname +'</td>';
	                html += '<td>'+ comp +'</td>';
	                html += '<td class="text-center">'+ rows[i]['bustype'] +'</td>';
	                html += '<td>'+ rows[i]['prodtypedesc'] +'</td>';
	                html += '<td class="text-center">'+ srwtargetdt +'</td>';
	                html += '<td class="text-center">'+ ccy.toUpperCase() +'</td>';
                    // html += '<td class="text-right">'+ rows[i]['potential'] +'%</td>';
                    html += '<td class="text-right">'+ addCommas(prem) +'</td>';
                    html += '<td class="text-right">'+ addCommas(premhkd )+'</td>';
                    html += '<td class="text-right">'+ rows[i]['comrate'] +'%</td>';
                    html += '<td class="text-right">'+ addCommas(abarevhkd) +'</td>';
					html += '<td class="text-center">'+ sharedabaini +'</td>';
                    html += '<td class="text-right">'+ addCommas(abarevshare) +'</td>';
	                html += '<td class="text-left">'+ rows[i]['statusdesc'] +'</td>';
	                // html += '<td class="text-center"><a href="cdm.php?id='+ rows[i]['uid'] +'"><i class="fa fa-pencil-square-o vieweditico"></i></a></td>';
	            html += '</tr>';
	            // ttlopps++;   
	        }
        }
        html += '</tbody>';
    html += '</table>';
    $("#tbloppspending").html(html);

    // $("#datattlopps").html(ttlopps);
}

function genOppsSigned(data){
	// var ttlsigned = 0;
	// var ttllost = 0;
	// var ttlcancel = 0;
    var rows = data['rows'];
    var html = "";
    var srwtargetdt = "";
    html = '<table class="table table-striped jambo_table table-condensed table-hover table-bordered">';
        html += '<thead>';
        html += '<tr>';
			html += '<th width="15">LAST NAME </th>';
			html += '<th width="15">First Name </th>';
			html += '<th width="20">Company </th>';
			html += '<th width="5">ica</th>';
			html += '<th width="10">Product</th>';
			html += '<th width="10">Target dt </th>';
			html += '<th width="5">Potential </th>';
			html += '<th width="5">Currency</th>';
			html += '<th width="5">Premium</th>';
			html += '<th width="5">aba Rev %</th>';
			html += '<th width="5">aba Rev HKD</th>';
			html += '<th width="5">Shared With</th>';
			html += '<th width="5">Status</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';
        
        for(var i=0;i<rows.length;i++){
        	if(rows[i]['oppsstatus'] == 's' || rows[i]['oppsstatus'] == 'l' || rows[i]['oppsstatus'] == 'x'){
				var sharedabaini = "";
				var abarevshare = 0;
				sharedabaini = rows[i]['sharedabaini'] == "" || rows[i]['sharedabaini'] == null ? "" : rows[i]['sharedabaini'];
				abarevhkd = rows[i]['abarevhkd'] == "" || rows[i]['abarevhkd'] == null ? 0 : rows[i]['abarevhkd'];
				if(sharedabaini != ""){
					abarevshare = Math.trunc(abarevhkd / 2);
				}else{
					abarevshare = abarevhkd;
				}
				
        		srwtargetdt = rows[i]['srwtargetdt'] == "" || rows[i]['srwtargetdt'] == null ? "" : rows[i]['srwtargetdt'];
	            html += '<tr>';
	                html += '<td>'+ rows[i]['lastname'] +'</td>';
	                html += '<td>'+ rows[i]['firstname'] +'</td>';
	                html += '<td>'+ rows[i]['companyname'] +'</td>';
	                html += '<td class="text-center">'+ rows[i]['bustype'] +'</td>';
	                html += '<td>'+ rows[i]['prodtypedesc'] +'</td>';
	                html += '<td class="text-center">'+ srwtargetdt +'</td>';
	                html += '<td class="text-right">'+ rows[i]['potential'] +'%</td>';
	                html += '<td class="text-center">'+ rows[i]['ccy'] +'</td>';
	                html += '<td class="text-right">'+ addCommas(rows[i]['premium']) +'</td>';
	                html += '<td class="text-right">'+ rows[i]['comrate'] +'%</td>';
					html += '<td class="text-center">'+ sharedabaini +'</td>';
                    html += '<td class="text-right">'+ addCommas(abarevshare) +'</td>';
	                html += '<td class="text-left">'+ rows[i]['statusdesc'] +'</td>';
	            html += '</tr>';
	        }
        }
        html += '</tbody>';
    html += '</table>';
    $("#tbloppssigned").html(html);
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
                    genOppsPending(opps);
                    // genOppsSigned(opps);
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
                    genOppsPending(opps);
                    // genOppsSigned(opps);
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
            genOppsPending(opps);
            // genOppsSigned(opps);

            $.unblockUI();
            // return false;
        }
        ,error: function(request, status, err){

        }
    });
}

function countOppsHeaders(data){
    var rows = data['rows'];
    var ttlopps = 0;
    var ttlmedins = 0;
    var ttllins = 0;
    var ttlgenins = 0;
    var ttlsigned = 0;
    var ttllost = 0;
    var ttlabarevopsnextytd = 0;
    var ttlwk = 0;
	var ttlabarevops = 0;
    var date = new Date();
    var year = date.getFullYear();
    var month = date.getMonth();
    var firstDay = (new Date(new Date().getFullYear(), 0, 1,0,0,0)).setHours(0, 0, 0, 0);
    var lastDay = (new Date(new Date().getFullYear(), 11, 31,0,0,0)).setHours(0, 0, 0, 0);
    var jan1 =   (new Date(new Date().getFullYear(), 12, 1,0,0,0)).setHours(0, 0, 0, 0);

    var curr = new Date;
    var firstdaywk = new Date(new Date(curr.setDate(curr.getDate() - curr.getDay()))).setHours(0, 0, 0, 0);
    var lastdaywk = new Date(new Date(curr.setDate(curr.getDate() - curr.getDay()+6))).setHours(0, 0, 0, 0);

    // console.log(rows);
    for(var i=0;i<rows.length;i++){
        var targetdt = rows[i]['srwtargetdt'];
        targetdt=((new Date(targetdt)).setHours(0, 0, 0, 0));
        if (rows[i]['oppsstatus'] == 'p' || rows[i]['oppsstatus'] == 'q' || rows[i]['oppsstatus'] == 'c'){
            ttlopps++;
            if (rows[i]['producttype'] == 'm'){
                ttlmedins++;
            } else if (rows[i]['producttype'] == 'l'){
                ttllins++;
            } else if (rows[i]['producttype'] == 'g'){
                ttlgenins++;
            }
            if(targetdt >= firstDay && targetdt <= lastDay){
                ttlabarevops += parseFloat(rows[i]['abarevhkd']);
            }
            if(targetdt == jan1){
               ttlabarevopsnextytd += parseFloat(rows[i]['abarevhkd']);
            }
             
        }
		
    }

    // console.log(firstday + ' ' + lastday);
    // console.log(firstDay);
    // console.log(targetdt);
    $("#datattlopps").html(ttlopps);
    $("#datattlmedins").html(ttlmedins);
    $("#datattllins").html(ttllins);
    $("#datattlgenins").html(ttlgenins);
    $("#datattlsigned").html(ttlsigned);
    $("#datattllost").html(ttllost);
	$("#abaRevTotalOpsYTD").html(addCommas(ttlabarevops));
    $("#abaRevTotalOpsNextYTD").html(addCommas(ttlabarevopsnextytd));
}
