<?php

/**
 * ROUTER
 *
 * @author Henrique Dias
 * @package MathPocket
 */

require_once('/config.php');

$DATA['url'] = isset($_GET['url']) ? $_GET['url'] : null;
$DATA['url'] = rtrim($DATA['url'], '/');
$DATA['url'] = explode('/', $DATA['url']);

if(empty($DATA['url'][0])) {

	if ($DATA['user']->loggedIn()) {
		$page = new Piece('home.user');
	} else {
		$page = new Piece('home');
	}

} else {

	switch ($DATA['url'][0]) {

		case 'sidebar':
			$page = new Piece('sidebar');
			break;

		case 'about':
			$page = new Piece('about');
			break;

		case 'dictionary':
			dictionary();
			break;

		case 'profile':
			profile();
			break;

		case 'user':
			user();
			break;

		case 'action':
			actions();
			break;

		default:
			$page = new Piece('404', 'red');
			break;
	}
}

function dictionary() {
	global $DATA;

	$page = new Dictionary();

	if (!isset($DATA['url'][1])) {

		$page->allItems();

	} else {

		if ($DATA['url'][1] == 'item') {

			if (!isset($DATA['url'][2])) {

				$page->allItems();

			} else {

				$page->item($DATA['url'][2]);

			}

		} else if (is_numeric($DATA['url'][1])) {

			$n = $DATA['url'][1];
			$page->allItems($n);

		} else if ($DATA['url'][1] == 'category') {

			if (!isset($DATA['url'][2])) {

				$page->allItems();

			} else {

				if (isset($DATA['url'][3]) && is_numeric($DATA['url'][3])) {
					$page->category($DATA['url'][2], $DATA['url'][3]);
				} else {
					$page->category($DATA['url'][2]);
				}

				
			}

		} else if ($DATA['url'][1] == 'favorites') {

			if($DATA['user']->loggedIn()) {

				$page->listFavLater($_SESSION['user_user'], 'favs');

			} else {

				Base::needLogin();

			} 

		} else if ($DATA['url'][1] == 'readlater') {

			if($DATA['user']->loggedIn()) {

				$page->listFavLater($_SESSION['user_user'], 'later');

			} else {

				Base::needLogin();

			} 

		} else {

			$page = new Piece('404', 'red');

		}
	}
		
}

function profile() {
	global $DATA;

	if (!isset($DATA['url'][1])) {

		$page = new Piece('404', 'red');

	} else {

		if ($DATA['user']->loggedIn()) {

			$DATA['user']->profile($DATA['url'][1]);

		} else {

			Base::needLogin();

		}		
	}
}

function user() {
	global $DATA;

	if($DATA['url'][1]) {

		switch ($DATA['url'][1]) {

			case 'login':
				$page = new Piece('login');
				break;

			case 'register':
				$page = new Piece('register');
				break;

			case 'config':
				if ($DATA['user']->loggedIn()) {

					$DATA['user']->configPage($_SESSION['user_user']);

				} else {

					Base::needLogin();
				}

				break;

			default:
				$page = new Piece('404', 'red');
				break;
		}
	}
}


function actions() {
	global $DATA;

	if ($DATA['url'][1]) {

		switch ($DATA['url'][1]) {

			case 'logout':
				if ($DATA['user']->logout()) {

					$result['status'] = 0;

	                ob_end_clean();
	                header('Content-type: application/json');
	                echo json_encode($result);
				}

				break;

			case 'login':
				$user = isset($_POST['user']) ? $_POST['user'] : null;
				$pass = isset($_POST['pass']) ? $_POST['pass'] : null;

				$remember = (isset($_POST['remember']) AND !empty($_POST['remember']));

				$DATA['user']->login( $user, $pass, $remember);
				break;

			case 'register':
				$name = isset($_POST['name']) ? $_POST['name'] : null;
				$user = isset($_POST['user']) ? $_POST['user'] : null;
				$pass = isset($_POST['password']) ? $_POST['password'] : null;

				$DATA['user'] = new User;
				$DATA['user']->registration($name, $user, $pass);
				break;

			case 'update_conf':
				$user = isset($_POST['user']) ? $_POST['user'] : null;
				$color = isset($_POST['color']) ? $_POST['color'] : null;
				$bio = isset($_POST['bio']) ? $_POST['bio'] : null;

				$DATA['user']->configUpdate($user, $color, $bio);
				break;

			case 'addFav':
				$id = isset($_POST['id']) ? $_POST['id'] : null;
				$user = isset($_POST['user']) ? $_POST['user'] : null;

				Dictionary::actionFavLater($id, $user, 'favs', 'add');
				break;

			case 'addLater':
				$id = isset($_POST['id']) ? $_POST['id'] : null;
				$user = isset($_POST['user']) ? $_POST['user'] : null;

				Dictionary::actionFavLater($id, $user, 'later', 'add');
				break;

			case 'remFav':
				$id = isset($_POST['id']) ? $_POST['id'] : null;
				$user = isset($_POST['user']) ? $_POST['user'] : null;

				Dictionary::actionFavLater($id, $user, 'favs', 'rem');
				break;

			case 'remLater':
				$id = isset($_POST['id']) ? $_POST['id'] : null;
				$user = isset($_POST['user']) ? $_POST['user'] : null;

				Dictionary::actionFavLater($id, $user, 'later', 'rem');
				break;

			default:
				$page = new Piece('404', 'red');
				break;
		}
	}
}

?>