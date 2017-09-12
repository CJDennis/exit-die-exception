<?php
require_once 'exit_die_exception.php';

class ReturnExceptionTest extends \Codeception\Test\Unit {
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before() {
  }

  protected function _after() {
  }

  // tests
  public function testShouldThrowAReturnException() {
    $this->tester->expectException(new ReturnException, function() {
      throw new ReturnException;
    });
  }

  public function testShouldRetrieveTheReturnExceptionResponseValue() {
    try {
      throw (new ReturnException)->response(42);
    }
    catch (ReturnException $e) {
      $this->assertSame(42, $e->value());
    }
  }
}
