<!-- page content -->
<div class="right_col" role="main">
  <!-- top tiles -->
  <div class = "row">
      <div class="col-md-12 col-sm-12 col-xs-12 tile_count">
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
          <span class="count_top" id = "oppsYTD"><i class="fa fa-money"></i> Opps HKD</span>
          <div class="count green" id="abaRevTotalOpsYTD">0</div>
          <div> 1 Jan <?php echo formatDate('Y' , TODAY );?> - 31 Dec <?php echo formatDate('Y' , TODAY );?></div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
          <span class="count_top" id = "oppsnextytd"><i class="fa fa-money"></i> Opps HKD</span>
          <div class="count green" id="abaRevTotalOpsNextYTD">0</div>
          <div> 1 Jan <?php echo (formatDate('Y' , TODAY ) + 1);?></div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
          <span class="count_top" id ="signedYTD"><i class="fa fa-money"></i> Signed HKD</span>
          <div class="count green" id="abaRevTotalSignedYTD">0</div>
          <div> 1 Jan <?php echo formatDate('Y' , TODAY );?> - 31 Dec <?php echo formatDate('Y' , TODAY );?></div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
          <span class="count_top" id = "signedNextYTD"><i class="fa fa-money"></i> Signed HKD</span>
          <div class="count green" id="abaRevTotalSignedNextYTD">0</div>
          <div> 1 Jan <?php echo (formatDate('Y' , TODAY ) + 1);?></div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
          <span class="count_top" id ="spiYTD"><i class="fa fa-money"></i> Signed and Policy Issued HKD</span>
          <div class="count green" id="abaRevTotalSPIYTD">0</div>
          <div> 1 Jan <?php echo formatDate('Y' , TODAY );?> - <?php echo formatDate('d M Y' , TODAY );?></div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
          <span class="count_top" id ="targetYTD"><i class="fa fa-money"></i> YTD Target HKD</span>
          <div class="count green" id="targetBDYTD">0</div>
          <div> 1 Jan <?php echo formatDate('Y' , TODAY );?> - 31 Dec <?php echo formatDate('Y' , TODAY );?></div>
        </div>
      </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 tile_count">
      <div class="col-md-2 col-sm-4 col-xs-4 tile_stats_count">
        <span class="count_top"><i class="fa fa-tasks"></i> <a href="#tasks">Pending Client Tasks</a></span>
        <div class="count" id="pendingTaskCnt">0</div>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-4 tile_stats_count">
        <span class="count_top"><i class="fa fa-tasks"></i> <a href="#tasks">Pending To Do Lists</a></span>
        <div style="cursor: pointer;" class="count" id="pendingTDLCnt">0</div>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-4 tile_stats_count">
        <span class="count_top"><i class="fa fa-users"></i> <a href="#pipeline">Total Pipeline Opportunities</a></span>
        <div style="cursor: pointer;" class="count" id="pipelineCnt">0</div>
      </div>
    </div>
  </div>
  
  <!-- /top tiles -->

  <div class="row">
    <div class="col-md-8 col-sm-8 col-xs-12">
      <!-- <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div id="monthly" class="dashboard_graph">
              <div class="x_title">
                <h2>Pipeline Opportunities</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <canvas id="mybarChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div> -->

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>CLIENT TASKS </h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="table-responsive" id="tlbclttasks" style="height: 356px;overflow-y: scroll;">
                <table class="table table-striped jambo_table table-condensed table-hover table-bordered">
                  <thead>
                    <tr>
                      <th>Task Date</th>
                      <th>Task Type </th>
                      <th>LAST NAME </th>
                      <th>First Name </th>
                      <th>Company </th>
                      <th>ic </th>
                      <th>Result Expected</th>
                      <th>Specific Result</th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td colspan="8" class="text-center">No Pending Tasks</td>
                      </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>TO DO LISTS </h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="table-responsive" id="tbltodolist" style="height: 356px;overflow-y: scroll;">
                <table class="table table-striped jambo_table table-condensed table-hover table-bordered">
                  <thead>
                    <tr>
                      <th>type</th>
                      <th>task or to do</th>
                      <th>priority </th>
                      <th>category </th>
                      <th>fuw </th>
                      <th>ofc </th>
                      <th>ot ppl </th>
                      <!-- <th>psd</th>
                      <th>pfu</th> -->
                      <th>start date</th>
                      <th>next ctc date </th>
                      <th>due dt </th>
                      <th>status</th>
                    </tr>
                  </thead>

                  <tbody>
                      <tr>
                          <td colspan="14" class="text-center">No Pending Tasks</td>
                      </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>PIPELINE OPPORTUNITIES</h2>
              <div class="row" >
                <div class="col-md-6 col-sm-8 col-xs-12 form-group top_search pull-right">
                  <div class="input-group">      
                    <input id="txtSearch" type="text" class="form-control" placeholder="Search Client or Prospect..."  onchange="return SearchCltPros()">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
            </div>

            <div class="x_content">
              <div class="table-responsive" id="tblpipeline" style="height: 356px;overflow-y: scroll;">
                <table class="table table-striped jambo_table table-condensed table-hover table-bordered">
                  <thead>
                    <tr>
                      <th width="10">LAST NAME </th>
                      <th width="10">First Name </th>
                      <th width="10">Company </th>
                      <th width="10">ic </th>
                      <th width="5">Product </th>
                      <th width="5">Target date</th>
                      <th width="5">Currency</th>
                      <th width="5">Premium</th>
                      <th width="5">Premium HKD</th>
                      <th width="10">aba Rev %</th>
                      <th width="5">aba Rev HKD</th>
                      <th width="5">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td colspan="12" class="text-center">No Pipeline Opportunities</td>
                      </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-sm-4 col-xs-12">
      <div class="row">
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
      </div>
    </div>
  </div>
</div>
<!-- /page content> -->
<input type="hidden" id="userid" name="userid" value="<?php echo $userid; ?>" />
