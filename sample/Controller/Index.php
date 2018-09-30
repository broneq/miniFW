<?php


namespace MiniFwSample\Controller;

use MiniFw\Controller\BaseController;

/**
 * Class Index
 * @package MiniFwSample
 */
class Index extends BaseController
{
    /**
     * Displays default route
     */
    public function indexAction()
    {
        $this->view->render('index/hello', ['var' => 'world']);
    }
}