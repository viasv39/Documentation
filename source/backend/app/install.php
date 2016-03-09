<?php
//	namespace libs\mysql;
	require_once '../config.php';
	
	$pdo  = null;
	$dbname = "tams";
	$sqlschema = "../db/schema.sql";
	$password = $_POST['pw'];
	
	// One connection through whole application     
	try {
		$pdo =  new PDO( "mysql:host=".DB_HOST, DB_USER, DB_PASSWORD);  
	}
	catch(PDOException $e) {
		die($e->getMessage());  
	}
		
		
	//-----------------------------------------------------------
	//---- CHECK INSTALLATION -----------------------------------
	//-----------------------------------------------------------
		
		
	$stmt = $pdo->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".$dbname."'");
	$exists = (bool) $stmt->fetchColumn();
	if($exists) {
		echo "<div style=\"text-align:center\"><br><br><br>Database Already Exists. <br>Setup Not Requried.<br><br></div>";
		exit(1);
	}
	
	if( !isset($_POST['pw'])) {
		echo "<div style=\"text-align:center\"><br><br><br>Please Enter An Admin Password:<br><form action=\"./install.php\" method=\"POST\"><input type='text' name='pw'><input type='submit' value='Create!'></form><br></div>";
		exit(0);
	}
	
	echo "<div style=\"text-align:center;\"><br><br><br>Installing....!<br><br></div>";
	
	
	//-----------------------------------------------------------
	//---- CREATE DATABSASE -------------------------------------
	//-----------------------------------------------------------
	
	
	$pdo->exec("CREATE DATABASE `$dbname`;") 
	or die(print_r($dbo->errorInfo(), true));
	
	
	//-----------------------------------------------------------
	//---- INSTALL SCHEMA ---------------------------------------
	//-----------------------------------------------------------
	
	$keywords = array(
		'ALTER', 'CREATE', 'DELETE', 'DROP', 'INSERT',
		'REPLACE', 'SELECT', 'SET', 'TRUNCATE', 'UPDATE', 'USE',
		'DELIMITER', 'END'
	    );
	# read file into array
	$file = file($sqlschema);
	# import file line by line
	# and filter (remove) those lines, beginning with an sql comment token
	$file = array_filter($file, create_function('$line', 'return strpos(ltrim($line), "--") !== 0;'));
	# and filter (remove) those lines, beginning with an sql notes token
	$file = array_filter($file, create_function('$line', 'return strpos(ltrim($line), "/*") !== 0;'));
	$sql = "";
	$del_num = false;
	foreach($file as $line){
		$query = trim($line);
		try
		{
			$delimiter = is_int(strpos($query, "DELIMITER"));
			if($delimiter || $del_num){
				if($delimiter && !$del_num ){
					$sql = "";
					$sql = $query."; ";
					echo "OK";
					echo "<br/>";
					echo "---";
					echo "<br/>";
					$del_num = true;
				}else if($delimiter && $del_num){
					$sql .= $query." ";
					$del_num = false;
					echo $sql;
					echo "<br/>";
					echo "do---do";
					echo "<br/>";
					$pdo->exec($sql);
					$sql = "";
				}else{                            
					$sql .= $query."; ";
				}
			}else{
				$delimiter = is_int(strpos($query, ";"));
				if($delimiter){
					$pdo->exec("$sql $query");
					echo "$sql $query";
					echo "<br/>";
					echo "---";
					echo "<br/>";
					$sql = "";
				}else{
					$sql .= " $query";
				}
			}
		}
		catch (\Exception $e){
			echo $e->getMessage() . "<br /> <p>The sql is: $query</p>";
		}
	}
	
	//-----------------------------------------------------------
	//---- INSERT USER ------------------------------------------
	//-----------------------------------------------------------
	
	//Insert User
	$firstname = "admin";
	$lastname = "admin";
	$username = "admin";
	$email = "noreply@csc190tams.com";
	$role = 0; //admin
	$password = password_hash($password, PASSWORD_DEFAULT);
	
	$assetSql = "INSERT INTO users (firstname,username, lastname, email, role, password) values(?, ?, ?, ?, ?, ?)";
	$assetQuery = $pdo->prepare($assetSql);
	$assetQuery->execute(array($firstname,$username, $lastname, $email, $role, $password));
	
	echo "<div style=\"text-align:center;\"><br><br><br>Install Completed Successfully!<br><br> Exiting...</div>";
	
	exit(0);
?>