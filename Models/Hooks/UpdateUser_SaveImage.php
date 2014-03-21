<?php
class UpdateUser_SaveImage {
    /**
     * @param $db MySQL
     */
    public static function exec($db, $object) {
        if (isset($_SESSION['user_auth']) && $object->u_id == $_SESSION['user_auth']['u_id']) {
            $_SESSION['image_url'] = $_SESSION['user_auth']['user_pic'];
        } else {
            $user_pic = $db->select("user_pic")
                ->from('at_users')
                ->where('u_id = ' . $object->u_id)
                ->fetch();

            if (!empty($user_pic)) {
                $_SESSION['image_url'] = $user_pic[0]['user_pic'];
            }
        }
    }
}