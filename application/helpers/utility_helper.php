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


?>

