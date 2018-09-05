<?php //Controller: interactions between view and model
class controller{
	public $model;
	public function __construct($model){
		$this->model = $model;
		if(isset($_POST) && !empty($_POST)){
			//get optionals from post
			if(isset($_POST['_optional']) && !empty($_POST['_optional'])){
				$this->model->optional = explode(',',$_POST['_optional']);
			}
			//create post array
			unset($_POST['_optional']);
			$this->model->post = $_POST;
			//form validation
			foreach($this->model->form as $k => $array){
				if($array['type'] != 'submit'){
					$field = $array['name'];
					$type = $array['type'];
					if(in_array($field,$this->model->optional) && empty($_POST[$field])){
						//skip optionals
					}else if( (!is_array($_POST[$field]) && empty($_POST[$field])) || (is_array($_POST[$field]) && !array_filter($_POST[$field])) ){
						//checking empty values and empty arrays
						$this->model->error['post']['empty'][] = $field;
					}else if($type == 'email' && filter_var($_POST[$field], FILTER_VALIDATE_EMAIL) === false){
						$this->model->error['post']['email'][] = $field;
					}else if($type == 'number' && !is_numeric($_POST[$field])){
						$this->model->error['post']['number'][] = $field;
					}else if($type == 'tel' && !preg_match('~^[0-9 +]+$~',$_POST[$field])){
						$this->model->error['post']['tel'][] = $field;
					}
				}
			}
			//model validation
			$model_array = array('to','from','subject','heading','body','footer');
			foreach($model_array as $obj){
				if(!isset($this->model->$obj) || $this->model->$obj == ''){
					$this->model->error['model']['missing data'][] = $obj;
				}
				if(($obj == 'to' || $obj == 'from') && !empty($this->model->$obj) && filter_var($this->model->$obj, FILTER_VALIDATE_EMAIL) === false){
					$this->model->error['model']['invalid email'][] = $obj;
				}
			}
			if(isset($this->model->duplicate) && !empty($this->model->duplicate) && filter_var($this->model->duplicate, FILTER_VALIDATE_EMAIL) === false){
				$this->model->error['model']['invalid email'][] = 'duplicate';
			}
			if(isset($this->model->template) && !empty($this->model->template)){
				if(!file_exists($this->model->template)){
					$this->model->error['model']['invalid or missing'][] = 'template';
				}
			}
			if(!empty($this->model->error['model'])){
				$this->model->error['post']['model'] = 'error';
			}
			//Send form if no errors
			if(empty($this->model->error)){
				//mandatory
				$to = $this->model->to;
				$from = $this->model->from;
				$duplicate = $this->model->duplicate;
				$subject = $this->model->subject;
				$heading = $this->model->heading;
				$body = $this->model->body;
				$footer = $this->model->footer;
				//additional/optional params
				$template = (property_exists($this->model,'template') ? $this->model->template : '');
				$GA_account = (property_exists($this->model,'GA_account') ? $this->model->GA_account : '');
				$GA_campaign = (property_exists($this->model,'GA_campaign') ? $this->model->GA_campaign : '');
				//location of form
				$form_url = urlencode($_SERVER['REQUEST_URI']);
				$form_url_full = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$_SERVER['REQUEST_URI']}";
				//Google Analytics tracking
				$tracking = '?utm_campaign=' . $GA_campaign . '&utm_source=' . $form_url . '&utm_medium=email-link'; //track links to your website
				$email_open = ''; //track opened emails
				if($GA_account && $GA_campaign){
					$email_open = '<img src="http://www.google-analytics.com/collect?v=1&tid=UA-' . $GA_account . '&cid=anon&t=event&ec=email-open&ea=' . $GA_campaign . '-email-open&el=' . $GA_campaign . '&cn=' . $GA_campaign . '&cs=email&cm=open">';
				}
				//post
				$post = '';
				$post .= '<h2>Form details</h2>';
				$post .= '<p><b>Form:</b> <a href="' . $form_url_full . '">' . $form_url_full . '</a></p>';
				foreach($this->model->post as $k => $v){
					foreach($this->model->form as $field){
						$field_name = '';
						if($field['name'] == $k){
							$field_name = $field['label'];
							if(!is_array($v)){
								$post .= '<p>' . '<b>' . $field_name . '</b> ' . $v . '</p>';
							}else{
								$this_array = implode(',',array_values(array_filter($v)));
								$post .= '<p>' . '<b>' . $field_name . '</b> ' . $this_array . '</p>';
							}
						}
					}
				}
				//headers
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .="From:" . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n";
				if($template){
					$msg = file_get_contents($template);
					$msg = str_replace('{heading}' , $heading, $msg);
					$msg = str_replace('{body}' , $body, $msg);
					$msg = str_replace('{receipt}' , $post, $msg);
					$msg = str_replace('{footer}' , $footer, $msg);
					$msg = str_replace('{tracking}' , $tracking, $msg);
					$msg = str_replace('{email_open}' , $email_open, $msg);
				}else{
					$msg = $heading;
					$msg .= $body;
					$msg .= $post;
					$msg .= $footer;
				}
				mail($to,$subject,$msg,$headers);
				if($duplicate){
					mail($duplicate,$subject,$msg,$headers);
				}
			}
		} //end if post
	} //end __construct
}
?>