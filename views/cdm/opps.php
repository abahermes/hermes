<!-- page content -->
<div class="right_col" role="main">
  <!-- top tiles -->
  <div class="row tile_count">
    <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
      <span class="count_top" id = "oppsYTD"><i class="fa fa-money"></i> Opps HKD</span>
      <div class="count green" id="abaRevTotalOpsYTD">0</div>
      <div>1 Jan <?php echo formatDate('Y' , TODAY );?> - 31 Dec <?php echo formatDate('Y' , TODAY );?></div>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
      <span class="count_top" id = "oppsnextytd"><i class="fa fa-money"></i> Opps HKD</span>
      <div class="count green" id="abaRevTotalOpsNextYTD">0</div>
      <div>1 Jan <?php echo (formatDate('Y' , TODAY ) + 1);?></div>
    </div>
  </div>
  <div class="row tile_count">
  	<div class="col-md-2 col-sm-2 col-xs-12 tile_stats_count" id="divttlops">
      <span class="count_top"><i class="fa fa-tasks"></i> Total Opportunities</span>
      <div style="cursor: pointer;" class="count" id="datattlopps">0</div>
      <!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
    </div>
    <div class="col-md-2 col-sm-2 col-xs-12 tile_stats_count" id="divttlmedins">
      <span class="count_top"><i class="fa fa-tasks"></i> Medical Insurance</span>
      <div style="cursor: pointer;" class="count" id="datattlmedins">0</div>
      <!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
    </div>
    <div class="col-md-2 col-sm-2 col-xs-12 tile_stats_count" id="divttllins">
      <span class="count_top"><i class="fa fa-tasks"></i> Life Insurance</span>
      <div style="cursor: pointer;" class="count" id="datattllins">0</div>
      <!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
    </div>
    <div class="col-md-2 col-sm-2 col-xs-12 tile_stats_count"  id="divttlgenins">
      <span class="count_top"><i class="fa fa-tasks"></i> General Insurance</span>
      <div style="cursor: pointer;" class="count" id="datattlgenins">0</div>
      <!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
    </div>
  </div>

  <div class="row">
    <div class="x_panel">
      <fieldset>
        <!-- <div class="x_title"> -->
         <legend>PIPELINE OPPORTUNITIES LIST 
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
            <li><a href="#opps">Opportunities</a></li>
            <!-- <li><a href="#sdspspilost">Signed / Paid / Issued / Lost</a></li> -->
          </ul>

          <div id="opps" class="x_content">
            <div class="table-responsive" id="tbloppspending">
              <table class="table table-striped jambo_table table-condensed table-hover table-bordered">
                <thead>
                  <tr>
                    <th width="8%">LAST NAME </th>
                    <th width="8%">First Name </th>
                    <th width="9%">Company </th>
                    <th width="5%">ica</th>
                    <th width="10%">Product</th>
                    <th width="10%">Target dt </th>
                    <th width="5%">Currency</th>
                    <th width="5%">Premium</th>
                    <th width="5%">Premium HKD</th>
                    <th width="5%">aba Rev %</th>
                    <th width="10%">aba Rev HKD</th>
                    <th width="5%">Shared With</th>
                    <th width="10%">aba rev Share</th>
                    <th width="5%">Status</th>
                  </tr>
                </thead>
              </table>
            </div>
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