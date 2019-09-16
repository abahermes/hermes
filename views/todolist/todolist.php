page content -->
<div class="right_col" role="main">
  <!-- top tiles -->
  <div class="row tile_count">
    <div class="row col-md-8 col-sm-8 col-xs-12">
      <div class="col-md-3 col-sm-3 col-xs-4 tile_stats_count">
        <span class="count_top"><i class="fa fa-tasks"></i> Due Today</span>
        <div style="cursor: pointer;" class="count blue" id="ttlduetoday">0</div>
        <!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
      </div>
      <div class="col-md-3 col-sm-3 col-xs-4 tile_stats_count">
        <span class="count_top"><i class="fa fa-tasks"></i> Overdue Tasks</span>
        <div style="cursor: pointer;" class="count red" id="ttloverdue">0</div>
        <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> -->
      </div>
      <div class="col-md-3 col-sm-3 col-xs-4 tile_stats_count">
        <span class="count_top"><i class="fa fa-tasks"></i> Task Pending</span>
        <div style="cursor: pointer;" class="count" id="ttltaskpending">0</div>
        <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span> -->
      </div>
    </div>
    
  </div>
  <!-- /top tiles -->

  <div class="row">
    <div class="x_panel">
      <fieldset>
        <legend>TO DO LIST <span class="pull-right"> 
<!--			<button class="btn btn-success btn-grad" title="Add New Task" onClick="return newTDL();">Add New Task</button>-->
			<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#frmTask" onClick="return newTDL();">Add New Task</button>
      		<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#frmUsefulLinks" onClick="return newUL();" >Add New Useful Links</button>
      		<button type="button" class="btn btn-warning" id = "BulkUpdate" onClick="return bulkUpdateSwitch();">Bulk Update</button>
			</span></legend>
      	<div class="row">
			<div class="col-md-6 col-sm-8 col-xs-12 form-group top_search">
			    <div class="input-group">
			      <div class="input-group-btn search-panel search-bar-head" id="divSearchBy">
			        <select class="form-control" id="txtSearchBy" name="txtSearchBy">
			        </select>
			      </div>       
			      <input id="txtSearch" type="text" class="form-control" placeholder="Search Tasks, Category or FUW..." onchange="return SearchTask()">
			      <span class="input-group-btn">
			        <button type="button" id="btnSearch" name="btnSearch" class="btn btn-default" ><span class="glyphicon glyphicon-search"></span></button>
			      </span>
			    </div>
			</div>
			 <div id = "divBulkUpdate" style="display: none;">
	            <span class="pull-right"> 
	              <div class="col-md-4 col-sm-4 col-xs-8" id="divFields">
	                    <select class="form-control" id="txtField" name="txtField">
							<option value="" selected disabled>Select field to update</option>
							<option value="nextctcdate">Next Contact Date</option>
							<option value="duedate">Due Date</option>
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
      </div>

        
        <div id="tabs">
          <ul>
            <li ><a href="#tasks" onClick="return dropDownTodo()">Task Pending</a></li>
            <li><a href="#tasksdone" onClick="return dropDownTodo()">Tasks Done</a></li>
            <li><a href="#usefullinks" onClick="return dropDownUsefulLink()">Useful Links</a></li>
          </ul>

          <div id="tasks" class="x_content" >
            <div class="table-responsive" id="datatblTDLPending">
              <table id="tblPending" class="table table-striped jambo_table table-condensed table-hover table-bordered" >
                <thead>
                  <tr>
                    <th>#</th>
                    <th>type</th>
                    <th>task or to do</th>
                    <th>priority </th>
                    <th>category </th>
                    <th>fuw </th>
                    <th>ofc </th>
                    <th>ot ppl </th>
                    <!--<th>psd</th> -->
                    <!--<th>pfu</th> -->
                    <th>start date</th>
                    <th>next ctc date </th>
                    <th>due dt </th>
                    <th># of Rev </th>
                    <th>status</th>
                    <th>FUM link </th>
                    <th>remarks </th>
                    <!-- <th>View / Edit</th> -->
                  </tr>
                </thead>
              </table>
            </div>

            <div class="table-responsive" id="datatblTDLPendingCheckbox" style="display: none;">
              <table id="tblPendingCheckbox" class="table table-striped jambo_table table-condensed table-hover table-bordered"  >
                <thead>
                  <tr>
                    <th><input type="checkbox" id = "selectall"></th>
                    <th>type</th>
                    <th>task or to do (use telegraphic style w abvts)</th>
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
                    <th># of Rev </th>
                    <th>status</th>
                    <th>FUM link </th>
                    <th>remarks </th>
                    <!-- <th>View / Edit</th> -->
                  </tr>
                </thead>
              </table>
            </div>
          </div>
          <div id="tasksdone" class="x_content">
            <div class="table-responsive" id="datatblTDLDone">
              <table id ="tblDone" class="table table-striped jambo_table table-condensed table-hover table-bordered">
                <thead>
                  <tr>
                    <!-- <th width="4">#</th> -->
                    <th width="4%">type</th>
                    <th width="50">task or to do</th>
                    <th width="4">priority </th>
                    <th width="4">category </th>
                    <th width="10">fuw </th>
                    <th width="4">ofc </th>
                    <th width="4">ot ppl </th>
                     <!--<th width="4">psd</th>
                    <th width="4">pfu</th> -->
                    <th width="7">start date</th>
                    <th width="7">next ctc date </th>
                    <th width="7">due dt </th>
                    <th width="10">FUM link </th>
                    <th width="100">remarks </th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>

          <div id="usefullinks" class="x_content">
            <div class="table-responsive" id="datatblUsefullinks">             
              <table id ="tblUsefullinks" class="table table-striped jambo_table table-condensed table-hover table-bordered">
                <thead>
                  <tr>
                    <th width="1">category</th>
                    <th width="1">link </th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2" class="text-center" >No Useful Links</td>
                    </tr>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </fieldset>
    </div>
  </div>

  <?php include_once('frmtaskdtls.php'); ?>
  <?php include_once('frmusefullinks.php'); ?>
  <input type="hidden" id="abaini" name="abaini" value="<?php echo $abaini; ?>"/>
  <input type="hidden" id="userid" name="userid" value="<?php echo $userid; ?>"/>
  <input type="hidden" id="userid" name="userid" value=""/>
  <input type="hidden" id="sortby" name="sortby" value=""/>
  <input type="hidden" id="sortin" name="sortin" value="ASC"/>
  <input type="hidden" id="bulkupdate" name="bulkupdate" value="Off"/>
  <input type="hidden" id="headerclickval" name="headerclickval" value="" />
  <input type="hidden" id="actid" name="actid" value="<?php if(isset($_GET['activityid']) && !empty($_GET['activityid'])){ echo $_GET['activityid']; } ?>"/>
</div>
<!-- /page content
