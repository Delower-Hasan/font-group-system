<?php
namespace Core;

class Controller {
   
    public function model($model) {
        $modelClass = "App\\Models\\" . $model;

        if (!class_exists($modelClass)) {
            throw new \Exception("Model class '$modelClass' not found.");
        }

        return new $modelClass();
    }

    public function view($view, $data = []) {
        $viewFile = __DIR__ . "/../views/" . $view . ".php";

        if (!file_exists($viewFile)) {
            throw new \Exception("View file '$viewFile' not found.");
        }

        extract($data);
        require_once $viewFile;
    }
}
