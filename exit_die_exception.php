<?php
class ExitDieException extends Exception {}
class DieException extends ExitDieException {}
class ExitException extends ExitDieException {}

class ReturnException extends Exception {
  protected $value;

  public function response($value) {
    $this->value = $value;
    return $this;
  }

  public function value() {
    return $this->value;
  }
}
