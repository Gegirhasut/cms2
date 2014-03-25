<?php
require_once ('Database/DBFactory.php');
require_once ('Controllers/admin/api/BaseApiController.php');

class Controller extends BaseApiController
{
    function post () {
        if (count(Router::$path) < 1) {
            throw new Exception("Unable to use API. No object defined, wrong request: " . $_SERVER['REQUEST_URI']);
            exit;
        }

        $class = Router::$path[0];

        if (!Application::requireClass($class)) {
            throw new Exception("Unable to use API. Wrong Object [$class]. Request: " . $_SERVER['REQUEST_URI']);
            exit;
        }

        $object = new ReflectionClass($class);
        $object = $object->newInstance();

        if (isset($_GET['cancel'])) {
            $file = 'filePath_' . $_POST['field'];
            if (isset($_SESSION[$file])) {
                if (file_exists($object->images['upload'] . $_SESSION[$file])) {
                    unlink($object->images['upload'] . $_SESSION[$file]);
                }
                unset($_SESSION[$file]);
            }
            exit;
        }

        $x = (int) $_POST['x'];
        $y = (int) $_POST['y'];
        $x2 = (int) $_POST['x2'];
        $y2 = (int) $_POST['y2'];
        $dest_w = $object->images['w'];
        $dest_h = $object->images['h'];
        $filePath = $_POST['filePath'];
        $uploadedPath = $object->images['upload'] . $filePath;
        $smallPath = $object->images['small_path'] . $filePath;

        require_once('Helpers/SimpleImage.php');
        $simpleImage = new SimpleImage();
        $simpleImage->load($uploadedPath);
        $simpleImage->crop($x, $y, $x2, $y2, $dest_w, $dest_h);
        $simpleImage->save($smallPath);

        require_once('Helpers/json.php');
        echo arrayToJson(array('path' => $smallPath, 'field' => $_POST['field'], 'file' => $filePath));

        exit;
    }

    function display () {
        $this->post();
    }
}