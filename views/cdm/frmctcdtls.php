<form class="modal multi-step" id="frmCtcDtls" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				<h4 class="modal-title step-1" data-step="1"><span class="text-red">Step 1 or 4:</span> Please make sure that the information below are correct.</h4>
				<h4 class="modal-title step-2" data-step="2"><span class="text-red">Step 2 or 4:</span> Company information</h4>
				<h4 class="modal-title step-3" data-step="3"><span class="text-red">Step 3 or 4:</span> Prospect additional information</h4>
				<h4 class="modal-title step-4" data-step="4"><span class="text-red">Step 4 of 4:</span> FUM Link and General Information</h4>
				<h4 class="modal-title step-5" data-step="5"><span class="text-red">Step 4 of 4:</span> Additional Information</h4>
				<h4 class="modal-title step-6" data-step="6"><span class="text-red">Step 4 of 4:</span> Other General Information</h4>
                <div class="m-progress">
                    <div class="m-progress-bar-wrapper">
                        <div class="m-progress-bar">
                        </div>
                    </div>
                </div>
            </div>
			
<!--			STEP 1-->
            <div class="modal-body step-1" data-step="1">
				<div class="row">
					<div class="col-lg-3 col-sm-3 col-xs-12">
						<div class="row" id="divTitles">
							<label>Title</label>
							<!-- <input type="text" list="dataLstTitles" id="txtTitle" name="txtTitle" class="form-control" />
							<span id="divTitles"><datalist id="dataLstTitles"></datalist> -->
								<select class="form-control" id="txtTitle" name="txtTitle">
								<!--     <option value="" selected></option>
									<option value="mr">Mr.</option>
									<option value="mrs">Mrs.</option>
									<option value="ms">Ms.</option>
									<option value="miss">Miss.</option> -->
								</select>
							<!-- </span> -->
						</div>
					</div>
					<div class="col-lg-9 col-sm-9 col-xs-12">
						<div class="row">
							<label>Chinese Name</label>
							<input type="text" id="txtCname" name="txtCname" class="form-control" />
						</div>
					</div>
				</div>
				<div class="row">
					<label>First Name <span class="text-red">*</span></label>
					<input type="text" id="txtFname" name="txtFname" class="form-control" />
				</div>
				<div class="row">
					<label>Middle Name</label>
					<input type="text" id="txtMname" name="txtMname" class="form-control" />
				</div>
				<div class="row">
					<label>Last Name <span class="text-red">*</span></label>
					<input type="text" id="txtLname" name="txtLname" class="form-control" onkeyup="this.value = this.value.toUpperCase();" />
				</div>
				<div class="row">
					<div class="col-lg-6 col-sm-6 col-xs-6"><div class="row">
						<label>Birth Date</label>
						<input type="text" id="txtBirthDate" name="txtBirthDate" class="form-control" />
					</div></div>
					<div class="col-lg-6 col-sm-6 col-xs-6"><div class="row">
						<label>Initial </label>
						<input type="text" id="txtini" name="txtini" class="form-control" />
					</div></div>
				</div>
				<div class="row">
					<label class="col-md-3 col-sm-3 col-xs-12"><div class="row">Gender <span class="text-red">*</span></div></label>
					<input type="radio" id="rGenderm" name="rGender" value="m" /> Male &nbsp; 
					<input type="radio" id="rGenderf" name="rGender" value="f" /> Female
				</div>
            </div>
			
<!--			STEP 2-->
            <div class="modal-body step-2" data-step="2">
				<div class="row">
					<label>Company</label>
					<input type="text" id="txtCompany" name="txtCompany" class="form-control" />
				</div>
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="row">
							<label>Job Title</label>
							<input type="text" id="txtJobTitle" name="txtJobTitle" class="form-control" />
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="row">
							<label>Email Address <span id="reqEAddr" class="text-red">*</span></label>
							<input type="text" id="txtEmailAddress" name="txtEmailAddress" class="form-control" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="row">
							<label>Website</label>
							<input type="text" id="txtWebsite" name="txtWebsite" class="form-control" />	
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12">
						<div class="row">
							<label>Office No <span id="reqHomPh" class="text-red">*</span></label>
							<input type="text" id="txtHomPhoneNo" name="txtHomPhoneNo" class="form-control" />
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12">
						<div class="row">
							<label>Mobile Phone No <span id="reqMobPh" class="text-red">*</span></label>
							<input type="text" id="txtMobPhoneNo" name="txtMobPhoneNo" class="form-control" />
						</div>
					</div>
				</div>
				<div class="row">
					<label>Address</label>
					<input type="text" id="txtAddress" name="txtAddress" class="form-control" />
				</div>
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="row" id="divNationality">
							<label>Nationality</label>
							<!-- <input type="text" list="dataLstNats" id="txtTitle" name="txtTitle" class="form-control" /> -->
							<!-- <span id="divNats"><datalist id="dataLstNats"></datalist>
							</span> -->
							<select class="form-control" id="txtNationality" name="txtNationality">
								<option value="" selected></option>
							</select>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="row" id="divEthnicity">
							<label>Ethnicity</label>
							<select class="form-control" id="txtEthnicity" name="txtEthnicity">
								<option value="" selected></option>
							</select>
						</div>
					</div>
				</div>
			</div>
			
