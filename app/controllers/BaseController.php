<?php
class BaseController {
  protected function render($view, $data = []) {
    extract($data);
    include "../app/views/$view.php";
  }

  public function index() {
    $this->render('mainPage');
  }
}
?>