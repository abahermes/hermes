<!-- <div id="individual"> -->
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <h2>Business Type: <b>Individual</b></h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <!-- <div class="row"> -->
                <div class="x_panel">
                    <fieldset>
                        <legend>Contact Details <a href="#" onClick="return editContactDetails();" title="Edit Client or Prospect"> <i class="fa fa-pencil blue"></i></a> <span class="pull-right"> <a href="#" onClick="return addCorporate()"><small>Add Corporate</small></a> <!-- <input type="button" class="btn btn-danger btn-grad" value="     Add Individual     " /> --> <!-- <input type="button" id="btnBSLType" class="btn btn-danger btn-grad" value="     Add Corporate     " /> --> <!-- <a href="#" title="View Client or Prospect Full Details"> <i class="fa fa-eye blue"></i></a> -->  </span></legend>
                        <div class="col-sm-12">
                            <h4 class="brief"><i>Junior Finance Officer ( Intern )</i></h4>
                            <div class="left col-xs-9">
                                <h2 id="contact-name" class="list-group-item-heading">Mr. Gustave MERLIER</h2>
                                <ul class="list-unstyled">
                                    <li><i class="fa fa-building"></i> <b>Company:</b> Abacare Hong Kong Limited</li>
                                    <li><i class="fa fa-envelope"></i> <b>Email:</b> gustave.merlier@abacare.com</li>
                                    <li><i class="fa fa-home"></i> <b>Address:</b> 17/F, Greenwich Centre, 260 King's Road, Hong Kong</li>
                                    <li><i class="fa fa-phone"></i> <b>Phone:</b> +852 28954449 x 307</li>
                                    <li><i class="fa fa-file"></i> <b>FUM:</b> <a href="#">01 fumclt {clt name}</a></li>
                                </ul>
                            </div>
                            <!-- <div class="right col-xs-3 text-center">
                                <img src="images/user.png" alt="" class="img-circle img-responsive">
                            </div> -->
                        </div>
                    </fieldset>
                    <input type="hidden" id="txtCtcId" name="txtCtcId" value="1" />
                </div>
            <!-- </div> -->
            <!-- <div class="row"> -->
                <div class="x_panel">
                    <fieldset>
                        <legend>Pending Tasks <span class="pull-right"><a href="#" onClick="return newTask();" title="Add New Activity"> <i class="fa fa-plus blue"></i></a></span></legend>
                        <div class="table-responsive" style="height: 375px; overflow-y: scroll;">
                            <table class="table table-striped jambo_table table-condensed table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th width="5">#</th>
                                    <th width="10">Task Date</th>
                                    <th width="10">Task Type</th>
                                    <th width="15">Other ppl</th>
                                    <th width="30">Result</th>
                                    <th width="25">Specific Result</th>
                                    <th width="5">Edit</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr id="dataTask" style="display: none;">
                                    <td class="text-center">1</td>
                                    <td class="text-center">Wed 11 Jun 2019</td>
                                    <td class="text-center">Call</td>
                                    <td></td>
                                    <td>Get Data</td>
                                    <td></td>
                                    <td class="text-center"><a href="#" onClick="return editTask();"><i class="fa fa-pencil-square-o vieweditico"></i></a></td>
                                </tr>
                                <tr id="dataTaskNone">
                                    <td colspan="7" class="text-center">No Pending Tasks</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                    <input type="hidden" id="txtTaskId" name="txtTaskId" value="" />
                </div>
            <!-- </div> -->
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <!-- <div class="row"> -->
                <div class="x_panel">
                    <fieldset>
                        <legend>Opportunities <span class="pull-right"> <a href="#" onClick="return newOpps();" title="Add New Opportunity"> <i class="fa fa-plus blue"></i></a></span></legend>
                        <div class="table-responsive">
                          <table class="table table-striped jambo_table table-condensed table-hover table-bordered">
                            <thead>
                              <tr>
                                <th width="5">#</th>
                                <th width="5">bsl</th>
                                <th width="10">Start rw Target Date</th>
                                <th width="5">Potential</th>
                                <th width="5">ccy</th>
                                <th width="20">Premium</th>
                                <th width="20">HKD Premium</th>
                                <th width="5">aba rev%</th>
                                <th width="20">HKD aba rev</th>
                                <th width="5">Edit</th>
                              </tr>
                            </thead>

                            <tbody>
                              <tr id="dataOpps" style="display: none;">
                                <td class="text-center">1</td>
                                <td class="text-center">medins</td>
                                <td>Mon 24 Jun 2019</td>
                                <td class="text-right">100%</td>
                                <td class="text-center">HKD</td>
                                <td class="text-right">1,000</td>
                                <td class="text-right">1,000</td>
                                <td class="text-right">20%</td>
                                <td class="text-right">200</td>
                                <td class="text-center"><a href="#" onClick="return editOpps();"><i class="fa fa-pencil-square-o vieweditico"></i></a></td>
                              </tr>
                              <tr id="dataOppsNone">
                                <td colspan="10" class="text-center">No Pipeline Opportunity</td>
                              </tr>
                              
                            </tbody>
                          </table>
                        </div>
                    </fieldset>
                </div>
            <!-- </div> -->
            <!-- <div class="row"> -->
                <div class="x_panel">
                    <fieldset>
                        <legend>Recent Activities <span class="pull-right"> <a href="#" onClick="return newCmts();" title="Add New Comments"> <i class="fa fa-plus blue"></i></a></span></legend>
                        <div style="height: 380px; overflow-y: scroll;">
                            <div class="dashboard-widget-content">
                                <ul class="list-unstyled timeline widget">
                                    <li>
                                        <div class="block" id="dataActivity" style="display: none;">
                                            <div class="block_content">
                                                <h2 class="title">Wed 19 Jun 2019</h2>
                                                <p class="excerpt"><span class="byline">11:00 - Email</span> - Email Client or Prospect</p>
                                                <p class="excerpt"><span class="byline">10:00 - Call</span> - Call Client or Prospect</p>
                                            </div>
                                        </div>
                                    </li>
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
<!-- </div> -->