<?php

/**
 * Base actions for the sclForumPlugin sclTopic module.
 * 
 * @package     sclForumPlugin
 * @subpackage  sclTopic
 * @author      Scenic City Labs
 * @version     SVN: $Id: BaseActions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
abstract class BasesclTopicActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->sclTopic = $this->getRoute()->getObject();
    $this->pager = new sfDoctrinePager('sclPost');
    $this->pager->setPage($request->getParameter('page',1));
    $query = Doctrine_Core::getTable('sclPost')->createQuery()
      ->where('topic_id = ?',$this->sclTopic->getId())
      ->orderBy('created_at ASC');
    $this->pager->setQuery($query);
    $this->pager->init();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->sclForum = $this->getRoute()->getObject();
    $this->form = new sclTopicForm(null, array(
        'sclForum' => $this->sclForum
      ));
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->sclForum = $this->getRoute()->getObject();
    $this->form = new sclTopicForm(null, array(
        'sclForum' => $this->sclForum
      ));
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->sclTopic = $this->getRoute()->getObject();
    $this->form = new sclTopicForm($this->sclTopic);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->sclTopic = $this->getRoute()->getObject();
    $this->form = new sclTopicForm($this->sclTopic);
    $this->processForm($request, $this->form);
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    
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
        $this->redirect(array('sf_route' => 'scl_forum_edit', 'sf_subject' => $record));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
    }
  }

}
