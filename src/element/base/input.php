<?php

namespace streaky\form\element\base;

class inputException extends \Exception {}

class input extends element {
	
	protected $type = false;
	
	protected $validate = false;
	
	public $placeholder = "";
	
	public function __construct() {
		throw new inputException("Inputs can't be directly created, must use a subclass");
	}
	
	public function getHtml(&$form, &$validate) {
		
		if(trim($this->id) == "") {
			$item->id = "{$form->id}-{$this->name}";
		}
		
		\tpl::assign("item-id", $this->id);
		
		if(in_array($this->name, $validate)) {
			$this->classes_input[] = "validate-item";
			$this->validate = true;
		}
		
		if($this->required == true) {
			$this->classes_outer[] = "required";
			if($this->validate == false) {
				$this->classes_input[] = "validate-item";
				$this->validate = true;
			}
		}
		
		$message = "";
		if($this->message != false && $this->message->message != "") {
			\tpl::assign("popover-message", $this->message->message);
			switch($this->message->error) {
				case \streaky\form\validate\response::ok;
					\tpl::assign("popover-classes", "icon icon-ok-sign");
				break;
				case \streaky\form\validate\response::info;
					\tpl::assign("popover-classes", "icon icon-info-sign");
				break;
				case \streaky\form\validate\response::warn;
					\tpl::assign("popover-classes", "icon icon-warning-sign");
				break;
				case \streaky\form\validate\response::error;
					\tpl::assign("popover-classes", "icon icon-exclamation-sign");
				break;
			}
			$message = \tpl::fetch("ui/popover.php");
		}
		\tpl::append("form-messages", $message);
		
		\tpl::assign("item-value", $this->value);
		\tpl::assign("item-label", $this->label);
		\tpl::assign("item-name", $this->name);
		\tpl::assign("item-help", $this->help);
		\tpl::assign("item-type", $this->type);
		\tpl::assign("item-placeholder", $this->placeholder);
		\tpl::assign("item-outer-classes", implode(" ", $this->classes_outer));
		\tpl::assign("item-input-classes", implode(" ", $this->classes_input));
		return \tpl::fetch("ui/input.php");
	}
	
	public function validate() {
		
	}
}