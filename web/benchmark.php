<?php

function testCPU() {
    $start = microtime(true);
    $num = 1;
    for ($i = 0; $i < 1000000; $i++) {
        $num = $num * 2;
        $num = sqrt($num);
        $num = log($num);
    }
    return microtime(true) - $start;
}

function testMemory() {
    $start = microtime(true);
    $array = [];
    for ($i = 0; $i < 1000000; $i++) {
        $array[] = $i;
    }
    unset($array);
    return microtime(true) - $start;
}

function testDisk() {
    $start = microtime(true);
    $filename = 'testfile.tmp';
    $data = str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890', 1000);
    file_put_contents($filename, $data);
    $content = file_get_contents($filename);
    unlink($filename);
    return microtime(true) - $start;
}

$cpuTime = testCPU();
$memoryTime = testMemory();
$diskTime = testDisk();

echo "Server Benchmark Results:\n";
echo "CPU Time: " . round($cpuTime, 5) . " seconds\n";
echo "Memory Allocation Time: " . round($memoryTime, 5) . " seconds\n";
echo "Disk Read/Write Time: " . round($diskTime, 5) . " seconds\n";
