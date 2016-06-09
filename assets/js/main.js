// The root URL for the RESTful services
var rootURL = "api/ips";

var currentIp;

// Retrieve ee_iprecord list when application starts 
findAll();

// Nothing to delete in initial application state
$('#btnDelete').hide();

$(function () {
	setInterval(function () {
		var x = $('iframe').attr('src');
		$('iframe').attr('src', x);
	}, 50000);
});

// Register listeners
$('#btnSearch').click(function() {
	search($('#searchKey').val());
	return false;
});

// Trigger search when pressing 'Return' on search key input field
$('#searchKey').keypress(function(e){
	if(e.which == 13) {
		search($('#searchKey').val());
		e.preventDefault();
		return false;
    }
});

$('#btnAdd').click(function() {
	newIp();
	return false;
});

$('#btnSave').click(function() {
	if ($('#ipId').val() == '')
		addIp();
	else
		updateIp();
	return false;
});

$('#btnDelete').click(function() {
	deleteIp();
	return false;
});

$('#ipList a').live('click', function() {
	findById($(this).data('identity'));
});


function search(searchKey) {
	if (searchKey == '') 
		findAll();
	else
		findByName(searchKey);
}

function newIp() {
	$('#btnDelete').hide();
	currentIp = {};
	renderDetails(currentIp); // Display empty form
}

function findAll() {
	console.log('findAll');
	$.ajax({
		type: 'GET',
		url: rootURL,
		dataType: "json", // data type of response
		success: renderList
	});
}

function findByName(searchKey) {
	console.log('findByName: ' + searchKey);
	$.ajax({
		type: 'GET',
		url: rootURL + '/search/' + searchKey,
		dataType: "json",
		success: renderList 
	});
}

function findById(id) {
	console.log('findById: ' + id);
	$.ajax({
		type: 'GET',
		url: rootURL + '/' + id,
		dataType: "json",
		success: function(data){
			$('#btnDelete').show();
			console.log('findById success: ' + data.name);
			currentIp = data;
			renderDetails(currentIp);
		}
	});
}

function addIp() {
	console.log('addIp');
	$.ajax({
		type: 'POST',
		contentType: 'application/json',
		url: rootURL,
		dataType: "json",
		data: formToJSON(),
		success: function(data, textStatus, jqXHR){
			alert('Ip created successfully');	
			$('#btnDelete').show();
			$('#ipId').val(data.id);
			location.reload();
		},
		error: function(jqXHR, textStatus, errorThrown){
			alert('addIp error: ' + textStatus);
		}
	});
}

function updateIp() {
	console.log('updateIp');
	$.ajax({
		type: 'PUT',
		contentType: 'application/json',
		url: rootURL + '/' + $('#ipId').val(),
		dataType: "json",
		data: formToJSON(),
		success: function(data, textStatus, jqXHR){
			alert('Ip updated successfully');
			location.reload();
		},
		error: function(jqXHR, textStatus, errorThrown){
			alert('updateIp error: ' + textStatus);
		}
	});
}

function deleteIp() {
	console.log('deleteIp');
	$.ajax({
		type: 'DELETE',
		url: rootURL + '/' + $('#ipId').val(),
		success: function(data, textStatus, jqXHR){
			alert('Ip deleted successfully');
			location.reload();
		},
		error: function(jqXHR, textStatus, errorThrown){
			alert('deleteIp error');
		}
	});
}

function renderList(data) {
	// JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
	var list = data == null ? [] : (data.ee_iprecord instanceof Array ? data.ee_iprecord : [data.ee_iprecord]);

	$('#ipList li').remove();
	$.each(list, function(index, ee_iprecord) {
		$('#ipList').append('<li><a href="#" data-identity="' + ee_iprecord.id + '">'+ee_iprecord.ip_host+'</a></li>');
	});
}

function renderDetails(ee_iprecord) {
	$('#ipId').val(ee_iprecord.id);
	$('#ip_host').val(ee_iprecord.ip_host);
}

// Helper function to serialize all the form fields into a JSON string
function formToJSON() {
	return JSON.stringify({
		"id": $('#ipId').val(), 
		"ip_host": $('#ip_host').val()
		});
}