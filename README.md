

Empathy PHP Framework - ELib-JWT
===


Licence
---
Empathy and officially released extension libraries are now distributed under an
MIT license.  See [LICENSE](./LICENSE).


JWT Support for Empathy Applications using https://github.com/firebase/php-jwt.

This extension depends on [elib-base](/docs/elib-base/).

The `JWT` service will automatically be enabled for your application. 
(See `services.php`).


The two methods available with this extension are:

<pre><code class="lang-php">&lt;php
$token = DI::getContainer()->get('JWT')->generate();
</code></pre>

and

<pre><code class="lang-php">&lt;php
$token = DI::getContainer()->get('JWT')->tryAuthenticate();
</code></pre>

