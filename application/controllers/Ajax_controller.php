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
        if (empty($userId)) {
			return;
		}

		if (empty($pageNo)) {
			$pageNo = 0;
		}

		$userId = cutUserId($userId);

        $pageSize = empty($_POST['pageSize']) ? IMG_SECTION_PAGE_SIZE : $_POST['pageSize'];

        $lastSize = empty($_POST['lastSize']) ? IMG_SECTION_LAST_SIZE : $_POST['lastSize'];

        $imgSec = $this->getImgSection($userId, $tagName, $pageNo, $pageSize, $lastSize);

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

    private function getImgSection($userId, $typeId, $pageNo = IMG_SECTION_PAGE_NO, $pageSize = IMG_SECTION_PAGE_SIZE, $last = IMG_SECTION_LAST_SIZE)
    {
        $groupSize = IMG_SECTION_SIZE;

        $typeId = strtolower($typeId);

		$visitor = $this->isOnline();

        if ($typeId == REPO_ID) {
            $imgSection = $this->Img->getRepositoryImgs($pageNo, $pageSize, $last);
        } else {
            $imgSection = $this->Img->getSectionImg($userId, $typeId, $pageNo, $pageSize, $last, $visitor);
        }


        if (empty($imgSection['imgList'])) {
            return null;
        }

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

    public function tag()
    {
        $res = "[
   {
      \"value\":\"Drink\",
      \"id\":\"ChIJCW8PPKmMWYgRXTo0BsEx75Q\"
   },
   {
      \"value\":\"Smoothy\",
      \"id\":\"ChIJV8n8ZvEVtokRWz0esW4x2gk\"
   },
   {
      \"value\":\"Interior\",
      \"id\":\"ChIJfTxB93w5QIcRcvYseNxCK8E\"
   },
   {
      \"value\":\"Light\",
      \"id\":\"ChIJVdvutIxiz1QRrfEteLgfO5s\"
   },
   {
      \"value\":\"Night\",
      \"id\":\"ChIJi_uVCUR7k1QRv4obofFy3fc\"
   },
   {
      \"value\":\"Dog\",
      \"id\":\"ChIJi_uVCUR7k1QRv4obofFy3fc\"
   },
   {
      \"value\":\"Driver\",
      \"id\":\"ChIJi_uVCUR7k1QRv4obofFy3fc\"
   },
   {
      \"value\":\"DDD\",
      \"id\":\"ChIJi_uVCUR7k1QRv4obofFy3fc\"
   },
   {
      \"value\":\"2新的分类\",
      \"id\":\"ChIJi_uVCUR7k1QRv4998fFy3fc\"
   }
]";
        echo $res;
    }

    public function tags2() {
        echo json_encode(array(array('value' => 'drink', 'id' => 'asdasd'), array('value' => 'smoothy', 'id' => '123123')));
    }

    public function tags() {
        echo json_encode(array('Drink', 'Smoothy', 'Interior', 'Light', 'Night', '新的分类'));
    }
}


?>

