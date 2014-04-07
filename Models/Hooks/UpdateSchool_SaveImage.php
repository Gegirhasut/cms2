<?php
class UpdateSchool_SaveImage {
    /**
     * @param $db MySQL
     */
    public static function exec($db, $object) {
        if (isset($_SESSION['school_auth']) && $object->u_id == $_SESSION['school_auth']['s_id']) {
            $_SESSION['image_url'] = $_SESSION['school_auth']['banner'];
        } else {
            $user_pic = $db->select("banner")
                ->from('at_schools')
                ->where('s_id = ' . $object->s_id)
                ->fetch();

            if (!empty($user_pic)) {
                $_SESSION['image_url'] = $user_pic[0]['banner'];
            }
        }
    }
}