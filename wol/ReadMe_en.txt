What is this?

    This is a "Wake on LAN script to remotely power on your PC"
    for users of Google Remote Desktop.
    While many people use Google Remote Desktop,
    there's no built-in way to power on the remote PC.

What does it do?

    Using a smartphone or similar device,
    turn on the power to a PC that is currently off (in sleep mode),
    and access to Google Remote Desktop will be completed smoothly.

How do I use it?

    If you manage a website, this should be self-explanatory:
    Simply configure the necessary details in config.php.
    To find the MAC address, run "ipconfig /all" in Command Prompt or similar.
    If you're already using Google Remote Desktop,
    you should be able to check it remotely.
    Also, make sure the log file "wol.log" has write permissions.

Prerequisites

    If the target PC does not have a fixed IP address for its internet connection,
    use of a DDNS service is required.
    Numerous free services are available,
    so please arrange one yourself.

    Ensure your router has the Wake on LAN port open beforehand.
    Protocol: UDP
    Port: 2304 or 9 (Within a LAN, port 9 is often used.)
    Destination: Broadcast address within the LAN (last IP address)
    Example: For a LAN like 192.168.0.0/24 (192.168.0.1 and above)
        “192.168.0.255”

    Enable Wake on LAN in your NIC (Ethernet) settings.
    * Wake on Magic Packet: Enabled
    * Wake on pattern match: Enabled
    * Shutdown Wake Up: Enabled
    * Enable PME: Enabled
      ...etc.

    On Windows, disable "Fast Startup".
    Also, locate and enable the Wake on LAN setting in your PC's BIOS.

    Depending on your PC's BIOS (UEFI),
    it may not wake up from a power-off (shutdown) state.
    In such cases, use "Hibernate" mode.

This software is licensed under the GPL v2. Naturally, it is free of charge.
Furthermore, the author assumes no responsibility whatsoever for any damages
or other issues arising from the use of this script.

Source code is available on GitHub
(ZIP download is provided for convenience)
https://github.com/ymch/php-wol-for-grd


Created by: Yachimau
https://ymch.jp/
