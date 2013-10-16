<?php
class MyFirstBlog_Controller_Blog extends Pimf_Controller_Abstract
{
  /**
   * A index action - this is a framework restriction!
   */
  public function indexAction()
  {
    $this->listentriesAction();
  }

  /**
   * @param Pimf_View $view
   * @return string
   */
  protected function loadMainView(Pimf_View $view)
  {
    echo new Pimf_View(
      'blog.phtml',
      array(
        'blog_title'   => 'This is my firs Blog with PIMF',
        'blog_content' => $view,
        'blog_footer'  => 'A Blog about cool and thin framework'
      )
    );
  }

  /**
   * Renders a HTML list of all entries which are stored at the sqlite database.
   */
  public function listentriesAction()
  {
    // use app/MyFirstBlog/_templates/list.phtml for viewing
    $viewAllEntries = new Pimf_View('list.phtml');
    $entries        = Pimf_Registry::get('em')->entry->getAll();

    // assign data to the template
    $viewAllEntries->assign('entries', $entries);

    echo $this->loadMainView($viewAllEntries);
  }

  /**
   * Renders a single entry from the list.
   *
   * @throws Pimf_Controller_Exception
   */
  public function showentryAction()
  {
    // first we check the input-parameters which are send with GET http method.
    $valid = new Pimf_Util_Validator($this->request->fromGet());

    if (!$valid->digit('id') || !$valid->value('id', '>', 0)) {
      throw new Pimf_Controller_Exception('not valid entry for "id"');
    }

    // we open new view and
    // use app/MyFirstBlog/_templates/entry.phtml for viewing
    $viewSingleEntry = new Pimf_View('article.phtml');

    $entry = Pimf_Registry::get('em')->entry->find(
      $this->request->fromGet()->get('id')
    );

    // assign data to the template
    $viewSingleEntry
      ->pump($entry->toArray())
      ->assign('back_link_title', 'Back to overview')
      ->assign('delete_link_title', 'Delete this entry');

    echo $this->loadMainView($viewSingleEntry);
  }

  /**
   * A action for deleting a blog-article.
   */
  public function deleteAction()
  {
    Pimf_Registry::get('em')->entry->delete(
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
    $valid = new Pimf_Util_Validator($this->request->fromGet());

    if (!$valid->digit('id') || !$valid->value('id', '>', 0)) {
      throw new Pimf_Controller_Exception('not valid entry for "id"');
    }

    /* @var $em Pimf_EntityManager */
    $em = Pimf_Registry::get('em');

    // find entry by id
    $entry = $em->entry->find(
      $this->request->fromGet()->get('id')
    );

    // open new json view
    $view = new Pimf_View_Json();

    // pump all data to the view and render
    $view->pump($entry)->render();
  }

  /**
   * A cli action for inserting a blog-article.
   */
  public function insertCliAction()
  {
    $title   = Pimf_Cli_Io::read('article title');
    $content = Pimf_Cli_Io::read('article content');

    $res = Pimf_Registry::get('em')->entry->insert(
      new MyFirstBlog_Model_Entry($title, $content)
    );

    var_dump($res);
  }

  /**
   * A cli action for updating a blog-article.
   */
  public function updateCliAction()
  {
    $id      = Pimf_Cli_Io::read('article id', '/[1-9999]/');
    $title   = Pimf_Cli_Io::read('article title');
    $content = Pimf_Cli_Io::read('article content');

    $em    = Pimf_Registry::get('em');
    $entry = new MyFirstBlog_Model_Entry($title, $content);

    $entry = $em->entry->reflect($entry, $id);

    $res = $em->entry->update($entry);

    var_dump($res);
  }

  /**
   * A cli action for deleting a blog-article.
   */
  public function deleteCliAction()
  {
    $id = Pimf_Cli_Io::read('entry id', '/[1-9999]/');

    $res = Pimf_Registry::get('em')->entry->delete($id);

    var_dump($res);
  }

  /**
   * A cli action for creating the blog-table.
   * @throws Pimf_Controller_Exception
   */
  public function create_blog_tableCliAction()
  {
    try {

      $res = Pimf_Registry::get('em')->getPDO()->exec(
        file_get_contents(
          dirname(dirname(__FILE__)) .'/_database/create-table.sql'
        )
      );

      var_dump($res);

    } catch (PDOException $e) {
      throw new Pimf_Controller_Exception($e->getMessage());
    }
  }
}