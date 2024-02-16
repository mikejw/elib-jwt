

Empathy PHP Framework - ELib-JWT
===


Licence
---
Empathy and officially released extension libraries are now distributed under an
MIT license.  See [LICENSE](./LICENSE).


JWT Support for Empathy Applications using https://github.com/firebase/php-jwt.

This extension depends on https://github.com/mikejw/elib-base.

The `JWT` service will automatically be enabled for your application. 
(See `services.php`).


The two methods available with this extension are:

    $token = DI::getContainer()->get('JWT')->generate();

and

    $token = DI::getContainer()->get('JWT')->tryAuthenticate();

