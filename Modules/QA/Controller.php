<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);
namespace Modules\QA;

use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Module\ModuleAbstract;
use phpOMS\Module\WebInterface;
use phpOMS\Views\View;
use phpOMS\Asset\AssetType;

use Modules\QA\Models\QAQuestionMapper;
use Modules\QA\Models\QABadgeMapper;

/**
 * Task class.
 *
 * @category   Modules
 * @package    Modules\QA
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Controller extends ModuleAbstract implements WebInterface
{

    /**
     * Module path.
     *
     * @var string
     * @since 1.0.0
     */
    /* public */ const MODULE_PATH = __DIR__;

    /**
     * Module version.
     *
     * @var string
     * @since 1.0.0
     */
    /* public */ const MODULE_VERSION = '1.0.0';

    /**
     * Module name.
     *
     * @var string
     * @since 1.0.0
     */
    /* public */ const MODULE_NAME = 'QA';

    /**
     * Module id.
     *
     * @var int
     * @since 1.0.0
     */
    /* public */ const MODULE_ID = 1006000000;

    /**
     * Providing.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $providing = [];

    /**
     * Dependencies.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $dependencies = [
    ];

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function setUpBackend(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        $head = $response->get('Content')->getData('head');
        $head->addAsset(AssetType::CSS, $request->getUri()->getBase() . 'Modules/QA/Theme/Backend/styles.css');
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewQADashboard(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/QA/Theme/Backend/qa-dashboard');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1006001001, $request, $response));

        $list = QAQuestionMapper::getNewest(50);
        $view->setData('questions', $list);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewQABadgeList(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/QA/Theme/Backend/qa-tag-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1006001001, $request, $response));

        $list = QABadgeMapper::getAll();
        $view->setData('tags', $list);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewQABadgeEdit(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/QA/Theme/Backend/qa-tag-edit');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1006001001, $request, $response));

        $tag = QABadgeMapper::get((int) $request->getData('id'));
        $view->setData('tag', $tag);

        return $view;
    }
    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewQADoc(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/QA/Theme/Backend/qa-question');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1006001001, $request, $response));

        $question = QAQuestionMapper::get((int) $request->getData('id'));
        $view->addData('question', $question);

        return $view;
    }
    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewQAQuestionCreate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/QA/Theme/Backend/qa-question-create');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1006001001, $request, $response));

        $question = QAQuestionMapper::get((int) $request->getData('id'));
        $view->addData('question', $question);

        return $view;
    }

    public function apiQAQuestionCreate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        if (!empty($val = $this->validateQAQuestionCreate($request))) {
            $response->set('qa_question_create', new FormValidation($val));

            return;
        }

        $question = $this->createQAQuestionFromRquest($request);
        QAQuestionMapper::create($question);
        $response->set('question', $question->jsonSerialize());
    }

    public function createQAQuestionFromRquest(RequestAbstract $request) : QAQuestion
    {
        $mardkownParser = new Markdown();
        
        $question = new QAQuestion();
        $question->setName($request->getData('title'));
        $question->setQuestion($request->getData('plain'));
        $question->setLanguage($request->getData('language'));
        $question->setCategory((int) $request->getData('category'));
        $question->setStatus((int) $request->getData('status'));
        $question->setBadges((array) $request->getData('badges'));

        return $question;
    }

    private function validateQAQuestionCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (
            ($val['title'] = empty($request->getData('title')))
            || ($val['plain'] = empty($request->getData('plain')))
            || ($val['language'] = empty($request->getData('language')))
            || ($val['category'] = empty($request->getData('category')))
            || ($val['badges'] = empty($request->getData('badges')))
            || ($val['status'] = (
                $request->getData('status') !== null
                && !QAQuestionStatus::isValidValue(strtolower($request->getData('status')))
            ))
        ) {
            return $val;
        }

        return [];
    }

    public function apiQAAnswerCreate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        if (!empty($val = $this->validateQAAnswerCreate($request))) {
            $response->set('qa_answer_create', new FormValidation($val));

            return;
        }

        $answer = $this->createQAAnswerFromRquest($request);
        QAAnswerMapper::create($answer);
        $response->set('answer', $answer->jsonSerialize());
    }

    public function createQAAnswerFromRquest(RequestAbstract $request) : QAAnswer
    {
        $mardkownParser = new Markdown();
        
        $answer = new QAAnswer();
        $answer->setName($request->getData('title'));
        $answer->setQuestion($request->getData('plain'));
        $answer->setQuestion((int) $request->getData('question'));
        $answer->setStatus((int) $request->getData('status'));

        return $answer;
    }

    private function validateQAAnswerCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (
            ($val['title'] = empty($request->getData('title')))
            || ($val['plain'] = empty($request->getData('plain')))
            || ($val['question'] = empty($request->getData('question')))
            || ($val['status'] = (
                $request->getData('status') !== null
                && !QAAnswerStatus::isValidValue(strtolower($request->getData('status')))
            ))
        ) {
            return $val;
        }

        return [];
    }

    public function apiQACategoryCreate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        if (!empty($val = $this->validateQACategoryCreate($request))) {
            $response->set('qa_category_create', new FormValidation($val));

            return;
        }

        $category = $this->createQACategoryFromRquest($request);
        QACategoryMapper::create($category);
        $response->set('category', $category->jsonSerialize());
    }

    public function createQACategoryFromRquest(RequestAbstract $request) : QACategory
    {
        $mardkownParser = new Markdown();
        
        $category = new QACategory();
        $category->setName($request->getData('title'));
        $category->setParent((int) $request->getData('parent'));

        return $category;
    }

    private function validateQACategoryCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (
            ($val['title'] = empty($request->getData('title')))
            || ($val['parent'] = empty($request->getData('parent')))
        ) {
            return $val;
        }

        return [];
    }

    public function apiQABadgeCreate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        if (!empty($val = $this->validateQABadgeCreate($request))) {
            $response->set('qa_badge_create', new FormValidation($val));

            return;
        }

        $badge = $this->createQABadgeFromRquest($request);
        QABadgeMapper::create($badge);
        $response->set('badge', $badge->jsonSerialize());
    }

    public function createQABadgeFromRquest(RequestAbstract $request) : QABadge
    {
        $mardkownParser = new Markdown();
        
        $badge = new QABadge();
        $badge->setName($request->getData('title'));

        return $badge;
    }

    private function validateQABadgeCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (
            ($val['title'] = empty($request->getData('title')))
        ) {
            return $val;
        }

        return [];
    }
}
