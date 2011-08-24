<?php
/******************************
**	PHP Login Ajax JQuery
**	programmer@chazzuka.com
**	http://www.chazzuka.com/
*******************************/
class Login
{
	// property
	private $user;
	private $pass;
	private $user_id;
	private $success_url;
	// init
	public function __construct()
	{
		$this->user = 'admin';
		$this->pass = '123456';
		$this->user_id = 1;
		$this->success_url = 'index.php';
	}
	// create form
	private function form($u=false)
	{
		$html = '<form name="ajaxform" id="ajaxform">'.
		    	'<label>Usuario</label>'.
		        '<input type="text" name="nameuser" id="nameuser" class="textfield" value="'.$u.'" />'.
		        '<label>Password</label>'.
        		'<input type="password" name="passuser" id="passuser" class="textfield" />'.
        		'<input type="submit" name="submit" id="submit" class="buttonfield" value="Acceder" />'.
        		'</form>';
		return $html;

	}

	// signin
	public function signin()
	{
		sleep(1);// dont use this in production

		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			// get username and password
			if(get_magic_quotes_gpc())
			{
				$u = stripslashes($_POST['nameuser']);
				$p = stripslashes($_POST['passuser']);
			}
			else
			{
				$u = $_POST['nameuser'];
				$p = $_POST['passuser'];
			}

			// if not blank
			if($u&&$p)
			{
				// try authenticate
				$permit = $this->auth($u,$p);
				// authenticated
				if($permit)
				{
					// json response
					$m = '{'.
						 'succes: true,'.
						 'title: \'<strong>Login Success</strong>\', '.
						 'content: \'Se ha autenticado correctamente<br />'.
						 '<a href="'.$this->success_url.'">Continuar</a> \','.
						  'page: \'buscadores/index.php\''.
						 '}';
					echo $m;


				}
				// failed authentication
				else
				{
					// json response
					$m = '{'.
						 'succes: false,'.
						 'title: \'<strong>'. utf8_encode('Autenticación fallida: La cambinación de usuario y password no es válido') . '</strong>\''.
						 '}';
					echo $m;
				}
			}
			else
			{
					// json response // user & pass are blank
					$m = '{'.
						 'succes: false,'.
						 'title: \'<strong>Login :</strong> authenticate your user and password\''.
						 '}';
					echo $m;
			}
		}
		else
		{
			// populate form
			echo $this->form();
		}
	}

	// check session expires
	private function session_expire_check()
		{
			// session not exist
			if(!isset($_SESSION["user_id"]) && !isset($_SESSION["expires"]))
			{
				// create
				$this->session_create();
			}
			else
			{
				//  if not valid current session
				if($_SESSION["user_id"]==0 && time() >= $_SESSION["expires"])
				{
					// destroy
					$this->session_kill();
				}
				else
				{
					// add 45 minutes more expiration
					$_SESSION["expires"] = (time()+(45*60));
				}
			}
		}
	// create session
	private function session_create($user_id=0)
		{
			$_SESSION['user_id'] = $user_id;
			$_SESSION["expires"] = time()+(45*60);
			return true;
		}
	// destroy session
	private function session_kill()
		{
			// if session is active
			if (isset($_SESSION["user_id"]) && $_SESSION["user_id"]!= 0)
			{
				// clean session
				$_SESSION = array();
				// create new
				$this->session_create();
			}
			return true;
		}

	// authenticate
	private function auth($u,$p)
		{
			@ $users = file(dirname(__FILE__)."/Login_users.php");
			if (($users)&&(sizeof($users)>2))
			{
				for($i=1;$i<sizeof($users)-1;$i++)
				{
					$users[$i] = trim($users[$i]);

					list($user, $pass, $userId) = explode(':', substr($users[$i],2));

					if($u==$user && $pass==md5($p))
					{
						$this->session_create($userId);
						return true;
					}

			}
		}
			return false;
		}
	// get file extension
	private function GetFileExtension($s)
	{
		return substr($s, strripos($s, '.') + 1);
	}
	// get file name withour extension
	private function GetFileNoExt($s)
	{
		return substr($s,0,(strlen($s)-(strlen($this->GetFileExtension($s))+1)));
	}
	// get file name with extension
	private function GetFileNameWithExt($s)
	{
		$current = strtolower(str_replace('\\','/',$s));
		return  substr($current,strrpos($current,'/')+1);
	}

	// check authentication
	public function checkauth()
	{
		// if logout request
		if(!(empty($_GET['a'])) && $_GET['a']=='logout'){$this->session_kill();}
		// check expiration
		$this->session_expire_check();
		// get current page name
		$curFile = $this->GetFileNoExt($this->GetFileNameWithExt($_SERVER["SCRIPT_NAME"]));
		// if not valid session and current page is not login page
		// redirect to login page
		if($_SESSION["user_id"]==0 && $curFile != 'login')
		{
			header('location:../index.php');
		}
		else if($curFile == 'login' && $_SESSION["user_id"])
		{		header('location:../index.php');		}
	}
}
?>
