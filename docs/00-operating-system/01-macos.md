# MacOS PHP 8.3 and 8.4

## Installing PHP 8.3

Install PHP 8.3 using Homebrew:

```shell
brew install php@8.3
```

Start the PHP 8.3 service:

```shell
brew services start php@8.3
```

Verify the PHP version:

```shell
php -v
```

To run PHP-FPM for PHP 8.3 without daemonizing:

```shell
/opt/homebrew/opt/php@8.3/sbin/php-fpm --nodaemonize
```

## Installing PHP 8.4

Unlink the current PHP version:

```shell
brew unlink php
```

Install PHP 8.4 using Homebrew:

```shell
brew install php@8.4
```

Link PHP 8.4, overwriting any existing PHP links:

```shell
brew link --overwrite php@8.4
```

To run PHP-FPM for PHP 8.4 without daemonizing:

```shell
/opt/homebrew/opt/php@8.4/sbin/php-fpm --nodaemonize
```

## Switching Between PHP Versions

Unlink the current PHP version:

```shell
brew unlink php
```

Link the desired PHP version. For PHP 8.3:

```shell
brew link --overwrite php@8.3
```

Update your `~/.zshrc` file to include the correct PHP version in your PATH. For PHP 8.3, add:

```shell
nano ~/.zshrc
```

Add the following lines to the end of the file:

```shell
export PATH="/usr/local/opt/php@8.3/bin:$PATH"
export PATH="/usr/local/opt/php@8.3/sbin:$PATH"
```

Apply the changes to your shell:

```shell
source ~/.zshrc
```

Verify the PHP version:
```shell
php -v
```

Repeat the unlinking and linking steps to switch between PHP 8.3 and PHP 8.4 as needed.
