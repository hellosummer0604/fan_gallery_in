<?php

function resource_url($path) {
	return base_url()."resource/".$path;
}

function repository_url($path) {
	return resource_url()."gallery/img_repository/$path";
}

function img_large_url($path) {
	return resource_url()."img_publish/img_large/$path";
}

function img_thumb_url($path) {
	return resource_url()."img_publish/img_thumb/$path";
}

function getStartEndOfPage($fullLen, $pageNo = 1, $pageSize = 80, $lastMin = 30) {
	$startNo = ($pageNo - 1) * $pageSize;
	$endNo = $startNo + $pageSize;
	
	if ( $pageNo != 1 && ($fullLen - $endNo < 0)) {
		return null;
	}
	
	if ($fullLen - $endNo < $lastMin) {
		$endNo = $fullLen;
	}
	
	return [$startNo, $endNo];
}

function responseJson($result = false, $msg = null, $errorMsg = null, $action = null, $data = null) {
	$VERSION = 0.1;

	return json_encode(array(
		'result'   => $result,
		'msg'      => $msg,
		'errorMsg' => $errorMsg,
		'action'   => $action,
		'data'     => $data,
		'version'  => $VERSION
	));
}

function br2newline($input) {
	$breaks = array("<br />","<br>","<br/>");

	return str_ireplace($breaks, PHP_EOL, $input);
}

function newline2br($input) {
	return str_replace(array("\r\n", "\r", "\n"), '<br>', $input);
}

function cutUserId($userId) {
	if (empty($userId)) {
		return null;
	}

	return substr($userId, 0, 32);
}

function isDev() {
	if(ENVIRONMENT == 'development') {
		return true;
	} else {
		return false;
	}
}
?>
