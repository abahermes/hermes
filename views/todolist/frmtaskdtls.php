  <div class="modal fade" id="frmTask" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onClick="return clearTDLFields()">&times;</button>
          <h4 class="modal-title">Task Details</h4>
        </div>
        <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Task Type <span class="text-red"> *</span> </label>
                            </div>

                            <div class="col-md-8 col-sm-8 col-xs-12" id="divTaskType">
                                <select class="form-control" id="txtTaskType" name="txtTaskType">
                                    <option value="" selected></option>
                                </select>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Task or to do (use telegraphic style w abvts) <span class="text-red">*</span> </label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <textarea rows="3" class="form-control" id="txtTask" name="txtTasks"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Priority</label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12" id="divPriority">
                                <select class="form-control" id="txtPriority" name="txtPriority">
                                    <option value=""></option>
                                    <option value="h">High</option>
                                    <option value="med">Medium</option>
                                    <option value="l">Low</option>
                                    <option value="n">NA</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Category</label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12" id="divCategory">
                                <select class="form-control" id="txtCategory" name="txtCategory">
                                    <option value="" selected></option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Follow up</label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12" id="divFuw">
                                <!-- <select class="form-control" id="txtFuw" name="txtFuw"></select> -->
                                <input type = "text" list="dataFuw" id="txtFuw" name="dataFuw"  class="form-control">
                                <span id='datalistFUW'>
                                    <datalist id="dataFuw">
                                    </datalist>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Office</label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12" id="divOfc">
                               <input type="text" id="txtOfc" name="txtOfc" readonly class="form-control" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Other people</label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12" id="divOthppl">
                                <input type = "text" list="dataOth" id="txtOthppl" name="dataOth"  class="form-control">
                                <span id='datalistOth'>
                                    <datalist id="dataOth">
                                    </datalist>
                                </span>
                            </div>
                        </div>

                        <div class="row" style="display: none;">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Process Start Date</label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" id="txtPSD" name="txtPSD" class="form-control" />
                            </div>
                        </div>

                        <div class="row" style="display: none;">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Process Follow Up Date</label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" id="txtPFU" name="txtPFU" class="form-control" />
                            </div>
                        </div>
 
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Start Date</label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" id="txtStartDate" name="txtStartDate" class="form-control" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Next Contact Date</label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" id="txtNextCtcDt" name="txtNextCtcDt" class="form-control" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Due Date</label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" id="txtDueDate" name="txtDueDate" class="form-control" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>FUM Link</label>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <input type="text" id="txtFUMText" name="txtFUMText" class="form-control" placeholder="FUM display title" />
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <input type="text" id="txtFUMLink" name="txtFUMLink" class="form-control" placeholder="FUM link"/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Status</label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12" id="divStatus">
                                <select class="form-control" id="txtStatus" name="txtStatus">
                                    <option value="" selected></option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Remarks (if any)</label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <textarea rows="3" class="form-control" id="txtTaskRemarks" name="txtTaskRemarks"></textarea>
                            </div>
                        </div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 text-right" style="padding-top: 15px;">
                                <button id="btnCancelTask" class="btn btn-warning btn-grad" data-dismiss="modal" onClick="return clearTDLFields()">Cancel</button>					           
                                <input type="button" id="btnSaveTask" class="btn btn-danger btn-grad" value="     Save Task     " />
								<input type="button" id="btnUpdateTask" class="btn btn-danger btn-grad" style="display: none;" value="     Update Task     " />
								<input type="hidden" id ="activityid" name="activityid" value="" />
								<input type="hidden" id="tid" name="tid" value="" />
                                <input type="hidden" id="duedate" name="duedate" value="" />
								<input type="hidden" id="noofrevisions" name="noofrevisions" value=""/>
								<input type="hidden" id="abaini" name="abaini" value="<?php echo $abaini; ?>" />
                                <input type="hidden" id="userid" name="userid" value="<?php echo $userid; ?>"/>
							</div>
						</div>
			
			
			
        </div>
      </div>
      
    </div>
  </div>