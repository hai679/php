<?php

file_put_contents('SplFileObject_rewind_error001.csv', 'eerste;tweede;derde');

$fo = new SplFileObject('SplFileObject_rewind_error001.csv');

$fo->rewind( "invalid" );

?>
