<?php
	require_once("connect.inc");
	if (!$c1 = my_mysqli_connect($host, $user, $passwd, $db, $port, $socket)) {
		printf("Cannot connect to the server using host=%s, user=%s, passwd=***, dbname=%s, port=%s, socket=%s\n",
			$host, $user, $db, $port, $socket);
		exit(1);
	}
	if (!$c2 = my_mysqli_connect($host, $user, $passwd, $db, $port, $socket)) {
		printf("Cannot connect to the server using host=%s, user=%s, passwd=***, dbname=%s, port=%s, socket=%s\n",
			$host, $user, $db, $port, $socket);
		exit(1);
	}

	$c1->query("use $db");
	$c2->query("use $db");
	$c1->query("drop table if exists type_change");
	$c1->query("create table type_change(a int, b char(10)) ENGINE = " . $engine);
	$c1->query("insert into type_change values (1, 'one'), (2, 'two')");
	$s1 = $c1->prepare("select a from type_change order by a");
	var_dump($s1->execute(), $s1->bind_result($col1));
	echo "---- Row 1\n";
	var_dump($s1->fetch());
	var_dump($col1);
	echo "---- Row 2\n";
	var_dump($s1->fetch());
	var_dump($col1);
	echo "---- Row 3\n";
	var_dump($s1->fetch());
	echo "----\n";

	echo "ALTER\n";
	var_dump($c2->query("alter table type_change drop a"));
	var_dump($s1->execute());
	var_dump($c1->error);

	echo "---- Row 1\n";
	var_dump($s1->fetch());
	var_dump($col1);
	echo "---- Row 2\n";
	var_dump($s1->fetch());
	var_dump($col1);
	echo "---- Row 3\n";
	var_dump($s1->fetch());
	echo "----\n";

	echo "done!";
?>
