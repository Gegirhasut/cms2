<?php

class ObjectParser {
    public static function parse($input, $object) {
        foreach($object->fields as $key => &$field) {
            if (isset($input[$key])) {
                $field['value'] = $input[$key];
                if (empty($field['value'])) {
                    switch ($field['type']) {
                        case 'decimal':
                        case 'integer':
                            $field['value'] = 0;
                            break;
                    }
                }
            }
        }
    }
}