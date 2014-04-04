<?php

class ObjectParser
{
    public static $object = 'Пользователь';

    public static function getMessage($check) {
        switch ($check) {
            case 'not_empty':
                return 'Поле не может быть пустым!';
            case 'email':
                return 'Не корректный email адрес!';
            case 'password2':
                return 'Пароли не совпадают!';
            case 'login':
                return 'Пара email и пароль не найдена!';
            case 'unique':
                return self::$object . ' с таким email уже существует!';
            case 'email_not_found':
                return self::$object . ' с указанным email не существует!';
            case 'strict':
                return 'Пароль должен быть длиной не менее 6 символов!';
            case 'website':
                return 'Не верно задан вебсайт. Указание http(s):// обязательно!';
        }

        return 'Ошибка';
    }

    public static function setSessionValues($name, $object) {
        foreach ($object->fields as $key => $value) {
            if (isset($value['value'])) {
                $_SESSION[$name][$key] = $value['value'];
            }
        }
    }

    public static function parse($input, $object, $noCheck = false) {
        $object->error = array();

        foreach($object->fields as $key => &$field) {
            if (isset($input[$key])) {
                if ($field['type'] == 'generated') {

                }
                elseif ($field['type'] == 'password') {
                    if (!empty($input[$key])) {
                        $field['value'] = md5($input[$key] . $GLOBALS['salt']);
                    }
                } else {
                    $field['value'] = $input[$key];
                }

                if (empty($field['value'])) {
                    switch ($field['type']) {
                        case 'decimal':
                        case 'integer':
                            $field['value'] = 0;
                            break;
                    }
                }
            }

            if ($field['type'] == 'checkbox') {
                $field['value'] = '0';
                if (!empty($input[$key]) && $input[$key] == 'on') {
                    $field['value'] = '1';
                }
            }
        }

        if ($noCheck) {
            return;
        }

        foreach($object->fields as $key => &$field) {
            if (!empty($field['check'])) {
                foreach ($field['check'] as $check) {
                    $error = false;
                    switch ($check) {
                        case 'not_empty':
                            $error = empty($field['value']);
                            break;
                        case 'email':
                            if (isset($field['value'])) {
                                $error = !filter_var($field['value'], FILTER_VALIDATE_EMAIL);
                            }
                            break;
                        case 'website':
                            if (isset($field['value'])) {
                                $error = !filter_var($field['value'], FILTER_VALIDATE_URL);
                            }
                            break;
                        case 'password2':
                            if (isset($field['value'])) {
                                $error = $object->fields[$field['password_field']]['value'] != $field['value'];
                            }
                            break;
                        case 'strict':
                            if (isset($field['value'])) {
                                $error = strlen($_POST[$key]) < 6;
                            }
                            break;
                    }

                    if ($error) {
                        $object->error[] = array ('name' => $key, 'message' => self::getMessage($check));
                    }
                }
            }
        }
    }
}