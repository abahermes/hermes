<div id="individual">
<div class="col-md-12 col-sm-12 col-xs-12">
    <!-- <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            
        </div>
    </div> -->
    <div class="row">
        <div class="col-lg-5 col-sm-5 col-xs-12">
            <!-- <div class="row"> -->
                <div class="x_panel">
                    <fieldset>
                        <legend><span id="dataCltProstName" >Name</span> <span class="pull-right"> <button class="btn btn-success btn-grad" title="Edit Account Details" data-toggle="modal" data-target="#frmCtcDtls">Edit Account Details</button></span></legend>
                        <div class="col-sm-12">
                            <!-- <h4 class="brief"><i><span id="dataJobTitle"></span></i></h4> -->
                            <div class="left col-xs-9">
                                <!-- <h2 id="contact-name" class="list-group-item-heading">
                                    <span id="dataContactName"></span> 
                                    <a href="https://abacare.sharepoint.com/:w:/r/abaorg/02opsgr/18.1%20docform%20tmpl%20finalized/01%20fum%20fl%20e/01%20fuminserttypeoffum%20tmpl.docx?d=wf8094391315042219c36d71c072ffa0e&csf=1&e=4sTIew" target="_blank">01 fuminserttypeoffum tmpl</a>
                                </h2> -->
                                <ul class="list-unstyled">
                                    <li id="labelbdt"><div class="row">
                                        <div class="col-lg-6 col-sm-6 col-xs-12"><i class="fa fa-birthday-cake"></i> <b>Birthday:</b> <span id="dataBDt"></span></div>
                                        <div class="col-lg-6 col-sm-6 col-xs-12"><i class="fa fa-birthday-cake"></i> <b>Age:</b> <span id="dataAge"></span></div>
                                    </div></li>
                                    <li id="labelContactName"><i class="fa fa-user"></i> <b>Contact Name:</b> <span id="dataContactName"></span></li>
                                    <li><i class="fa fa-briefcase"></i> <b>Job Title:</b> <span id="dataJobTitle"></span></li>
                                    <li><i class="fa fa-building"></i> <b>Company:</b> <span id="dataCompanyName"></span></li>
                                    <li><i class="fa fa-envelope"></i> <b>Email:</b> <span id="dataEAddr"></span></li>
                                    <!-- <li><i class="fa fa-home"></i> <b>Address:</b> <span id="dataAddr"></span></li> -->
                                    <li><i class="fa fa-home"></i> <b>Website:</b> <span id="dataWebsite"></span></li>
                                    <li><div class="row">
                                        <div class="col-lg-6 col-sm-6 col-xs-12"><i class="fa fa-phone"></i> <b>Mobile Phone:</b> <span id="dataMobNo"></span></div>
                                        <div class="col-lg-6 col-sm-6 col-xs-12"><i class="fa fa-phone"></i> <b>Office Phone:</b> <span id="dataBusNo"></span></div>
                                    </div></li>
                                    <!-- <li></li> -->
                                    <li><i class="fa fa-file"></i> <b>FUM:</b> <span id="dataFUM"></span></li>
                                </ul>
                            </div>
                            <!-- <div class="right col-xs-3 text-center">
                                <img src="images/user.png" alt="" class="img-circle img-responsive">
                            </div> -->
                        </div>
                    </fieldset>
                    <input type="hidden" id="txtCtcId" name="txtCtcId" value="1" />
                <!-- </div>
                <div class="x_panel" id="divGalInfo"> -->
                    <br />
                    <fieldset>
                        <legend>General Info</legend>
                        <span id="divGalInfo1">
                            <p><b>How I was or we were introduced to this clt, supplier or 3rd party?</b></p>
                            <p style="margin-left: 10px;"><span id="dataGalInfo1"></span></p>
                        </span>
                        <span id="divGalInfo2">
                            <p><b>Information about company (www.inputwebsiteofthecompanyifapplicable.com) n gal info of the group as a summary</b></p>
                            <p style="margin-left: 10px;"><span id="dataGalInfo2"></span></p>
                        </span>
                        <span id="divGalInfo3">
                            <p><b>For clients or prospects only Information about group or individual existing insurance and if they use broker or directly with insurance company renewal date, latest changes, past and present benefits</b></p>
                            <p style="margin-left: 10px;"><span id="dataGalInfo3"></span></p>
                        </span>
                        <span id="divGalInfo4">
                            <p><b>Information about person(s) we are meeting or which we are involved with this client, supplier or third party. person 1, 2, 3</b></p>
                            <p style="margin-left: 10px;"><span id="dataGalInfo4"></span></p>
                        </span>
                        <span id="divGalInfo5">
                            <p><b>Any other useful remarks or any information not listed before relevant to relationship wtih this client, supplier or 3rd party</b></p>
                            <p style="margin-left: 10px;"><span id="dataGalInfo5"></span></p>
                        </span>
                    </fieldset>
                </div>
                <div class="x_panel" id="divNotes">
                    <fieldset>
                        <legend>Important Notes</legend>
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <input type="hidden" id="noteslength" name="noteslength" value="" />
                                <textarea rows="16" class="form-control" id="txtImpNotes" name="txtImpNotes" placeholder="Enter Important notes here"></textarea>
                                <span class="pull-right"><input type="button" class="btn btn-danger btn-grad" id="btnSubmitNotes" name="btnSubmitNotes" value="   Save   " /></span>
                            </div>
                            <!-- <div class="row">
                                <span id="dataNotes"></span>
                            </div> -->
                        </div>
                    </fieldset>
                </div>
                
            <!-- </div> -->
        </div>
        <div class="col-lg-7 col-sm-7 col-xs-12">
            <!-- <div class="row"> -->
                <div class="x_panel">
                    <fieldset>
                        <legend>Pending Tasks <span class="pull-right"> <button class="btn btn-success btn-grad" title="Add New Task" onClick="return newTask();" data-toggle="modal" data-target="#frmTask" id = "btnAdd">Add New Task</button></span></legend>
                        <div class="table-responsive" style="overflow-y: scroll;" id="taskstbldata">
                            <table class="table table-striped jambo_table table-condensed table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th width="15%">Task Date</th>
                                    <th width="15%">Task Type</th>
                                    <th width="30%">Result</th>
                                    <th width="40%">Specific Result</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr>
                                    <td colspan="7" class="text-center">No Pending Tasks</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                    <input type="hidden" id="txtTaskId" name="txtTaskId" value="" />
                </div>
                <div class="x_panel">
                    <fieldset>
                        <legend>Opportunities <span class="pull-right"> <button class="btn btn-success btn-grad" title="Add New Opportunity" onClick="return newOpps();" data-toggle="modal" data-target="#frmOpps">Add New Opportunity</button></span></legend>
                        <div class="table-responsive" style="overflow-y: scroll;" id="oppstbldata">
                          <table class="table table-striped jambo_table table-condensed table-hover table-bordered">
                            <thead>
                              <tr>
                                <th width="10">bsl</th>
                                <th width="35">Target Date</th>
                                <th width="10">Potential</th>
                                <th width="5">ccy</th>
                                <th width="15">Premium</th>
                                <th width="15">Premium HKD</th>
                                <th width="10">aba rev%</th>
                                <th width="10">aba rev HKD</th>
                              </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="8" class="text-center">No Pending Opportunities</td>
                                </tr>
                            </tbody>
                          </table>
                        </div>
                    </fieldset>
                </div>

                <div class="x_panel">
                    <fieldset>
                        <legend>Signed</legend>
                        <div class="table-responsive" style="overflow-y: scroll;" id="sdoppstbldata">
                          <table class="table table-striped jambo_table table-condensed table-hover table-bordered">
                            <thead>
                              <tr>
                                <th width="10">bsl</th>
                                <th width="35">Target Date</th>
                                <th width="5">ccy</th>
                                <th width="15">Premium</th>
                                <th width="15">Premium HKD</th>
                                <th width="10">aba rev%</th>
                                <th width="10">aba rev HKD</th>
                                <th width="10">Signed Date</th>
                                <!-- <th width="10">Policy number</th> -->
                              </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="10" class="text-center">No Pending Signed</td>
                                </tr>
                            </tbody>
                          </table>
                        </div>
                    </fieldset>
                </div>
                <div class="x_panel">
                    <fieldset>
                        <legend>Signed  and Policy Issued</legend>
                        <div class="table-responsive" style="overflow-y: scroll;" id="sptabledata">
                          <table class="table table-striped jambo_table table-condensed table-hover table-bordered">
                            <thead>
                              <tr>
                                <th width="10">bsl</th>
                                <th width="35">Start Date</th>
                                <th width="5">ccy</th>
                                <th width="15">Premium</th>
                                <th width="15">Premium HKD</th>
                                <th width="10">aba rev%</th>
                                <th width="10">aba rev HKD</th>
                                <th width="10">Pol Issued Date</th>
                                <th width="10">Policy number</th>
                              </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="10" class="text-center">No Pending Signed</td>
                                </tr>
                            </tbody>
                          </table>
                        </div>
                    </fieldset>
                </div>
            <!-- </div> -->
            <!-- <div class="row"> -->
                <div class="x_panel">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <label>Enter your comments to the client/prospect here (if any):</label>
                            <textarea rows="4" class="form-control" id="txtComments" name="txtComments" placeholder="Enter comments here"></textarea>
                            <span class="pull-right"><input type="button" class="btn btn-danger btn-grad" id="btnSubmitCmts" name="btnSubmitCmts" value="   SUBMIT   " /></span>
                        </div>
                    </div>
                </div>
                <div class="x_panel">
                    <fieldset>
                        <legend>Recent Activities </legend>
                        <div style="height: 600px; overflow-y: scroll;">
                            <div class="dashboard-widget-content" id="dataActivities">
                                <ul class="list-unstyled timeline widget">
                                    <li>
                                        <div class="block" id="dataActivityNone">
                                            <div class="block_content">
                                                <h2 class="title">No Recent Activity</h2>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </fieldset>
                </div>
            <!-- </div> -->
        </div>
    </div>
</div>
<!-- </div>