<!--			STEP 3-->
            <div class="modal-body step-3" data-step="3">
				<div class="row">
					<div class="col-md-3 col-sm-3 col-xs-12">
						<div class="row"><label>Business Type <span class="text-red">*</span></label></div>
					</div>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="row">
							<input type="radio" id="rBusinessTypei" name="rBusinessType" value="i" /> Individual &nbsp; 
							<input type="radio" id="rBusinessTypec" name="rBusinessType" value="c" /> Corporate
						</div>
					</div>
				</div>
				<div class="row" id=divAff>
					<label>Affinity Name <span class="text-red">*</span></label>
					<select class="form-control" id="txtAffinityName" name="txtAffinityName">
						<!-- <option value="" selected>NONE</option>
						<option value="">POTENTIAL</option>
						<option value="">BAR ASSOCIATION</option>
						<option value="">BETTER LIFE GROUP</option>
						<option value="">HBSA</option>
						<option value="">HKRU</option>
						<option value="">TGSL</option> -->
					</select>
				</div>
				<div class="row" id="divRecomBy">
					<label>Recommended by <span class="text-red">*</span></label>
					<select class="form-control" id="txtRecomBy" name="txtRecomBy">
						<option value="" selected></option>
						<option value="1">aba Website</option>
						<option value="2">abac/ofc</option>
						<option value="3">Association</option>
						<option value="4">Chamber Com</option>
						<option value="5">Client/Lead</option>
						<option value="6">Cold Call</option>
						<option value="7">Cross Sell Opportunities</option>
						<option value="8">Database</option>
						<option value="9">Direct Inquiry</option>
						<option value="10">Facebook</option>
						<option value="11">Friend</option>
						<option value="12">Internet</option>
						<option value="13">Introducer</option>
						<option value="14">LinkedIn</option>
						<option value="15">Networking Event</option>
						<option value="16">Other</option>
						<option value="17">Personal Contact</option>
						<option value="18">WeChat</option>
						<option value="19">WhatsApp</option>
					</select>
				</div>
				<div class="row" id="divRecomName">
					<label>Recommended Name</label>
					<input type="text" class="form-control" id="txtRecomName" name="txtRecomName" />
				</div>
				<div class="row" id="divIntroducer" style="display: none;">
					<label>Introducer</label>
					<input type="text" class="form-control" id="txtIntroducer" name="txtIntroducer" />
				</div>
				<div class="row" id="divabainiofc" style="display: none;">
					<label>abaini / ofc</label>
					<select class="form-control" id="txtabainiofc" name="txtabainiofc">
						<option value="" selected></option>
					</select>
				</div>
				<div class="row" id="divsalesofc">
					<label>Sales Office</label>
					<select class="form-control" id="txtSalesOfc" name="txtSalesOfc">
						<!-- <option value="" selected></option> -->
					</select>
				</div>
				<div class="row" id="divshared" style="display: none;">
					<label>Shared</label>
					<select class="form-control" id="txtSharedx" name="txtSharedx">
						<option value="" selected></option>
					</select>
				</div>
            </div>
			
<!--			STEP 4-->
            <div class="modal-body step-4" data-step="4">
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-12"><div class="row"><label>Copy / Paste FUM Link </label></div></div>
					<div class="col-md-8 col-sm-8 col-xs-12"><div class="row">
						<input type="text" class="form-control" id="txtFumLink" name="txtFumLink" />
					</div></div>
				</div>
				<div class="row">
					<label>How I was or we were introduced to this clt, supplier or 3rd party?</label>
					<textarea rows="2" id="txtIntroduced" name="txtIntroduced" class="form-control"></textarea>
				</div>
				<div class="row">
					<label>Information about company <a href="www.inputwebsiteofthecompanyifapplicable.com" target="_blank">(www.inputwebsiteofthecompanyifapplicable.com)</a> n gal info of the group as a summary</label>
					<textarea rows="2" id="txtCompanyLink" name="txtCompanyLink" class="form-control"></textarea>
				</div>
				<div class="row">
					<label>For clients or prospects only Information about group or individual existing insurance and if they use broker or directly with insurance company renewal date, latest changes, past and present benefits</label>
					<textarea rows="2" id="txtBroker" name="txtBroker" class="form-control"></textarea>
				</div>
				<div class="row">
					<label>Information about person(s) we are meeting or which we are involved with this client, supplier or third party. person 1, 2, 3</label>
					<textarea rows="2" id="txtpplInvolved" name="txtpplInvolved" class="form-control"></textarea>
				</div>
				<div class="row">
					<label>Any other useful remarks or any information not listed before relevant to relationship wtih this client, supplier or 3rd party</label>
					<textarea rows="2" id="txtGalInfoRemarks" name="txtGalInfoRemarks" class="form-control"></textarea>
				</div>
				<!-- </span> -->
				<!-- <div id="galinfo" style="display: none;">
					<div class="row"><p>Additional General Information</p></div>
					<span id="divGalInfoItems">
						<div class="row"><label>Q#1</label> <textarea class="form-control" rows="2" cols="" id="txtGalInfoQuestion1" name="txtGalInfoQuestion1" placeholder="Question here"></textarea></div>
						<div class="row"><label>A#1</label> <textarea class="form-control" rows="2" cols="" id="txtGalInfoAnswer1" name="txtGalInfoAnswer1" placeholder="Answer here"></textarea></div>
					</span>
					<input type="hidden" id="galInfoItemsCnt" name="galInfoItemsCnt" value="1" />
					<div class="row text-right">
						<input type="button" class="btn btn-danger btn-grad" id="btnNewGalInfoItem" name="btnNewGalInfoItem" value="New Item" />
					</div>
				</div>
				<div id="otgalinfo" style="display: none;">
					<div class="row"><p>Other General Information</p></div>
					<span id="dataGalInfos"></span>
				</div> -->

            </div>
			
			
