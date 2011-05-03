<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Labels extends Controller {

	public function action_index()
	{	
	  $filename = APPPATH."languages/dk.php";
    $handle = fopen($filename, "r");
    $labels = fread($handle, filesize($filename));
    $labels = str_replace("<?php", "", $labels);
    $labels = str_replace("?>", "", $labels);
    
		$this->response->body(View::factory('tilbud/admin/labels_index')
													->set('labels', $labels)
											);
    fclose($handle);

		$posts = $this->request->post();

		// This will check if submitted
		if(!empty($posts)) {
		  if ($_POST['labels'] != "") {
		    $handle = fopen($filename, "w");
		    fwrite($handle, "<?php");
		    fwrite($handle, $_POST['labels']);
		    fwrite($handle, "?>");
		    fclose($handle);
		    
        Message::add('success', LBL_Successfully_saved);
        return;
		    
	    }
		}


	}

} // End Cities
