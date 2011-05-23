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

	public function action_view($deal_id)
	{
		$page  = View::factory('tilbud/admin/emails/view');
		$deals = ORM::factory('deal', $deal_id);
				
		// Send or Send to Subscribers is requested
		$posts = $this->request->post();
		if(!empty($posts)) {
		
			if(isset($posts['submit']) || isset($posts['submitall'])) {
				
				$_GET['type'] = 'deals';
				
				$emails = explode(",", $posts['to']);
				$err_mails = array();
				foreach($emails as $mail) {
					
					if(!Valid::email(trim($mail)))
						$err_mails[] = $mail;
										
					if(!empty($err_mails))
						$errors['to'] = __(INVALID_EMAIL . " - " . implode(",", $err_mails));
				}
				echo '<pre>'; print_r($posts); echo '</pre>';
				
				if(!empty($errors)) {
					$page->errors = $errors;
				} else {
					// Send Emails
									
					$to = implode(",", $emails);
					$subject = $posts['subject'];
					$headers = 'MIME-Version: 1.0' . "\r\n";
					$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
					$headers .= "From: no-reply@tilbudibyen.com" . "\r\n".
											"Reply-To: no-reply@tilbudibyen.com" . "\r\n".
											"X-Mailer: PHP/" . phpversion();
					
					$message = $posts['body'];
					
					if(mail($to, $subject, $message, $headers)) {
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
