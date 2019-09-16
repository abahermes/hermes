<!-- page content -->
<div class="right_col" role="main">
  <!-- top tiles -->
  <div class="row tile_count">
    <div class="col-md-2 col-sm-2 col-xs-4 tile_stats_count">
      <span class="count_top"><i class="fa fa-tasks"></i> Total Contacts</span>
      <div style="cursor: pointer;" class="count" id="datattlctcs">0</div>
      <!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
    </div>
    <div class="col-md-2 col-sm-2 col-xs-4 tile_stats_count">
      <span class="count_top"><i class="fa fa-tasks"></i> Total Prospects</span>
      <div style="cursor: pointer;" class="count" id="datattlprosts">0</div>
      <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span> -->
    </div>
    <div class="col-md-2 col-sm-2 col-xs-4 tile_stats_count">
      <span class="count_top"><i class="fa fa-tasks"></i> Total Clients</span>
      <div style="cursor: pointer;" class="count" id="datattlclts">0</div>
      <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span> -->
    </div>
    
    <!-- <div class="col-md-4 col-sm-4 col-xs-12 form-group pull-right top_search">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search Client or Prospect...">
        <span class="input-group-btn">
          <button type="button" id="btnSearch" name="btnSearch" class="btn btn-default" >     SEARCH     </button>
        </span>
      </div>
    </div> -->
  </div>
  <!-- /top tiles -->

  <div class="row">
    <div class="x_panel">
    <fieldset>
        <!-- <div class="x_title"> -->
          <legend>CLIENTS and PROSPECTS LIST
            <span class="pull-right"> 
<!--          <button class="btn btn-success btn-grad" title="Add New Task" onClick="return newTDL();">Add New Task</button>-->
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#frmCtcDtls" id="btnAddNew">Add New Client or Prospect </button>
            </span>
          </legend>
          <!-- <div class="clearfix"></div> -->
        <!-- </div> -->
        <div class="row">
          <div class="col-md-6 col-sm-8 col-xs-12 form-group top_search">
                <div class="input-group">   
                  <input id="txtSearch" type="text" class="form-control" placeholder="Search Client or Prospect..." onchange="return searchCltPros()">
                  <span class="input-group-btn">
                    <button type="button" id="btnSearch" name="btnSearch" class="btn btn-default" ><span class="glyphicon glyphicon-search"></span></button>
                  </span>
                </div>
          </div>      
        </div>
        <div class="x_content">
          <div class="table-responsive" id="tblcltsprosts">
            <table class="table table-striped jambo_table table-condensed table-hover table-bordered">
              <thead>
                <tr>
                  <th width="15%">Name</th>
                  <!-- <th width="5%">ini</th> -->
                  <th width="15%">Company</th>
                  <!-- <th width="15%">Email Address</th> -->
                  <th width="15%">Job Title</th>
                  <th width="10%">ica</th>
                  <th width="10%">Account Type </th>
                  <th width="15%">FUM </th>
                  <th width="10%">Nationality</th>
                  <th width="10%">Introducer</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </fieldset>
    </div>
  </div>
</div>
<!-- /page content -->
<?php include_once('views/cdm/frmctcdtls.php');?>
<input type="hidden" id="userid" name="userid" value="<?php echo $userid; ?>" />
<input type="hidden" id="sortby" name="sortby" value="" />
<input type="hidden" id="sortin" name="sortin" value="ASC" />
<input type="hidden" id="headerclickval" name="headerclickval" value="" />
<input type="hidden" name="etag" id="etag" value="" />
<input type="hidden" name="uid" id="uid" value="" />
<input type="hidden" id="ofc" name="ofc" value="<?php echo $ofc; ?>" />
<input type="hidden" id="salesofcid" name="salesofcid" value="" />