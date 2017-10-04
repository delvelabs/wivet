<?php
	// before you can run these tests, start the node js server
	// you can find in js/nodejs/echo_server.js by running:
	// 			node echo_server.js
	define('NOSTARTBODY', true);
	require_once('../genclude.php');
?>

<script>
	"use strict";
	window.addEventListener("load", function(event) {

		var socket1;
		var button1 = document.getElementById("button1");
		var message1 = document.getElementById("message1");
		var socket2;
		var button2 = document.getElementById("button2");
		var div2 = document.getElementById("div2");
		var socket3;
		var button3 = document.getElementById("button3");
		var div3 = document.getElementById("div3");
		
		// override href in existing <a> with direct link
		button1.addEventListener("click", function(event) {

			socket1 = new WebSocket("ws://localhost:8181", "echo-protocol");

			socket1.addEventListener("open", function(event) {
				socket1.send('../innerpages/<?php tc('22_16e11'); ?>.php');
			});

			socket1.addEventListener("message", function(event) {
				message1.href = event.data;
				socket1.close();
			});

			socket1.addEventListener("error", function(event) {
				message1.textContent = "Error: " + event;
				socket1.close();
			});
			
			socket1.addEventListener("close", function(event) {
			});
		});
	
		// create new <a> with direct link
		button2.addEventListener("click", function(event) {

			socket2 = new WebSocket("ws://localhost:8181", "echo-protocol");

			socket2.addEventListener("open", function(event) {
				socket2.send('../innerpages/<?php tc('22_abcde'); ?>.php');
			});

			socket2.addEventListener("message", function(event) {
				var alink = document.createElement("a");
				alink.href = event.data;
		        alink.innerHTML = "click me 2";
		        div2.appendChild(alink);
				socket2.close();
			});

			socket2.addEventListener("error", function(event) {
				message2.textContent = "Error: " + event;
				socket2.close();
			});

			socket2.addEventListener("close", function(event) {
			});
		});

		// create new <a> with created link
		button3.addEventListener("click", function(event) {

			socket3 = new WebSocket("ws://localhost:8181", "echo-protocol");

			socket3.addEventListener("open", function(event) {
				socket3.send('innerpages,<?php tc('22_8590a.php'); ?>');
			});

			socket3.addEventListener("message", function(event) {
				var alink = document.createElement("a");
				var substrings = event.data.split(',');
				alink.href = "../".concat(substrings[0], "/", substrings[1]);
		        alink.innerHTML = "click me 3";
		        div3.appendChild(alink);
				socket3.close();
			});
			
			socket3.addEventListener("error", function(event) {
				message3.textContent = "Error: " + event;
				socket3.close();
			});

			socket3.addEventListener("close", function(event) {
			});
		});
	});
</script>

<?php html_body();  ?>
<div id="div1">
	<input id="button1" type="button" value="Click Me" /><br />
	<a href=# id="message1">Link</a>
</div>
<div id="div2">
	<input id="button2" type="button" value="Click Me" /><br />
</div>
<div id="div3">
	<input id="button3" type="button" value="Click Me" /><br />
</div>