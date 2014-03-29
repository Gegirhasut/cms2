<?php
class MemcacheServer
{
    protected static $memcache = null;

    public static function connect () {
        @self::$memcache = memcache_connect($GLOBALS['memcache']['ip'], 11211);
        return self::$memcache;
    }

    public static function tryToShowPage($pageKey, $userDependant = false) {
        if ($userDependant) {
            $pageKey .= '_' . isset($_SESSION['user_auth']);
        }
        if (($page = self::$memcache->get($pageKey)) != null) {
            echo $page;
            exit;
        }

        return $pageKey;
    }
}