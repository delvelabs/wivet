<?php
	require_once('../genclude.php');
?>
	<div style="margin-left: 40px;">
		<?php
			if(!isset($showbacklink)) {
				$showbacklink = true;
			}
			if(isset($_GET['id']) && !empty($_GET['id'])) {
				$scan = loadScan($_GET['id']);
			} else {
				$scan = loadScan();
			}
			if(!isset($scan['pageVisits'])) {
				$scan['pageVisits'] = array();
			}
			//html_print_r($scan, '$scan');
			//html_print_r($_SESSION['testcases'], '$_SESSION[testcases]');

			if(!empty($_GET['id']) && is_array($scan)) {
				if($showbacklink) {
					echo "<br/><a href='statistics.php'>BACK</a><br/><br/>";
				}
				$descEntries = loadLinksDesc();
				?>

				<table>
					<tr>
						<td>Coverage</td>
						<td>:&nbsp;&nbsp;<b><span id="coverage">%<?php echo intval(100*count($scan['pageVisits'])/count($descEntries)); ?></span></b></td>
					</tr>
					<tr>
						<td>From IP</td>
						<td>:&nbsp;&nbsp;<b><?php echo htmlentities($scan['ipaddress'], ENT_QUOTES);?></b></td>
					</tr>
					<tr>
						<td>Started On</td>
						<td>:&nbsp;&nbsp;<b><?php echo htmlentities(date('M dS Y h:i:s A', $scan['starttime']), ENT_QUOTES);?></b></td>
					</tr>
				</table>
				<br/>
				<span class="explanation">purple rows indicate missed cases, other rows indicate hit.</span>
				<br/><br/>
				<table class="list">
					<thead>
						<th>URI</th>
						<th>Description</th>
						<th>Number of Accesses</th>
<?php
				if(CHEATPROOF) {
					echo ' 						<th>Secret URI</th>'."\n";
				}
?>

						<th>User Agent</th>
						<th>First Seen</th>
						<th>Last Seen</th>
					</thead>
					<tbody>
				<?php

					/*
					 currenturlsvisited's structure
						every element's key is REQUEST_URI and value is array X
						there are one or elements in value array X;

							key: noofaccess
							value: how many times this link is fetched in this session

							key: timefirstaccess
							value: the time the link is fetched

							key: timelastaccess
							value: the time the link is fetched
					*/
					$i = 0;
					foreach ($scan['pageVisits'] as $k=>$v) {
						if($i%2 == 1) {
							$cls = "odd";
						} else {
							$cls = "even";
						}
						if(!isset($descEntries[$k])) {
							$descEntries[$k] = '';
						}
						echo "<tr class='" . $cls . "'>";
						echo "<td>" . $k . "</td>";
						echo "<td>" . $descEntries[$k] . "</td>";
						echo "<td>" . $v["noofaccess"] . "</td>";
						if(CHEATPROOF) {
							echo "<td>".$v["secreturi"].".php</td>";
						}
						if(strlen($v["useragent"]) < 70) {
							echo "<td>" . htmlentities($v["useragent"], ENT_QUOTES) . "</td>";
						} else {
							echo "<td>" . substr($v["useragent"], 0, 25) . " ... " . substr($v["useragent"], strlen($v["useragent"]) - 25, 25) . "</td>";
						}
						echo "<td>" . date('Y m d H:i:s', $v["timefirstaccess"]) . "</td>";
						echo "<td>" . date('Y m d H:i:s', $v["timelastaccess"]) . "</td>";
						echo "</tr>";
						$i++;
					}

					// list missed urls
					foreach ($descEntries as $k=>$v){
						if(!isset($scan['pageVisits']) || !array_key_exists($k, $scan['pageVisits'])){
							echo "<tr class='miss'>";
								echo "<td>" . $k . "</td>";
								echo "<td>" . $descEntries[$k] . "</td>";
								echo "<td>0</td>";
								if(CHEATPROOF) {
									echo "<td>??</td>";
									//echo '<td>'.$_SESSION['testcases'][$k].".php</td>";
								}
								echo "<td>N/A</td>";
								echo "<td>Never</td>";
								echo "<td>Never</td>";
							echo "</tr>";
						}
					}

				?>
					</tbody>
				</table>
				<br/>
				<br/>

				<?php
			} else {

                if(isset($_GET['rm_id']) && !empty($_GET['rm_id'])) {
                    if($_GET['rm_id'] == "ALL_ENTRIES"){
                        clearScans();
                    } else {
				        clearScan(intval($_GET['rm_id']));
				    }
                }


				$scans = listScans();
				$bots = loadBotsList();

				$descEntries = loadLinksDesc();
				//html_print_r($scans, '$scans');
				echo "<br/><br/>";
				//rsort($scans);
				//$brCount = 0;
                echo '<script>function deleteEntry(record){
                   if(window.prompt("2 + 2 = ?") === "4"){
                       window.location.href = "statistics.php?rm_id=" + record;
                   }
                }</script>';

				foreach($scans as $scan){
					// get a user agent, maybe I shouldn't store user agent in values
					//$scanEntries = saveScan($tokens[0]);
					$score = '%'. intval(100 * count($scan['pageVisits'])/count($descEntries));
					$scan['score'] = $score;
					//html_print_r($scan, '$scan');

					// is this scan performed by a bot listed in our list
					$isBot = false;
					foreach($bots as $aBot){
						if(@stripos($scan['useragent'], trim($aBot)) !== false){
							$isBot = true;
							break;
						}
					}

					// if this wasn't a bot then list it to the user
					if(!$isBot){

						echo '<a href="statistics.php?id='.$scan['record'] .'">'.htmlentities($scan['ipaddress'], ENT_QUOTES).' started on '.date('M dS Y h:i:s A',$scan['starttime']).'</a>&nbsp;&nbsp;(Coverage: '.htmlentities($scan['score'], ENT_QUOTES).')'.'&nbsp;&nbsp;&nbsp;&nbsp;[<a style="color:red;" href="#" onClick="deleteEntry('.$scan['record'] .')">delete</a>]' ;
						//$brCount++;
						//if($brCount%4 == 0)
						echo '<br/>';
					}
				}

				if(count($scans) == 0){
						echo "No statistics collected for now ...";
				} else {

                    echo '<script>function deleteAll(){
                       if(window.prompt("1 + 1 = ?") === "2"){
                           var id= "ALL_ENTRIES";
                           window.location.href = "statistics.php?rm_id=" + id;
                       }
                    }</script>';

                    echo '<br/><hr/><br/>[<a style="color:red;" href="#" onClick="deleteAll()">delete ALL ENTRIES</a>]';
				}
			}
			?>
	</div>
