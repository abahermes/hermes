<?php
    // include database and object files
    require_once('../inc/global.php');
    require_once('models/database.php');
    require_once('../inc/functions.php');
    require_once('inc/class.phpmailer.php');
    require_once('models/abauser_model.php');
    require_once('models/activities_model.php');

    $result = array();
    $json = json_decode(file_get_contents("php://input"))->data;

    if(!empty($json)){
      $f = $json->f;
      $result = $f($json);
      // $result = $json;
    }

    function logMeIn($data){
      $res = array();
      $res['err'] = 0;
      $res['errmsg'] = "";

      $uname = $data->u;
      $pword = generatePassword($data->p);

      // user login
      $users = new abaUserModel;
      $res['login'] = $users->logMeIn($uname);
      
      if(count($res['login']['rows']) == 0){
        $res['err'] = 1;
        $res['errmsg'] = "User not found! Please contact IT administrator.";
        goto exitme;
      }

      $row = $res['login']['rows'][0];
      $password = $row['password'];
      
      $res['password'] = $password;
      $res['pword'] = $pword;

      if($password != $pword){
        $res['err'] = 1;
        $res['errmsg'] = "Access denied! Please enter the correct password.";
        goto exitme;
      }

      $userid = $res['login']['rows'][0]['userid'];

      // save activity
      $actdata['type'] = "login";
      $actdata['details'] = 'Logged In';
      $actdata['assignedto'] = $userid;
      $actdata['abauser'] = $userid;
      $actdata['userid'] = $userid;
      $actdata['acctid'] = "";

      $acts = new ActivitiesModel;
      $acts->saveActivity($actdata);

      exitme:
      $users->closeDB();
      return $res;
    }

    function changePassword($data){
      $res = array();
      $res['err'] = 0;
      $res['errmsg'] = "";
      $abaini = $data->abaini;
      $oldpw = generatePassword($data->opw);

      // user login
      $users = new abaUserModel;
      $res['login'] = $users->logMeIn($abaini);
      
      if(count($res['login']['rows']) == 0){
        $res['err'] = 1;
        $res['errmsg'] = $abaini . " user not found! Please contact IT administrator.";
        goto exitme;
      }

      $row = $res['login']['rows'][0];
      $userid = $res['login']['rows'][0]['userid'];
      $password = $row['password'];
      
      $res['password'] = $password;
      $res['pword'] = $oldpw;

      if($password != $oldpw){
        $res['err'] = 1;
        $res['errmsg'] = "Old/current password is incorrect! Please enter the correct current password.";
        goto exitme;
      }

      $val['abaini'] = $abaini;
      $val['password'] = generatePassword($data->npw);
      $res['abauser'] = $users->changePassword($val);

      exitme:
      $users->closeDB();
      return $res;
    }

    function forgotPassword($data){
      $res = array();
      $res['err'] = 0;
      $res['errmsg'] = "";
      $abaini = $data->u;

      // user login
      $users = new abaUserModel;
      $res['login'] = $users->logMeIn($abaini);
      
      if(count($res['login']['rows']) == 0){
        $res['err'] = 1;
        $res['errmsg'] = $abaini . " user not found! Please contact IT administrator.";
        goto exitme;
      }

      $row = $res['login']['rows'][0];

      $val['abaini'] = $abaini;
      $val['pw'] = generateRandomString(4);
      $val['password'] = generatePassword($val['pw']);
      $res['abauser'] = $users->changePassword($val);
      $res['epw'] = $users->emailPassword($val);

      exitme:
      $users->closeDB();
      return $res;
    }

    function userLoggedActivity(){
      $res = array();
      $res['err'] = 0;

      $users = new abaUserModel;
      $res['userlogged'] = $users->userLoggedActivity();

      return $res;
    }

    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Expires: 0");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    echo json_encode($result);
?>