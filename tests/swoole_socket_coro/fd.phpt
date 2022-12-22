--TEST--
swoole_socket_coro: fd
--SKIPIF--
<?php require __DIR__ . '/../include/skipif.inc'; ?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';
$sockets = [];
for ($n = MAX_REQUESTS; $n--;) {
    $sockets[] = new OpenSwoole\Coroutine\Socket(AF_INET, SOCK_STREAM, IPPROTO_IP);
    if (count($sockets) > 1) {
        Assert::assert(end($sockets)->fd === prev($sockets)->fd + 1);
    }
}
echo "DONE\n";
?>
--EXPECT--
DONE
