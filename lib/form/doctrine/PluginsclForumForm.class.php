<?php

/**
 * PluginsclForum form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginsclForumForm extends BasesclForumForm
{

  /**
   * Setup the form
   */
  public function setup()
  {
    parent::setup();
    $this->offsetUnset('created_at');
    $this->offsetUnset('updated_at');
    $this->offsetUnset('lft');
    $this->offsetUnset('rgt');
    $this->offsetUnset('level');
    $this->offsetUnset('root_id');
    $this->offsetUnset('created_by');
    $this->offsetUnset('updated_by');
    if ($this->isNew())
    {
      $this->offsetUnset('slug');
    }
  }

}
