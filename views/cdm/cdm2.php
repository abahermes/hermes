<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <!-- top tiles -->
            <div class="row">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group pull-right top_search">
                    <?php include_once('inc/divsearchcltprost.php'); ?>
                </div>
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
                    <?php include_once('indtab1.php');?>

                    <!-- CORPORATE TAB -->
                    <?php // include_once('corptab.php');?>
                <!-- </div> -->
                </div>
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
<!-- /page content -->