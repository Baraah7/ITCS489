<?php
class CoreController {
  protected function render($view, $data = []) {
    extract($data);
    include "../app/views/$view.php";
  }
}
?>