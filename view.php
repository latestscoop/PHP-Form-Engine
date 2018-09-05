<?php //View: outputs
class view{
	//private $model;
	private $controller;
	public function __construct($controller){
		$this->controller = $controller;
	}
	public function output(){
	//Display error messages detected in controller
		$errors = array();
		if(!empty($this->controller->model->error['post']['empty'])){
			$error_list = '';
			foreach($this->controller->model->form as $key => $field){
				if(in_array($field['name'],$this->controller->model->error['post']['empty']))
				$error_list .= '<span>\'' . str_replace(':','',$field['label']) . '\'</span>' .', ';
			}
			$errors[] = 'The following mandatory field(s) must be completed: ' . rtrim($error_list,', ') . '.';
		}
		if(!empty($this->controller->model->error['post']['email'])){
			$error_list = '';
			foreach($this->controller->model->form as $key => $field){
				if(in_array($field['name'],$this->controller->model->error['post']['email']))
				$error_list .= '<span>\'' . str_replace(':','',$field['label']) . '\'</span>' .', ';
			}
			$errors[] = 'The following email field(s) are incorrect: ' . rtrim($error_list,', ') . '.';
		}
		if(!empty($this->controller->model->error['post']['number'])){
			$error_list = '';
			foreach($this->controller->model->form as $key => $field){
				if(in_array($field['name'],$this->controller->model->error['post']['number']))
				$error_list .= '<span>\'' . str_replace(':','',$field['label']) . '\'</span>' .', ';
			}
			$errors[] = 'The following number only field(s) is incorrect: ' . rtrim($error_list,', ') . '.';
		}
		if(!empty($this->controller->model->error['post']['tel'])){
			$error_list = '';
			foreach($this->controller->model->form as $key => $field){
				if(in_array($field['name'],$this->controller->model->error['post']['tel']))
				$error_list .= '<span>\'' . str_replace(':','',$field['label']) . '\'</span>' .', ';
			}
			$errors[] = 'The following field(s) is formatted incorrectly: ' . rtrim($error_list,', ') . '.';
		}
		if(!empty($this->controller->model->error['post']['model'])){
			$errors[] = 'System error: This form has been set up incorrectly. Please refer to the $view->dev_report();';
		}
		if(!empty($errors)){
			echo '<div id="form_errors">';
			foreach($errors as $error){
				echo '<span>' . $error . '</span>';
			}
			echo '</div>';
		}
	//Display success message
		if(isset($_POST) && !empty($_POST) & empty($errors) && !empty($this->controller->model->success) ){
			$success = $this->controller->model->success;
			echo '<div id="form_success">' . $success . '</div>';
		}
	//Create form vars with or without post data
		if(isset($_POST) && !empty($_POST)){
			foreach($this->controller->model->post as $field => $v){
				${$field} = $v;
			}
		}else{
			foreach($this->controller->model->form as $field){
				${$field['name']} = '';
			}
		}
	//Display form
		echo '<form action="" method="POST" id="' . $this->controller->model->form_name . '">';
			//hidden field listion optional fields, picked up by controller and ignored during error reporting
			$optionals = '';
			foreach($this->controller->model->form as $key => $field){
				if($field['optional'] === true){
					$optionals .= $field['name'] . ',';
				}
			}
			echo '<input type="hidden" name="_optional" id="_optional" value="' . rtrim($optionals,',') . '">';
			//echo all fields
			foreach($this->controller->model->form as $key => $field){
				echo '<label for="' . $field['name'] . '">' . $field['label'] . '</label>';
				if($field['type'] == 'text' || $field['type'] == 'email' || $field['type'] == 'tel' || $field['type'] == 'url' || $field['type'] == 'number'){
					echo '<input type="' . $field['type'] . '" name="' . $field['name'] . '" id="' . $field['name'] . '" class="' . $field['class'] . '" placeholder="' . $field['placeholder'] . '" value="' . ${$field['name']} . '" style="' . $field['style'] . '">';
				}else if($field['type'] == 'textarea'){
					echo '<textarea name="' . $field['name'] . '" id="' . $field['name'] . '" class="' . $field['class'] . '" placeholder="' . $field['placeholder'] . '" style="' . $field['style'] . '">' . ${$field['name']} . '</textarea>';
				}else if($field['type'] == 'radio'){
					$radio = explode(',',$field['placeholder']);
					echo '<input type="hidden" name="' . $field['name'] . '" id="' . $field['name'] . '" value=""' . '>';
					foreach($radio as $v){
						echo '<label class="sub">' . $v;
						echo '<input type="radio" name="' . $field['name'] . '" id="' . $field['name'] . '" class="' . $field['class'] . '" value="' . $v. '" style="' . $field['style'] . '" ' . (${$field['name']} == $v ? 'checked' : '') . '>';
						echo '</label>';
					}
				}else if($field['type'] == 'checkbox'){
					$checkbox = explode(',',$field['placeholder']);
					foreach($checkbox as $k => $v){
						echo '<input type="hidden" name="' . $field['name'] . '[' . $k . ']' . '" id="' . $field['name'] . '[' . $k . ']' . '" value=""' . '>';
						echo '<label class="sub">' . $v;
						echo '<input type="checkbox" name="' . $field['name'] . '[' . $k . ']' . '" id="' . $field['name'] . '[' . $k . ']' . '" class="' . $field['class'] . '" value="' . $v. '" style="' . $field['style'] . '" ' . (is_array(${$field['name']}) && ${$field['name']}[$k] == $v ? 'checked' : '') . '>';
						echo '</label>';
					}
				}else if($field['type'] == 'select'){
					$select = explode(',',$field['placeholder']);
					echo '<select name="' . $field['name'] . '" id="' . $field['name'] . '" class="' . $field['class'] . '" style="' . $field['style'] . '">';
					echo '<option value=""></option>';
					foreach($select as $v){
						echo '<option value="' . $v. '" ' . (${$field['name']} == $v ? 'selected' : '') . '>' . $v . '</option>';
					}
					echo '</select>';
				}else if($field['type'] == 'submit'){
					echo '<input type="submit" id="' . $field['name'] . '" class="' . $field['class'] . '" style="' . $field['style'] . '" value="' . $field['placeholder'] . '">';
				}
			}
		echo '</form>';
	}
	public function dev_report(){
		//outputs completed object - used for error reporting
		echo '<pre>';
			echo '<br><br>Controller '; print_r($this->controller);
		echo '</pre>';
	}
}
?>