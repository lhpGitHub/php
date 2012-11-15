<?php

$a = 'abc';
print '<br/>settype string na array';
print '<br/>oryginal przed: '; print_r($a);
settype($a, 'array');
print '<br/>oryginal po: '; print_r($a);
print '<br/>--------------------';

$a = 'abc';
print '<br/>settype string na boolean';
print '<br/>oryginal przed: '; var_dump($a);
settype($a, 'boolean');
print '<br/>oryginal po: '; var_dump($a);
print '<br/>--------------------';

$a = '';
print '<br/>settype pusty string na boolean';
print '<br/>oryginal przed: '; var_dump($a);
settype($a, 'boolean');
print '<br/>oryginal po: '; var_dump($a);
print '<br/>--------------------';


?>
