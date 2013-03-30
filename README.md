SlmException
===
SlmException is a Zend Framework 2 module to gain more control over the exception handling in your application. It provides various markers for exception classes so you have fine grained control about the rendered view script and HTTP status code of a thrown exception.

Furthermore are two features planned: out of the box logging of exceptions to your defined logger instance and custom messages displayed per exception.

Installation
---
SlmException can be installed via composer. Put the `slm/exception` dependency in your list and run `composer update`. At this moment there is no tag of SlmException so you have to rely on `dev-master` to use this module. Furthermore, enable `SlmException` in your application.module.config.

Usage
---
SlmException now focuses on a single feature: fine grained control of exception view template rendering and HTTP status code output. A real-world use case is your Blog module where you want to fetch an Article entity. However, when no article can be found, you possibly throw a `Blog\Exception\ArticleNotFound` exception. On the other hand, you want to display a "Page not found" message to the visitor trying to access this non-existing blog article.

What you need to do is to implement a marker interface from SlmException, the rest is done automatically:

```php
<?php

namespace Blog\Exception;

use SlmException\Exception\PageNotFoundInterface;

class ArticleNotFoundException extends \Exception implements PageNotFoundInterface
{}
```

Throwing this exception, the error template `error/page-not-found` will be rendered. Style it to your needs. Furthermore, the `PageNotFoundInterface` is coupled to the HTTP status code `404` so you will see in your response the 404 status code is set.

You can now semantically use exceptions in your program to handle exceptional cases, but nevertheless be able to show correct messages to your user. The case with the `PageNotFound` might be obvisous, but applications can also have exceptional code flow where other HTTP stauts codes might be appropriate.

Future features
---
Besides exception view rendering, logging and custom messages are planned too. With logging, all exceptions are logged out of the box with to a given logger instance. This logger can be a configured `Logger` object, a key inside the Service Manager or connected easily with `Soflomo\Log`.

Custom messages are texts shown to users based on a very specific exception class. You might want to give a user support in a very specific case. With a database table containing messages per exception class, you can show these messages to the user when the exception occurs. An example might be the user uses a link to reset the password, but the token in the link is expired. The text can show a helpful message that the token is invalid and a direct link to the form to request a new password reset link.


Development
---
SlmException is at this moment under development. Use at your own risk! If you have any issue, feel free to open a request at the canonical repository at http://github.com/juriansluiman/SlmException. If you have questions, you can contact me at jurian@juriansluiman.nl.