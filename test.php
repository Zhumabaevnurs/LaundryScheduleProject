<?php
$a = array('a', 'b', 'c', 'd');
$b = array('a','e', 'f', 'g');
$c = array('h', 'i', 'j');
$d = array('k', 'l', 'm', 'n', 'o');

print_r(array_interlace($a, $b, $c, $d));
Array
(
[0] => a
[1] => v
[2] => h
[3] => k
[4] => b
[5] => e
[6] => i
[7] => l
[8] => c
[9] => f
[10] => j
[11] => m
[12] => d
[13] => g
[14] => n
[15] => o
)
?>
