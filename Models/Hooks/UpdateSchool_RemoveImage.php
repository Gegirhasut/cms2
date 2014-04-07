<?php
class UpdateSchool_RemoveImage {
    /**
     * @param $db MySQL
     * @param $object User
     */
    public static function exec($db, $object) {
        if (isset($_SESSION['image_url']) && !empty($_SESSION['image_url'])) {
            if ($object->banner != $_SESSION['image_url']) {
                if (file_exists($object->images['small_path'] . $_SESSION['image_url'])) {
                    unlink($object->images['small_path'] . $_SESSION['image_url']);
                }
                if (file_exists($object->images['upload'] . $_SESSION['image_url'])) {
                    unlink($object->images['upload'] . $_SESSION['image_url']);
                }
            }

            unset($_SESSION['image_url']);
        }
    }
}