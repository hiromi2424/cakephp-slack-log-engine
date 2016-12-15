[![Build Status](https://img.shields.io/travis/hiromi2424/cakephp-slack-log-engine/master.svg?style=flat-square)](https://travis-ci.org/hiromi2424/cakephp-slack-log-engine)
[![Coverage Status](https://img.shields.io/codecov/c/github/hiromi2424/cakephp-slack-log-engine.svg?style=flat-square)](https://codecov.io/github/hiromi2424/cakephp-slack-log-engine)
[![Total Downloads](https://img.shields.io/packagist/dt/hiromi2424/cakephp-slack-log-engine.svg?style=flat-square)](https://packagist.org/packages/hiromi2424/cakephp-slack-log-engine)
[![Latest Stable Version](https://img.shields.io/packagist/v/hiromi2424/cakephp-slack-log-engine.svg?style=flat-square)](https://packagist.org/packages/hiromi2424/cakephp-slack-log-engine)

## What is this?

This is CakePHP plugin to provide a log engine that post to slack using incoming webhooks.

Please see detail [how to configure webhooks on slack](https://api.slack.com/incoming-webhooks).

The engine uses [Slack for PHP](https://github.com/maknz/slack) and is just thin wrapper for the library.

## Installation

```
composer require hiromi2424/cakephp-slack-log-engine
```

## Requirements

* CakePHP 3.x
* PHP 5.4+

## Log options

Either `client` or `hookUrl` is required.

- `hookUrl` [string] Slack hook url.
- `client` [\Maknz\Slack\Client] Slack client instance for custom.
- `clientClass` [string(optional)] slack client class. This option is used only with `hookUrl` option.

Other available settings can be seen at [Slack for PHP Official Docs](https://github.com/maknz/slack#settings)
