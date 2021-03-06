<?php
namespace MyFirstBlog\Controller;

use Pimf\Controller\Base, Pimf\View, Pimf\Registry, Pimf\Util\Validator, Pimf\Controller\Exception as Bomb,
    Pimf\View\Json as ViewJson, Pimf\Cli\Io, MyFirstBlog\Model\Entry;

class Blog extends Base
{
  /**
   * A index action - this is a framework restriction!
   */
  public function indexAction()
  {
    $this->listentriesAction();
  }

  /**
   * @param View $view
   * @return string
   */
  protected function loadMainView(View $view)
  {
    echo new View(
      'blog.phtml',
      array(
        'blog_title'   => 'Welcome to PIMF blog',
        'blog_content' => $view,
        'blog_footer'  => 'Learn the terrain and create something beautiful!'
      )
    );
  }

  /**
   * Renders a HTML list of all entries which are stored at the sqlite database.
   */
  public function listentriesAction()
  {
    // use app/MyFirstBlog/_templates/list.phtml for viewing
    $viewAllEntries = new View('list.phtml');
    $entries        = Registry::get('em')->entry->getAll();

    // assign data to the template
    $viewAllEntries->assign('entries', $entries);

    echo $this->loadMainView($viewAllEntries);
  }

  /**
   * Renders a single entry from the list.
   *
   * @throws \Pimf\Controller\Exception
   */
  public function showentryAction()
  {
    // first we check the input-parameters which are send with GET http method.
    $valid = new Validator($this->request->fromGet());

    if (!$valid->digit('id') || !$valid->value('id', '>', 0)) {
      throw new Bomb('not valid entry for "id"');
    }

    // we open new view and
    // use app/MyFirstBlog/_templates/entry.phtml for viewing
    $viewSingleEntry = new View('article.phtml');

    $entry = Registry::get('em')->entry->find(
      $this->request->fromGet()->get('id')
    );

    // assign data to the template
    $viewSingleEntry
      ->pump($entry->toArray())
      ->assign('back_link_title', 'Back to overview')
      ->assign('json_link_title', 'Show as JSON');

    echo $this->loadMainView($viewSingleEntry);
  }

  /**
   * A action for deleting a blog-article.
   */
  public function deleteAction()
  {
    Registry::get('em')->entry->delete(
      $this->request->fromGet()->get('id')
    );

    $this->indexAction();
  }

  /**
   * Sends a data for single entry as a JSON format.
   */
  public function jsonAction()
  {
    // first we check the input-parameters which are send with GET http method.
    $valid = new Validator($this->request->fromGet());

    if (!$valid->digit('id') || !$valid->value('id', '>', 0)) {
      throw new Bomb('not valid entry for "id"');
    }

    /* @var $em \Pimf\EntityManager */
    $em = Registry::get('em');

    // find entry by id
    $entry = $em->entry->find(
      $this->request->fromGet()->get('id')
    );

    // open new json view
    $view = new ViewJson();

    // pump all data to the view and render
    $view->pump($entry->toArray())->render();
  }

  /**
   * A cli action for inserting a blog-article.
   */
  public function insertCliAction()
  {
    $title   = Io::read('article title');
    $content = Io::read('article content');

    $res = Registry::get('em')->entry->insert(
      new Entry($title, $content)
    );

    var_dump($res);
  }

  /**
   * A cli action for updating a blog-article.
   */
  public function updateCliAction()
  {
    $id      = Io::read('article id', '/[1-9999]/');
    $title   = Io::read('article title');
    $content = Io::read('article content');

    $em    = Registry::get('em');
    $entry = new Entry($title, $content);

    $entry = $em->entry->reflect($entry, $id);

    $res = $em->entry->update($entry);

    var_dump($res);
  }

  /**
   * A cli action for deleting a blog-article.
   */
  public function deleteCliAction()
  {
    $id = Io::read('entry id', '/[1-9999]/');

    $res = Registry::get('em')->entry->delete($id);

    var_dump($res);
  }

  /**
   * A cli action for creating the blog-table.
   * @throws \Pimf\Controller\Exception
   */
  public function create_blog_tableCliAction()
  {
    try {

      $pdo = Registry::get('em')->getPDO();

      $res = $pdo->exec(
        file_get_contents(
          dirname(dirname(__FILE__)) . '/_database/create-table.sql'
        )
      ) or print_r($pdo->errorInfo(), true);

      var_dump($res);

    } catch (\PDOException $e) {
      throw new Bomb($e->getMessage());
    }
  }
}