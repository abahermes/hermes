<?php
    // include database and object files
    require_once('../inc/global.php');
    require_once('models/database.php');
    require_once('../inc/functions.php');
    require_once('models/dropdowns_model.php');
    require_once('models/activities_model.php');
    require_once('models/contacts_model.php');
    require_once('models/accounts_model.php');
    require_once('models/tasks_model.php');
    require_once('models/opportunities_model.php');
    require_once('models/suppliers_model.php');
    require_once('models/employees_model.php');
    require_once('models/fxrates_model.php');
    require_once('models/salesoffices_model.php');
    require_once('models/notes_model.php');
    require_once('models/leads_model.php');

    $result = array();
    $json = json_decode(file_get_contents("php://input"))->data;

    if(!empty($json)){
      $f = $json->f;
      $result = $f($json);
      // $result = $json;
    }

    function loadDefault($data){
      $res = array();
	  $userid = "";
//	  $salesofcdesc = $data->salesofc;
      // get employees
      $ees = new EmployeesModel;
      $res['ees'] = $ees->getActiveabaPeople();

      // get nationalities
      $dd = new DropdownsModel;
      $res['nats'] = $dd->getNationalitiesList();
      $res['eths'] = $dd->getEthnicitiesList();
      $res['titles'] = $dd->getCltProstTitles($userid);

      //sales office
      $salesofc = new SalesOfficesModel;
      $res['salesofc'] = $salesofc->getSalesOfficesOnly();
//	  $res['salesofcid']= $salesofc->getSalesOfficeByDesc($salesofcdesc);

      $dd->closeDB();

      return $res;
    }

    function loadCltProstDataInfo($data){
      $res = array();
      $id = $data->id;
      $abaini = $data->abaini;
      $salesofcdesc = $data->salesofc;

      // get account by sesid
      $accts = new AccountsModel;
      $res['acct'] = $accts->getAccount($id);
      $acctexist = count($res['acct']['rows']);
      // $accts->CloseDB();

      $dd = new DropdownsModel;
      $res['nats'] = $dd->getNationalitiesList();
      $res['eths'] = $dd->getEthnicitiesList();
      $res['titles'] = $dd->getCltProstTitles();
      $res['cdmtasktypes'] = $dd->getCDMTaskTypes();
      $res['cdmresultexpected'] = $dd->getCDMresultexpected();
      $res['cdmaffinity']=$dd->getAffinities();
      $res['cdmbsl']=$dd->getProductTypes();
		
      //sales office
      $salesofc = new SalesOfficesModel;
      $res['salesofc'] = $salesofc->getSalesOfficesOnly();
      $res['salesofcid']= $salesofc->getSalesOfficeByDesc($salesofcdesc);

      if($acctexist > 0){
        $ctcid = $res['acct']['rows'][0]['ctcid'];
        $acctid = $res['acct']['rows'][0]['acctid'];
        // get contact by ctcid
        $ctcs = new ContactsModel;
        $res['ctc'] = $ctcs->getContact($ctcid);
        // get contact by ctcid
        $tasks = new TasksModel;
        $res['task'] = $tasks->getPendingTasks($acctid);

        // get activities by acctid
        $acts = new ActivitiesModel;
        $res['act'] = $acts->getActivities($acctid);

        // get opps
        $opps = new OpportunitiesModel;
        $res['opps'] = $opps->getPendingOpps($acctid);
        $res['signedopps'] = $opps->getSignedOpps($acctid);

        // get suppliers
        $sups = new SuppliersModel;
        $res['sup'] = $sups->getSuppliers();
        $res['dttoday'] = formatDate("D d M y",TODAY);

        // get employees
        $ees = new EmployeesModel;
        $res['ees'] = $ees->getActiveabaPeople();

        // get addtl gal info
        $res['galinfos'] = $accts->getAddtlGalInfo($acctid);

        $notes = new NotesModel;
        $res['notes'] = $notes->getNotes($acctid);
      }
      // closing DB
      $accts->closeDB();

      return $res;
    }

    function saveCltProst($data){
      $res = array();
      $val = array();
      $valCtc = array();
      $abauser = $data->abauser;
      $firstname = $data->firstname;
      $lastname = $data->lastname;
      $middlename = $data->middlename;
      $assignedto = $data->assignedto;
      $userid = $data->userid;
      $company = strtoupper($data->companyname);

      // contact
      $valCtc['uid'] = $data->uid;
      $valCtc['etag'] = $data->etag;
      $valCtc['leadid'] = $data->leadid;
      $valCtc['title'] = $data->title;
      $valCtc['firstname'] = $firstname;
      $valCtc['lastname'] = strtoupper($lastname);
      $valCtc['middlename'] = $middlename;
      $valCtc['chinesename'] = $data->chinesename;
      $valCtc['birthdate'] = $data->birthdate;
      $valCtc['gender'] = $data->gender;
      $valCtc['company'] = strtoupper($data->companyname);
      $valCtc['jobtitle'] = $data->jobtitle;
      $valCtc['eaddr'] = $data->eaddr;
      $valCtc['website'] = $data->website;
      $valCtc['homphno'] = $data->homphno;
      $valCtc['mobphno'] = $data->mobphno;
      $valCtc['addr'] = $data->addr;
      $valCtc['nationality'] = $data->nationality;
      $valCtc['ethnicity'] = $data->ethnicity;
      $valCtc['assignedto'] = $assignedto;
      $valCtc['userid'] = $userid;
      $valCtc['ini'] = $data->ini;

      $valCtc['abauser'] = $abauser;

      // $leads = new LeadsModel;
      // $valCtc['leadid'] = $leads->saveLeadFromNewCltProst($valCtc);

      $ctcs = new ContactsModel;
      $res['ctc'] = $ctcs->saveContact($valCtc);
      // $ctcs->closeDB();
      $ctcid = $res['ctc']['ctcid'];

      // account
      if($ctcid != ""){
        // clt prost addtl info
        $valAcct['ctcid'] = $ctcid;
        $valAcct['businesstype'] = $data->businesstype;
        $valAcct['affinity'] = $data->affinity;
        $valAcct['recomby'] = $data->recomby;
        $valAcct['recomname'] = $data->recomname;
        $valAcct['abainiofc'] = $data->abainiofc;
        $valAcct['introducer'] = $data->introducer;
        $valAcct['shared'] = $data->shared;
		    $valAcct['salesofc'] = $data->salesofc;
        $valAcct['userid'] = $userid;

        // fum
        $valAcct['fumlink'] = $data->fumlink;
        $valAcct['galinfo1'] = $data->galinfo1;
        $valAcct['galinfo2'] = $data->galinfo2;
        $valAcct['galinfo3'] = $data->galinfo3;
        $valAcct['galinfo4'] = $data->galinfo4;
        $valAcct['galinfo5'] = $data->galinfo5;

        $valAcct['assignedto'] = $assignedto;
        $valAcct['abauser'] = $abauser;
        $valAcct['firstname'] = $firstname;
        $valAcct['lastname'] = $lastname;
        $valAcct['middlename'] = $middlename;
        $valAcct['company'] = $company;

        $accts = new AccountsModel;
        $res['acct'] = $accts->saveAccount($valAcct);
        $cnt = 1;

        $galinfos = $data->galinfos;
        $res['galinfos'] = $galinfos;
        $res['galinfoscnt'] = count($galinfos);

        if(count($galinfos) > 0){
          $res['gal'] = array();
          foreach($galinfos as $val){
            $gal['acctid'] = $res['acct']['acctid'];
            $gal['cnt'] = $cnt;
            $gal['userid'] = $userid;
            $gal['question'] = $val->question;
            $gal['answer'] = $val->answer;
            $accts->saveAddtlGalInfo($gal);
            $cnt++;
            $res['gal'][] = $gal;
          }
        }

        // closing DB
        // $accts->closeDB();
      }
      // $res['valctc'] = $valCtc;
      return $res;
    }

    function updateCltProst($data){
      $res = array();
      $val = array();
      $abauser = $data->abauser;
      $firstname = $data->firstname;
      $lastname = $data->lastname;
      $middlename = $data->middlename;
      $assignedto = $data->assignedto;
      $userid = $data->userid;
      $acctid = $data->acctid;
      // contact
      $valCtc['acctid'] = $acctid;
      $valCtc['ctcid'] = $data->ctcid;
      $valCtc['title'] = $data->title;
      $valCtc['firstname'] = $firstname;
      $valCtc['lastname'] = $lastname;
      $valCtc['middlename'] = $middlename;
      $valCtc['chinesename'] = $data->chinesename;
      $valCtc['ini'] = $data->ini;
      $valCtc['birthdate'] = $data->birthdate;
      $valCtc['gender'] = $data->gender;
      $valCtc['company'] = $data->companyname;
      $valCtc['jobtitle'] = $data->jobtitle;
      $valCtc['eaddr'] = $data->eaddr;
      $valCtc['homphno'] = $data->homphno;
      $valCtc['mobphno'] = $data->mobphno;
      $valCtc['addr'] = $data->addr;
      $valCtc['nationality'] = $data->nationality;
      $valCtc['ethnicity'] = $data->ethnicity;
      $valCtc['assignedto'] = $assignedto;
      $valCtc['userid'] = $userid;

      $valCtc['abauser'] = $abauser;

      $ctcs = new ContactsModel;
      $res['ctc'] = $ctcs->updateContact($valCtc);

      // account
      if($valCtc['ctcid'] != ""){
        // clt prost addtl info
        $valAcct['acctid'] = $acctid;
        $valAcct['businesstype'] = $data->businesstype;
        $valAcct['affinity'] = $data->affinity;
        $valAcct['recomby'] = $data->recomby;
        $valAcct['recomname'] = $data->recomname;
        $valAcct['abainiofc'] = $data->abainiofc;
        $valAcct['introducer'] = $data->introducer;
        $valAcct['shared'] = $data->shared;
		$valAcct['salesofc'] = $data->salesofc;
        $valAcct['userid'] = $userid;

        // fum
        $valAcct['fumlink'] = $data->fumlink;
        $valAcct['galinfo1'] = $data->galinfo1;
        $valAcct['galinfo2'] = $data->galinfo2;
        $valAcct['galinfo3'] = $data->galinfo3;
        $valAcct['galinfo4'] = $data->galinfo4;
        $valAcct['galinfo5'] = $data->galinfo5;

        $valAcct['assignedto'] = $assignedto;
        $valAcct['abauser'] = $abauser;
        $valAcct['firstname'] = $firstname;
        $valAcct['lastname'] = $lastname;
        $valAcct['middlename'] = $middlename;

        $accts = new AccountsModel;
        $res['acct'] = $accts->updateAccount($valAcct);

         $cnt = 1;
        foreach($data->galinfos as $val){
          $gal['acctid'] = $acctid;
          $gal['cnt'] = $cnt;
          $gal['userid'] = $userid;
          // $gal['galinfos'][] = array("question"=>$val->question,
          //                     "answer"=>$val->answer);
          $gal['question'] = $val->question;
          $gal['answer'] = $val->answer;

          $accts->saveAddtlGalInfo($gal);
          $cnt++;
        }
      }

      // closing DB
      $accts->closeDB();

      return $res;
    }

    function saveTask($data){
      $res = array();
      $val = array();
      $acctid = $data->acctid;
      $tasktype = $data->tasktype;

      $val['sesid'] = $data->sesid;
      $val['abaini'] = $data->abaini;
      $val['assignedto'] = $data->assignedto;
      $val['acctid'] = $acctid;
      $val['cltprost'] = $data->cltprost;
      $val['endtime'] = $data->endtime;
      $val['id'] = $data->id;
      $val['noofmtg'] = $data->noofmtg;
      $val['otppl'] = $data->otppl;
      $val['resultexpected'] = $data->resultexpected;
      $val['specificresult'] = $data->specificresult;
      $val['starttime'] = $data->starttime;
      $val['taskdate'] = $data->taskdate;
      $val['taskremarks'] = $data->taskremarks;
      $val['tasktype'] = $tasktype;
      $val['userid'] = $data->userid;

      $dd = new DropdownsModel;
      $val['tasktypedesc'] = $dd->getCDMTaskTypes($tasktype)[0]['dddescription'];

      $tasks = new TasksModel;
      $res['task'] = $tasks->saveTask($val);
      $res['tasks'] = $tasks->getPendingTasks($acctid);

      // get activities by acctid
      $acts = new ActivitiesModel;
      $res['acts'] = $acts->getActivities($acctid);

      // closing DB
      $acts->closeDB();

      return $res;
    }

    function updateTask($data){
      $res = array();
      $val = array();
      $acctid = $data->acctid;
      $tasktype = $data->tasktype;
      $userid = $data->userid;

      $val['sesid'] = $data->id;
      $val['userid'] = $userid;
      $val['taskid'] = $data->taskid;
      $val['abaini'] = $data->abaini;
      $val['assignedto'] = $data->assignedto;
      $val['acctid'] = $acctid;
      $val['cltprost'] = $data->cltprost;
      $val['endtime'] = $data->endtime;
      $val['id'] = $data->id;
      $val['noofmtg'] = $data->noofmtg;
      $val['otppl'] = $data->otppl;
      $val['resultexpected'] = $data->resultexpected;
      $val['specificresult'] = $data->specificresult;
      $val['starttime'] = $data->starttime;
      $val['taskdate'] = $data->taskdate;
      $val['taskremarks'] = $data->taskremarks;
      $val['tasktype'] = $tasktype;
      $val['resultachieve'] = $data->resultachieve;

      $dd = new DropdownsModel;
      $val['tasktypedesc'] = $dd->getCDMTaskTypes($tasktype)[0]['dddescription'];

      $tasks = new TasksModel;
      $res['task'] = $tasks->updateTask($val);
      $res['tasks'] = $tasks->getPendingTasks($acctid);

      // get activities by acctid
      $acts = new ActivitiesModel;
      $res['acts'] = $acts->getActivities($acctid);
      
      // closing DB
      $acts->closeDB();

      return $res;
    }

    function getTask($data){
      $res = array();
      $val = array();
      $taskid = $data->taskid;

      // get contact by ctcid
      $tasks = new TasksModel;
      $res['task'] = $tasks->getTask($taskid);

      // closing DB
      $tasks->closeDB();

      return $res;
    }

    function saveOpportunity($data){
      $res = array();
      $val = array();
      $acctid = $data->acctid;
      $userid = $data->userid;
      $status = $data->status;

      $val['sesid'] = $data->sesid;
      $val['userid'] = $userid;
      $val['abaini'] = $data->abaini;
      $val['assignedto'] = $data->assignedto;
      $val['acctid'] = $acctid;
      $val['accttype'] = $data->accttype;
      $val['prodtype'] = $data->prodtype;
      $val['srwtargetdt'] = $data->srwtargetdt;
      $val['ccy'] = $data->ccy;
      $val['premium'] = str_replace(",","",$data->premium);
      $val['comrate'] = $data->comrate;
      $val['potential'] = $data->potential;
      $val['status'] = $status;
      $val['supplier'] = $data->supplier;
      $val['remarks'] = $data->remarks;
      $val['cltprost'] = $data->cltprost;
      $val['premhkd'] = str_replace(",","",$data->premhkd);
      $val['abarevhkd'] = str_replace(",","",$data->abarevhkd);
      $val['prodtypedesc'] = $data->prodtypedesc;
      $val['polissueddate'] = $data->polissueddate;
      $val['polnumber'] = $data->polnumber;
      $val['signeddate']=$data->signeddate;
      $val['lostdate']=formatDate("Y-m-d",$data->lostdate);
	  $val['shared'] = $data->shared;

      $opps = new OpportunitiesModel;
      $res['opp'] = $opps->saveOpps($val);
      $res['opps'] = $opps->getPendingOpps($acctid);
      $res['signedopps'] = $opps->getSignedOpps($acctid);

      // get activities by acctid
      $acts = new ActivitiesModel;
      $res['acts'] = $acts->getActivities($acctid);

       if($status == 's' || $status == 'sp'){
        $cltstatus = array();
        $cltstatus['status'] = 1;
        $cltstatus['acctid'] = $acctid;
        $cltstatus['userid'] = $userid;
        $accts = new AccountsModel;
        $res['accts'] = $accts->updateAccountStatus($cltstatus);
      }

      // closing DB
      $acts->closeDB();

      return $res;
    }

    function saveComments($data){
      $res = array();
      $val = array();
      $acctid = $data->acctid;
      $userid = $data->userid;

      $val['sesid'] = $data->sesid;
      $val['userid'] = $userid;
      $val['abaini'] = $data->abaini;
      $val['assignedto'] = $data->assignedto;
      $val['acctid'] = $acctid;
      $val['cltprost'] = $data->cltprost;
      $val['comments'] = $data->comments;

      $tasks = new TasksModel;
      $res['cmts'] = $tasks->saveComments($val);
      
      // get activities by acctid
      $acts = new ActivitiesModel;
      $res['acts'] = $acts->getActivities($acctid);

      // closing DB
      $acts->closeDB();

      return $res;
    }

    function getOpps($data){
      $res = array();
      $val = array();
      $oppsid = $data->oppsid;

      // get opps by oppsid
      $opps = new OpportunitiesModel;
      $res['opps'] = $opps->getOpps($oppsid);

      // closing DB
      $opps->closeDB();

      return $res;
    }

    function updateOpps($data){
      $res = array();
      $val = array();
      $acctid = $data->acctid;
      $oppsid = $data->oppsid;
      $userid = $data->userid;
      $status = $data->status;
      
      $val['oppsid'] = $oppsid;
      $val['userid'] = $userid;
      $val['sesid'] = $data->sesid;
      $val['abaini'] = $data->abaini;
      $val['assignedto'] = $data->assignedto;
      $val['acctid'] = $acctid;
      $val['accttype'] = $data->accttype;
      $val['prodtype'] = $data->prodtype;
      $val['srwtargetdt'] = formatDate("Y-m-d",$data->srwtargetdt);
      $val['ccy'] = $data->ccy;
      $val['premium'] = str_replace(",","",$data->premium);
      $val['comrate'] = $data->comrate;
      $val['potential'] = $data->potential;
      $val['status'] = $status;
      $val['supplier'] = $data->supplier;
      $val['remarks'] = $data->remarks;
      $val['cltprost'] = $data->cltprost;
      $val['prodtypedesc'] = $data->prodtypedesc;
      $val['premhkd'] = str_replace(",","",$data->premhkd);
      $val['abarevhkd'] = str_replace(",","",$data->abarevhkd);
      $val['polissueddt'] = formatDate("Y-m-d",$data->polissueddt);
      $val['polnumber'] = $data->polnumber;
      $val['signeddate']=formatDate("Y-m-d",$data->signeddate);
      $val['lostdate']=formatDate("Y-m-d",$data->lostdate);
      $val['shared'] = $data->shared;
      
      $opps = new OpportunitiesModel;
      $res = $opps->updateOpps($val);
      $res['opps'] = $opps->getPendingOpps($acctid);
      $res['signedopps'] = $opps->getSignedOpps($acctid);
      $res['val'] = $val;

      // get activities by acctid
      $acts = new ActivitiesModel;
      $res['acts'] = $acts->getActivities($acctid);

      if($status == 's' || $status == 'sp'){
        $cltstatus = array();
        $cltstatus['status'] = 1;
        $cltstatus['acctid'] = $acctid;
        $cltstatus['userid'] = $userid;
        $accts = new AccountsModel;
        $res['accts'] = $accts->updateAccountStatus($cltstatus);
      }

      // closing DB
      $acts->closeDB();

      return $res;
    }

    function computePremiumHKD($data){
      $res = array();
      $val['ccy'] = $data->ccy == "" ? 'HKD' : $data->ccy;
      $val['period'] = $data->targetdate == "" ? '' : formatDate("Ym",$data->targetdate);

      $fxrates = new FXRatesModel;
      $res['fxrates'] = $fxrates->computePremiumHKD($val)['rows'][0];

      return $res;
    }

    function saveNotes($data){
      $res = array();

      $val = array();
      $acctid = $data->acctid;
      $userid = $data->userid;

      $val['userid'] = $userid;
      $val['acctid'] = $acctid;
      $val['cltprost'] = $data->cltprost;
      $val['notes'] = $data->notes;

      $notes = new NotesModel;
      $res['note'] = $notes->saveNotes($val);
      $res['notes'] = $notes->getNotes($acctid);
      $notes->closeDB();

      // get activities by acctid
      $acts = new ActivitiesModel;
      $res['acts'] = $acts->getActivities($acctid);
      $acts->closeDB();

      return $res;
    }

    function updateNotes($data){
      $res = array();

      $val = array();
      $acctid = $data->acctid;
      $userid = $data->userid;

      $val['userid'] = $userid;
      $val['acctid'] = $acctid;
      $val['cltprost'] = $data->cltprost;
      $val['notes'] = $data->notes;

      $notes = new NotesModel;
      $res['note'] = $notes->updateNotes($val);
      $res['notes'] = $notes->getNotes($acctid);
      $notes->closeDB();

      // get activities by acctid
      $acts = new ActivitiesModel;
      $res['acts'] = $acts->getActivities($acctid);
      $acts->closeDB();

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