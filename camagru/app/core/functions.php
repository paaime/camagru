<?php

function show($stuff)
{
	echo "<pre>";
	print_r($stuff);
	echo "</pre>";
}

function esc($str)
{
	return htmlspecialchars($str);
}

function redirect($path)
{
	header("Location: " . ROOT . "/" . $path);
	die;
}

function debug_to_console($data)
{
	$output = $data;
	if (is_array($output))
		$output = implode(',', $output);

	echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function is_logged_in()
{
	if (!isset($_SESSION['USER'])) {
		header('Location: ' . ROOT . '/login');
		exit();
	} else {
		return true;
	}
}

function is_logged_in_request()
{
	if (!isset($_SESSION['USER'])) {
		return false;
	} else {
		return true;
	}
}