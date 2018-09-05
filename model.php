<?php //Model: properties (data) and methods (data manipulation rules)
class email_details{
	public function __construct(){
		$this->form_name = '';
		$this->to = '';
		$this->from = '';
		$this->duplicate = '';
		$this->subject = '';
		$this->heading = '';
		$this->body = '';
		$this->footer = '';
		$this->form = '';
		$this->optional = '';
		$this->post = '';
		$this->error = '';
		$this->success = '';
	} 
}
class email_details_template extends email_details{
	//updated to include email templating
	public function __construct(){
		$this->template = '';
	} 
}
class email_details_template_tracked extends email_details_template{
	//updated to include email tracking through Google Analytics
	public function __construct(){
		$this->GA_account = ''; //Google Analytics account ID
		$this->GA_campaign = ''; //Google Analytics campaign name
	} 
}
?>