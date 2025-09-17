# Minikube

**MicroK8s, the lightweight Kubernetes**

The following sources were used when writing the document:

- https://kubernetes.io/de/docs/tasks/tools/install-minikube/
- https://minikube.sigs.k8s.io/docs/tutorials/multi_node/
- https://minikube.sigs.k8s.io/docs/start/
- https://ubuntu.com/blog/microk8s-ha-tech-preview-is-now-available

Install latest Minikube version manually:

```bash
curl -LO https://storage.googleapis.com/minikube/releases/latest/minikube-linux-amd64
sudo install minikube-linux-amd64 /usr/local/bin/minikube
```

On Linux, you can download and test highly available MicroK8s from the ‘ha-preview’ branch:

```bash
sudo snap install microk8s --classic --channel=latest/edge/ha-preview
```

Create the `bassnet` cluster:

```bash
minikube start --memory=2048 --cpus=2 --nodes=4 --kubernetes-version=v1.19.2 --vm-driver=kvm2 --disk-size=30g -p bassnet --extra-config=apiserver.enable-admission-plugins="LimitRanger,NamespaceExists,NamespaceLifecycle,ResourceQuota,ServiceAccount,DefaultStorageClass,MutatingAdmissionWebhook"
```

Get the status of the `bassnet` cluster:

```bash
minikube status -p bassnet
```

## Deploy **hallo** application

Deploy our hello world deployment:

```bash
kubectl apply -f hello-deployment.yaml
```

Get the status of the deployment:

```bash
kubectl rollout status deployment/hello
```

Deploy our hello world service, which just spits back the IP address the request was served from:

```bash
kubectl apply -f hello-svc.yaml
```

Check out the IP addresses of our pods, to note for future reference

```bash
kubectl get pods -o wide
```

Look at our service, to know what URL to hit

```bash
minikube service list -p bassnet
```

## Manage the cluster

Pause Kubernetes without impacting deployed applications:

```bash
minikube pause
```

Halt the cluster:

```bash
minikube stop
```

Increase the default memory limit (requires a restart):

```bash
minikube config set memory 16384
```

Browse the catalog of easily installed Kubernetes services:

```bash
minikube addons list
```

Create a second cluster running an older Kubernetes release:

```bash
minikube start -p aged --kubernetes-version=v1.19.2
```

Delete all of the minikube clusters:

```bash
minikube delete --all
```
