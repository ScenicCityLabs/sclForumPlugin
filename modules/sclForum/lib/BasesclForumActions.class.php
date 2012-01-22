<?php

/**
 * Base actions for the sclForumPlugin sclForum module.
 * 
 * @package     sclForumPlugin
 * @subpackage  sclForum
 * @author      Scenic City Labs
 * @version     SVN: $Id: BaseActions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
abstract class BasesclForumActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->pager = new sfDoctrinePager('sclForum', 0);
    $query = Doctrine_Core::getTable('sclForum')->createQuery()
      ->orderBy('root_id ASC, lft ASC');
    $this->pager->setQuery($query);
    $this->pager->init();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->sclForum = $this->getRoute()->getObject();
    $this->pager = new sfDoctrinePager('sclTopic');
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->setMaxPerPage($request->getParameter('maxperpage', 10));
    $query = Doctrine_Core::getTable('sclTopic')->createQuery()
        ->where('forum_id = ?', $this->sclForum->getId())
        ->orderBy('is_sticky DESC, updated_at DESC');
    $this->pager->setQuery($query);
    $this->pager->init();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new sclForumForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new sclForumForm();
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->sclForum = $this->getRoute()->getObject();
    $this->form = new sclForumForm($this->sclForum);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->sclForum = $this->getRoute()->getObject();
    $this->form = new sclForumForm($this->sclForum);
    $this->processForm($request, $this->form);
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->sclForum = $this->getRoute()->getObject();
    $request->checkCSRFProtection();
    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->sclForum)));
    if ($this->getRoute()->getObject()->getNode()->delete())
    {
      $this->getUser()->setFlash('notice', 'The forum was deleted successfully.');
    }
    $this->redirect('@scl_forum');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';
      try
      {
        $record = $form->save();
      }
      catch (Doctrine_Validator_Exception $e)
      {
        $errorStack = $form->getObject()->getErrorStack();
        $message = get_class($form->getObject()) . ' has ' . count($errorStack) . " field" . (count($errorStack) > 1 ? 's' : null) . " with validation errors: ";
        foreach ($errorStack as $field => $errors)
        {
          $message .= "$field (" . implode(", ", $errors) . "), ";
        }
        $message = trim($message, ', ');
        $this->getUser()->setFlash('error', $message);
        return sfView::SUCCESS;
      }
      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice . ' You can add another one below.');
        $this->redirect('@scl_forum_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);
        $this->redirect(array('sf_route' => 'scl_forum_show', 'sf_subject' => $record));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
    }
  }

}
