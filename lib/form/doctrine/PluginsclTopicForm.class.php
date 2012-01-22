<?php

/**
 * PluginsclTopic form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginsclTopicForm extends BasesclTopicForm
{
  public function setup()
  {
    parent::setup();
    $this->offsetUnset('ip_address');
    $this->offsetUnset('created_at');
    $this->offsetUnset('updated_at');
    $this->offsetUnset('created_by');
    $this->offsetUnset('updated_by');
    $this->offsetUnset('deleted_at');
    $this->offsetUnset('version');

    $this->setWidget('forum_id', new sfWidgetFormInputHidden());

    if ($this->getOption('sclForum'))
    {
      $this->getWidget('forum_id')->setAttribute('value', $this->getOption('sclForum')->getId());
    }
    elseif(!$this->isNew())
    {
      $this->getWidget('forum_id')->setAttribute('value', $this->getObject()->getForumId());
    }
  }

  public function getSclForum()
  {
    if ($this->getOption('sclForum'))
    {
      return $this->getOption('sclForum');
    }
    elseif (!$this->isNew())
    {
      return $this->getObject()->Forum;
    }

    return false;
  }
}
