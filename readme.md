# Web Application Ip/Host Ping Api.

## Introduction
Ip/Host Ping Api is get ping time for any listed records. Slim framework is used to develop this application.. 

## Features
* CRUD operations for IP/Host.
* Functions are
* * Search - To search for desired IP/Host
* * IP/Host add/modify/delete - To add/modify/delete the selected IP/Host
* * IP/Host listing - Listing of saved IP/Host
* * Status listing - Listing of response status from IP/Host

## REST API methods
* GET 	/api/ips 	           	Retrieve all ips/host
* GET 	/api/ips/search/trade 	Search for ips/host with keyword e.g‘google’
* GET 	/api/ips/status/ 		Retrieve IP/Host response time/status
* GET 	/api/ips/13 			Retrieve IP/Host with e.g id == 13
