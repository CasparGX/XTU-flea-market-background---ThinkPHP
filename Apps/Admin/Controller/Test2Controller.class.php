<?php
namespace Admin\Controller;
use Admin\Controller\TestController;
class Test2Controller extends TestController {

	public function index($id=1) {
		if($id==2)
			echo $id;
	}
}
?>