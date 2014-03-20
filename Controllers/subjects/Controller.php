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

        $rubrics = $this->db->select('title, r_id')
            ->from($rubric->table)
            ->orderBy('sort')
            ->fetch('r_id');

        foreach ($rubrics as &$rubric) {
            $rubric['subjects'] = array();
        }

        $subjects = $this->db->select('subject, url, r_id, subject_po')
            ->from($subject->table)
            ->fetch();

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