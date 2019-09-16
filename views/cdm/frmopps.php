<div class="modal" id="frmOpps" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
          		<button type="button" class="close" data-dismiss="modal" onClick="return clearOppsFields()">&times;</button>
				<h4 class="modal-title">Opportunity Details</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">
						<div class="row">
							<div class="col-md-3 col-sm-3 col-xs-12">
								<div class="row"><label>Account Type <span class="text-red">*</span></label></div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-12">
								<div class="row"><input type="checkbox" id="chkAccountTypec" name="chkAccountTypec" value="c" /> Client</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="row"><input type="checkbox" id="chkAccountTypep" name="chkAccountTypep" value="p" /> Prospect</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="row" id="dataBSL">
									<label>Product Type <span class="text-red hide">*</span></label>
									<select class="form-control" id="txtProdType" name="txtProdType"></select>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="row">
									<label><span id = "lblStartOrTargetDate">Target Date </span><span class="text-red" id="reqStartRWTargetDt">*</span></label>
									<input type="text" class="form-control" id="txtStartRWTargetDt" name="txtStartRWTaragetDt" readonly />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 col-sm-2 col-xs-12">
								<div class="row">
									<label>Currency <span class="text-red hide">*</span></label>
									<select class="form-control" id="txtCCY" name="txtCCY">
										<option value=""></option>
										<option value="chf">CHF</option>
										<option value="cny">CNY</option>
										<option value="eur">EUR</option>
										<option value="gbp">GBP</option>
										<option value="hkd" selected>HKD</option>
										<option value="sgd">SGD</option>
										<option value="usd">USD</option>
									</select>
								</div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-12">
								<div class="row">
									<label>Premium Amt <span class="text-red" id="reqPremAmnt" style="display: none;">*</span></label>
									<input type="text" class="form-control text-right" id="txtPremium" name="txtPremium" placeholder="0" />
								</div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-12">
								<div class="row">
									<label>Premium Amt HKD <span class="text-red" id="reqPremAmntinHKD" style="display: none;">*</span></label>
									<input type="text" class="form-control text-right" id="txtPremiuminHKD" name="txtPremiuminHKD" placeholder="0" readonly/>
								</div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-12">
								<div class="row">
									<label>aba rev% <span class="text-red" id="reqabaRev" style="display: none;">*</span></label>
									<input type="text" class="form-control text-right" id="txtComRate" name="txtComRate" placeholder="0" />
								</div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-12">
								<div class="row">
									<label>aba rev HKD <span class="text-red" id="reqabaRevinHKD" style="display: none;">*</span></label>
									<input type="text" class="form-control text-right" id="txtComRateinHKD" name="txtComRateinHKD" placeholder="0" readonly/>
								</div>
							</div>
						</div>
						<div class="row" id="divOpps">
							<div class="col-md-3 col-sm-3 col-xs-12" id = "divLostDate" style="display: none;">
								<div class="row">
									<label>Lost Date</label>
									<input type="text" id="txtLostDate" name="txtLostDate" class="form-control" />
								</div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-12" id = "divSignedDate" style="display: none;">
								<div class="row">
									<label>Signed Date</label>
									<input type="text" id="txtSignedDate" name="txtSignedDate" class="form-control" />
								</div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-12" id = "divPotential">
								<div class="row">
									<label>Potential <span class="text-red">*</span></label>
									<select class="form-control" id="txtPotential" name="txtPotential">
										<option value="20" selected>20%</option>
										<option value="40">40%</option>
										<option value="60">60%</option>
										<option value="80">80%</option>
										<option value="100">100%</option>
									</select>
								</div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-12">
								<div class="row">
									<label>Status</label>
									<select class="form-control" id="txtOppsStatus" name="txtOppsStatus">
										<option value="p" selected>Potential</option>
										<option value="q">Quote Given / in Discussion</option>
										<option value="c">Closing Stage</option>
										<option value="s">Signed</option>
										<option value="sp" style="display:none;">Signed and Policy Issued</option>
										<option value="l">Lost</option>
										<option value="x">Cancel</option>
									</select>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-12" >
								<div class="row" id="divsharedwith">
									<label>Shared</label>
									<select class="form-control" id="txtShared" name="txtShared">
										<option value="" selected></option>
									</select>
								</div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-12">
								<div class="row">
									<label>aba rev share </label>
									<input type="text" class="form-control text-right" id="txtAbaRevShare" name="txtAbaRevShare" placeholder="0" readonly/>
								</div>
							</div>
						</div>
						<div class="row" id = "divSigned" style="display: none;">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="row">
									<label>Policy Issued Date </label>
									<input type="text" id="txtPolIssuedDate" name="txtPolIssuedDate" class="form-control" />
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="row">
									<label>Policy Number </label>
									<input type="text" id="txtPolicyNo" name="txtPolicyNo" class="form-control" />
								</div>
							</div>
						</div>
						<div class="row" id="divSuppliers">
							<label>Supplier <span class="text-red" style="display: none;" id="reqOppsSup">*</span></label>
							<span id="dataSupplier"><select class="form-control">
								<option value="" selected></option>
							</select></span>
						</div>
						<div class="row" id="divRemarks">
							<label>Reason / Remarks <span class="text-red" id="reqOppsRemarks" style="display: none;">*</span></label>
							<textarea rows="2" class="form-control" id="txtOppsRemarks" name="txtOppsRemarks"></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<label class="col-md-4 col-sm-4 col-xs-12 form-label">&nbsp;</label>
					<div class="col-md-8 col-sm-8 col-xs-12 text-right">
                		<button type="button" id="btnCloseOpps" class="btn btn-warning" data-dismiss="modal" onClick="return clearOppsFields()">Cancel</button>
						<input type="button" id="btnSaveOpps" class="btn btn-danger btn-grad" value="     Save Opportunity     " />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
