<?php
class InsertSubject {
    /**
     * @param $db MySQL
     */
    public static function exec($db, $object) {
        $db->sql("UPDATE at_subjects SET cnt = cnt + 1 WHERE s_id = " . $object->s_id);
        $db->sql("UPDATE at_users SET subjects = subjects + 1 WHERE u_id = " . $object->u_id);
    }
}