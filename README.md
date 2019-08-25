ScreenshotExtension
===================

This library allows to save screenshots whenever a step fails in a Behat
scenario.

Installation
------------

```
$ composer require lovers-of-behat/screenshot-extension
```

Configuration
-------------

Add the extension to your `behat.yml`:

```
suites:
  extensions:
    LoversOfBehat\ScreenshotExtension:
      storage:
        filesystem:
          path: '/path/to/screenshots/directory/'
```
