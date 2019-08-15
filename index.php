<?php
session_start();

// Generate CSRF token.
// This is all likely way easier in a PHP framework,
// but we'll do it the manual way for now.
if (empty($_SESSION['token'])) {
  $_SESSION['token'] = bin2hex(random_bytes(32));
}

if (!empty($_POST['token'])) {
  // Check to make sure hashes match.
  if (!hash_equals($_SESSION['token'], $_POST['csrftoken'])) {
    // We could also do some proper logging here for failed attempts.
    die('An error has occurred.');
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?php echo $_SESSION['token'] ?>">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Suggestion box</title>
  </head>
  <body>
    <div class="container" id="main">
      <h2>Leave a suggestion</h2>

      <form id="suggestion-form">
        <div class="form-group">
          <div class="form-row">
            <div class="col-sm">
              <div class="input-group mb-3 md-form">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="email-tooltip">Email</span>
                </div>
                <input type="email" name="email" class="form-control" id="email" aria-describedby="email-tooltip" placeholder="Enter your contact email">
                <div class="invalid-feedback">
                </div>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-sm">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="phrase-tooltip">Message</span>
                </div>
                <textarea name="phrase" class="form-control" id="phrase" aria-describedby="phrase-tooltip" placeholder="Enter your suggestion here"></textarea>
                <div class="invalid-feedback">
                </div>
              </div>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary float-right">Submit</button>
      </form>
    </div>

    <div class="container" id="response">
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/form.js"></script>
  </body>
</html>
