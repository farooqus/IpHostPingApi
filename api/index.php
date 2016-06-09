<?php
require 'Slim/Slim.php';

$app = new Slim();

$app->get('/ips', 'getIps');
$app->get('/ips/:id', 'getIp');
$app->get('/ips/search/:query', 'findByName');
$app->get('/ips/status/', 'getStatus');
$app->post('/ips', 'addIp');
$app->put('/ips/:id', 'updateIp');
$app->delete('/ips/:id',	'deleteIp');

$app->run();

function getIps() {
	$sql = "SELECT id,ip_host FROM ee_iprecord ORDER BY ip_host";
	try {
		$db = getConnection();
		$stmt = $db->query($sql);  
		$ips = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"ee_iprecord": ' . json_encode($ips) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getStatus() {
	$sql = "SELECT distinct(ip_host),id FROM  ee_iprecord";
	try {
		$db = getConnection();
		$stmt = $db->query($sql);  
		//$data = $stmt->fetchAll(PDO::FETCH_OBJ);		
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($data as $row) {
		   $content[] = pingHost($row['ip_host']);		   
		}
		$db = null;
		echo json_encode($content);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}	
}

function pingHost($data_host){
    $starttime = microtime(true);
    $file      = @fsockopen($data_host, 80, $errno, $errstr, 10);
    $stoptime  = microtime(true);
    $status    = 0;

    if (!$file){
        $status = "null"; 
    }
    else{
        fclose($file);
        $status = ($stoptime - $starttime) * 1000;
        $status = floor($status);
		$status = array($data_host => $status);
    }
    return $status;
}

function getIp($id) {
	$sql = "SELECT id,ip_host FROM ee_iprecord WHERE id=:id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$ee_iprecord = $stmt->fetchObject();  
		$db = null;
		echo json_encode($ee_iprecord); 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function addIp() {
	$request = Slim::getInstance()->request();
	$ee_iprecord = json_decode($request->getBody());
	// for multiple host/ip add can be added
	// $array = get_object_vars($ee_iprecord);
	//	$string = 'google.com,192.168.0.1,127.0.0.1,bad_host';
	//$array = explode(',', $string);

	$sql = "INSERT INTO ee_iprecord (ip_host) VALUES (:ip_host)";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("ip_host", $ee_iprecord->ip_host);
		$stmt->execute();
		$ee_iprecord->id = $db->lastInsertId();
		$db = null;
		echo json_encode($ee_iprecord); 
	} catch(PDOException $e) {
		error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function updateIp($id) {
	$request = Slim::getInstance()->request();
	$body = $request->getBody();
	$ee_iprecord = json_decode($body);
	$sql = "UPDATE ee_iprecord SET ip_host=:ip_host WHERE id=:id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("ip_host", $ee_iprecord->ip_host);
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$db = null;
		echo json_encode($ee_iprecord); 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function deleteIp($id) {
	$sql = "DELETE FROM ee_iprecord WHERE id=:id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$db = null;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function findByName($query) {
	$sql = "SELECT id,ip_host FROM ee_iprecord WHERE UPPER(ip_host) LIKE :query ORDER BY ip_host";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$query = "%".$query."%";  
		$stmt->bindParam("query", $query);
		$stmt->execute();
		$ips = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"ee_iprecord": ' . json_encode($ips) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getConnection() {
	$dbhost="localhost";
	$dbuser="root";
	$dbpass="";
	$dbname="iptestapi";
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbh;
}
?>