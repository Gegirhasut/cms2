<?php
require_once ('Database/DBFactory.php');
require_once ('Controllers/api/BaseApiController.php');

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

        $fileElementName = 'fileToUpload';

        $this->checkUploadFile($fileElementName);

        $result_array = $this->uploadFile($fileElementName, $class);

        @unlink($_FILES[$fileElementName]);

        echo arrayToJson($result_array);
        exit;
    }

    function getExtension($filename)
    {
        return end(explode(".", $filename));
    }

    function uploadFile($fileElementName, $class) {
        Application::requireClass($class);
        $object = new ReflectionClass($class);
        $object = $object->newInstance();

        $fileName = md5(uniqid(mt_rand(), true));
        $from = $_FILES[$fileElementName]['tmp_name'];
        $extension = $this->getExtension(basename($_FILES[$fileElementName]['name']));
        $chars = "0123456789abcdefghijklmnopqrstuvwxyz";

        $path = '';
        while ($object->images['levels'] > 0) {
            $f = $chars[rand(0, strlen($chars)-1)];
            $object->images['levels']--;
            $path .= "/$f";
            if (!is_dir($object->images['upload'] . $path)) {
                mkdir($object->images['upload'] . $path);
            }

            if (!is_dir($object->images['small_path'] . $path)) {
                mkdir($object->images['small_path'] . $path);
            }
        }

        $to = $object->images['upload'] . $path . "/$fileName.$extension";

        if (move_uploaded_file($from, $to)) {
            require_once("Helpers/SimpleImage.php");
            $image = new SimpleImage();
            $image->load($to);

            if ($image->getWidth() > $object->images['maxw']) {
                $image->resizeToWidth($object->images['maxw']);
            }

            if ($image->getHeight() > $object->images['maxh']) {
                $image->resizeToHeight($object->images['maxh']);
            }

            $image->save($to);

            $_SESSION['filePath_' . $_POST['field']] = $path . "/$fileName.$extension";

            $result = array();
            $result['filePath'] = $path . "/$fileName.$extension";
            $result['to'] = $to;
            $result['path'] = $path;

            $result['realw'] = $image->getWidth();
            $result['realh'] = $image->getHeight();
            $result['picw'] = $object->images['w'];
            $result['pich'] = $object->images['h'];
            $result['field'] = $_POST['field'];

            return $result;
        } else {
            return array ('error' => 'Unable to upload file');
        }
    }

    function checkUploadFile ($fileElementName) {
        require_once('Helpers/json.php');
        $result = array();

        if(!empty($_FILES[$fileElementName]['error']))
        {
            switch($_FILES[$fileElementName]['error'])
            {
                case '1':
                    $result['error'] = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
                    break;
                case '2':
                    $result['error'] = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
                    break;
                case '3':
                    $result['error'] = 'The uploaded file was only partially uploaded';
                    break;
                case '4':
                    $result['error'] = 'No file was uploaded.';
                    break;

                case '6':
                    $result['error'] = 'Missing a temporary folder';
                    break;
                case '7':
                    $result['error'] = 'Failed to write file to disk';
                    break;
                case '8':
                    $result['error'] = 'File upload stopped by extension';
                    break;
                case '999':
                default:
                    $result['error'] = 'No error code available';
            }
        } elseif (empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none') {
            $result['error'] =  'No file was uploaded..';
        }
        if (!empty($result)) {
            echo arrayToJson($result);
            exit;
        }
    }

    function display () {
        $this->post();
    }
}