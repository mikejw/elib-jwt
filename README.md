

Empathy PHP Framework - ELib-JWT
===

JWT Support for Empathy Applications using https://github.com/firebase/php-jwt.

This extension depends on [elib-base](/docs/elib-base/).

The `JWT` service will automatically be enabled for your application. 
(See `services.php`).


The two methods available with this extension are:

<pre><code class="lang-php">&lt;php
$token = DI::getContainer()->get('JWT')->generate();
</code></pre>

`generate()` uses a one-hour lifetime by default. Pass a lifetime in seconds
when a different expiry is required:

<pre><code class="lang-php">&lt;php
$ttl = 60 * 60 * 24 * 30;
$token = DI::getContainer()->get('JWT')->generate($ttl);
</code></pre>

The default can be configured with the `ELIB_JWT_TTL` environment variable or
the ELib `JWT_TTL` setting. `getTTL()` returns the resolved lifetime, which is
useful when setting a browser cookie to the same expiry:

<pre><code class="lang-php">&lt;php
$jwt = DI::getContainer()->get('JWT');
$ttl = $jwt->getTTL();
$token = $jwt->generate($ttl);
</code></pre>

and

<pre><code class="lang-php">&lt;php
$token = DI::getContainer()->get('JWT')->tryAuthenticate();
</code></pre>


Licence
---
Empathy and officially released extension libraries are now distributed under an
MIT license.  See [LICENSE](./LICENSE).
