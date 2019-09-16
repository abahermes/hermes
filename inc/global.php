<?php
	include_once('config.php');
	$today = date("Y-m-d h:i:s");

	// FILES LOCATIONS
	define("ADMIN", base_URL . "admin/");
	define("CSS", base_URL . "css/");
	define("JS", base_URL . "js/");
	define("IMAGES", base_URL . "images/");
	define("FAVICO", IMAGES . "favicon.png");
	define("VIEWS", 'views/');
	define("CONTROLLERS", 'controllers/');
	define("API", 'api/');

	// PAGE LOCATIONS
	// CDM
	define("DASHBOARDCDM", base_URL . "dashboardcdm.php");
	define("LEADS", base_URL . "leads.php");
	define("CLIENTSPROSPECTS", base_URL . "clientsprospects.php");
	define("TASKS", base_URL . "tasks.php");
	define("TASKSDONE", base_URL . "tasksdone.php");
	define("OPPORTUNITIES", base_URL . "opportunities.php");
	define("OPPSSPIL", base_URL . "oppsspil.php");

	// HRIS
	define("EES", base_URL . "ees.php");
	define("DASHBOARDHRIS", base_URL . "dashboardhris.php");

	// abacare TABLES
	define("ABAUSER","aba_abvt_users");
	define("ABAPEOPLESMST","aba_people");
	define("DESIGNATIONSMST", "aba_designations");
	define("DROPDOWNSMST", "aba_dropdown");
	define("ETHNICITYMST", "aba_ethnicities");
	define("FXRATESMST", "aba_fxrates");
	define("NATIONALITYMST", "aba_nationalities");
	define("SALESOFFICESMST", "aba_sales_offices");
	
	// CDM TABLES
	define("CDMACCOUNTS", "aba_cdm_accounts");
	define("CDMACTIVITIES", "aba_cdm_activities");
	define("CDMCONTACTS", "aba_cdm_contacts");
	define("CDMGALINFOS", "aba_cdm_generalinfos");
	define("CDMLEADS", "aba_cdm_leads");
	define("CDMLEADDUPS", "aba_cdm_lead_duplicates");
	define("CDMNOTES", "aba_cdm_notes");
	define("CDMOPPS", "aba_cdm_opportunities");
	define("CDMTASKS", "aba_cdm_tasks");

	// SUPPLIERS TABLES
	define("SUPPLIERS", "aba_suppliers");

	//TO DO LIST TABLES
	define("TODOLISTS","aba_cdm_tdl");
	define("TODOLISTSATRAIL","aba_cdm_tdl_atrail");
	define("USEFULINKS","aba_cdm_usefullinks");

	// TEXT DESCRIPTIONS
	define("TITLE", "abacare Group Limited | ee Portal");
	define("TODAY", $today);

	$isLogged = 0;
	$abaUser = "";
	$accsslvl = 3;
	
	$abaini = 'reca';
	$abaemail = 'rey.castanares@abacare.com';
	$userid = 'A161215-00089';
?>