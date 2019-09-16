<form class="modal multi-step" id="frmpopupmsg" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title step-1" data-step="1" id="otlk1ststep">Do you have a list of contacts saved in your MS outlook?</h3>
				<h3 class="modal-title step-2" data-step="2" id="otlk2ndstep">Does your contacts have more than 1000 records?</h3>
			</div>
			<div class="modal-footer">
				<div class="row text-center">
					<button id="btnNo" type="button" class="btn btn-warning" data-dismiss="modal">No</button>
					<button id="btnYes" type="button" class="btn btn-danger step step-1" data-step="1">Yes</button>
					<button id="btnNo1" type="button" class="btn btn-warning step step-2" data-dismiss="modal" onclick="javascript: window.location='leadssync.php'">No</button>
					<button id="btnYes1" type="button" class="btn btn-danger step step-2" data-dismiss="modal">Yes</button>
				</div>
			</div>
		</div>
	</div>
</form>





