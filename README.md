Hale
====

[![Build Status](https://travis-ci.org/iromli/hale.png)](https://travis-ci.org/iromli/hale)

Yet another PHP port of Armin's [itsdangerous](https://github.com/mitsuhiko/itsdangerous) library.

Differences
-----------

With the original `itsdangerous` library written in Python:

* Hale uses `Hale.Signer` instead of `itsdangerous.Signer` as default salt string.
* Hale uses `default` instead of `django-concat` as default key derivation method name.

With the original `itsdangerous-php` library written in PHP (dooh):

* Hale tries to conform with PSR-0 and PSR-1.
* Testcases (although it's not fully 100%-covered)

Kudos
-----

* The original [itsdangerous](https://github.com/mitsuhiko/itsdangerous) library written in Python.
* The original [itsdangerous-php](https://github.com/mattbasta/itsdangerous-php) as an inspiration (no license mentioned yet).

Todo
----

1. <del>Make `Hale` as Composer-installable library.</del>
2. Create example to check the interoptability with the real `itsdangerous` library (likely in separate repo).

Copyright
---------

Hale is released under MIT license. See `LICENSE.txt` for details.
