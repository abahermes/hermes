<!-- page content -->
<div class="right_col" role="main">
    <div class="row col-md-12 col-sm-12 col-xs-12">
        <!-- top tiles -->
        <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-12">
                
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
            <!-- <div id="tabs"> -->
                <!-- <ul>
                    <li><a href="#individual">Individual</a></li>
                    <li><a href="#corporate">Corporate</a></li>
                </ul> -->

                <!-- INDIVIDUAL TAB -->
                <?php include_once('indtab.php');?>

                <!-- CORPORATE TAB -->
                <?php // include_once('corptab.php');?>
            <!-- </div> -->
        </div>

        <!-- CONTACT DETAILS FORM -->
        <?php include_once('frmctcdtls.php');?>

        <!-- TASK DETAILS FORM -->
        <?php include_once('frmtaskdtls.php');?>

        <!-- OPPORTUNITY FORM -->
        <?php include_once('frmopps.php');?>
    </div>
</div>
<!-- /page content -->