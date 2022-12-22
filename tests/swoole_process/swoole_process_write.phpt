--TEST--
swoole_process: write
--SKIPIF--
<?php require __DIR__ . '/../include/skipif.inc'; ?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';

$proc = new \swoole_process(function(\swoole_process $process) {
    $r = $process->write("SUCCESS");
    Assert::same($r, 7);
});
$r = $proc->start();
Assert::assert($r > 0);

swoole_timer_after(10, function() use($proc) {
    echo $proc->read();
});

OpenSwoole\Event::wait(true);
?>
--EXPECT--
SUCCESS
