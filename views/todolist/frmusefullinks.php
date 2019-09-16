  <div class="modal fade" id="frmUsefulLinks" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onClick="return clearUsefulLinkFields()">&times;</button>
          <h4 class="modal-title">Useful Link Details</h4>
        </div>
        <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Category <span class="text-red"> *</span> </label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12" id="divCategory">
                                <input type = "text" list="dataCat" id="txtCat" name="dataCat"  class="form-control">
                                <span id='datalistCat'>
                                    
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Display title</label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" id="txtFUMTextUL" name="txtFUMTextUL" class="form-control" placeholder="Display title text here..." />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Web Link or URL</label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" id="txtFUMLinkUL" name="txtFUMLinkUL" class="form-control" placeholder="Web link or URL..."/>
                            </div>
                        </div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 text-right" style="padding-top: 15px;">
                                <button id="btnCancel" class="btn btn-warning btn-grad" data-dismiss="modal" onClick="return clearUsefulLinkFields()" >Cancel</button>					           
                                <input type="button" id="btnSave" class="btn btn-danger btn-grad" value="     Save     " />
								<input type="button" id="btnUpdate" class="btn btn-danger btn-grad" style="display: none;" value="     Update     " />
								<input type="hidden" id ="usefullinkid" name="usefullinkid" value="" />
								<input type="hidden" id="abaini" name="abaini" value="<?php echo $abaini; ?>" />
                                <input type="hidden" id="userid" name="userid" value="<?php echo $userid; ?>"/>
							</div>
						</div>
			
			
			
        </div>
      </div>
      
    </div>
  </div>