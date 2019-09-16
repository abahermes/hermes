<!-- page content -->
<div class="right_col" role="main">
  <div class="row">
    <div class="x_panel">
      <fieldset>
          <legend>Change Password</legend>
      </fieldset>
      <!-- <div class="animate form login_form">
        <section class="login_content"> -->
          <div class="col-lg-4 col-sm-4 col-xs-12"></div>
          <div class="col-lg-4 col-sm-4 col-xs-12">
            <form method="Post" id="frmLogin" name="frmLogin">
                <div class="row">
                    <div class="col-lg-3 col-sm-3 col-xs-12 text-right">Old Password</div>
                    <div class="col-lg-9 col-sm-9 col-xs-12 text-left"><input type="password" class="form-control" name="txtOldPass" id="txtOldPass" placeholder="**********" /></div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-sm-3 col-xs-12 text-right">New Password</div>
                    <div class="col-lg-9 col-sm-9 col-xs-12 text-left"><input type="password" class="form-control" name="txtNewPass" id="txtNewPass" placeholder="**********" /></div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-sm-3 col-xs-12 text-right">Confirm Password</div>
                    <div class="col-lg-9 col-sm-9 col-xs-12 text-left"><input type="password" class="form-control" name="txtConPass" id="txtConPass" placeholder="**********" /></div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-sm-3 col-xs-12 text-right"></div>
                    <div class="col-lg-9 col-sm-9 col-xs-12 text-right"><input type="button" class="btn btn-grad btn-danger" id="btnChangePW" name="btnChangePW" value=" CHANGE " /></div>
                </div>
            </form>
          </div>
          <div class="col-lg-4 col-sm-4 col-xs-12"></div>
        <!-- </section>
      </div> -->
    </div>
  </div>
</div>
<input type="hidden" id="txtCurPW" name="txtCurPW" value="<?php echo $pw; ?>" />
<input type="hidden" id="abaini" name="abaini" value="<?php echo $abaini; ?>" />
<input type="hidden" id="userid" name="userid" value="<?php echo $userid; ?>" />