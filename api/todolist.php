<?php
	// include database and object files
    require_once('../inc/global.php');
    require_once('models/database.php');
    require_once('../inc/functions.php');
    require_once('models/todolist_model.php');
    require_once('models/employees_model.php');
    require_once('models/dropdowns_model.php');
    require_once('models/salesoffices_model.php');
    require_once('models/tdlatrail_model.php');
    require_once('models/usefullinks_model.php');

    $result = array();
    $json = json_decode(file_get_contents("php://input"))->data;

    if(!empty($json)){
      $f = $json->f;
      $result = $f($json);
      // $result = $json;
    }

    function loadDefaults($data){
    	$res =array();
        $val= array();
    	//LOAD TODOLIST
        $userid = $data->userid;
    	$val['userid'] = $userid;
        $val['searchtask']="";

    	$tdl= new TodoListModel;
    	$res['tdl'] = $tdl->getPendingTodoList($val);

    	// GET EES LIST
    	$ees = new EmployeesModel;
    	$res['ees'] = $ees->getActiveabaPeople();

    	//GET CATEGORY
    	$cat = new DropdownsModel;
    	$res['cat'] = $cat->getTDlCategories();

    	//GET STATUS PERCENT
    	$status = new DropdownsModel;
    	$res['status'] = $status->getTDlStatusPercent();

        $usefullinkcats = new DropdownsModel;
        $res['usefullinkcats'] = $usefullinkcats->getUsefulLinkCategories();

        //GET TASK TYPES
        $tasktypes = new DropdownsModel;
        $res['tasktypes'] = $tasktypes->getTDLTaskTypes();

    	//GET USEFULLINKS
        $usefullinks = new UsefulLinkModel;
        $res['usefullinks'] = $usefullinks->getAllUsefulLinks($userid);
    	

    	return $res;
    }

    function saveNewTDl($data){
      $res = array();
	  $val = array();
      $gettask=array();
	  $val['taskType'] = $data->taskType;
	  $val['task'] = $data->task;
	  $val['prio'] = $data->prio;
	  $val['cat'] = $data->cat;
	  $val['fuw'] = $data->fuw;
	  $val['ofc'] = $data->ofc;
	  $val['othppl'] = $data->othppl;
	  $val['psd'] = $data->psd;
	  $val['pfu'] = $data->pfu;
	  $val['startdate'] = $data->startdate;
	  $val['nextctcdate'] = $data->nextctcdate;
	  $val['duedate'] = $data->duedate;
      $val['fumtext'] = $data->fumtext;
	  $val['fumlink'] = $data->fumlink;
	  $val['status'] = $data->status;
	  $val['remarks'] = $data->remarks;
	  $val['abaini'] = $data->abaini;
      $val['userid'] = $data->userid;
      $val['noofrevisions'] = $data->noofrevisions;

      $gettask['userid']=$data->userid;
      $gettask['searchtask']="";

	  $tasks = new TodoListModel;
	  $res['task'] = $tasks->saveTodoList($val);

	  // $tasks = new TodoListModel;
	  $res['tasks'] = $tasks->getPendingTodoList($gettask);
	  $tasks->DBClose();
	  return $res;
    }

    function updateTodoData($data){
    	$res = array();
    	$val = array();
    	$gettask=array();

    	$val['activityid']=$data->taskid;
    	$val['taskType'] = $data->taskType;
		$val['task'] = $data->task;
		$val['prio'] = $data->prio;
		$val['cat'] = $data->cat;
		$val['fuw'] = $data->fuw;
		$val['ofc'] = $data->ofc;
		$val['othppl'] = $data->othppl;
		$val['psd'] = $data->psd;
		$val['pfu'] = $data->pfu;
		$val['startdate'] = $data->startdate;
		$val['nextctcdate'] =$data->nextctcdate;
		$val['duedate'] = $data->duedate;
        $val['fumtext'] = $data->fumtext;
		$val['fumlink'] = $data->fumlink;
		$val['status'] = $data->status;
		$val['remarks'] = $data->remarks;
		$val['abaini'] = $data->abaini;
        $val['userid'] = $data->userid;
        $val['noofrevisions'] = $data->noofrevisions;

        $gettask['userid']=$data->userid;
        $gettask['searchtask']="";

		$tasks = new TodoListModel;
		$res['task'] = $tasks->updateTodoList($val);

		$ttasks = new TodoListModel;
      	$res['ttask'] = $ttasks->getPendingTodoList($gettask);

      	$tasks->DBClose();
		return $res;
    }

    function getTodoData($data){
    	$res = array();
		$taskid = $data->taskid;

		$tasks = new TodoListModel;
		$res['task'] = $tasks->getTodoData($taskid);

		$tasks->DBClose();
		return $res;
    }

    function getOfc($data){
    	$res = array();
    	$abaini=$data->abaini;

    	//GET ABAINI'S OFC
    	$ofcdesignation = new EmployeesModel;
    	$res['ofcdesignation'] = $ofcdesignation->getabaPeopleByIni($abaini);

    	return $res;
    }

    function SearchTask($data){
    	$res = array();
        $val=array();
        $searchby = $data->searchby;
    	$val['searchtask'] = $data->searchtext;
        $val['searchby'] = $searchby;
        $val['userid'] = $data->userid;

    	//GET SEARCH TEXT results
        // if($searchby == 'usefullink'){
        // $usefullinks = new UsefulLinkModel;
        // $res['usefullinks'] = $usefullinks->searchUsefulLink($val);
        // }
        // else {
    	$tasks = new TodoListModel;
    	$res['tasks'] = $tasks->searchTDL($val);
        // }
    	// $tasks->DBClose();
    	return $res;
    }

    function SortingTDL($data){
    	$res = array();
        $val = array();
    	$val['sortby'] = $data->sortby;
        $val['userid'] = $data->userid;
        $val['sortin']=$data->sortin;

    	//GET TASK results
    	$tasks = new TodoListModel;
    	$res['tasks'] = $tasks->getSortedTodoList($val);

    	// $tasks->DBClose();
    	return $res;
    }

    function filterHeaderSearch($data){
        $res = array();
        $val = array();

        $val['userid']=$data->userid;
        $val['headerval']=$data->headerval;

        $search = new TodoListModel;
        $res['search'] = $search->filterHeaderTDL($val);

        return $res;
    }

    function SaveUsefulLink($data){
        $res = array();
        $val = array();

        $val['userid'] = $data->userid;
        $val['cat'] = $data->cat;
        $val['fumtext'] = $data->fumtext;
        $val['fumlink'] = $data->fumlink;

        $usefullink = new UsefulLinkModel;
        $res['usefullink'] = $usefullink->saveUsefulLink($val);

        return $res;
    }

    function getUsefulLink($data){
        $res = array();
        $val = array();

        $val['userid']=$data->userid;
        $val['usefullinkid']=$data->usefullinkid;

        $usefullink = new UsefulLinkModel;
        $res['usefullink'] = $usefullink->getUsefulLinkData($val);

        return $res;
    }

    function updateUsefulLink($data){
        $res = array();
        $val = array();

        $val['ulid'] = $data->ulid;
        $val['userid'] = $data->userid;
        $val['cat'] = $data->cat;
        $val['fumtext'] = $data->fumtext;
        $val['fumlink'] = $data->fumlink;

        $usefullink = new UsefulLinkModel;
        $res['usefullink'] = $usefullink->updateUsefulLink($val);

        return $res;
    }

    function SearchULs($data){
        $res = array();
        $val=array();
        $searchby = $data->searchby;
        $val['searchtask'] = $data->searchtext;
        $val['searchby'] = $searchby;
        $val['userid'] = $data->userid;

        //GET SEARCH TEXT results
        // if($searchby == 'usefullink'){
        $usefullinks = new UsefulLinkModel;
        $res['usefullinks'] = $usefullinks->searchUsefulLink($val);
        // }
        // else {
        // }
        // $tasks->DBClose();
        return $res;
    }
    function BulkUpdate($data){
        $res = array();
        $val=array();
        $val['selecteddata']['selected']=$data->selecteddata;
        $val['fieldname']=$data->fieldname;
        $val['datereplace']=$data->datereplace;

        $selected = new TodoListModel;
        $res['selected'] = $selected->BulkUpdateDates($val);

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