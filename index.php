<!DOCTYPE HTML>
<html>
<head>
<title>Ip/Host Ping Api</title>
<link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body>

<div class="header">
	<input type="text" maxlength="256" autocomplete="off" id="searchKey"/>
	<button id="btnSearch">Search</button>
	<button id="btnAdd">New IP/Host</button>
</div>

<div class="leftArea">
	<form id="ipForm">
		<div style="display:none;">
			<label>Id:</label>
			<input id="ipId" name="id" type="text" autocomplete="off" disabled />
		</div>
		<label>IP/Host:</label>
		<input type="text" id="ip_host" name="ip_host" maxlength="256" autocomplete="off" required>
		<button id="btnSave">Save</button>
		<button id="btnDelete">Delete</button>
	</form>
</div>

<div class="mainArea">
	<ul id="ipList"></ul>
</div>

<div class="rightArea">
	<iframe id="status_data" width="750" height="auto" border="0" src="api/ips/status/"></iframe>
</div>

<script src="assets/js/jquery-1.7.1.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>