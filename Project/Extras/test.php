<?php	// debug error reorting	// override the server configuration	// this code must precede the script itself	// argh	if ( ! defined ( 'E_NONE' ) ) {		define ( 'E_NONE', 0 );	}	// make sure we are clean (just in case)	$display_errors = 0; // not a boolean;	$error_level = $display_errors ? E_ALL | E_STRICT : E_NONE;	ini_set ( 'display_errors', $display_errors );	error_reporting ( $error_level );	// fin debug error reorting/**	File for testing the BaseElements Plug-In HTTP functions	echo both the full HTTP headers for the request and any POST arguments, username & password and the HTTP method back to the user-agent	@project	BaseElements Plug-In	@link		https://github.com/nickorr/BaseElements-Plugin	@version	1.0.6	@since		January 20, 2015	@author		Mark Banks, https://github.com/minstral*/	define ( 'TEST_SCRIPT_VERSION', '1.0.6' );/**	format key value pairs	@param string $key the name	@param string $value the value	@return string the formatted key value pair*/	function format_key_value_pair ( $key, $value ) {		return $key . ": " . $value;	}/**	print out the key value pairs from the supplied has as HTML	@param hash $hash a hash (sic)	@return NULL*/	function print_hash ( $hash ) {		foreach ( $hash as $key => $value ) {			echo format_key_value_pair ( $key, $value ) . '<br>';		}	}/**	print out line of text with a label, to be used between PRE tags	@param string $label a descriptive label or title	@param string $line the text to display	@return NULL*/	function print_line ( $label, $line ) {		echo format_key_value_pair ( $label, $line ) . "\n";	}/**	extract an element from an array without generating e_notice 'errors'	when the key is not set	@param array $array the array to access	@param string $key the array element to retrieve	@return string the value for the key or an empty string when the key is not set*/	function value_for_key ( $array, $key ) {		$value = '';		if ( isset ( $array [ $key ] ) ) {			$value = $array [ $key ];		}		return $value;	}?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"><html lang="en"><head>	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	<title>BaseElements Plug-In HTTP Test Helper</title></head><body><?php	// make sure we ask for the username and password (if available)	$realm = "BaseElements Plug-In";	header ( 'WWW-Authenticate: Digest realm="' . $realm . '",qop="auth",nonce="' . uniqid() . '",opaque="' . md5 ( $realm ) . '"' );	header ( 'HTTP/1.0 401 Unauthorized' );	echo '<pre>';	print_line ( 'Test Script Version', TEST_SCRIPT_VERSION );	print_line ( 'Method', value_for_key ( $_SERVER, 'REQUEST_METHOD' ) );	print_line ( 'Path', value_for_key ( $_SERVER, 'REQUEST_URI' ) );	print_line ( 'Username', value_for_key ( $_SERVER, 'PHP_AUTH_USER' ) );	print_line ( 'Password', value_for_key ( $_SERVER, 'PHP_AUTH_PW' ) );	print_line ( 'Digest', value_for_key ( $_SERVER, 'PHP_AUTH_DIGEST' ) );	print_line ( 'Referrer', value_for_key ( $_SERVER, 'HTTP_REFERER' ) );	// POST Args	print_hash ( $_POST );	// PUT Data	echo file_get_contents ( 'php://input' );	echo '</pre>';?><hr /><?php	// HTTP Headers	print_hash ( getallheaders() );?></body></html>