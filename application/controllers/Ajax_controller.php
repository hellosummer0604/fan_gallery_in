<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ajax_controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Photograph');
        $this->load->model('Repository');
        $this->load->model('Img');
        $this->load->model('Master_user');
    }

    public function index()
    {
        echo "index---";
        echo repository_url("img2.jpg");
        echo "!!!";
//		$this->db->query();
    }


	public function getImgDetail()
	{
		if (empty($_POST['imgId'])) {
			echo json_encode(null);
			return;
		} else {
			$imgId = $_POST['imgId'];
		}


		//firstly check database
		$imgObj = Img::load($imgId);

		if (empty($imgObj)) {
			//cannot find
			echo json_encode(null);
		}

		echo json_encode($this->utils->imgDetailWrapper($imgObj));
	}


	/**
	 * @param null $userId
	 * @param null $tagName
	 * @param null $pageNo
	 */
    public function getImg($userId = null, $tagName = null, $pageNo = null)
    {

		if (empty($pageNo)) {
			$pageNo = 0;
		}

		$userId = cutUserId($userId);

        $pageSize = empty($_POST['pageSize']) ? IMG_SECTION_PAGE_SIZE : $_POST['pageSize'];

        $lastSize = empty($_POST['lastSize']) ? IMG_SECTION_LAST_SIZE : $_POST['lastSize'];

		if (empty($userId) || ($userId != REPO_URL && strlen($userId) < USER_ID_LEN)) {//the null passed by router is a string which length is 32
			$imgSec = $this->getHomePageImgSection($tagName, $pageNo, $pageSize, $lastSize);
		} else {
			if($userId == REPO_URL) {
				$userId = $this->utils->isOnline();
			}
			$imgSec = $this->getUserImgSection($userId, $tagName, $pageNo, $pageSize, $lastSize);
		}

        if (empty($imgSec)) {
            echo json_encode(null);
        } else {
            echo json_encode($imgSec);
        }
    }

    /*
     * get img section from database
     *
     * $typeId can be 1.repository, 2.category name, 3.tag name, 4 author id
     */

    private function getUserImgSection($userId, $typeId, $pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE)
    {
        $typeId = strtolower($typeId);

		$visitor = $this->isOnline();

        if ($typeId == REPO_ID) {
            $imgSection = $this->Img->getRepositoryImgs($pageNo, $pageSize, $last);
        } else {
            $imgSection = $this->Img->getSectionImg($userId, $typeId, $pageNo, $pageSize, $last, $visitor);
        }

		return $this->assembleImgSection($imgSection, $typeId);
    }

    private function getHomePageImgSection($typeId, $pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE) {
		$imgSection =  $this->Master_user->getPhotos($typeId, $pageNo, $pageSize, $last);

		return $this->assembleImgSection($imgSection, $typeId);
	}

    private function assembleImgSection($imgSection, $typeId) {
		if (empty($imgSection['imgList']) || empty($typeId)) {
			return null;
		}

		$groupSize = IMG_SECTION_SIZE;

		$groupNum = count($imgSection['imgList']) / $groupSize;

		if ($groupNum < 2) {
			$groupName = 's_' . $typeId . '_g_' . "0";

			$groupList = array($groupName => array('id' => $groupName, 'imgList' => $imgSection['imgList']));

			$res = array('id' => $typeId, 'loadingList' => array(), 'waitingList' => $groupList);
		} else {
			$remainImg = count($imgSection['imgList']);

			$groupList = array();

			for ($i = 0; $i < $groupNum - 2; $i++) {
				$groupName = 's_' . $typeId . '_g_' . $i;

				$temp_img_array = array_slice($imgSection['imgList'], $i * $groupSize, $groupSize);

				$temp_img_array = array('id' => $groupName, 'imgList' => $temp_img_array);

				$groupList[$groupName] = $temp_img_array;

				$remainImg = $remainImg - $groupSize;
			}
			//last group
			$groupName = 's_' . $typeId . '_g_' . $i;

			$temp_img_array = array_slice($imgSection['imgList'], $i * $groupSize, $remainImg);

			$temp_img_array = array('id' => $groupName, 'imgList' => $temp_img_array);

			$groupList[$groupName] = $temp_img_array;

			$res = array('id' => $typeId, 'loadingList' => array(), 'waitingList' => $groupList);
		}

		$res['pagination'] = $imgSection['pagination'];

		return $res;
	}


	public function tag() {
		$userId = $this->isOnline();

		if (empty($userId)) {
			echo json_encode(null);
			return;
		}

		$this->load->model('Tag');

		$tags = Tag::getAllTags($userId, null, 0);

		if (empty($tags)) {
			echo json_encode(null);
			return;
		}

		$data = array();

		foreach ($tags as $tag) {
			$data[] = array('id' => $tag['id'], 'value' => $tag['tag_name']);
		}

		echo json_encode($data);
	}

}


?>

