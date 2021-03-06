<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Emails extends Controller {

	public function action_index()
	{	
		$cities = ORM::factory('category');
		
		// This is an example of how to use Kohana pagination
    // Get the total count for the pagination
		$total = $cities->count_all();
		
		$pagination = new Pagination(array(
									 'total_items' 		=> $total,
									 'items_per_page'	=> 10, 
									 'auto_hide' 			=> false,
									 'view'           => 'pagination/useradmin',));
		$sort = isset($_GET['sort']) ? $_GET['sort'] : 'name'; // set default sorting direction here
    $dir  = isset($_GET['dir']) ? 'DESC' : 'ASC';
		$result = $cities->limit($pagination->items_per_page)->offset($pagination->offset)->order_by($sort, $dir)
              ->find_all();
							
		foreach($result as $city) {
			$res[] = $city->as_array();
		}

		$this->response->body(View::factory('tilbud/admin/categories/category_index')
													->set('paging', $pagination)
													->set('categories', $res)
													->set('no_pager', TRUE)
											);
	}


	public function action_viewcustomers($deal_id)
	{
		$page  = View::factory('tilbud/admin/emails/viewcustomers');
		$deal_sql = "select * from deals where ID='" . $deal_id . "'";
		$deal_result = DB::query(Database::SELECT, $deal_sql)->execute()->as_array();
		$deal = $deal_result[0];
		$user = Auth::instance()->get_user()->as_array();

    $sql = "select * from orders where deal_id = " . $deal_id;
    $orders = DB::query(Database::SELECT, $sql)->execute()->as_array();
    for($i=0; $i < sizeof($orders); $i++) {
      $sql2 = "select * from users where id = " . $orders[$i]['user_id'];
      $u = DB::query(Database::SELECT, $sql2)->execute()->as_array();
      $orders[$i]['users'] = $u[0];
    }
    $page->orders = $orders;
    $page->deal = $deal;
		$this->response->body($page);
  }

  public function action_notify_buyers()
  {
    if (isset($_POST['semail'])) {
      foreach($_POST['semail'] as $email) {

    		$user_sql = "select * from users where email='" . $email . "'";
    		$user_result = DB::query(Database::SELECT, $user_sql)->execute()->as_array();
    		$user = $user_result[0];

    		$deal_sql = "select * from deals where ID='" . $_POST['deal_id'] . "'";
    		$deal_result = DB::query(Database::SELECT, $deal_sql)->execute()->as_array();
    		$deal = $deal_result[0];

    		$order_sql = "select * from orders ORDER BY ID DESC limit 0,1";
    		$order_result = DB::query(Database::SELECT, $order_sql)->execute()->as_array();
    		$order = $order_result[0];

    		$name  = $user['lastname'] . ', ' . $user['firstname'];

    		$to = $email;
    		$subject = "Tillykke med dit " . mb_convert_encoding("køb", "ISO-8859-1", "UTF-8") . ": " . html_entity_decode($deal['contents_title']) . " hos TilbudiByen.com (Ordrenummer {$order['ID']}";
    		$headers = 'MIME-Version: 1.0' . "\r\n";
    		$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
    		$headers .= "From: no-reply@tilbudibyen.com" . "\r\n".
    								"Reply-To: no-reply@tilbudibyen.com" . "\r\n".
    								"X-Mailer: PHP/" . phpversion();

    		ob_start();
    		include_once(APPPATH . 'views/tilbud/template_test_order.php');
    		$content = ob_get_clean();
    		$message = $content;

            $tilbud = "TILBUDIBYEN";
            $datas[] = $user['firstname'] . " " . $user['lastname'] . ";" . strftime("%Y-%m-%d", strtotime($order['date_paid'])) . ";" . strftime("%Y-%m-%d", strtotime($deal['expiry_date']));            

            $title = mb_convert_encoding($deal['title'], "ISO-8859-1", "UTF-8");
            $description = mb_convert_encoding($deal['description'], "ISO-8859-1", "UTF-8");
            $description = substr($description, 0, 100) . "...";
            $refno = "Referencenummer: ". $order['refno'];
            $address = $deal['addresses'];
            $second = mb_convert_encoding('Købsdato', "ISO-8859-1", "UTF-8");
            $third = mb_convert_encoding('Udløbsdato', "ISO-8859-1", "UTF-8");

            $guide = mb_convert_encoding("
            Sådan bruger du dit værdibevis <br>
            - Print værdibeviset ud<br>
            - Hæng det op på køleskabet eller læg det i din pung<br>
            - Nyd oplevelsen med dine venner eller familie", "ISO-8859-1", "UTF-8");

            $pdf = new PDF('P', 'mm', array(250,200));
            //Column titles
            $header=array('Indehave',$second,$third);
            //Data loading
            $data=$pdf->LoadData($datas);
            $pdf->SetFont('Arial','B',20);
            $pdf->AddPage();    

            $pdf->Cell(0,20,$tilbud,0,1);

            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(0,6,$title,0,1);
            $pdf->SetFont('Arial','',11);
            $pdf->Cell(0,6,$description,0,1);
            $pdf->Ln();

            $pdf->BasicTable($header,$data);
            $pdf->Ln();
            $pdf->SetFont('Arial','B',11);    
            $pdf->Cell(0,7,$refno,0,1);

            $pdf->SetFont('Arial','',10);
            $pdf->Cell(0,5,$address,0,1);

            $pdf->Ln();
            $pdf->WriteHTML($guide);
            $pdf->Ln();
            $pdf->Cell(0,6, "TilbudIbyen kundeservice", 0,1);
            $pdf->Cell(0,6, "Mail: kundeservice@tilbudibyen.com", 0,1);
            $pdf->Cell(0,6, mb_convert_encoding("Vi ses på www.tilbudibyen.com","ISO-8859-1", "UTF-8"), 0,1);

        $from = "no-reply@tilbudibyen.com"; 
        // a random hash will be necessary to send mixed content
        $separator = md5(time());

        // carriage return type (we use a PHP end of line constant)
        $eol = PHP_EOL;

        // attachment name
        $filename = "Værdibevis-" . $order['refno'] . ".pdf";

        // encode data (puts attachment in proper format)
        $pdfdoc = $pdf->Output("", "S");
        $attachment = chunk_split(base64_encode($pdfdoc));


        // main header (multipart mandatory)
        $headers  = "From: ".$from.$eol;
        $headers .= "MIME-Version: 1.0".$eol; 
        $headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol; 
        $headers .= "Content-Transfer-Encoding: 7bit".$eol;
        $headers .= "This is a MIME encoded message.".$eol.$eol;

        // message
        $headers .= "--".$separator.$eol;
        $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
        $headers .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
        $headers .= $message.$eol.$eol;

        // attachment
        $headers .= "--".$separator.$eol;
        $headers .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
        $headers .= "Content-Transfer-Encoding: base64".$eol;
        $headers .= "Content-Disposition: attachment".$eol.$eol;
        $headers .= $attachment.$eol.$eol;
        $headers .= "--".$separator."--";

        // send message
    		mail($to, $subject, $message, $headers);
      }
        echo "Done sending emails.";
      
    }else{
      echo __(LBL_PLEASE_SELECT_EMAIL_ADDRESS);
    }
  }
  
  public function action_sendtest()
  {
		$user_sql = "select * from users where email='" . $_POST['test_email'] . "'";
		$user_result = DB::query(Database::SELECT, $user_sql)->execute()->as_array();
		$user = $user_result[0];
		
		$deal_sql = "select * from deals where ID='" . $_POST['deal_id'] . "'";
		$deal_result = DB::query(Database::SELECT, $deal_sql)->execute()->as_array();
		$deal = $deal_result[0];

		$order_sql = "select * from orders ORDER BY ID DESC limit 0,1";
		$order_result = DB::query(Database::SELECT, $order_sql)->execute()->as_array();
		$order = $order_result[0];
		
		$name  = $user['lastname'] . ', ' . $user['firstname'];
		
		$to = $_POST['test_email'];
		$subject = "Tillykke med dit " . mb_convert_encoding("køb", "ISO-8859-1", "UTF-8") . ": " . html_entity_decode($deal['contents_title']) . " hos TilbudiByen.com (Ordrenummer {$order['ID']}";
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
		$headers .= "From: no-reply@tilbudibyen.com" . "\r\n".
								"Reply-To: no-reply@tilbudibyen.com" . "\r\n".
								"X-Mailer: PHP/" . phpversion();

		ob_start();
		include_once(APPPATH . 'views/tilbud/template_test_order.php');
		$content = ob_get_clean();
		$message = $content;

        $tilbud = "TILBUDIBYEN";
        $datas[] = $user['firstname'] . " " . $user['lastname'] . ";" . strftime("%Y-%m-%d", strtotime($order['date_paid'])) . ";" . strftime("%Y-%m-%d", strtotime($deal['expiry_date']));

        $title = mb_convert_encoding($deal['title'], "ISO-8859-1", "UTF-8");
        $description = mb_convert_encoding($deal['description'], "ISO-8859-1", "UTF-8");
        $description = substr($description, 0, 100) . "...";
        
        $refno = "Referencenummer: ". $order['refno'];
        $address = $deal['addresses'];
        $second = mb_convert_encoding('Købsdato', "ISO-8859-1", "UTF-8");
        $third = mb_convert_encoding('Udløbsdato', "ISO-8859-1", "UTF-8");

        $guide = mb_convert_encoding("
        Sådan bruger du dit værdibevis <br>
        - Print værdibeviset ud<br>
        - Hæng det op på køleskabet eller læg det i din pung<br>
        - Nyd oplevelsen med dine venner eller familie", "ISO-8859-1", "UTF-8");

        $pdf = new PDF('P', 'mm', array(250,200));
        //Column titles
        $header=array('Indehave',$second,$third);
        //Data loading
        $data=$pdf->LoadData($datas);
        $pdf->SetFont('Arial','B',20);
        $pdf->AddPage();    

        $pdf->Cell(0,20,$tilbud,0,1);

        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0,6,$title,0,1);
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(0,6,$description,0,1);
        $pdf->Ln();

        $pdf->BasicTable($header,$data);
        $pdf->Ln();
        $pdf->SetFont('Arial','B',11);    
        $pdf->Cell(0,7,$refno,0,1);

        $pdf->SetFont('Arial','',10);
        $pdf->Cell(0,5,$address,0,1);

        $pdf->Ln();
        $pdf->WriteHTML($guide);
        $pdf->Ln();
        $pdf->Cell(0,6, "TilbudIbyen kundeservice", 0,1);
        $pdf->Cell(0,6, "Mail: kundeservice@tilbudibyen.com", 0,1);
        $pdf->Cell(0,6, mb_convert_encoding("Vi ses på www.tilbudibyen.com","ISO-8859-1", "UTF-8"), 0,1);

    $from = "no-reply@tilbudibyen.com"; 
    // a random hash will be necessary to send mixed content
    $separator = md5(time());

    // carriage return type (we use a PHP end of line constant)
    $eol = PHP_EOL;

    // attachment name
    $filename = "Værdibevis-" . $order['refno'] . ".pdf";

    // encode data (puts attachment in proper format)
    $pdfdoc = $pdf->Output("", "S");
    $attachment = chunk_split(base64_encode($pdfdoc));


    // main header (multipart mandatory)
    $headers  = "From: ".$from.$eol;
    $headers .= "MIME-Version: 1.0".$eol; 
    $headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol; 
    $headers .= "Content-Transfer-Encoding: 7bit".$eol;
    $headers .= "This is a MIME encoded message.".$eol.$eol;

    // message
    $headers .= "--".$separator.$eol;
    $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
    $headers .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
    $headers .= $message.$eol.$eol;

    // attachment
    $headers .= "--".$separator.$eol;
    $headers .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
    $headers .= "Content-Transfer-Encoding: base64".$eol;
    $headers .= "Content-Disposition: attachment".$eol.$eol;
    $headers .= $attachment.$eol.$eol;
    $headers .= "--".$separator."--";

    // send message
		mail($to, $subject, $message, $headers);
  
    echo "done.";
    
  }
  
	public function action_view($deal_id)
	{
		$page  = View::factory('tilbud/admin/emails/view');
		$deals = ORM::factory('deal', $deal_id);
				
		// Send or Send to Subscribers is requested
		$posts = $this->request->post();
		if(!empty($posts)) {
		
			if(isset($posts['submit']) || isset($posts['submitall'])) {
				
				$_GET['type'] = 'deals';
				
				if(isset($posts['submit'])) {
					$emails = explode(",", $posts['to']);
					$err_mails = array();
					foreach($emails as $mail) {
						
						if(!Valid::email(trim($mail)))
							$err_mails[] = $mail;
											
						if(!empty($err_mails))
							$errors['to'] = __(LBL_INVALID_EMAIL . " - " . implode(",", $err_mails));
					}
				}
				
				if(!empty($errors)) {
					$page->errors = $errors;
				} else {
					// Send Emails
					$mailer = new XMail();
					$mailer->subject = $posts['subject'];
					$mailer->message = $posts['body'];
					
					if(isset($posts['submitall'])) {
						$subscribers = ORM::factory('category')->get_subscribers($deals->city_id);
						
						if(!empty($subscribers)) {
							foreach($subscribers as $sub) {
								$mailer->to = $sub['email'];
								$mailer->send();
							}
							Message::add('success', __(LBL_EMAIL_SENT));
							$this->request->redirect('admin/deals');
							return;
						} else {
							Message::add('success', __(LBL_NO_SUBSCRIBERS));
							$this->request->redirect('admin/deals');
							return;
						}
					} else {
						$mailer->to	= implode(",", $emails);
					}

					if($mailer->send()) {					
						Message::add('success', __(LBL_EMAIL_SENT));
						$this->request->redirect('admin/deals');
						return;
					} // End of Mailer
				
				} // End of Error Checking
			} // End of Posts Submit
		}
		
		switch($_GET['type']) {
			case 'deals': 
				$email_id = 2; 
				
				// Load Variables
				$DEAL 					= html_entity_decode($deals->description);
				$DEALID         = $deals->ID;
				$EMAILFORMATURL = HTML::anchor(Url::base(TRUE) . 'deals/email_format/'.$deals->ID, 'klik her');
				$BGHEADER				= url::base(TRUE) . 'images/bg-header.png';
				$LOGO						= HTML::Image(Url::base(TRUE).'images/logo.png');
				$FACEBOOK				= HTML::Image(Url::base(TRUE).'images/facebook-like.png');
				$PRICE_FOR_EMAIL= ($deals->price_for_email != "") ? $deals->price_for_email : "";
			
				
				$DEALTITLE			= $deals->title;
				$DEALURL				= HTML::anchor(Url::base(TRUE) . 'deals/view/' . $deals->ID, 
													HTML::Image(Url::base(TRUE) . 'images/bestil.png', array('alt' => 'Order Now',
																																										 'style' => 'margin-bottom: 15px;')));
				$DEALREGPRICE		= $deals->regular_price;
				$DEALPRICE			= ($deals->regular_price * (100 - $deals->discount)) / 100;
				$DEALCLASS			= strlen($DEALPRICE) > 5 ? ' font-size: 45px;' : '';
				$DEALDISCOUNT		= $deals->discount;
				$DEALSAVINGS		= $deals->regular_price - $DEALPRICE;
				$DEALINFO				= html_entity_decode($deals->information);

  			/*
  			$dimages = ORM::factory('image')->where('tid', '=', $deals->ID)->find_all()->as_array();
  			$one_image_path = "";
  			if(!empty($dimages)) {
  				foreach($dimages as $d) {
  					$one_image_path = $d->path;
  					break;
  				}
  			}*/
  			

        $one_image_path = ($deals->image_email != "") ? ('uploads/' . $deals->ID . '/' . $deals->image_email) : "";
				$IMAGE_FOR_EMAIL			= HTML::Image(Url::base(TRUE) . $one_image_path,
															array('width' => 421, 
																		'height' => 284, 
																		'style' => 'margin-bottom: 20px;'));
				$DEALCONTENTS 	= $deals->contents;
				$SEE_VIDEO_DEALS = mb_convert_encoding("Se dagens tilbud på video - <a href=\"http://www.tilbudibyen.com/deals/view/" . $DEALID . "?video=play\">klik her</a>.", "ISO-8859-1", "UTF-8");

        $addresses = unserialize($deals->addresses);
        $address_list = "";
        for($i=0; $i<sizeof($addresses); $i++){
          $address_list .= html_entity_decode($addresses[$i]['company_name']);
          $address_list .= "<br/>";
				  $address_list .=  html_entity_decode($addresses[$i]['address']) ;
				  $address_list .= "<br/>";
				  $address_list .=  html_entity_decode($addresses[$i]['telephone']) ;
				  $address_list .= "<br/>";
				}

				$LOCATION				= $address_list;

				$page->type			= $_GET['type'];
				break;
			default:  		$email_id = 1; break;
		}

		$emails = ORM::factory('email', $email_id);
		
		$subject = addslashes($emails->subject);
		$body    = addslashes($emails->text);
		
		eval("\$text=\"$body\";");
		eval("\$subject=\"$subject\";");
		
		$page->subject = html_entity_decode($subject);
		$page->body		 = html_entity_decode($text);
		$page->to			 = isset($posts['to']) ? $posts['to'] : '';
		
		$this->response->body($page);
	}
	
	public function action_add()
	{		
		$page  = View::factory('tilbud/admin/emails/form');
		$page->label = __(LBL_EMAIL_TEMPLATE_ADD);

		$emails = ORM::factory('email');

		// Get posts
		$posts = $this->request->post();
		if(!empty($posts)) {
			
			$emails->name = $posts['template_name'];
			$emails->subject = $posts['subject'];
			$emails->text = $posts['body'];
			
			if($emails->save()) {
				// message: save success
        Message::add('success', __(sprintf(LBL_SUCCESS_ADD, LBL_EMAIL_TEMPLATES, $emails->name)));
				
				// Assuming all is correct
				Request::current()->redirect('admin/emails');
				return;
			}
		}
		
		$page->body = isset($posts['body']) ? $posts['body'] : '';
		$page->subject = isset($posts['subject']) ? $posts['subject'] : '';
		$page->template_name = isset($posts['template_name']) ? $posts['template_name'] : '';
		
		$this->response->body($page);
	}
	
	public function action_edit($id=NULL)
	{
		
	}
	
	public function action_delete($id=NULL)
	{
		
	}
	
	public function before() 
	{
		// This codeblock is very useful in development sites:
		// What it does is get rid of invalid sessions which cause exceptions, which may happen
		// 1) when you make errors in your code.
		// 2) when the session expires!
		try {
			 $this->session = Session::instance();
		} catch(ErrorException $e) {
			 session_destroy();
		}
		// Execute parent::before first
		parent::before();
		// Open session
		$this->session = Session::instance();

		// Check user auth and role
		$action_name = Request::current()->action();

		if(Auth::instance()->logged_in('admin') === FALSE) {
			if(Auth::instance()->logged_in()) {
				Request::current()->redirect('user/myaccount');
			} else {
				Request::current()->redirect('user/login?u=' . urlencode($_SERVER['REDIRECT_URL']));
			}
		}
	}

} // End Groups
