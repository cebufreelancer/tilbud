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

    $sql = "select * from orders where deal_id = " . $deal_id;
    $orders = DB::query(Database::SELECT, $sql)->execute()->as_array();
    for($i=0; $i < sizeof($orders); $i++) {
      $sql2 = "select * from users where id = " . $orders[$i]['user_id'];
      $user = DB::query(Database::SELECT, $sql2)->execute()->as_array();
      $orders[$i]['users'] = $user[0];
    }
    $page->orders = $orders;
    $page->deal = $deal;
		$this->response->body($page);
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
		
		$to = $user['email'];
		$subject = "Tillykke med dit køb: {$deal['contents_title']} hos TilbudiByen.dk (Ordrenummer {$order['ID']}";
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
		$headers .= "From: no-reply@tilbudibyen.com" . "\r\n".
								"Reply-To: no-reply@tilbudibyen.com" . "\r\n".
								"X-Mailer: PHP/" . phpversion();

		ob_start();
		include_once(APPPATH . 'views/tilbud/template_test_order.php');
		$content = ob_get_clean();
		
		$message = $content;
//		mail($to, $subject, $message, $headers);

    require('fpdf.php');

    $pdf = new FPDF('P', 'pt', array(500,233));
    $pdf->AddPage();
    //$pdf->Image('lib/fpdf/image.jpg',0,0,500);
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40,10,'Hello World!');

    // email stuff (change data below)

    $from = "no-reply@tilbudibyen.com"; 

    // a random hash will be necessary to send mixed content
    $separator = md5(time());

    // carriage return type (we use a PHP end of line constant)
    $eol = PHP_EOL;

    // attachment name
    $filename = "testing123.pdf";

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

	public function action_pdf()
	{
    require('fpdf.php');
    $contents = "TILBUDIBYEN";
    $pdf=new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40,10, $contents);
    $pdf->Output('testing123.pdf', 'F');
  }
  
	
	public function action_view($deal_id)
	{
		$page  = View::factory('tilbud/admin/emails/view');
		$deals = ORM::factory('deal', $deal_id);
		$emails = ORM::factory('email', 1);
		
		$posts = $this->request->post();
		if(!empty($posts)) {
			
		}
		
		switch($_GET['type']) {
			case 'deals': 
				$email_id = 2; 
				
				// Load Variables
					// construct URL *kludge*
				$DEAL 					= $deals->description;
				$EMAILFORMATURL = HTML::anchor(Url::base(TRUE) . 'deals/email_format/'.$deals->ID, 'klik her');
				$BGHEADER				= url::base(TRUE) . 'images/bg-header.png';
				$LOGO						= HTML::Image(Url::base(TRUE).'images/logo.png');
				$FACEBOOK				= HTML::Image(Url::base(TRUE).'images/facebook-like.png');
				
				$DEALTITLE			= $deals->title;
				$DEALURL				= HTML::anchor(Url::base(TRUE) . 'deals/view/' . $deals->ID, 
													HTML::Image(Url::base(TRUE) . 'images/ordernow.png', array('alt' => 'Order Now',
																																										 'style' => 'margin-bottom: 20px;')));
				$DEALREGPRICE		= $deals->regular_price;
				$DEALPRICE			= ($deals->regular_price * (100 - $deals->discount)) / 100;
				$DEALCLASS			= strlen($DEALPRICE) > 5 ? ' font-size: 45px;' : '';
				$DEALDISCOUNT		= $deals->discount;
				$DEALSAVINGS		= $deals->regular_price - $DEALPRICE;
				$DEALINFO				= $deals->information;
				$DEALIMAGE			= HTML::Image(Url::base(TRUE) . 'uploads/' . $deals->ID . '/' . rawurlencode($deals->image), 
															array('width' => 445, 
																		'height' => 300, 
																		'style' => 'margin-bottom: 20px;'));
				$DEALCONTENTS 	= $deals->contents;
				
				$LOCATION				= $deals->addresses;
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