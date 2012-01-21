<?php

/**
 * PluginsclPost form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginsclPostForm extends BasesclPostForm
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
    $this->setWidget('topic_id', new sfWidgetFormInputHidden());

    if ($this->getOption('sclTopic'))
    {
      $this->getWidget('forum_id')->setAttribute('value', $this->getOption('sclTopic')->getForum()->getId());
      $this->getWidget('topic_id')->setAttribute('value', $this->getOption('sclTopic')->getId());
    }
  }

  public function getSclTopic()
  {
    if ($this->getOption('sfTopic'))
    {
      return $this->getOption('sclTopic');
    }

    return $this->getObject()->getTopic();
  }

  public function getSclForum()
  {
    
  }
}
