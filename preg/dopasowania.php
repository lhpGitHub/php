<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<input type="text" name="reg" size="150" value="<?php echo $_REQUEST['reg']; ?>">
	<input type="submit">
</form>

<?php
header('Content-Type: text/html; charset=utf-8');


$multiLineText = file_get_contents('wierszyk.txt');
$signleLineText = 'A co to to, co to to, kto to tak pcha? Ze pedzi, ze wali, ze bucha, buch-buch? To para goraca wprawila to w ruch, To para, co z kotla rurami do tlokow, A tloki kolami ruszaja z dwoch bokow I gnaja, i pchaja, i pociag sie toczy, Bo para te tloki wciaz tloczy i tloczy, I kola turkoca, i puka, i stuka to: Tak to to, tak to to, tak to to, tak to to!...';

echo '----------jednowierszowy ciag znakow----------<br>';
echo $signleLineText.'<br><br><pre>';
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