<?php
function df($itemdata) {
    return round($itemdata / 1024 / 1024 / 1024, 2) . "gb";
}

$freespace=disk_free_space("/");
$totalspace=disk_total_space("/");
$percent=round(($freespace/$totalspace)*100,2);
echo df($freespace) ." ".df($totalspace) . " " . $percent . "%" . PHP_EOL;

if ($percent>80) {
    $message="Server " . getHostName() . " is running out of disk space";
    shell_exec('echo "' . $message . '" | mail -s "***DISK SPACE WARNING***" sales@garagemasteronline.com');
}