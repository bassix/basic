# Ubuntu

For the whole development process, the **[Ubuntu](https://ubuntu.com/download/server)** operating system is used. The following sections describe the installation and configuration of the operating system.

## Services

For linux, there are 3 main init systems: Systemd, Upstart and SysV. Although nearly all Linux systems run on Systemd. The other two init systems might also co-exist in your system.

* For Systemd, use command `sudo systemctl disable mysql`
* For Upstart, use `echo manual >> /etc/init/mysql.override`;
* For SysV, run the following command `sudo update-rc.d mysql disable`

If you'd like to find which init system is running on your server, please read this answer: (https://unix.stackexchange.com/questions/196166/how-to-find-out-if-a-system-uses-sysv-upstart-or-systemd-initsystem/196183#196183)

## unminimize

On minimal **Ubuntu Server** sometimes it is too limited and needs to be unminimized:

```shell
sudo unminimize
```

Update your existing packages and install a prerequisite packages which let apt utilize https:

```shell
sudo apt update
sudo apt install apt-transport-https ca-certificates curl software-properties-common
```
