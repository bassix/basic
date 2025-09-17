# GIT

**Git** is a de-facto standard for distributed version control systems and is used by the majority of developers nowadays. It allows you to keep track of your code changes, revert to previous stages, create branches, and to collaborate with your fellow developers.

**Git** is originally developed by [Linus Torvalds](https://en.wikipedia.org/wiki/Linus_Torvalds), the creator of the Linux kernel.

The easiest and the recommended way to install **Git** is to install it using the apt package management tool from Ubuntu’s default repositories:

```shell
sudo apt update
sudo apt install git
```

## Git-Flow

Install `git-flow` by entering the following commands in the terminal:

```shell
sudo apt update
sudo apt install git-flow
```

## Commands and Cheatsheet

**Everyone specially real developers should know how to use git. Here are some useful commands and cheatsheet.**

Delete all local branches with missing remote branches:

```shell
git fetch -p && for branch in $(git for-each-ref --format '%(refname) %(upstream:track)' refs/heads | awk '$2 == "[gone]" {sub("refs/heads/", "", $1); print $1}'); do git branch -D $branch; done
```
