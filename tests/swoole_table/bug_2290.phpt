--TEST--
swoole_table: bug_2290
--SKIPIF--
<?php require  __DIR__ . '/../include/skipif.inc'; ?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';

$table = new \OpenSwoole\Table(1024);
$table->column('h', \OpenSwoole\Table::TYPE_STRING, 128);
$table->column('b', \OpenSwoole\Table::TYPE_STRING, 1024 * 512);
$table->column('_e', \OpenSwoole\Table::TYPE_INT);
$table->create();

$headers = ['Content-Type' => 'text/html; charset=utf-8'];
$body = <<<EOS
<!DOCTYPE html><html lang="en"></html>
EOS;

$value = ['h' => json_encode($headers, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), 'b' => $body];
$value['_e'] = time(); // Remove this line and the result is correct
$table->set('test', $value);

echo $table->get('test', 'b');
?>
--EXPECT--
<!DOCTYPE html><html lang="en"></html>
