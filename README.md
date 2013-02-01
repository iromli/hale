Hale
====

[![Build Status](https://travis-ci.org/iromli/hale.png)](https://travis-ci.org/iromli/hale)

Yet another PHP port of Armin's [itsdangerous](https://github.com/mitsuhiko/itsdangerous) library.

Differences
-----------

* Hale uses `Hale.Signer` instead of `itsdangerous.Signer` as a salt string.
* Hale uses `default` instead of `django-concat` as key derivation method name.

Kudos
-----

* The original [itsdangerous](https://github.com/mitsuhiko/itsdangerous) library written in Python.
* The original [itsdangerous-php](https://github.com/mattbasta/itsdangerous-php) as an inspiration (no license mentioned yet).

Copyright
---------

Hale is released under MIT license. See `LICENSE.txt` for details.
