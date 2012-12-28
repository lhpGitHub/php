<form action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="text" name="reg" size="150" value="<?php echo $_REQUEST['reg']; ?>">
	<input type="submit">
</form>

<?php
header('Content-Type: text/html; charset=utf-8');


$multiLineText = file_get_contents('wierszyk.txt');
$signleLineText = "A skądże to, jakże to, czemu tak gna? A co to to, co to to, kto to tak pcha? Że pędzi, że wali, że bucha, buch-buch? To para gorąca wprawiła to w ruch, To para, co z kotła rurami do tłoków, A tłoki kołami ruszają z dwóch boków I gnają, i pchają, i pociąg się toczy, Bo para te tłoki wciąż tłoczy i tłoczy, I koła turkocą, i puka, i stuka to: Tak to to, tak to to, tak to to, tak to to!...";

echo '----------jednowierszowy ciag znakow----------<br>';
echo $signleLineText.'<br><br>';
if(isset($_REQUEST['reg']) && !empty($_REQUEST['reg'])) {
	echo pregMatch($signleLineText, $_REQUEST['reg']).'<br>';
	echo pregMatchAll($signleLineText, $_REQUEST['reg']);
}

echo '<br><br>';
echo '----------wielowierszowy tekst z pliku----------<br>';
echo nl2br($multiLineText).'<br><br>';
if(isset($_REQUEST['reg']) && !empty($_REQUEST['reg'])) {
	echo pregMatch($multiLineText, $_REQUEST['reg']).'<br>';
	echo pregMatchAll($multiLineText, $_REQUEST['reg']);
}

function pregMatch($s, $reg) {
	$matches = null;
	preg_match($reg, $s, $matches);
	return 'pregMatch<br>:'.var_export($matches, TRUE);
}

function pregMatchAll($s, $reg) {
	$matches = null;
	preg_match_all($reg, $s, $matches);
	return 'pregMatchAll<br>:'.var_export($matches, TRUE);
}