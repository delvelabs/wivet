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
		
		// create a new connection when the button is clicked,
		// then directly send a message and after receiving it close the connection
		button1.addEventListener("click", function(event) {

			// open websocket connection
			socket1 = new WebSocket("ws://localhost:8181", "echo-protocol");

			// when connection is open
			socket1.addEventListener("open", function(event) {
				socket1.send('../innerpages/<?php tc('22_16e11'); ?>.php');
			});

			// when receiving message
			socket1.addEventListener("message", function(event) {
				message1.href = event.data;
				socket1.close();
			});

			// when error occures
			socket1.addEventListener("error", function(event) {
				message1.textContent = "Error: " + event;
				socket1.close();
			});

			// when connection should be closed
			socket1.addEventListener("close", function(event) {
			});
		});
	
		// create a new connection when the button is clicked,
		// then directly send a message and after receiving it close the connection
		button2.addEventListener("click", function(event) {

			// open websocket connection
			socket2 = new WebSocket("ws://localhost:8181", "echo-protocol");

			// when connection is open
			socket2.addEventListener("open", function(event) {
				socket2.send('../innerpages/<?php tc('22_abcde'); ?>.php');
			});

			// when receiving message
			socket2.addEventListener("message", function(event) {
				message1.href = event.data;
				var alink = document.createElement("a");
				alink.href = event.data;
		        alink.innerHTML = "click me 2";
		        div2.appendChild(alink);
				socket2.close();
			});

			// when error occures
			socket2.addEventListener("error", function(event) {
				message2.textContent = "Error: " + event;
				socket2.close();
			});

			// when connection should be closed
			socket2.addEventListener("close", function(event) {
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