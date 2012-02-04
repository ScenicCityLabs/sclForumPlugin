<?php

/**
 * Base actions for the sclForumPlugin sclPost module.
 * 
 * @package     sclForumPlugin
 * @subpackage  sclPost
 * @author      Scenic City Labs
 * @version     SVN: $Id: BaseActions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
abstract class BasesclPostActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    
  }

  public function executeShow(sfWebRequest $request)
  {

  }

  /**
   *
   * @param sfWebRequest $request
   */
  public function executeNew(sfWebRequest $request)
  {
    $this->sclTopic = $this->getRoute()->getObject();

    if ($this->sclTopic->getIsLocked())
    {
      $this->getUser()->setFlash('error', 'This topic is locked and no replies can be added');
      $this->redirect(array('sf_route' => 'scl_topic_show', 'sf_subject' => $this->sclTopic));
    }

    $this->form = new sclPostForm(null, array(
        'sclTopic' => $this->sclTopic
      ));
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->sclTopic = $this->getRoute()->getObject();
    $this->form = new sclPostForm(null, array(
        'sclTopic' => $this->sclTopic
      ));
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    
  }

  public function executeUpdate(sfWebRequest $request)
  {

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
        if ($form->getObject()->isNew())
        {
          $this->dispatcher->notify(new sfEvent($this, 'forum.post_create', array()));
        }
        else
        {
          $this->dispatcher->notify(new sfEvent($this, 'forum.post_update', array()));
        }
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
        $this->redirect('@scl_post_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);
        $this->redirect(array('sf_route' => 'scl_topic_show', 'sf_subject' => $form->getSclTopic()));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
    }
  }

}
