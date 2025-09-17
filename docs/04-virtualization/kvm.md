## KVM Virtual Machine

Reference:

* [KVM hypervisor: a beginners’ guide](https://ubuntu.com/blog/kvm-hyphervisor)
* [Configuration of KVM hypervisor on Linux Using Ubuntu as Example](https://trueconf.com/blog/knowledge-base/configure-kvm-hypervisor-ubuntu-server)

Install related dependencies:

```shell
sudo apt install -y qemu-system qemu-kvm libvirt-daemon-system virtinst libvirt-clients bridge-utils virt-manager
```

Enable and start the `libvirt` daemon:

```shell
sudo systemctl enable --now libvirtd
```

Adding a user to KVM and Libvirt groups:

```shell
sudo usermod -aG kvm,libvirt $USER
```

_**Note:** You may need to log out and log back in for the group changes to take effect._

Create pool to store images:

```shell
sudo mkdir -p /var/kvm
virsh pool-define-as --name kvm-pool --type dir --target /var/kvm
virsh pool-start kvm-pool
virsh pool-autostart kvm-pool
```

Check if the pool is created:

```shell
virsh pool-list --all
```

Download ISO image for Ubuntu Server installation:

```shell
cd /var/kvm
sudo -u libvirt-qemu wget https://releases.ubuntu.com/24.10/ubuntu-24.10-live-server-amd64.iso
```

Create a new virtual machine:

```shell
virt-install \
  --name basic \
  --description "basic virtual machine for testing" \
  --vcpus 2 \
  --memory 4096 \
  --osinfo ubuntu25.04 \
  --location /var/kvm/ubuntu-24.10-live-server-amd64.iso \
  --disk path=/var/kvm/basic.img,size=30 \
  --network bridge:br0 \
  --graphics none \
  --console pty,target_type=serial \
  --extra-args 'console=ttyS0,115200n8 serial'
```

## Create a individual virtual machine

Prepare resources:

```shell
sudo -u libvirt-qemu mkdir -p /var/kvm
cd /var/kvm
sudo -u libvirt-qemu wget https://releases.ubuntu.com/24.10/ubuntu-24.10-live-server-amd64.iso
```

Create a new virtual machine:

```shell
virt-install \
--name=basic \
--vcpus=2 \
--memory=4096 \
--os-variant=ubuntu24.10 \
--location=/var/kvm/ubuntu-24.10-live-server-amd64.iso \
--disk path=/var/kvm/basic.img,size=30 \
--network bridge=br0 \
--graphics none \
--console pty,target_type=serial \
--extra-args 'console=ttyS0,115200n8 serial' \
--virt-type=kvm
```

## DRAFTS

```shell
# create a storage pool
mkdir -p /var/kvm/images
virt-install \
--name ubuntu1904 \
--ram 4096 \
--disk path=/var/kvm/images/ubuntu1904.img,size=30 \
--vcpus 2 \
--os-type linux \
--os-variant ubuntu19.04 \
--network bridge=br0 \
--graphics none \
--console pty,target_type=serial \
--location 'http://jp.archive.ubuntu.com/ubuntu/dists/disco/main/installer-amd64/' \
--extra-args 'console=ttyS0,115200n8 serial'
Starting install...     # installation starts

# after finishing installation, back to KVM host and shutdown the guest like follows
root@dlp:~# virsh shutdown ubuntu1904
Domain template is being shutdown
# mount guest's disk and enable a service like follows
root@dlp:~# guestmount -d ubuntu1904 -i /mnt
root@dlp:~# ln -s /mnt/lib/systemd/system/getty@.service /mnt/etc/systemd/system/getty.target.wants/getty@ttyS0.service
root@dlp:~# umount /mnt
# start guest again, if it's possible to connect to the guest's console, it's OK all
root@dlp:~# virsh start ubuntu1904 --console

Ubuntu 19.04 ubuntu ttyS0

ubuntu login:
```
