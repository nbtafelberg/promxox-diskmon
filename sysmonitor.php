<?php
/**
 * Proxmox Cluster Disk space monitor.
 * - On the cluster master set up posix so that it can send email
 * - install php php-mysql (remove apache2 afterwards)
 * - set up a crontab to run every hour with php /root/sysmonitor.php < assuming thats where you put it
 * - when disk space gets over 80% full you will get hourly emails to tell you
 */
/**
 * Format the data
 * @param type $itemdata
 * @return type
 */

function df($itemdata) {
    return round($itemdata / 1024 / 1024 / 1024, 2) . "gb";
}
// dump the cluster data to a file
shell_exec("pvesh get /cluster/resources --output-format json > /root/monitor.json");

$data = file_get_contents("/root/monitor.json");
$data = json_decode($data);

foreach ($data as $item) {
    $id = $item->id;
    // you can add in anything else you want to test for
    if (strpos($id, "lxc") !== false || strpos($id,"lvm")!==false) {
        $diskpercent = round((($item->disk / $item->maxdisk) * 100), 2);
        $message = $item->id . " " . $item->name . " " . df($item->disk) . " " . df($item->maxdisk) . " " . round((($item->disk / $item->maxdisk) * 100), 2) . "% " . PHP_EOL;
        if ($diskpercent > 80) {
            echo "***" . $message . "***";
            shell_exec('echo "' . $message . '" | mail -s "***DISK SPACE WARNING***" YOUR_EMAIL_ADDRESS_TO_SEND_TO');
        } else {
            echo $message;
        }
    }
}







