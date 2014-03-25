<?php
/**
 * Created by JetBrains PhpStorm.
 * User: максим
 * Date: 21.03.14
 * Time: 22:05
 * To change this template use File | Settings | File Templates.
 */

class RemoveSubject {
    /**
     * @param $db MySQL
     */
    public static function exec($db, $object) {
        $us = $db->select("s_id, u_id")
            ->from('at_user_subjects')
            ->where('us_id = ' . $object->us_id)
            ->fetch();

        if (!empty($us)) {
            $db->sql("UPDATE at_subjects SET cnt = cnt - 1 WHERE s_id = " . $us[0]['s_id']);
            $db->sql("UPDATE at_users SET subjects = subjects - 1 WHERE u_id = " . $us[0]['u_id']);
        }
    }
}