<?php
/**
 * Wake on LAN script for remote PC power on
 *
 * This file is part of the wol.zip package.
 *
 * This software is licensed under the GNU General Public License (GPL).
 * You can redistribute it and/or modify it under the terms of the GPL.
 *
 * This software is provided as-is, without any warranty.
 * The author assumes no responsibility for any damages or issues arising from its use.
 *
 * Created by: Yachimau
 * https://ymch.jp/
 */

header('Content-Type: text/html; charset=UTF-8');

session_start();
require __DIR__ . '/config.php';

/* ===== WOL Transmission Function ===== */
function send_wol($host, $mac) {
    $mac = str_replace(array('-', ':'), '', $mac);
    if (strlen($mac) !== 12) return false;

    $packet = str_repeat(chr(0xFF), 6);
    for ($i = 0; $i < 16; $i++) {
        $packet .= pack('H12', $mac);
    }

    $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    socket_set_option($sock, SOL_SOCKET, SO_BROADCAST, 1);
    socket_sendto($sock, $packet, strlen($packet), 0, $host, WOL_PORT);
    socket_close($sock);

    return true;
}

/* ===== Log Recording ===== */
function write_log($message) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $line = date('Y-m-d H:i:s') . " [$ip] $message\n";

    $logs = file_exists(WOL_LOG_FILE)
        ? file(WOL_LOG_FILE, FILE_IGNORE_NEW_LINES)
        : array();

    $logs[] = trim($line);
    if (count($logs) > WOL_LOG_MAX) {
        $logs = array_slice($logs, -WOL_LOG_MAX);
    }

    file_put_contents(WOL_LOG_FILE, implode("\n", $logs) . "\n");
}

/* ===== Logout ===== */
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

/* ===== Login Process ===== */
if (isset($_POST['password'])) {
    if ($_POST['password'] === WOL_PASSWORD) {
        $_SESSION['auth'] = true;
    } else {
        $error = 'The password is incorrect.';
    }
}

/* ===== WOL Transmission Processing ===== */
if (isset($_SESSION['auth'], $_POST['targets'])) {
    foreach ($_POST['targets'] as $host) {
        if (isset($WOL_TARGETS[$host])) {
            send_wol($host, $WOL_TARGETS[$host]);
            write_log("WOL sent to $host");
        }
    }
    header('Location: redirect.html');
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">
<title>WOL Sender</title>

<style>
body {
    font-family: system-ui, sans-serif;
    text-align: center;
    margin-top: 4em;
}
#host_list {
    display: inline-block;
    width: fit-content;
    margin: 1em 0 2em;
    text-align: left;
    line-height: 200%;
}
#redirect {
    margin-top: .5em;
}
#logout {
    margin-top: 3em;
}
</style>

<script type="text/javascript">
function Confirmation() {
    const checkboxes = document.querySelectorAll('#host_list input[type="checkbox"]');
    for (const checkbox of checkboxes) {
        if (checkbox.checked) {
            document.getElementById('exec').target='_blank';
            return true;
        }
    }
    alert('Please Select Host(s).');
    return false;
}
</script>
</head>
<body>
<?php if (empty($_SESSION['auth'])): ?>
<h3>Login</h3>
<form method="post">
    <input type="password" name="password">
    <button type="submit">Login</button>
</form>
<?php if (!empty($error)) echo '<p style="color:red">'.$error.'</p>'; ?>
<?php else: ?>
<h1>Wake on LAN</h1>
<form id="exec" method="post" onsubmit="return Confirmation();">
    <div id="host_list">
<?php foreach ($WOL_TARGETS as $host => $mac): ?>
    <label>
        <input type="checkbox" name="targets[]" value="<?php echo htmlspecialchars($host, ENT_QUOTES, 'UTF-8'); ?>">
        <?php echo htmlspecialchars($host, ENT_QUOTES, 'UTF-8'); ?>
    </label><br>
<?php endforeach; ?>
    </div>
    <br>
    <button type="submit" style="font-size:150%;">Send WOL Packet</button><br>
    <div id="redirect">&raquo; <a href="redirect.html" target="_blank">Open Google Remote Desktop</a></div>
</form>
<p id="logout"><a href="?logout=1">Logout</a></p>
<?php endif; ?>
</body>
</html>
