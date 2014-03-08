<?php
class Base {
    public $error = null;

    public function __set($name, $value) {
        if (isset($this->fields[$name])) {
            $this->fields[$name]['value'] = $value;
        }
    }

    public function __get($name) {
        if (isset($this->fields[$name])) {
            if (isset($this->fields[$name]['value'])) {
                return $this->fields[$name]['value'];
            }
        }

        return null;
    }

    public function __unset($name) {
        if (isset($this->fields[$name])) {
            unset($this->fields[$name]);
        }
    }
}