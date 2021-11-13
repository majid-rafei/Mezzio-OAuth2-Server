# Mezzio-OAuth2-Authorization-Authentication-Server
This is a basic OAuth2 authorization/authentication server implemented using Mezzio.

I have found some problems with Mezzio prepared sql queries used to create tables needed by OAuth2. In this project we have overcome tricks in creating new Mezzio/OAuth2 server.

**OAuth Sql Preparation:**
Please use these queries in order to create and prepare tables needed in OAuth2:
```sql
--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) PRIMARY KEY NOT NULL,
  -- Hint: 'user_id' is introduced as an int column in original sql 
  -- query provided in mezzio-authentication-oauth2 package! 
  -- But here we change it to a varchar column beacuse of getUserIdentifier() 
  -- in vendor/mezzio/mezzio-authentication-oauth2/src/Repository/Pdo/AccessTokenRepository.php,
  -- which is a string as well.
  `user_id` varchar(255) DEFAULT NULL,
  -- Hint: 'client_id' is introduced as an int column in original sql 
  -- query provided in mezzio-authentication-oauth2 package! 
  -- But here we change it to a varchar column beacuse of getClient()->getIdentifier() 
  -- in vendor/mezzio/mezzio-authentication-oauth2/src/Repository/Pdo/AccessTokenRepository.php,
  -- which is a string as well.
  `client_id` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text,
  `revoked` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `expires_at` datetime NOT NULL
);

CREATE INDEX `IDX_CA42527CA76ED39519EB6921BDA26CCD` ON oauth_access_tokens (`user_id`,`client_id`);
CREATE INDEX `IDX_CA42527CA76ED395` ON oauth_access_tokens (`user_id`);
CREATE INDEX `IDX_CA42527C19EB6921` ON oauth_access_tokens (`client_id`);

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) PRIMARY KEY NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `client_id` int(10) NOT NULL,
  `scopes` text,
  `revoked` tinyint(1) NOT NULL DEFAULT '0',
  `expires_at` datetime DEFAULT NULL
);

CREATE INDEX `IDX_BB493F83A76ED395` ON oauth_auth_codes (`user_id`);
CREATE INDEX `IDX_BB493F8319EB6921` ON oauth_auth_codes (`client_id`);

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  -- Hint: You may want to change AUTOINCREMENT to AUTO_INCREMENT
  `id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `redirect` varchar(255) DEFAULT NULL,
  `personal_access_client` tinyint(1) DEFAULT NULL,
  `password_client` tinyint(1) DEFAULT NULL,
  `revoked` tinyint(1) DEFAULT NULL,
  `is_confidential` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
);

CREATE INDEX `IDX_13CE81015E237E06A76ED395BDA26CCD` ON oauth_clients (`name`,`user_id`);
CREATE INDEX `IDX_13CE8101A76ED395` ON oauth_clients (`user_id`);

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) PRIMARY KEY NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL DEFAULT '0',
  `expires_at` datetime NOT NULL
);

CREATE INDEX `IDX_5AB6872CCB2688BDA26CCD` ON oauth_refresh_tokens (`access_token_id`);

--
-- Table structure for table `oauth_scopes`
--

CREATE TABLE `oauth_scopes` (
  `id` varchar(100) PRIMARY KEY NOT NULL
);

--
-- Table structure for table `oauth_users`
--

