# ExitDieException
Provides a way to unit-test code that makes extensive use of `exit`s and `die`s.
Early `return`s can also be caught and tested for.

Usage:

index_wrapper.php:
```php
<?php
require_once 'exit_die_exception.php';

try {
  require 'index.php';
}
catch (ExitDieException $e) {
  exit $e->getMessage;  // string
  // or
  exit $e->getCode; // integer
}
```

Now in `index.php` or any files `include`d/`require`d by it, you can replace:
* `die 'message';` with `throw new DieException('message');`
* `die 42;` with `throw new DieException('', 42);`
* `exit 'message';` with `throw new ExitException('message');`
* `exit 42;` with `throw new ExitException('', 42);`

This allows you to test for early `exit`s/`die`s in your unit-tests, without killing the entire test.
Simply use similar code to the above inside the test instead of calling the wrapper file.
e.g. in Codeception:

```php
  // tests
  public function testShouldThrowAnExitException() {
    $this->tester->expectException(new ExitDieException, function() {
      throw new ExitException;
    });
  }
```

Eventually, you will want to refactor your code to get rid of both all the `exit`s/`die`s
and the `ExitDieException`s. This allows you to unit test your code as you work towards this goal.

In a similar vein, the `ReturnException` allows you to replace troublesome early `return`s
within functions and methods as you're refactoring. As an example, you decide to perform
[Extract Method](https://refactoring.com/catalog/extractMethod.html) on some code within a method.
But, uh oh! the code you've just extracted contained an early `return`! So, previously,
you were `return`ing from the parent method, but now you're `return`ing from the child method
and executing the remainer of the parent's code! You've unintentionally changed the behaviour!

This is where `ReturnException` comes in.

```php
  function parent() {
    try {
      $this->child();
    }
    catch (ReturnException $e) {
      return $e->value();
    }

    // Remainder of original parent code
    // ...
  }

  function child() {
    // Part of code previously in parent()
    // ...
    throw (new ReturnException)->response($return_value);
  }
```

Again, this is intended to be a temporary measure to allow you to refactor your code
and eventually eliminate the need for `ReturnException`. One of the good things about both of these
methods is that you can search through your project for remaining instances of `ExitException`,
`DieException` and `ReturnException` to know what still needs cleaning up.
