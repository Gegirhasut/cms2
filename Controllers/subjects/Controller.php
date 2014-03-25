<?php
require_once('Controllers/SmartyController.php');
require_once ('Database/DBFactory.php');

class Controller extends SmartyController
{
    public $db = null;

    function __construct() {
        /**
         * var MySQL
         */

        $this->db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
        parent::__construct();
    }

    function loadSubjects() {
        Application::requireClass('Subject');
        Application::requireClass('Rubric');
        $subject = new Subject();
        $rubric = new Rubric();

        if (count(Router::$path) > 0) {
            $rubrics = $this->db->select('title, r_id')
                ->from($rubric->table)
                ->where('r_id = ' . (int) Router::$path[0])
                ->orderBy('sort')
                ->fetch('r_id');

            if (!empty($rubrics)) {
                foreach ($rubrics as $r) {
                    $this->smarty->assign('title', 'Все Учителя - Предметы для обучения. ' . $r['title']);
                    $this->smarty->assign('description', 'Все Учителя - Поиск репетиторов. Предметы для обучения. ' . $r['title']);
                    $this->smarty->assign('keywords', $r['title'] . ', учителя, репетиторы');
                    $this->smarty->assign('h1', "Предметы для обучения. {$r['title']}.");
                }
            }
        } else {
            $rubrics = $this->db->select('title, r_id')
                ->from($rubric->table)
                ->orderBy('sort')
                ->fetch('r_id');

            $this->smarty->assign('title', 'Все Учителя - Предметы для обучения');
            $this->smarty->assign('description', 'Все Учителя - Поиск репетиторов. Предметы для обучения.');
            $this->smarty->assign('keywords', 'учителя, репетиторы, все рубрики');
            $this->smarty->assign('h1', 'Предметы для обучения');
        }



        foreach ($rubrics as &$rubric) {
            $rubric['subjects'] = array();
        }

        if (count(Router::$path) > 0) {
            $subjects = $this->db->select('subject, url, r_id, subject_po')
                ->from($subject->table)
                ->where('r_id = ' . (int) Router::$path[0])
                ->fetch();
        } else {
            $subjects = $this->db->select('subject, url, r_id, subject_po')
                ->from($subject->table)
                ->fetch();
        }

        foreach ($subjects as $subject) {
            $rubrics[$subject['r_id']]['subjects'][] = $subject;
        }

        $this->smarty->assign('rubrics', $rubrics);
    }

    function display () {
        $this->loadSubjects();

        $this->smarty->assign('page', 'subjects');

        parent::display();
    }
}