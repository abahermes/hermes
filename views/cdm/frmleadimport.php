<div class="modal" id="frmLeadImport" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
          		<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Leads Import</h4>
			</div>
			<div class="modal-body">
                <form method="Post" enctype="multipart/form-data" >
                <div class="row">
                    <input type="file" id="txtFileImport" name="txtFileImport" class="form-control" />
                </div>
                <div class="clearfix"></div>
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 text-right">
                		<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
						<input type="submit" id="btnSaveTask" class="btn btn-danger btn-grad" value="     Import     " />
                        <input type="hidden" id="leadImport" name="leadImport" value="1" />
                        <input type="hidden" id="txtuserid" name="txtuserid" value="<?php echo $userid;?>" />
					</div>
				</div>
                </form>
			</div>
		</div>
	</div>
</div>