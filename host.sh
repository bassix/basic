#!/bin/bash

echo "welcome please select your options"
read choice
firewall_status=$(sudo systemctl status firewalld)
apache_status=$(sudo systemctl status apache2)
firewall_stop=$(sudo systemctl stop firewalld)
apache_stop=$(sudo systemctl stop apache2)
firewall_start=$(sudo systemctl start firewalld)
apache_start=$(sudo systemctl start apache2)

case $choice in
    1) status of the firewall is "$firewall_status"
        ;;
    2) status of apache is "$apache_status"
        ;;
    3) echo stop firewall by "$firewall_stop"
        ;;
    4) echo stop apache by "$apache_stop"
        ;;
    5) echo start firewall by "$firewall_start"
        ;;
    6) echo start apache by "$apache_start"
        ;;
    *) echo exit
esac
