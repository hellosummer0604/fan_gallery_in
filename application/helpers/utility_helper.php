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

?>

