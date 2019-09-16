<!-- page content -->
<div class="right_col" role="main">
    <!-- top tiles -->
    <div class="row">
        <div class="row col-md-8 col-sm-8 col-xs-12">
            
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search Client or Prospect...">
                <span class="input-group-btn">
                    <button type="button" id="btnSearch" name="btnSearch" class="btn btn-default" >     SEARCH     </button>
                </span>
            </div>
        </div>
    </div>
    <!-- /top tiles -->
    
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <!-- <div class="row"> -->
                <div class="x_panel">
                    <fieldset>
                        <legend>Step 1: Client / Prospect Details <a href="#" title="View Client or Prospect Full Details"> <i class="fa fa-eye blue"></i></a> <span class="pull-right"> <a href="#" title="Edit Client or Prospect"> <i class="fa fa-pencil blue"></i></a></span></legend>
                        <div class="row form-horizontal">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Name</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="txtName" name="txtName" readonly class="form-control col-md-2 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Company</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="txtCompany" name="txtCompany" readonly class="form-control col-md-8 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Business Type</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="radio" id="rBusType" name="rBusType" value="1"> Individual 
                                        <input type="radio" id="rBusType" name="rBusType" value="2"> Corporate
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Affinity Name</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <select>Select affinity name</select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Recommended By</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <select>Select recommended by</select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Recommended Name</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="txtRecomName" name="txtRecomName" class="form-control col-md-2 col-xs-12">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">sm bdem cs</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <select>Select sm bdem cs</select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">FUM Link</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" id="txtRecomName" name="txtRecomName" class="form-control col-md-2 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">&nbsp;</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <button id="btnIndividual" class="btn btn-danger" name="btnIndividual" class="form-control col-md-2 col-xs-12"> Add Individual </button>
                                        <button id="btnCorporate" class="btn btn-danger" name="btnCorporate" class="form-control col-md-2 col-xs-12"> Add Corporate </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            <!-- </div> -->
        </div>
    </div>

    <div class="row">
        <div class="col-md-7 col-sm-7 col-xs-12">
            <!-- <div class="row"> -->
                <div class="x_panel">
                    <fieldset>
                        <legend>Step 2: Tasks <span class="pull-right"><a href="#"> <i class="fa fa-plus green"></i></a></span></legend>
                        <div class="row">
                            <div class="x_content">
                                <div class="table-responsive">
                                  <table class="table table-striped jambo_table table-condensed table-hover table-bordered">
                                    <thead>
                                      <tr>
                                        <th width="5">#</th>
                                        <th width="15">Task Date</th>
                                        <th width="15">Task Type</th>
                                        <th width="35">Result</th>
                                        <th width="25">Specific Result</th>
                                        <th width="5">Edit</th>
                                      </tr>
                                    </thead>

                                    <tbody>
                                      <tr>
                                        <td class="text-center">1</td>
                                        <td class="text-center">30 May 2014</td>
                                        <td class="text-center">c</td>
                                        <td>Get Data</td>
                                        <td></td>
                                        <td class="text-center"><a href="#"><i class="fa fa-pencil-square-o vieweditico"></i></a></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            <!-- </div> -->
            <div class="x_panel">
                <fieldset>
                    <legend>Task Details</legend>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 col-sm-4 col-xs-12 form-label">Task Type</label>
                            <select class="col-md-8 col-sm-8 col-xs-12 form-control">Select task type</select>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-sm-4 col-xs-12 form-label">Task Date</label>
                            <input type="text" class="col-md-8 col-sm-8 col-xs-12 form-control" />
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="col-md-5 col-sm-5 col-xs-12">
            <div class="row">
                <div class="x_panel">
                    <fieldset>
                        <legend>Step 3: Opportunities</legend>
                        <div class="x_content">
                            <div class="form-group">
                                <div class="x_panel">
                                <fieldset>
                                    <legend>Medical Insurance <span class="pull-right" id="newMedIns"><a href="#" title="Add Medical Insurance"> <i class="fa fa-plus green"></i></a></span> <span class="pull-right" id="editMedIns"><a href="#" title="Edit Medical Insurance"> <i class="fa fa-pencil blue"></i></a></span></legend>

                                    <div class="row">
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <input type="checkbox" > Client <br />
                                            <input type="checkbox" > Prospect
                                        </div>

                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                            Potential <br />
                                            <select>Select potential</select>
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            Start rw Target Date <br />
                                            <input type="text" class="form-control" >
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            Status <br />
                                            <select>Select status</select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-3 col-xs-12">&nbsp;</div>

                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                            Currency <br />
                                            <select>Select currency</select>
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            Premium Amount <br />
                                            <input type="text" id="txtPremAmnt" name="txtPremAmnt" class="form-control">
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            aba Rev % <br />
                                            <input type="text" id="txtabaRev" name="txtabaRev" class="form-control">
                                        </div>
                                    </div>
                                </fieldset>
                                </div>
                                <div class="x_panel">
                                <fieldset>
                                    <legend>Life Insurance <span class="pull-right" id="newLIns"><a href="#" title="Add Life Insurance"> <i class="fa fa-plus green"></i></a></span> <span class="pull-right" id="editLIns"><a href="#" title="Edit Life Insurance"> <i class="fa fa-pencil blue"></i></a></span></legend>
                                    
                                    <div class="row">
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <input type="checkbox" > Client <br />
                                            <input type="checkbox" > Prospect
                                        </div>

                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                            Potential <br />
                                            <select>Select potential</select>
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            Start rw Target Date <br />
                                            <input type="text" class="form-control" >
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            Status <br />
                                            <select>Select status</select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-3 col-xs-12">&nbsp;</div>

                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                            Currency <br />
                                            <select>Select currency</select>
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            Premium Amount <br />
                                            <input type="text" id="txtPremAmnt" name="txtPremAmnt" class="form-control">
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            aba Rev % <br />
                                            <input type="text" id="txtabaRev" name="txtabaRev" class="form-control">
                                        </div>
                                    </div>
                                </fieldset>
                                </div>
                                <div class="x_panel">
                                <fieldset>
                                    <legend>General Insurance <span class="pull-right" id="newGenIns"><a href="#" title="Add General Insurance"> <i class="fa fa-plus green"></i></a></span> <span class="pull-right" id="editGenIns"><a href="#" title="Edit General Insurance"> <i class="fa fa-pencil blue"></i></a></span></legend>
                                    
                                    <div class="row">
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <input type="checkbox" > Client <br />
                                            <input type="checkbox" > Prospect
                                        </div>

                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                            Potential <br />
                                            <select>Select potential</select>
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            Start rw Target Date <br />
                                            <input type="text" class="form-control" >
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            Status <br />
                                            <select>Select status</select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-3 col-xs-12">&nbsp;</div>

                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                            Currency <br />
                                            <select>Select currency</select>
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            Premium Amount <br />
                                            <input type="text" id="txtPremAmnt" name="txtPremAmnt" class="form-control">
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            aba Rev % <br />
                                            <input type="text" id="txtabaRev" name="txtabaRev" class="form-control">
                                        </div>
                                    </div>
                                </fieldset>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- /page content -->