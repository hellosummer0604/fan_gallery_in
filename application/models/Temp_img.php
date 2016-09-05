<?php
require_once ('Base_img.php');

class Temp_img extends Base_img
{
	protected static $tbl = "Upload_temp";

	protected $_session = null;

	/**
	 * @return null
	 */
	public function getSession() {
		return $this->_session;
	}

	/**
	 * @param null $session
	 */
	public function setSession($session) {
		$this->_session = $session;
	}

	public static function loadBySessAndUser($session, $userId) {
		$data = array();

		if (!empty($session)) {
			$data['session'] = $session;
		} else {
			return null;
		}

		if (!empty($userId)) {
			$data['user_id'] = $userId;
		} else {
			return null;
		}

		$objs = self::loadByTerm($data);

		if (empty($objs)) {
			return null;
		}

		return $objs;
	}

}


?>

