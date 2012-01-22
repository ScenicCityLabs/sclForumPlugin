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

    // create a new widget to represent this category's "parent"
    $this->setWidget('parent', new sfWidgetFormDoctrineChoiceNestedSet(array(
        'model' => 'sclForum',
        'add_empty' => true,
      )));

    // if the current category has a parent, make it the default choice
    if ($this->getObject()->getNode()->hasParent())
    {
      $this->setDefault('parent', $this->getObject()->getNode()->getParent()->getId());
    }
    // set a validator for parent which prevents a category being moved to one of its own descendants
    $this->setValidator('parent', new sfValidatorDoctrineChoiceNestedSet(array(
        'required' => false,
        'model' => 'sclForum',
        'node' => $this->getObject(),
      )));
    $this->getValidator('parent')->setMessage('node', 'A category cannot be made a descendent of itself.');
  }

  /**
   * Updates and saves the current object. Overrides the parent method
   * by treating the record as a node in the nested set and updating
   * the tree accordingly.
   *
   * @param Doctrine_Connection $con An optional connection parameter
   */
  public function doSave($con = null)
  {
    // save the record itself
    parent::doSave($con);
    // if a parent has been specified, add/move this node to be the child of that node
    if ($this->getValue('parent'))
    {
      $parent = Doctrine::getTable('sclForum')->findOneById($this->getValue('parent'));
      if ($this->isNew())
      {
        $this->getObject()->getNode()->insertAsLastChildOf($parent);
      }
      else
      {
        $this->getObject()->getNode()->moveAsLastChildOf($parent);
      }
    }
    // if no parent was selected, add/move this node to be a new root in the tree
    else
    {
      $categoryTree = Doctrine::getTable('sclForum')->getTree();
      if ($this->isNew())
      {
        $categoryTree->createRoot($this->getObject());
      }
      else
      {
        $this->getObject()->getNode()->makeRoot($this->getObject()->getId());
      }
    }
  }

}
