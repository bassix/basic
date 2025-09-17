# Rancher

_Rancher is designed to work on Linux machines, so to test locally you might need to install onto a Virtual Machine._

Start the Rancher container using the following `docker run` command:

```bash
docker run -d --restart=unless-stopped -p 8080:8080 rancher/server:stable
```
