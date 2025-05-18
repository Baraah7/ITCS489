<?php
require_once 'models/Category.php';

class CategoryController {
    public function index() {
        $categories = Category::getAll();
        include 'views/categories/index.php';
    }

    public function create() {
        include 'views/categories/create.php';
    }

    public function store($data) {
        Category::create($data);
        header('Location: index.php?controller=category&action=index');
    }

    public function edit($id) {
        $category = Category::getById($id);
        include 'views/categories/edit.php';
    }

    public function update($id, $data) {
        Category::update($id, $data);
        header('Location: index.php?controller=category&action=index');
    }

    public function delete($id) {
        Category::delete($id);
        header('Location: index.php?controller=category&action=index');
    }
}
?>