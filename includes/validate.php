<?php
/**
 * validate.php
 * Simple PHP class and validation logic for form input.
 */

$val = new Validator();
$val->email($_POST['email'], 'email');
$val->text($_POST['phrase'], 'phrase');

echo json_encode($val);
exit();

class Validator {

  public $errors = array();
  public $values = array();

  /**
   * Validate and sanitize an email field.
   *
   * @param string $value
   *  The value of the email field submitted by the form.
   * @param string $element
   *  The specific element id of the email form input.
   */
  public function email($value, $element) {
    // Bootstrap actually provides this, but we'll use this as backup.
    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
      $this->errors[$element] = 'Please enter an email address';
    }
    else {
      $this->errors[$element] = '';
    }

    // Sanitize email.
    $this->values[$element] = filter_var($value, FILTER_SANITIZE_EMAIL);
  }

  /**
   * Validate and sanitize a text field.
   *
   * @param string $value
   *  The value of the text field submitted by the form.
   * @param string $element
   *  The specific element id of the text field form input.
   */
  public function text($value, $element) {
    $value = trim($value);
    if (!filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[-a-zA-Z0-9\s.:,]*$/")))) {
      $this->errors[$element] = 'Please enter a message (alphanumeric only)';
    }
    else {
      $this->errors[$element] = '';
    }

    // Sanitize string.
    $this->values[$element] = filter_var($value, FILTER_SANITIZE_STRING);
  }
}
