<div class="modal" id="frmTask" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
          		<button type="button" class="close" data-dismiss="modal" onClick="return clearTaskFields()">&times;</button>
				<h4 class="modal-title">Edit Task Details</h4>
			</div>
			<div class="modal-body">
				<div class="row form-group">
					<div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Task Type <span class="text-red">*</span></label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12" id="divTaskType">
                                <select class="form-control" id="txtTaskType" name="txtTaskType"></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Task Date <span class="text-red">*</span></label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" id="txtTaskDate" name="txtTaskDate" class="form-control" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Other People</label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" class="form-control" id="txtotPpl" name="txtotPpl" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-sm-4 col-xs-12" id="divStartTime">
                                <label id="lblSTime">Start Time <span class="text-red" style="display: none;" id="reqSTime">*</span></label>
                                <select class="form-control" id="txtSTime" name="txtSTime">
                                    <option value="" selected></option>
                                    <option value="00:00">00:00</option>
                                    <option value="00:30">00:30</option>
                                    <option value="01:00">01:00</option>
                                    <option value="01:30">01:30</option>
                                    <option value="02:00">02:00</option>
                                    <option value="02:30">02:30</option>
                                    <option value="03:00">03:00</option>
                                    <option value="03:30">03:30</option>
                                    <option value="04:00">04:00</option>
                                    <option value="04:30">04:30</option>
                                    <option value="05:00">05:00</option>
                                    <option value="05:30">05:30</option>
                                    <option value="06:00">06:00</option>
                                    <option value="06:30">06:30</option>
                                    <option value="07:00">07:00</option>
                                    <option value="07:30">07:30</option>
                                    <option value="08:00">08:00</option>
                                    <option value="08:30">08:30</option>
                                    <option value="09:00">09:00</option>
                                    <option value="09:30">09:30</option>
                                    <option value="10:00">10:00</option>
                                    <option value="10:30">10:30</option>
                                    <option value="11:00">11:00</option>
                                    <option value="11:30">11:30</option>
                                    <option value="12:00">12:00</option>
                                    <option value="12:30">12:30</option>
                                    <option value="13:00">13:00</option>
                                    <option value="13:30">13:30</option>
                                    <option value="14:00">14:00</option>
                                    <option value="14:30">14:30</option>
                                    <option value="15:00">15:00</option>
                                    <option value="15:30">15:30</option>
                                    <option value="16:00">16:00</option>
                                    <option value="16:30">16:30</option>
                                    <option value="17:00">17:00</option>
                                    <option value="17:30">17:30</option>
                                    <option value="18:00">18:00</option>
                                    <option value="18:30">18:30</option>
                                    <option value="19:00">19:00</option>
                                    <option value="19:30">19:30</option>
                                    <option value="20:00">20:00</option>
                                    <option value="20:30">20:30</option>
                                    <option value="21:00">21:00</option>
                                    <option value="21:30">21:30</option>
                                    <option value="22:00">22:00</option>
                                    <option value="22:30">22:30</option>
                                    <option value="23:00">23:00</option>
                                    <option value="23:30">23:30</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-xs-12" id="divETime">
                                <label id="lblETime">End Time <span class="text-red" style="display: none;" id="reqSTime">*</span></label>
                                <select class="form-control" id="txtETime" name="txtETime">
                                    <option value="" selected></option>
                                    <option value="00:00">00:00</option>
                                    <option value="00:30">00:30</option>
                                    <option value="01:00">01:00</option>
                                    <option value="01:30">01:30</option>
                                    <option value="02:00">02:00</option>
                                    <option value="02:30">02:30</option>
                                    <option value="03:00">03:00</option>
                                    <option value="03:30">03:30</option>
                                    <option value="04:00">04:00</option>
                                    <option value="04:30">04:30</option>
                                    <option value="05:00">05:00</option>
                                    <option value="05:30">05:30</option>
                                    <option value="06:00">06:00</option>
                                    <option value="06:30">06:30</option>
                                    <option value="07:00">07:00</option>
                                    <option value="07:30">07:30</option>
                                    <option value="08:00">08:00</option>
                                    <option value="08:30">08:30</option>
                                    <option value="09:00">09:00</option>
                                    <option value="09:30">09:30</option>
                                    <option value="10:00">10:00</option>
                                    <option value="10:30">10:30</option>
                                    <option value="11:00">11:00</option>
                                    <option value="11:30">11:30</option>
                                    <option value="12:00">12:00</option>
                                    <option value="12:30">12:30</option>
                                    <option value="13:00">13:00</option>
                                    <option value="13:30">13:30</option>
                                    <option value="14:00">14:00</option>
                                    <option value="14:30">14:30</option>
                                    <option value="15:00">15:00</option>
                                    <option value="15:30">15:30</option>
                                    <option value="16:00">16:00</option>
                                    <option value="16:30">16:30</option>
                                    <option value="17:00">17:00</option>
                                    <option value="17:30">17:30</option>
                                    <option value="18:00">18:00</option>
                                    <option value="18:30">18:30</option>
                                    <option value="19:00">19:00</option>
                                    <option value="19:30">19:30</option>
                                    <option value="20:00">20:00</option>
                                    <option value="20:30">20:30</option>
                                    <option value="21:00">21:00</option>
                                    <option value="21:30">21:30</option>
                                    <option value="22:00">22:00</option>
                                    <option value="22:30">22:30</option>
                                    <option value="23:00">23:00</option>
                                    <option value="23:30">23:30</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-xs-12">
                                <label># of mtgs</label>
                                <input type="text" class="form-control" id="txtNoOfMtg" name="txtNoOfMtg" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Result Expected <span class="text-red">*</span></label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12" id="divResultExpected">
                                <select class="form-control" id="txtResultExpected" name="txtResultExpected"></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Specific Result</label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <textarea rows="2" class="form-control" id="txtSpecificResult" name="txtSpecificResult"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Discussions / Remarks (if any)</label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <textarea rows="2" class="form-control" id="txtTaskRemarks" name="txtTaskRemarks"></textarea>
                            </div>
                        </div>
                        <div class="row" id="divResutlAchieve" style="display: none;">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Result Achieved</label>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="radio" id="rResultAchieveY" name="rResultAchieve" value="y" /> Yes &nbsp;&nbsp;&nbsp;
                                <input type="radio" id="rResultAchieveN" name="rResultAchieve" value="n" /> No
                            </div>
                        </div>
                    </div>
				</div>
				<div class="row">
					<label class="col-md-4 col-sm-4 col-xs-12 form-label"></label>
					<div class="col-md-8 col-sm-8 col-xs-12 text-right">
                		<button type="button" id="btnCloseTask" class="btn btn-warning" data-dismiss="modal">Close</button>
						<input type="button" id="btnSaveTask" class="btn btn-danger btn-grad" value="     Save Task     " />
                        <input type="button" id="btnDoneTask" class="btn btn-success btn-grad" style="display: none;" value="     Task Done     " />
					</div>
				</div>		
			</div>
		</div>
	</div>
</div>
