# Dealroadshow K8S Framework

This framework uses low-level library [dealroadshow/k8s-resources](https://github.com/dealroadshow/k8s-resources)
and adds some high-level abstractions to facilitate definitions of your Kubernetes
manifests. The recommended way to use this framework is by installing [dealroadshow/k8s-bundle](https://github.com/dealroadshow/k8s-bundle),
which integrates this framework with Symfony 5.

By using [dealroadshow/k8s-bundle](https://github.com/dealroadshow/k8s-bundle) you get the
full power of [Symfony framework](https://github.com/symfony/symfony), zero-configuration
Dependency Injection, which will make your experience in writing Kubernetes manifests
better than ever.

However, framework can be used as a standalone library.

## Installation
The real work of generating Kubernetes Yaml manifests is done by the 
[dealroadshow/k8s-resources](https://github.com/dealroadshow/k8s-resources) library.

Therefore, you need to install the proper version of this library before using the 
framework. Check your Kubernetes version, and install corresponding version of
[dealroadshow/k8s-resources](https://github.com/dealroadshow/k8s-resources). 

For example, if you're using Kubernetes v1.16, install [dealroadshow/k8s-resources](https://github.com/dealroadshow/k8s-resources)
as follows:

```bash
composer require dealroadshow/k8s-resources:^1.16
```

As you see, [dealroadshow/k8s-resources](https://github.com/dealroadshow/k8s-resources)
versioning mirrors versioning of Kubernetes itself.


After that, you may install the latest version of K8S Framework:

```bash
composer require dealroadshow/k8s-framework
```

If you want to see usage examples, please refer to 
[dealroadshow/k8s-bundle](https://github.com/dealroadshow/k8s-bundle).
