<?php
    // include database and object files
    require_once('../inc/global.php');
    require_once('models/database.php');
    require_once('../inc/functions.php');
    require_once('models/dropdowns_model.php');
    require_once('models/leads_model.php');
    require_once('models/accounts_model.php');
    require_once('models/employees_model.php');
    require_once('models/salesoffices_model.php');

    $result = array();
    $json = json_decode(file_get_contents("php://input"))->data;

    if(!empty($json)){
      $f = $json->f;
      $result = $f($json);
      // $result = $json;
    }

    function loadDefault($data){
      $res = array();
      $userid = $data->userid;
      $salesofcdesc = $data->salesofc;

      // get leads
      $leads = new LeadsModel;
      $res['leads'] = $leads->getLeads($userid);
      $res['dupleads'] = $leads->getLeadDuplicates($userid);
      $res['cnt'] = $leads->getCountLeads($userid);
      $leads->closeDB();

      // get employees
      $ees = new EmployeesModel;
      $res['ees'] = $ees->getActiveabaPeople();
      $ees->closeDB();

      // get nationalities
      $dd = new DropdownsModel;
      $res['nats'] = $dd->getNationalitiesList();
      $res['eths'] = $dd->getEthnicitiesList();
      $res['titles'] = $dd->getCltProstTitles();
      $res['affs'] = $dd->getAffinities();
      $dd->closeDB();

      $salesofc = new SalesOfficesModel;
      $res['salesofc'] = $salesofc->getSalesOfficesOnly();
      $res['salesofcid']= $salesofc->getSalesOfficeByDesc($salesofcdesc);
      $salesofc->closeDB();

      return $res;
    }

    function getLead($data){
      $res = array();
      $leadid = $data->leadid;

      // get leads
      $leads = new LeadsModel;
      $res['lead'] = $leads->getLead($leadid);
      $leads->closeDB();

      // get accounts
      $accts = new AccountsModel;
      $res['accts'] = $accts->getLeadAccounts($leadid);

      return $res;
    }

    function saveLeads($data){
      $res = array();
      // $res['leads'] = $data;
      $rows = $data->rows;
      $cnt = count($res['rows']);

      // get clients n prospects
      $cltsprosts = new LeadsModel;
      $res['leads'] = $cltsprosts->getLeads($userid);

      return $res;
    }

    function searchLeads($data){
      $res = array();
      $val=array();
      $searchby = $data->searchby;
      $val['$searchtext'] = $data->searchtext;
      $val['searchby'] = $searchby;
      $val['userid'] = $data->userid;

      $searchlead = new LeadsModel;
      $res['searchedleads'] = $searchlead->searchLeads($val);

      return $res;
    }

    function sortLeads($data){
      $res = array();
      $val = array();
      $val['sortby'] = $data->sortby;
      $val['userid'] = $data->userid;
      $val['sortin']=$data->sortin;

      //GET TASK results
      $leads = new LeadsModel;
      $res['leads'] = $leads->getSortedLeads($val);

      // $tasks->DBClose();
      return $res;
    }

    function syncLeads($data){
      // $res = array();
      // $res['err'] = 0;
      // $ctcs = mysqli_escape_string($data);
      // $res['eaddr'] = $data->eaddr[0];
      // $cnt = 0;
      // $userid = $data->userid;
      // $leads = new LeadsModel;
      // $cnt = $leads->getTotalLeads($userid);
      // $cnt = ($cnt + 1);

      // $cntdata = count($ctcs);
      // for($i=0;$i<$cntdata;$i++){
        // $res['eaddr'][] = mysqli_escape_string($ctcs[$i]->eaddr[0]->address);
      //   $val = array();
      //   $val['firstname'] = $ctcs[$i]->firstname;
      //   $val['lastname'] = $ctcs[$i]->lastname;
      //   $val['middlename'] = $ctcs[$i]->middlename;
      //   $val['chinesename'] = $ctcs[$i]->chinesename;
      //   $val['birthdate'] = $ctcs[$i]->birthdate;
      //   $val['initials'] = $ctcs[$i]->initials;
      //   $val['companyname'] = $ctcs[$i]->companyname;
      //   $val['jobtitle'] = $ctcs[$i]->jobtitle;
      //   $val['manager'] = $ctcs[$i]->manager;
      //   $val['mobilephoneno'] = $ctcs[$i]->mobilephone;
      //   $val['userid'] = $userid;
      //   $val['cnt'] = $cnt;

      //   // $res['eaddr'][] = $ctcs[$i]->emailaddress->address . '<br />';

      //   // $res['res'][] = $leads->syncLead($val);
      //   // echo $res . '<br />';
      //   $cnt++;
      // }
      // // $leads->closeDB();

      return $data;
    }

    function deleteLead($data){
      $res = array();
      $userid = $data->userid;
      $val['userid'] = $userid;
      $val['leadid'] = $data->leadid;

      $leads = new LeadsModel;
      $res['lead'] = $leads->deleteLead($val);
      $res['leads'] = $leads->getLeads($userid);

      return $res;
    }

    function deleteLeads($data){
      $res = array();
      $userid = $data->userid;
      $val['userid'] = $userid;
      $val['leadids'] = $data->leadids;

      $leads = new LeadsModel;
      $res['lead'] = $leads->deleteLeads($val);
      $res['leads'] = $leads->getLeads($userid);

      return $res;
    }

    function saveDuplicateLead($data){
      $res = array();
      $userid = $data->userid;
      $leadid = $data->leadid;
      $cnt = 0;

      // get leads
      $leads = new LeadsModel;
      $cnt = $leads->getTotalLeads($userid);
      $val['duplead'] = $leads->getDuplicateLead($leadid)['rows'][0];
      $val['duplead']['cnt'] = ($cnt + 1);
      $val['duplead']['userid'] = $userid;
      $val['duplead']['leadid'] = $leadid;
      $res['lead'] = $leads->saveDuplicateLead($val['duplead']);
      $res['leads'] = $leads->getLeads($userid);
      $res['dupleads'] = $leads->getLeadDuplicates($userid);
      $res['cnt'] = $leads->getCountLeads($userid);
      $leads->closeDB();

      return $res;
    }

    function deleteDuplicateLead($data){
      $res = array();
      $userid = $data->userid;
      $leadid = $data->leadid;
      $cnt = 0;

      // get leads
      $leads = new LeadsModel;
      $res['lead'] = $leads->deleteDuplicateLead($leadid);
      $res['dupleads'] = $leads->getLeadDuplicates($userid);
      $leads->closeDB();

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