<!-- page content -->
<div class="right_col" role="main">
  <!-- top tiles -->
  <div class="row tile_count">
    <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
      <span class="count_top" id ="signedYTD"><i class="fa fa-money"></i> Signed HKD</span>
      <div class="count green" id="abaRevTotalSignedYTD">0</div>
      <div> 1 Jan <?php echo formatDate('Y' , TODAY );?> - 31 Dec <?php echo formatDate('Y' , TODAY );?> HKD</div>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
        <span class="count_top" id = "signedNextYTD"><i class="fa fa-money"></i> Signed HKD</span>
        <div  class="count green" id="abaRevTotalSignedNextYTD">0</div>
        <div> 1 Jan <?php echo (formatDate('Y' , TODAY ) + 1);?></div>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
        <span class="count_top" id ="spiYTD"><i class="fa fa-money"></i> Signed and Policy Issued HKD</span>
        <div  class="count green" id="abaRevTotalSPIYTD">0</div>
        <div> 1 Jan <?php echo formatDate('Y' , TODAY );?> - <?php echo formatDate('d M Y' , TODAY );?></div>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
      <span class="count_top" id ="targetYTD"><i class="fa fa-money"></i> YTD Target HKD</span>
      <div class="count green" id="targetBDYTD">0</div>
      <div> 1 Jan <?php echo formatDate('Y' , TODAY );?> - 31 Dec <?php echo formatDate('Y' , TODAY );?></div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 tile_count">
        <div class="col-md-2 col-sm-4 col-xs-4 tile_stats_count"  id="divttlsigned">
          <span class="count_top"><i class="fa fa-tasks"></i> Signed</span>
          <div style="cursor: pointer;" class="count" id="datattlsigned">0</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-4 tile_stats_count"  id="divttlspi">
          <span class="count_top"><i class="fa fa-tasks"></i> Signed and Policy Issued</span>
          <div style="cursor: pointer;" class="count" id="datattlspi">0</div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-4 tile_stats_count"  id="divttllost">
          <span class="count_top"><i class="fa fa-tasks"></i> Lost</span>
          <div style="cursor: pointer;" class="count" id="datattllost">0</div>
        </div>
    </div>
  </div>
  <!-- /top tiles -->

  <div class="row">
    <div class="x_panel">
      <fieldset>
        <!-- <div class="x_title"> -->
         <legend>SIGNED AND ISSUED POLICIES
          <!-- <span class="pull-right">  -->
            <!-- <button type="button" id="btnSearch" name="btnSearch" class="btn btn-default" >     SEARCH     </button> -->
            <!-- <div class="clearfix"></div> -->
          <!-- </span> -->
         </legend>
        <!-- </div> -->
        <div class="row">
          <div class="col-md-6 col-sm-8 col-xs-12 form-group top_search">
            <div class="input-group">      
               <input id="txtSearch" type="text" class="form-control" placeholder="Search Client or Prospect..."  onchange="return SearchCltPros()">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
              </span>
            </div>
          </div>
        </div>
        <div id="tabs">
          <ul>
            <li><a href="#signed">Signed</a></li>
            <li><a href="#signedissued">Signed and Policy Issued</a></li>
            <li><a href="#lost">Lost</a></li>
          </ul>

          <div id="signed" class="x_content">
            <div class="table-responsive" id="tbloppssigned">
              <table class="table table-striped jambo_table table-condensed table-hover table-bordered">
                <thead>
                  <tr>
                    <th width="15%">LAST NAME </th>
                    <th width="15%">First Name </th>
                    <th width="15%">Company </th>
                    <th width="5%">ica</th>
                    <th width="10%">Product</th>
                    <th width="10%">Start rw Target dt </th>
                    <th width="5%">Potential </th>
                    <th width="5%">Currency</th>
                    <th width="5%">Prem</th>
                    <th width="5%">aba Rev %</th>
                    <th width="5%">Sigend Date</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>

          <div id="signedissued" class="x_content">
            <div class="table-responsive" id="tbloppssignedpoissued"></div>
          </div>

          <div id="lost" class="x_content">
            <div class="table-responsive" id="tbllost"></div>
          </div>
        </div>
      </fieldset>
    </div>
  </div>
</div>
<!-- page content -->

<input type="hidden" id="userid" name="userid" value="<?php echo $userid; ?>" />
<input type="hidden" id="sortby" name="sortby" value="" />
<input type="hidden" id="sortin" name="sortin" value="ASC" />
<input type="hidden" id="headerclickval" name="headerclickval" value="" />