# Docker

Docker is an open platform for developing, shipping, and running applications. Docker enables you to separate your applications from your infrastructure so you can deliver software quickly. With Docker, you can manage your infrastructure in the same ways you manage your applications. By taking advantage of Docker’s methodologies for shipping, testing, and deploying code quickly, you can significantly reduce the delay between writing code and running it in production.

Resources:

* https://www.docker.com/
* https://linuxconfig.org/how-to-install-kubernetes-on-ubuntu-22-04-jammy-jellyfish-linux
* https://www.bornfight.com/blog/blog-lamp-docker-setup-with-php-8-and-mariadb-for-symfony-projects/

## Docker install

On newer distributions the installation can be very easy because Docker is already integrated:

```shell
sudo apt update
sudo apt install docker.io
```

Once Docker has finished installing, use the following commands to start the service and to make sure it starts automatically after each reboot:

```shell
sudo systemctl start docker
sudo systemctl enable docker
```

## Docker install for older distributions

Add GPG key for the official **Docker** repo to the **Ubuntu** system:

```shell
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker.gpg
# Alternative:
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
```

Use the following command to set up the stable repository. To add the nightly or test repository, add the word nightly or test (or both) after the word stable in the commands below. Learn about nightly and test channels.

```shell
echo "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
```

**Note:** If this leads to an error, then change your distribution (like `impish`) to `focal`:

```shell
echo "deb [arch=amd64] https://download.docker.com/linux/ubuntu focal stable"
```

Now update the package database to get the new **Docker** packages from the added repo:

```shell
sudo apt update
```

Install **Docker** community edition and cli tools:

```shell
sudo apt-get install docker-ce docker-ce-cli containerd.io
```

**Note:** If you want to run **Docker** as non-root user then you need to add it to the `docker` group:

Create the docker group if it does not exist:

```shell
sudo groupadd docker
```

Add your user to the `docker` group:

```shell
sudo usermod -aG docker ${USER}
```

Run the following command or Logout and login again and run (that doesn't work you may need to reboot your machine first)

```shell
newgrp docker
```

Resources:

* https://docs.docker.com/engine/install/ubuntu/
* https://support.netfoundry.io/hc/en-us/articles/360057865692-Installing-Docker-and-docker-compose-for-Ubuntu-20-04
* http://csmojo.com/posts/mx-linux-setting-up-docker-and-docker-compose.html
* https://docs.docker.com/engine/install/debian/
* https://docs.docker.com/install/linux/linux-postinstall/

## Docker Commands

**Docker** should now be installed, the daemon started, and the process enabled to start on boot. To verify:

```shell
sudo systemctl status docker
```

Restart the Docker daemon:

```shell
sudo service docker restart
```

Check docker service status:

```shell
sudo service docker status
```

Test the installation:

```shell
sudo docker run hello-world
```

## Portainer

For a better overview of running containers Portainer can be a helpful tool:

```shell
docker run -d --restart=unless-stopped -p 9000:9000 -v /var/run/docker.sock:/var/run/docker.sock portainer/portainer
```

Open the admin ui: http://localhost:9000/

Username: admin
Password: `<root_password>`

## Docker Images update

**Update Docker images automatically**

Docker images within a running container do not update automatically. Once you have used an image to create a container, it continues running that version, even after new releases come out. It is recommended to run containers from the latest Docker image unless you have a specific reason to use an older release.

* https://phoenixnap.com/kb/update-docker-image-container
* https://stackoverflow.com/questions/26423515/how-to-automatically-update-your-docker-containers-if-base-images-are-updated
    * https://engineering.salesforce.com/open-sourcing-dockerfile-image-update-6400121c1a75
        * https://github.com/containrrr/watchtower
* https://ostechnix.com/automatically-update-running-docker-containers/

```shell
#!/usr/bin/env bash
set -e
BASE_IMAGE="registry"
REGISTRY="registry.hub.docker.com"
IMAGE="$REGISTRY/$BASE_IMAGE"
CID=$(docker ps | grep $IMAGE | awk '{print $1}')
docker pull $IMAGE

#for IMAGE in $(docker ps --format {{.Image}} -q | sort -u)
for im in $CID
do
    LATEST=`docker inspect --format "{{.Id}}" $IMAGE`
    RUNNING=`docker inspect --format "{{.Image}}" $im`
    NAME=`docker inspect --format '{{.Name}}' $im | sed "s/\///g"`
    echo "Latest:" $LATEST
    echo "Running:" $RUNNING
    if [ "$RUNNING" != "$LATEST" ];then
        echo "upgrading $NAME"
        stop docker-$NAME
        docker rm -f $NAME
        start docker-$NAME
    else
        echo "$NAME up to date"
    fi
done
```

## Docker Compose

**Docker Compose** is a tool for defining and running multi-container Docker applications. With **Docker Compose**, you use a YAML file to configure your application’s services. Then, with a single command, you create and start all the services from your configuration. To learn more about all the features of Compose, [see the list of features](https://docs.docker.com/compose/#features).

Resources:

* https://docs.docker.com/compose/
* https://docs.docker.com/compose/install/

### Docker Compose install

On newer distributions the installation can be very easy because **Docker Compose** is already integrated:

```shell
sudo apt install docker-compose
```

### Docker Compose install for older distributions

Alternation this is under Debian packages - though this may be a few versions behind!

Run this command to download the current stable release of **Docker Compose**:

```shell
sudo curl -L "https://github.com/docker/compose/releases/download/2.6.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
```

_**Note:** check the version first to get the latest: [https://github.com/docker/compose/releases/](https://github.com/docker/compose/releases/)

```shell
curl -s https://api.github.com/repos/docker/compose/releases/latest | grep browser_download_url | grep -i $(uname -s)-$(uname -m) | cut -d '"' -f 4
```

Apply executable permissions to the binary:

```shell
sudo chmod +x /usr/local/bin/docker-compose
```

Test the installation:

```shell
docker-compose --version
```
