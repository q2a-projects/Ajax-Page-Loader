<?php

//	Output this header as early as possible
	header('Content-Type: text/plain; charset=utf-8');


//	Ensure no PHP errors are shown in the Ajax response
	//error_reporting(0);
	//@ini_set('display_errors', 0);


//	Load the Q2A base file which sets up a bunch of crucial functions
	require_once './../../qa-include/qa-base.php';
	qa_report_process_stage('init_ajax');		

//	Get general Ajax parameters from the POST payload, and clear $_GET
	qa_set_request(qa_post_text('qa_request'), qa_post_text('qa_root'));

	require_once QA_INCLUDE_DIR.'qa-db-selects.php';
	require_once QA_INCLUDE_DIR.'qa-app-users.php';
	require_once QA_INCLUDE_DIR.'qa-app-cookies.php';
	require_once QA_INCLUDE_DIR.'qa-app-votes.php';
	require_once QA_INCLUDE_DIR.'qa-app-format.php';
	require_once QA_INCLUDE_DIR.'qa-app-options.php';

	require_once 'ajax-pages.php';


	
	if(isset($_REQUEST['url'])){
		$action = $_REQUEST['url'];
	}else
		die();
	
	$requestlower = strtolower($action);
	//$parts = explode("/", $requestlower);

	qa_page_queue_pending();
	
	qa_set_request($requestlower, qa_post_text('qa_root'));
	$qa_content = qa_get_request_content();
	
		global $qa_template;
		var_dump($qa_template);
		$tmpl = substr($qa_template, 0, 7) == 'custom-' ? 'custom' : $qa_template;
		$themeclass = qa_load_theme_class(qa_get_site_theme(), $tmpl, $qa_content, qa_request());
		$themeclass->initialize();


		$themeclass->head_title();
		$themeclass->head_metas();
		$themeclass->head_css();
		$themeclass->head_links();
		$themeclass->head_lines();
		$themeclass->head_script();
		$themeclass->head_custom();
	
	// finish
	qa_db_disconnect();
	die();
	
/*
	Omit PHP closing tag to help avoid accidental output
*/