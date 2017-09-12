<?php
require_once 'exit_die_exception.php';

class ExitDieExceptionTest extends \Codeception\Test\Unit {
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before() {
  }

  protected function _after() {
  }

  // tests
  public function testShouldThrowAnExitException() {
    $this->tester->expectException(new ExitDieException, function() {
      throw new ExitException;
    });
  }

  public function testShouldThrowADieException() {
    $this->tester->expectException(new ExitDieException, function() {
      throw new DieException;
    });
  }

  public function testShouldThrowAnExitExceptionWithAnExitValue() {
    $this->tester->expectException(new ExitDieException('42'), function() {
      throw new ExitException('42');
    });
  }

  public function testShouldThrowADieExceptionWithAnExitValue() {
    $this->tester->expectException(new ExitDieException('42'), function() {
      throw new DieException('42');
    });
  }
}
