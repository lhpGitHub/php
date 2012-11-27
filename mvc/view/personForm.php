<?php 
$msg = SessionRegistry::getFlashVars('msg');
if($msg) {
	echo "<div>$msg</div><br/>";
}

$person = $request->getData('person');
extract($person);

if($request->getActionName() == 'update')
	$action = $request->getAbsolutePath().'/person/update/'.$id.'/';
else
	$action = $request->getAbsolutePath().'/person/create/';

$back = $request->getAbsolutePath().'/person/read/';


?>

<div>
	<form name="person" action="<?= $action ?>" method="get">
    <p>
		<label for="firstname">first name: </label>
		<input type="text" id="fName" value="<?= $fName ?>"><br>
		<label for="lastname">last name: </label>
		<input type="text" id="lName" value="<?= $lName ?>"><br>
		<input type="hidden" id="fSend" value="1"><br>
		<input type="submit" id="submit" value="send" onclick="return send()">
	</p>
 </form>
</div>
<div><a href="<?= $back ?>">BACK</a></div>

<script>
	function send() {
		var form = document.forms["person"];
		var fName = form["fName"].value;
		var lName = form["lName"].value;
		var fSend = form["fSend"].value;
		form.action += fName + '/' + lName + '/' + fSend;
	}
</script>