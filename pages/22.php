<?php
	define('NOSTARTBODY', true);
  require_once('../genclude.php');
?>
<script>
	"use strict";
	// Initialize everything when the window finishes loading
	window.addEventListener("load", function(event) {

		var socket1;
		var button1 = document.getElementById("button1");
		var message1 = document.getElementById("message1");
	
		// create a new connection when the button is clicked,
		// then directly send a message and after receiving it close the connection
		button1.addEventListener("click", function(event) {
			socket1 = new WebSocket("ws://localhost:8181", "echo-protocol");
			
			socket1.addEventListener("open", function(event) {
				socket1.send('../innerpages/<?php tc('22_16e11'); ?>.php');
			});
	
			socket1.addEventListener("message", function(event) {
				message1.href = event.data;
				socket1.close();
			});
	
			// Display any errors that occur
			socket1.addEventListener("error", function(event) {
			message1.textContent = "Error: " + event;
			});
	
			socket1.addEventListener("close", function(event) {
			});
		});
	});
</script>
<?php html_body();  ?>
  <div>
  	<input id="button1" type="button" value="Click Me" /><br />
  	<a href=# id="message1">Link</a>
  </div>