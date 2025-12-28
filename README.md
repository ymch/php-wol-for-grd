# Simple Wake on LAN Script (PHP)

A small and simple Wake on LAN helper script written in PHP,
designed for use with Google Remote Desktop.

This script allows you to remotely power on a PC in sleep or hibernate mode
using a web browser on a smartphone or other device.

---

## What is this?

This is a **Wake on LAN (WOL) script** for users of Google Remote Desktop.

While Google Remote Desktop is widely used,  
it does not provide a built-in way to power on a remote PC.
This script fills that gap.

---

## What does it do?

- Sends a WOL (Magic Packet) to a target PC
- Allows remote power-on from a web browser
- Works well together with Google Remote Desktop

---

## How do I use it?

If you manage a website, this should be self-explanatory.

1. Configure the required settings in `config.php`
2. Specify hostnames (or IP addresses) and MAC addresses
3. Set write permissions for the log file `wol.log`

To find the MAC address, run:

ipconfig /all

If you are already using Google Remote Desktop,  
you should be able to check it remotely.

---

## Prerequisites

- If the target PC does not have a fixed global IP address,
  a DDNS service is required.
- Configure your router to allow Wake on LAN packets.

**Router settings:**

- Protocol: UDP  
- Port:  
  - `9` for LAN  
  - `2304` for WAN (recommended)  
- Destination: Broadcast address within the LAN  
  - Example: `192.168.0.255` for `192.168.0.0/24`

**NIC (Ethernet) settings:**

- Wake on Magic Packet: Enabled
- Wake on pattern match: Enabled
- Shutdown Wake Up: Enabled
- Enable PME: Enabled

**Windows:**

- Disable *Fast Startup*
- Enable Wake on LAN in BIOS / UEFI

> Depending on the BIOS/UEFI, the PC may not wake from a full shutdown.
> In such cases, use *Hibernate* mode.

---

## License

This software is licensed under the  
**GNU General Public License version 2 (GPL v2)**.

It is free of charge.

The author assumes **no responsibility whatsoever**
for any damages or issues arising from the use of this script.

---

Author: Yachimau  
Website: https://ymch.jp/  
License: GPL v2  

Repository:
https://github.com/ymch/php-wol-for-grd
