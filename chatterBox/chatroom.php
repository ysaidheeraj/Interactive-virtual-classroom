<?php
session_start();
 ?>
<script>
	
	
setInterval("users()",3000);

	
	function users(){
	xhr1 = new XMLHttpRequest();
	xhr1.open('POST' , 'userFetch.php' , true);
	xhr1.setRequestHeader('content-type','application/x-www-form-urlencoded');
	xhr1.send();
	xhr1.onreadystatechange = function(){
	//	alert(xhr.responseText);
			document.getElementById('loginperson').innerHTML = xhr1.responseText;
			}
		
		
		}
		
		
</script>
<?php

include_once('config.php');

?>

<div id="loginperson">
</div>


</div>
<style>

				#loginperson {
					/*width:238px;
					height:497px;
					border:double;*/
					float:left;}
</style>
 
 
 
 