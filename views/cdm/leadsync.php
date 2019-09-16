page content -->
<div class="right_col" role="main">
	<div class="page-title">
		<div class="row">
			<!-- <div class="col-lg-12 col-sm-12 col-xs-12"> -->
				<div class="col-lg-6 col-sm-12 col-xs-12">
					<h3>Leads Contact List </h3>
				</div>
				<div class="col-lg-6 col-sm-12 col-xs-12 text-right">
          <span class="pull-right"><a type="button" class="btn btn-primary" href="#" id="btnImport" data-toggle="modal" data-target="#frmLeadImport" >Import outlook contacts</a></span>
					<!-- <a type="button" class="btn btn-lg btn-primary" href="#" id="connect-button">Connect to Outlook</a>
					<a type="button" class="btn btn-lg btn-primary" href="#" id="sync-button">Synchronize Outlook Contacts to hermes</a> -->
				</div>
			<!-- </div> -->
		</div>
	</div>

<!--
  <div class="page-title">
    <div class="title_left">
      <h3>Microsoft Outlook Contact list 
        <small> 
          <a class="btn btn-lg btn-primary" href="#" role="button" id="connect-button">Connect to Outlook</a> 
          <a class="btn btn-lg btn-primary" href="#" role="button" id="sync-button">Synchronize Outlook Contacts to hermes</a>
        </small></h3>
    </div>
  </div>
-->

  <div class="clearfix"></div>
	
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <fieldset>
          <legend><span id="rownum"></span></legend>
			
	        <div class="row">
          <div class="col-md-6 col-sm-8 col-xs-12 form-group top_search">
    			  <div class="input-group">
    					<div class="input-group-btn search-panel search-bar-head">
    						<select class="form-control" id="txtSearchBy" name="txtSearchBy">
    							<option value="fullname" selected>Name </option>
    							<option value="company">Company</option>
                  <option value="jobtitle">Job Title </option>
    							<!-- <option value="tasktype">Task Type</option>
    							<option value="resexpected">Result Expected</option> -->
    						</select>
    					</div>
    					<!-- <input type="hidden" name="search_param" value="all" id="search_param">          -->
    					<input type="text" class="form-control" name="x" placeholder="Search..." id = "txtSearch" onchange="return searchLeads()">
    					<span class="input-group-btn">
    						<button class="btn btn-default" type="button" id="btnSearch" name="btnSearch"><span class="glyphicon glyphicon-search"></span></button>
    					</span>
    			  </div>
          </div>
        </div>
	

          <div class="table-responsive" id="contacts">
            <table class="table table-striped jambo_table table-condensed table-hover table-bordered">
              <thead>
                <tr>
                  <th width="5">#</th>
                  <th width="15">Name</th>
                  <th width="10">Job Title</th>
                  <th width="25">Company</th>
                  <th width="10">e-Address</th>
                  <th width="10">Phone No</th>
                  <th width="25">Address</th>
                </tr>
              </thead>
              <!-- <tbody>
                <tr>
                  <td colspan="7" class="text-center">Please connect to your MS outlook abacare exchange account</td>
                </tr>
              </tbody> -->
            </table>
          </div>
        </fieldset>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->

<!-- CONTACT DETAILS FORM -->
<?php include_once('frmctcdtls.php');?>

<!-- POPUP MESSAGE FORM -->
<?php include_once('frmpopupmsg.php');?>

<!-- LEADS IMPORT FORM -->
<?php include_once('frmleadimport.php');?>

<input type="hidden" name="etag" id="etag" value="" />
<input type="hidden" name="uid" id="uid" value="" />
<input type="hidden" id="txtlid" name="txtlid" value="" />
<input type="hidden" id="leadid" name="leadid" value="" />
<input type="hidden" id="userid" name="userid" value="<?php echo $userid;?>" />
<input type="hidden" id="abaini" name="abaini" value="<?php echo $abaini;?>" />
<input type="hidden" id="abaemail" name="abaemail" value="<?php echo $abaemail;?>" />
<input type="hidden" id="sortin" name="sortin" value="ASC" />
<input type="hidden" id="sortby" name="sortby" value="" />