<?php
/* For licensing terms, see /license.txt */
class page extends Controller {

	public $navtitle;
	public $navlist = array();
							
	public function __construct() {
		$this->navtitle = "Mail Center Sub Menu";
		$this->navlist[] = array("Email Templates", "email_open.png", "templates");		
		$this->navlist[] = array("Mass Emailer", "transmit.png", "mass");
	}
	
	public function description() {
		return "<strong>Mail Center</strong><br />
		Welcome to the Mail. Here you can edit your email templates or send a mass email to all your users.<br />";			
	}

	public function content() { # Displays the page 
		global $main, $style, $db;
		
		switch($main->get_variable('sub')) {
			default:
			case 'templates': #email templates
				$n = null;
				if($_POST && $main->checkToken()) {
					foreach($main->postvar as $key => $value) {
						if($value == "" && !$n) {
							$main->errors("Please fill in all the fields!");
							$n++;
						}
					}
					if(!$n) {
						
						$main->postvar['subject'] 	= $db->strip($main->postvar['subject']);
						$main->postvar['content'] 	= $db->strip($main->postvar['content']);
						$main->postvar['template'] 	= $db->strip($main->postvar['template']);
						
						
						$db->query("UPDATE <PRE>templates SET
								    subject = '{$main->postvar['subject']}',
							   		content = '{$main->postvar['content']}'
							   		WHERE id = '{$main->postvar['template']}'");
							   		
						$main->errors("Template edited");
						$main->generateToken();						
					}
				}
				$query = $db->query("SELECT * FROM `<PRE>templates` ORDER BY `acpvisual` ASC");
				while($data = $db->fetch_array($query)) {
					$values[] = array($data['acpvisual'], $data['id']);	
				}
				$selected_id = 0;
				if (isset($main->getvar['do']) && !empty($main->getvar['do'])) {
					$selected_id = $main->getvar['do'];
				}		
				
				$array['TEMPLATES'] 	= $main->dropDown("LOL", $values, $selected_id, 0, 1);
				$array['TEMPLATE_ID'] 	= $selected_id;
				
				$this->replaceVar("email/emailtemplates.tpl", $array);
				break;			
			case "mass": #mass emailer
				$this->replaceVar("email/massemail.tpl");
				break;
		}
	}
}