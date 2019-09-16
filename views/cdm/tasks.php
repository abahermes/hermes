
<!-- page content -->
<div class="right_col" role="main">
  <!-- top tiles -->
  <div class="row tile_count">
    <div class="row col-md-8 col-sm-12 col-xs-12">
      <div class="col-md-2 col-sm-2 col-xs-4 tile_stats_count">
        <span class="count_top"><i class="fa fa-tasks"></i> Total Tasks</span>
        <div  class="count green" id="datattltasks">0</div>
        <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> -->
      </div>
      <div class="col-md-2 col-sm-2 col-xs-4 tile_stats_count">
        <span class="count_top"><i class="fa fa-tasks"></i> Due Tasks</span>
        <div class="count red" id="dataduetasks">0</div>
        <!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
      </div>
      <div class="col-md-2 col-sm-2 col-xs-4 tile_stats_count">
        <span class="count_top"><i class="fa fa-tasks"></i> Due Today</span>
        <div class="count blue" id="dataduetoday">0</div>
        <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span> -->
      </div>
      <div class="col-md-2 col-sm-2 col-xs-4 tile_stats_count">
        <span class="count_top"><i class="fa fa-tasks"></i> Total Calls</span>
        <div  class="count" id="datattlcalls">0</div>
        <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> -->
      </div>
      <div class="col-md-2 col-sm-2 col-xs-4 tile_stats_count">
        <span class="count_top"><i class="fa fa-tasks"></i> Total Mtgs</span>
        <div  class="count" id="datattlmtgs">0</div>
        <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> -->
      </div>
      <div class="col-md-2 col-sm-2 col-xs-4 tile_stats_count">
        <span class="count_top"><i class="fa fa-tasks"></i> Total Call-Mtgs</span>
        <div  class="count" id="datattlcm">0</div>
        <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> -->
      </div>
    </div>
  </div>
  <!-- /top tiles -->

  <div class="row">
    <div class="x_panel">
      <fieldset>
        <legend>TASKS LIST 
          <span class="pull-right"> 
                <button type="button" class="btn btn-warning" id = "BulkUpdate" onClick="return bulkUpdateSwitch();">Bulk Update</button>
          </span>
        </legend>
        <div class="row">
          <div class="col-md-6 col-sm-8 col-xs-12 form-group top_search">
    			  <div class="input-group">
    					<div class="input-group-btn search-panel search-bar-head">
    						<select class="form-control" id="txtSearchBy" name="txtSearchBy">
    							<option value="lname" selected>Last name</option>
    							<option value="fname">First name</option>
    							<option value="company">Company</option>
    							<option value="tasktype">Task Type</option>
    							<option value="resexpected">Result Expected</option>
                  <option value="othppl">Other People</option>
    						</select>
    					</div>
    					<input type="hidden" name="search_param" value="all" id="search_param">         
    					<input id="txtSearch" type="text" class="form-control" placeholder="Search..." onchange="return searchTask()">
    					<span class="input-group-btn">
    						 <button type="button" id="btnSearch" name="btnSearch" class="btn btn-default" ><span class="glyphicon glyphicon-search"></span></button>
    					</span>
    			  </div>
          </div>
          <div id = "divBulkUpdate" style="display: none;">
            <span class="pull-right"> 
              <div class="col-md-4 col-sm-4 col-xs-8" id="divFields">
                    <select class="form-control" id="txtField" name="txtField">
                        <option value="taskdate" selected>Task Date</option>
                    </select>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-8" id="divDate">
                    <input type="text" id="txtDateReplace" name="txtDateReplace" class="form-control" placeholder="Choose date to replace" />
                </div>
                <div class="col-md-2 col-sm-2 col-xs-8" id="divDate">
                    <button id="btnUpdateTaskDates" type="button" class="btn btn-warning">Update All</button>
                </div>
            </span>
          </div>   
        </div>
		  
        <div id="tabs">
          <ul>
            <li><a href="#tasks">Tasks</a></li>
            <li><a href="#tasksdone">Tasks Done</a></li>
          </ul>
          <div id="tasks" class="x_content">
            <div class="table-responsive" id="tbltaskspending">
              <table class="table table-striped jambo_table table-condensed table-hover table-bordered">
                <thead>
                  <tr>
                    <th width="10%">Task Date</th>
                    <th width="10%">Task Type</th>
                    <th width="10%">LAST NAME</th>
                    <th width="10%">First Name</th>
                    <th width="10%">Company</th>
                    <th width="5%">ica</th>
                    <th width="5%">lob</th>
                    <th width="5%">ot ppl</th>
                    <th width="15%">Result Expected</th>
                    <th width="20%">Specific Result</th>
                  </tr>
                </thead>
              </table>
            </div>
            <div class="table-responsive" id="tbltaskspendingcheckbox"  style="display: none;"></div>
          </div>
          <div id="tasksdone" class="x_content">
            <div class="table-responsive" id="tbltasksdone"></div>
          </div>
        </div>
      </fieldset>
    </div>
  </div>
</div>

<input type="hidden" id="userid" name="userid" value="<?php echo $userid; ?>" />
<input type="hidden" id="sortby" name="sortby" value="" />
<input type="hidden" id="sortin" name="sortin" value="ASC" />
<input type="hidden" id="headerclickval" name="headerclickval" value="" />
<input type="hidden" id="bulkupdate" name="bulkupdate" value="Off"/>