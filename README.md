Welcome to PIMF
===============
Have you ever wished a PHP framework that perfectly adapts to your projects needs, your programming experience and your customers budget? A thin PHP framewrok with less implementing rools and easy to learn how to use it? PIMF is about to satisfy your demands!

[![Build Status](https://secure.travis-ci.org/gjerokrsteski/pimf.png?branch=master)](http://travis-ci.org/gjerokrsteski/pimf)
[![Dependency Status](https://www.versioneye.com/user/projects/52122a71632bac227d003d39/badge.png)](https://www.versioneye.com/user/projects/52122a71632bac227d003d39)

PIMF Philosophy
---------------
A good and robust business-logic is better that fat and complex framework. Most of the PHP framewroks are bigger than your problem. At all you need less than 20% of the functionality of the framework to solve you problem. Therefore we belive that the “right” 20% of the effort is the 80% of the results - and that is PIMF.

The aim was to create robust and secure projects and deliver them fast. We wanted just one easy framewrok, who can be used once for all  our projects. And than - PIMF was born!

PIMFs implementation is based on well proved design patterns as well as fast objects relation mapping mechanism - like famous PHP frameworks had. The architecture is designed upgrade friendly - so you can upgrade to newer versions without to override your projects. And for all of you out there, who like to create rich application interfaces with ExtJs or Dojo - we have created mechanism to couple your GUI to the controllers in a easy and fast way.

Installation
------------
**Step 1.** Download PIMF

```php
git clone --recursive https://github.com/gjerokrsteski/pimf.git
```

**Step 2.** Extract the PIMF archive and upload the contents to your web server.

**Step 3.** Open the config.php file and set

```php
'environment' => 'production'
'local_temp_directory' => '/tmp/' //if necessary
```

**Step 4.** Go to your PIMF root directory and run the command:  

```cli
php pimf core:init
```

**Step 5.** Navigate to your application in a web browser.

If all is well, you should see a pretty PIMF splash page. Get ready - there is lot more to learn!


Learning PIMF
-------------
One of the best ways to learn PIMF is to read through the entirety of its documentation. This guide details all aspects of the framework and how to apply them to your application.

Please read here: https://github.com/gjerokrsteski/pimf/wiki


Contributing and pull request guidelines
----------------------------------------
[GitHub pull requests](https://help.github.com/articles/using-pull-requests) are a great way for everyone in the community to contribute to the PIMF codebase. Found a bug? Just fix it in your fork and submit a pull request. This will then be reviewed, and, if found as good, merged into the main repository.

In order to keep the codebase clean, stable and at high quality, even with so many people contributing, some guidelines are necessary for high-quality pull requests:

- **Branch:** Unless they are immediate documentation fixes relevant for old versions, pull requests should be sent to the `develop` branch only. Make sure to select that branch as target when creating the pull request (GitHub will not automatically select it.)
- **Documentation:** If you are adding a new feature or changing the API in any relevant way, this should be documented.
- **Unit tests:** To keep old bugs from re-appearing and generally hold quality at a high level, the PIMF core is thoroughly unit-tested. Thus, when you create a pull request, it is expected that you unit test any new code you add. For any bug you fix, you should also add regression tests to make sure the bug will never appear again. If you are unsure about how to write tests, the core team or other contributors will gladly help.

Framework Sponsor
-------------------
JetBRAINS supports the development of the PIMF with PHPStorm licenses and we feel confidential that PHPStorm strongly influences the PIMF's quality. Use PHPStorm! http://www.jetbrains.com/phpstorm/