CREATE TABLE `oauth_users` (
  -- Hint: You may want to change AUTOINCREMENT to AUTO_INCREMENT
  `id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  `username` varchar(320) UNIQUE NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(80) DEFAULT NULL,
  `last_name` varchar(80) DEFAULT NULL
);

CREATE INDEX `UNIQ_93804FF8F85E0677` ON oauth_users (`username`);

--
-- Population for table `oauth_clients`
--

INSERT INTO oauth_clients (name, secret, redirect, personal_access_client, password_client, is_confidential)
VALUES ('client_test', '$2y$10$fFlZTo2Syqa./0JJ2QKV4O/Nfi9cqDMcwHBkN/WMcRLLlaxYUP2CK', '/redirect', 1, 1, 1),
('client_test2', '$2y$10$fFlZTo2Syqa./0JJ2QKV4O/Nfi9cqDMcwHBkN/WMcRLLlaxYUP2CK', '/redirect', 0, 0, 1),
('client_test_not_confidential', '$2y$10$fFlZTo2Syqa./0JJ2QKV4O/Nfi9cqDMcwHBkN/WMcRLLlaxYUP2CK', '/redirect', 0, 0, 0);

--
-- Population for table `oauth_users`
--

INSERT INTO oauth_users (username, password)
VALUES ('user_test', '$2y$10$DW12wQQvr4w7mQ.uSmz37OQkKcIZrRZnpXWoYue7b5v8E/pxvsAru');

INSERT INTO oauth_scopes (id)
VALUES ('test');

```

# Mezzio Skeleton and Installer

[![Build Status](https://github.com/mezzio/mezzio-skeleton/actions/workflows/continuous-integration.yml/badge.svg)](https://github.com/mezzio/mezzio-skeleton/actions/workflows/continuous-integration.yml)

*Begin developing PSR-15 middleware applications in seconds!*

[mezzio](https://github.com/mezzio/mezzio) builds on
[laminas-stratigility](https://github.com/laminas/laminas-stratigility) to
provide a minimalist PSR-15 middleware framework for PHP with routing, DI
container, optional templating, and optional error handling capabilities.

This installer will setup a skeleton application based on mezzio by
choosing optional packages based on user input as demonstrated in the following
screenshot:

![screenshot-installer](https://user-images.githubusercontent.com/1011217/90332191-55d32200-dfbb-11ea-80c0-27a07ef5691a.png)

The user selected packages are saved into `composer.json` so that everyone else
working on the project have the same packages installed. Configuration files and
templates are prepared for first use. The installer command is removed from
`composer.json` after setup succeeded, and all installer related files are
removed.

## Getting Started

Start your new Mezzio project with composer:

```bash
$ composer create-project mezzio/mezzio-skeleton <project-path>
```

After choosing and installing the packages you want, go to the
`<project-path>` and start PHP's built-in web server to verify installation:

```bash
$ composer run --timeout=0 serve
```

You can then browse to http://localhost:8080.

> ### Linux users
>
> On PHP versions prior to 7.1.14 and 7.2.2, this command might not work as
> expected due to a bug in PHP that only affects linux environments. In such
> scenarios, you will need to start the [built-in web
> server](http://php.net/manual/en/features.commandline.webserver.php) yourself,
> using the following command:
>
> ```bash
> $ php -S 0.0.0.0:8080 -t public/ public/index.php
> ```

> ### Setting a timeout
>
> Composer commands time out after 300 seconds (5 minutes). On Linux-based
> systems, the `php -S` command that `composer serve` spawns continues running
> as a background process, but on other systems halts when the timeout occurs.
>
> As such, we recommend running the `serve` script using a timeout. This can
> be done by using `composer run` to execute the `serve` script, with a
> `--timeout` option. When set to `0`, as in the previous example, no timeout
> will be used, and it will run until you cancel the process (usually via
> `Ctrl-C`). Alternately, you can specify a finite timeout; as an example,
> the following will extend the timeout to a full day:
>
> ```bash
> $ composer run --timeout=86400 serve
> ```

## Installing alternative packages

There is a feature to install alternative packages: Instead of entering one of
the selection **you can actually type the package name and version**.

> ```
>   Which template engine do you want to use?
>   [1] Plates
>   [2] Twig
>   [3] zend-view installs zend-servicemanager
>   [n] None of the above
>   Make your selection or type a composer package name and version (n): infw/pug:0.1
>   - Searching for infw/pug:0.1
>   - Adding package infw/pug (0.1)
> ```

That feature allows you to install any alternative package you want. It has its limitations though:

* The alternative package must follow this format `namespace/package:1.0`. It needs the correct version.
* Templates are not copied, but the ConfigProvider can be configured in such way that it uses the
  default templates directly from the package itself.
* This doesn't work for containers as the container.php file needs to be copied.

## Troubleshooting

If the installer fails during the ``composer create-project`` phase, please go
through the following list before opening a new issue. Most issues we have seen
so far can be solved by `self-update` and `clear-cache`.

1. Be sure to work with the latest version of composer by running `composer self-update`.
2. Try clearing Composer's cache by running `composer clear-cache`.

If neither of the above help, you might face more serious issues:

- Info about the [zlib_decode error](https://github.com/composer/composer/issues/4121).
- Info and solutions for [composer degraded mode](https://getcomposer.org/doc/articles/troubleshooting.md#degraded-mode).

## Application Development Mode Tool

This skeleton comes with [laminas-development-mode](https://github.com/laminas/laminas-development-mode).
It provides a composer script to allow you to enable and disable development mode.

### To enable development mode

**Note:** Do NOT run development mode on your production server!

```bash
$ composer development-enable
```

**Note:** Enabling development mode will also clear your configuration cache, to
allow safely updating dependencies and ensuring any new configuration is picked
up by your application.

### To disable development mode

```bash
$ composer development-disable
```

### Development mode status

```bash
$ composer development-status
```

## Configuration caching

By default, the skeleton will create a configuration cache in
`data/config-cache.php`. When in development mode, the configuration cache is
disabled, and switching in and out of development mode will remove the
configuration cache.

You may need to clear the configuration cache in production when deploying if
you deploy to the same directory. You may do so using the following:

```bash
$ composer clear-config-cache
```

You may also change the location of the configuration cache itself by editing
the `config/config.php` file and changing the `config_cache_path` entry of the
local `$cacheConfig` variable.

## Skeleton Development

This section applies only if you cloned this repo with `git clone`, not when you
installed mezzio with `composer create-project ...`.

If you want to run tests against the installer, you need to clone this repo and
setup all dependencies with composer.  Make sure you **prevent composer running
scripts** with `--no-scripts`, otherwise it will remove the installer and all
tests.

```bash
$ composer update --no-scripts
$ composer test
```

Please note that the installer tests remove installed config files and templates
before and after running the tests.

Before contributing read [the contributing guide](https://github.com/mezzio/.github/blob/master/CONTRIBUTING.md).
