<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $pageTitle; ?></title>
	<!-- favicons***************************************** -->
	<!-- Opera speed dial icon -->
    <link rel="icon" type="image/png" href="assets/icons/195x195image.png">
	<!-- display largest first as iOS < 4.2 does not support size attr -->
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/icons/apple-touch-icon-114x114-precomposed.png">
	<!-- For iPad: apple doesn't need this but andoid OS (2.1+) does -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/icons/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" href="assets/icons/touch-icon-iphone.png" />
	<!-- browser should find ICO file by default without <link> -->
	<link rel="icon" type="image/png" href="assets/icons/favicon.png" />
	<!--[if IE]><link rel="shortcut icon" href="pathto/favicon.ico"><![endif]-->
	<!-- or, set /favicon.ico for IE10 win -->
	<meta name="msapplication-TileColor" content="#2E8D61">
	<meta name="msapplication-TileImage" content="assets/icons/tileicon.png">
	<!-- stylesheets******************************************************** -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/<?php echo $pagecss; ?>">	
</head>