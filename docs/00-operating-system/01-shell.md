# Shell

The main work on infrastructure level is done on the command line. To make the work more efficient and faster, the shell is configured and extended with plugins and themes.

## Antibody

**[Antibody](https://getantibody.github.io/)** is a shell plugin manager made from the ground up thinking about performance.

Resource: https://getantibody.github.io/

## Oh My ZSH!4

The **[Z-Shell (zsh)](https://www.zsh.org/)** is a Unix console that can be used both as an interactive login console and as a powerful command line interpreter for console scripts. The zsh is often seen as an extended Bourne console which combines many improvements and features of bash, ksh and tcsh.

## Installation

Install pre requirements if not installed:

```shell
sudo apt install curl git zsh autojump
```

Install the **[Z-Shell (zsh)](https://www.zsh.org/)** shell:

```shell
curl -L https://github.com/robbyrussell/oh-my-zsh/raw/master/tools/install.sh | sh
```

If during the installation errors occur mainly there are related to the authorization. To fix this run following command:

```shell
chsh -s `which zsh` && /usr/bin/env zsh && . ~/.zshrc
```

If the change didn't work and we still have the default console running, run:

```shell
sudo chsh -s $(which zsh) $(whoami)
```

### Extend with Plugins

Install Oh My ZSH Completion plugin for `symfony/console` based tools. Clone the repository into `~/.oh-my-zsh/custom/plugins/symfony-console` directory.

```shell
git clone https://github.com/jerguslejko/zsh-symfony-completion.git $ZSH_CUSTOM/plugins/symfony-console
```

Activate the plugin by inserting `symfony-console` into the plugins list in your `~/.zshrc`:

```shell
plugins=(symfony-console)
```

Optionally, specify which `symfony/console` tools you want to activate auto-completion for. If you do not define this variable, values below will be used as defaults. Please note, this line MUST appear before source `$ZSH/oh-my-zsh.sh`.

```shell
export SYMFONY_CONSOLE_TOOLS="composer artisan valet envoy bin/console"
```

Enabling Plugins (`zsh-autosuggestions` & `zsh-syntax-highlighting`):

* Download [zsh-autosuggestions](https://github.com/zsh-users/zsh-autosuggestions):

    ```shell
    git clone https://github.com/zsh-users/zsh-autosuggestions.git $ZSH_CUSTOM/plugins/zsh-autosuggestions
    ```

* Download [zsh-syntax-highlighting](https://github.com/zsh-users/zsh-syntax-highlighting)

    ```shell
    git clone https://github.com/zsh-users/zsh-syntax-highlighting.git $ZSH_CUSTOM/plugins/zsh-syntax-highlighting
    ```

* Activate both plugins by appending `nano ~/.zshrc` find `plugins=(git)` to `plugins=(git zsh-autosuggestions zsh-syntax-highlighting)`
* Reopen terminal

#### Activate useful Plugins

Full list of current useful plugins:

```shell
# Symfony
export SYMFONY_CONSOLE_TOOLS="composer artisan valet envoy bin/console"

plugins=(
    ant
    autojump
    battery
    bower
    brew
    colorize
    composer
    command-not-found
    docker
    docker-compose
    extract
    git
    git-flow
    github
    history
    kubectl
    node
    npm
    phing
    pip
    python
    screen
    symfony-console
    symfony2
    vagrant
    yarn
    zsh-autosuggestions
    zsh-syntax-highlighting
)

# Terminal navigation
alias lll="ls -als"
alias ..="cd .."
alias ...="cd ../../"

# navigation aliases
alias dev="cd ~/bassix-basic"

# kubectl aliases
alias k="kubectl"
alias kgx="kubectl config get-contexts"

# docker aliases
alias d="docker"
alias dps="docker ps"
```

### Themes

The **ZSH** and the **[Oh My ZSH!](https://ohmyz.sh/)** shell extension can be styled by themes. One of the most resi

**[Powerlevel10k](https://github.com/romkatv/powerlevel10k#oh-my-zsh)** is a theme for **ZSH**. It emphasizes [speed](https://github.com/romkatv/powerlevel10k#uncompromising-performance), [flexibility](https://github.com/romkatv/powerlevel10k#extremely-customizable) and [out-of-the-box experience](https://github.com/romkatv/powerlevel10k#configuration-wizard).

Installation instruction for **[Oh My ZSH!](https://ohmyz.sh/)** https://github.com/romkatv/powerlevel10k#oh-my-zsh

1. Clone the repository:  

    ```shell
    git clone --depth=1 https://github.com/romkatv/powerlevel10k.git ${ZSH_CUSTOM:-$HOME/.oh-my-zsh/custom}/themes/powerlevel10k
    ```

2. Set `ZSH_THEME="powerlevel10k/powerlevel10k"` in `~/.zshrc`

To customize prompt, run `p10k configure` or edit `~/.p10k.zsh`.

To get the branch full name comment following line out `(( $#where > 32 )) && where[13,-13]="…"`.

#### Powerline

Source: https://dev.to/nicoh/installing-oh-my-zsh-on-ubuntu-362f

First, we install **powerline** font to have support for icons in our terminal:

```shell
sudo apt install fonts-powerline
```

Then, we change the default theme '_robbyrussell_' to '_agnoster_'. This one is pretty common because it's optimized for git repository usage.

```shell
nano ~/.zshrc
```

### Old installation procedure

Install and activate the Agnoster Theme by installing the Powerline fonts:

```shell
sudo apt install software-properties-common
sudo apt-add-repository universe
sudo apt-get update
sudo apt-get install python3-pip
sudo pip3 install git+git://github.com/Lokaltog/powerline
wget https://github.com/Lokaltog/powerline/raw/develop/font/PowerlineSymbols.otf https://github.com/Lokaltog/powerline/raw/develop/font/10-powerline-symbols.conf
sudo mv PowerlineSymbols.otf /usr/share/fonts/
sudo fc-cache -vf
sudo mv 10-powerline-symbols.conf /etc/fonts/conf.d/
```

## Default Bash Version on macOS

Resource:

* https://itnext.io/upgrading-bash-on-macos-7138bd1066ba

To see how outdated the Bash version included in macOS is, execute the following command:

```shell
bash --version
```

As you can see, this is GNU Bash version 3.2, which dates from 2007! This version of Bash is included in all versions of macOS, even the newest one.
