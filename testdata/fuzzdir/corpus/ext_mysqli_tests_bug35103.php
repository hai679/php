<?php

$drop = <<<EOSQL
DROP TABLE test_bint;
DROP TABLE test_buint;
EOSQL;
	require_once("connect.inc");

	$mysql = new my_mysqli($host, $user, $passwd, $db, $port, $socket);
	$mysql->query("DROP TABLE IF EXISTS test_bint");
	$mysql->query("CREATE TABLE test_bint (a bigint(20) default NULL) ENGINE=MYISAM");
	$mysql->query("INSERT INTO test_bint VALUES (9223372036854775807),(-9223372036854775808),(-2147483648),(-2147483649),(-2147483647),(2147483647),(2147483648),(2147483649)");

	$mysql->query("DROP TABLE IF EXISTS test_buint");
	$mysql->query("CREATE TABLE test_buint (a bigint(20) unsigned default NULL)");
	$mysql->query("INSERT INTO test_buint VALUES (18446744073709551615),(9223372036854775807),(9223372036854775808),(2147483647),(2147483649),(4294967295)");

	$stmt = $mysql->prepare("SELECT a FROM test_bint ORDER BY a");
	$stmt->bind_result($v);
	$stmt->execute();
	$i=0;
	echo "BIG INT SIGNED, TEST\n";
	while ($i++ < 8) {
		$stmt->fetch();
		echo $v, "\n";
	}
	$stmt->close();

	echo str_repeat("-", 20), "\n";

	$stmt = $mysql->prepare("SELECT a FROM test_buint ORDER BY a");
	$stmt->bind_result($v2);
	$stmt->execute();
	$j=0;
	echo "BIG INT UNSIGNED TEST\n";
	while ($j++ < 6) {
		$stmt->fetch();
		echo $v2, "\n";
	}
	$stmt->close();

	$mysql->multi_query($drop);

	$mysql->close();
?>
