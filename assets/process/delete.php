<?php
session_start();
include "../connection.php";
require_once "../functions.php";
sessionTimeout(); 


		$delete = $db->prepare("DELETE FROM fliers WHERE id=:ID;");
		$delete->bindParam(":ID",$_GET['ID']);
		$delete->execute();

		dbClose();
		
		redirect('list');

 ?>