<?php
class TaskListView extends BaseView {
	public function __construct(){
		parent::__construct();
	}
	
	public function view_index(){
		$this->smarty->display('taskList.htm');
	}
}

?>