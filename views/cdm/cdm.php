page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <!-- top tiles -->
            <div class="row">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <h2>Business Type: <b><span id="dataBusType"></span></b></h2>
                </div>
                <!-- <div class="col-md-4 col-sm-4 col-xs-12 form-group pull-right top_search">
                    <?php include_once('inc/divsearchcltprost.php'); ?>
                </div> -->
            </div>
            <!-- /top tiles -->

            <div class="row">
                <div class="x_content">
                <!-- <div id="tabs"> -->
                    <!-- <ul>
                        <li><a href="#individual">Individual</a></li>
                        <li><a href="#corporate">Corporate</a></li>
                    </ul> -->

                    <!-- INDIVIDUAL TAB -->
                    <?php include_once('cltprostdata.php');?>

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

                <!-- COMMENTS FORM -->
                <?php include_once('frmcmts.php');?>

                <!-- COMMENTS FORM -->
                <?php include_once('frmcltprostlist.php');?>
            </div>
        </div>
    </div>
    <input type="hidden" id="sesid" name="sesid" value="<?php echo $_GET['id']; ?>" />
    <input type="hidden" id="abaini" name="abaini" value="<?php echo $abaini; ?>" />
    <input type="hidden" id="abaemail" name="abaemail" value="<?php echo $abaemail; ?>" />
    <input type="hidden" id="userid" name="userid" value="<?php echo $userid; ?>" />
    <input type="hidden" id="acctid" name="acctid" value="" />
    <input type="hidden" id="ctcid" name="ctcid" value="" />
    <input type="hidden" name="su" id="su" value="" />
    <input type="hidden" name="tid" id="tid" value="<?php if(isset($_GET['taskid']) && !empty($_GET['taskid'])){ echo $_GET['taskid']; } ?>" />
    <input type="hidden" name="cltprost" id="cltprost" value="" />
    <input type="hidden" name="txtTaskDone" id="txtTaskDone" value="0" />
    <input type="hidden" name="oppsid" id="oppsid" value="<?php if(isset($_GET['oppsid']) && !empty($_GET['oppsid'])){ echo $_GET['oppsid']; } ?>" />
    <input type="hidden" id="salesofc" name="salesofc" value="<?php echo $ofc; ?>" />
    <input type="hidden" name="refresh" id="refresh" value="0" />
</div>
<!-- /page content