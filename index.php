<?php //View
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/London');//optional - may already be set

//index->controller->model->view->index
require_once 'model.php';
require_once 'controller.php';
require_once 'view.php';
$model = new email_details_template_tracked();
	//build set parameters for the form
	$model->form_name = "aform"; //form div id
	$model->to = "scooper+to@caw.ac.uk";
	$model->from = (isset($_POST['_email']) ? $_POST['_email'] : '');
	$model->duplicate = (isset($_POST['_email']) ? $_POST['_email'] : ''); //optional receipt email
	$model->subject = "subject";
	$model->heading = "<h1>heading</h1>";
	$model->body = '<p>body text.</p>';
	$model->body .= '<p>more body text.</p>';
	$model->body .= '<p><a href="www.example.com{tracking}">even more body text</a>.</p>';
	$model->footer = '<p><a href="">footer</a> <a href="">footer</a> <a href="">footer</a></p>';
	$model->GA_account = "12345678-0"; //optional Google Analytics tracking for email opens
	$model->GA_campaign = "my-campaign-name"; //optional Google Analytics tracking for email opens and link clicks
	$model->template = "template.html"; //optional template url
	$model->form = array(
		//accepted field types; text, email, tel, url, number, text area, radio, select, submit
		//use plcaeholder to list field options separated by commas (no spaces)
		//set optional to false to create mandatory fields
		'0' => array(
			'type' => 'text',
			'name' => '_fname',
			'label' => 'First Name:',
			'placeholder' => 'First Name',
			'optional' => false,
			'class' => '',
			'style' => '',
		),
		'1' => array(
			'type' => 'text',
			'name' => '_lname',
			'label' => 'Last name:',
			'placeholder' => 'Last name',
			'optional' => false,
			'class' => '',
			'style' => '',
		),
		'2' => array(
			'type' => 'email',
			'name' => '_email',
			'label' => 'Email:',
			'placeholder' => 'Email',
			'optional' => false,
			'class' => '',
			'style' => '',
		),
		'3' => array(
			'type' => 'tel',
			'name' => '_phone',
			'label' => 'Phone:',
			'placeholder' => 'Phone',
			'optional' => true,
			'class' => '',
			'style' => '',
		),
		'4' => array(
			'type' => 'tel',
			'name' => '_fax',
			'label' => 'Fax:',
			'placeholder' => 'Fax',
			'optional' => true,
			'class' => '',
			'style' => '',
		),
		'5' => array(
			'type' => 'number',
			'name' => '_number',
			'label' => 'A number:',
			'placeholder' => 'A number',
			'optional' => true,
			'class' => '',
			'style' => '',
		),
		'6' => array(
			'type' => 'textarea',
			'name' => '_message',
			'label' => 'Message:',
			'placeholder' => 'Message',
			'optional' => false,
			'class' => 'message',
			'style' => 'height:5em; width:300px;',
		),
		'7' => array(
			'type' => 'radio',
			'name' => '_radio',
			'label' => 'Radio:',
			'placeholder' => 'one,two,three',
			'optional' => false,
			'class' => '',
			'style' => '',
		),
		'8' => array(
			'type' => 'checkbox',
			'name' => '_checkbox',
			'label' => 'Checkbox:',
			'placeholder' => 'one,two,three,four',
			'optional' => false,
			'class' => '',
			'style' => '',
		),
		'9' => array(
			'type' => 'select',
			'name' => '_select',
			'label' => 'Select:',
			'placeholder' => 'one,two,three,four',
			'optional' => false,
			'class' => '',
			'style' => '',
		),
		'10' => array(
			'type' => 'submit',
			'name' => 'submit',
			'label' => '',
			'placeholder' => 'Send',
			'optional' => false,
			'class' => '',
			'style' => '',
		),
	);
	//$model->optional = ''; //set in controller
	//$model->post = ''; //set in controller
	//$model->error = ''; //set in controller
	$model->success = 'Thank you. Your message has been sent'; //message for successful form post
$controller = new controller($model);
$view = new view($controller);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Email</title>
<link href="styles.css<?php echo '?refresh=' . date('YmdHis'); //auto refresh styles ?>" rel="stylesheet" type="text/css">
</head>
<body>
	<?php $view->output(); ?>
	<?php $view->dev_report(); //display object for error reporting ?>
</body>
</html>