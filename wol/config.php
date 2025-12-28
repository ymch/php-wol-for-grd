<?php
/**
 * Configuration file for Wake on LAN script
 *
 * This file is part of the wol.zip package.
 *
 * This software is licensed under the MIT License.
 * See the LICENSE file for details.
 *
 * This software is provided as-is, without any warranty.
 * The author assumes no responsibility for any damages or issues arising from its use.
 *
 * Created by: Yachimau
 * https://ymch.jp/
 */

// ===== Authentication =====
define('WOL_PASSWORD', '**********'); // Set Your Password

// ===== WOL Destination Address =====
$WOL_TARGETS = array(
    // List hostnames and MAC addresses separated by commas.
    // [HostName or IP Address] => [MAC Address],
    'example1.com' => '00-00-00-00-00-00',
    'example2.com' => '11-11-11-11-11-11',
    'example3.com' => '22-22-22-22-22-22',
);

// ===== WOL Port =====
define('WOL_PORT', 2304); // 2304 or 9

// ===== Log File =====
define('WOL_LOG_FILE', __DIR__ . '/wol.log');
define('WOL_LOG_MAX', 100); // Number of Log Entries Saved

