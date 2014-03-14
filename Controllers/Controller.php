<?php
require_once('Controllers/SmartyController.php');
require_once ('Database/DBFactory.php');

class Controller extends SmartyController
{
    private $db = null;
    private $rubric = null;
    private $subject = null;
    private $user = null;

    function __construct() {
        parent::__construct();
        $this->db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
        Application::requireClass('Rubric');
        $this->rubric = new Rubric();
        Application::requireClass('Subject');
        $this->subject = new Subject();
        Application::requireClass('User');
        $this->user = new User();
    }

    protected function assignSubjects () {
        $rubrics = $this->db
            ->select('r_id, title')
            ->from($this->rubric->table)
            ->orderBy('sort')
            ->limit(0, 4)
            ->fetch('r_id');

        foreach ($rubrics as &$r) {
            $r['subjects'] = array();
            $this->db = $this->db
                ->select('url, subject, r_id')
                ->from($this->subject->table)
                ->where("r_id = {$r['r_id']}")
                ->orderBy('subject')
                ->limit(0, 5)
                ->union();
        }

        $subjects = $this->db->fetch();

        foreach ($subjects as $subject) {
            $rubrics[$subject['r_id']]['subjects'][] = $subject;
        }

        $this->smarty->assign('rubrics', $rubrics);
    }

    function display () {
        $this->assignSubjects();

        $this->smarty->assign('page', 'main');
        parent::display();
    }
}