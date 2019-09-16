$(function(){
	$("#btnCloseCltProstList").on("click", function(){
        $("#frmCltsProsts").dialog("close");
    });
});

function searchCltProst(){
	$('html').css('overflow','hidden');
    $("#frmCltsProsts").css('zIndex',1040);
    $("#frmCltsProsts").dialog({
        autoOpen: true,
        draggable: false,
        width: 1400,
        height: 600,
        modal: true,
        title: "Clients or Prospects List",
        close: function(){
            $('html').css('overflow','auto');
            $(this).dialog("close");
        }
    });
}