<!--			Step 4.1-->
			<div class="modal-body step-5" data-step="5">
				<div id="galinfo">
					<div class="row"><p>Additional General Information</p></div>
					<span id="divGalInfoItems">
						<div class="row"><label>Q#1</label> <textarea class="form-control" rows="2" cols="" id="txtGalInfoQuestion1" name="txtGalInfoQuestion1" placeholder="Question here"></textarea></div>
						<div class="row"><label>A#1</label> <textarea class="form-control" rows="2" cols="" id="txtGalInfoAnswer1" name="txtGalInfoAnswer1" placeholder="Answer here"></textarea></div>
					</span>
					<input type="hidden" id="galInfoItemsCnt" name="galInfoItemsCnt" value="" />
					<input type="hidden" id="NewgalInfoItemsCnt" name="NewgalInfoItemsCnt" value="1" />
					<div class="row text-right">
						<input type="button" class="btn btn-danger btn-grad" id="btnNewGalInfoItem" name="btnNewGalInfoItem" value="New Item" />
					</div>
				</div>
			</div>
			<div class="modal-body step-6" data-step="6">
				<div id="galinfoload">
					<div class="row"><p>Additional General Information</p></div>
					<span id="divGalInfoItemsLoad">
						<div class="row"><label>Q#1</label> <textarea class="form-control" rows="2" cols="" id="txtGalInfoQuestion1" name="txtGalInfoQuestion1" placeholder="Question here"></textarea></div>
						<div class="row"><label>A#1</label> <textarea class="form-control" rows="2" cols="" id="txtGalInfoAnswer1" name="txtGalInfoAnswer1" placeholder="Answer here"></textarea></div>
					</span>
					<!-- <input type="hidden" id="galInfoItemsCnt" name="galInfoItemsCnt" value="" /> -->
					<!-- <div class="row text-right">
						<input type="button" class="btn btn-danger btn-grad" id="btnNewGalInfoItem" name="btnNewGalInfoItem" value="New Item" />
					</div> -->
				</div>
			</div>
			
            <div class="modal-footer">
				<button id ="btnDelete" type="button" class="btn btn-warning" data-dismiss="modal" style="display: none;">Delete</button>
                <button id ="btnClose" type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                <button id="btnStep2" type="button" class="btn btn-danger step step-1" data-step="1">Continue</button>
                <button id="" type="button" class="btn btn-danger step step-3" data-step="3" onclick="sendEvent('#frmCtcDtls', 2)">Back</button>
                <button id="" type="button" class="btn btn-danger step step-2" data-step="2" onclick="sendEvent('#frmCtcDtls', 1)">Back</button>
                <button id="btnStep4" type="button" class="btn btn-danger step step-3" data-step="3">Continue</button>
                <button id="" type="button" class="btn btn-danger step step-4" data-step="4" onclick="sendEvent('#frmCtcDtls', 3)">Back</button>
                <!-- <button id="btnOthGalInfo" type="button" class="btn btn-danger step step-6" data-step="6">Other General Info</button> -->
                <!-- <button id="btnNewGalInfo" type="button" class="btn btn-danger step step-4" data-step="4">Add New General Info</button> -->
                <button id="btnUpdateCtcDtls" type="button" class="btn btn-danger step step-4" data-step="4">Save</button>
                <button id="" type="button" class="btn btn-danger step step-5" data-step="5" onclick="sendEvent('#frmCtcDtls', 4)">Back</button>
				<button id="btnUpdateCtcDtls2" type="button" class="btn btn-danger step step-5" data-step="5">Save</button>
                <button id="btnStep3" type="button" class="btn btn-danger step step-2" data-step="2">Continue</button>
            </div>
        </div>
    </div>
</form>


