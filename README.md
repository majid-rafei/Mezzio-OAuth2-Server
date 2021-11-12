# Mezzio-OAuth2-Authorization-Authentication-Server
This is a basic Oauth2 authorization/authentication server implemented using Mezzio.

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
