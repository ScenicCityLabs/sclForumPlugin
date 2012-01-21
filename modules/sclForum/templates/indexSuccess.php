<?php

/**
 * Description
 * 
 * @author      Joshua Estes
 * @copyright
 * @package
 * @subpackage
 * @version
 */

/* @var $pager sfDoctrinePager */
/* @var $record sclForum */
?>
<h1>Forum List</h1>

<div class="forum-list">
<?php foreach($pager->getResults() as $record): ?>
  <div class="forum">
    <div class="forum-title"><?php echo link_to($record->getTitle(),'scl_forum_show',$record) ?></div>
    <div class="forum-description"><?php echo $record->getDescription() ?></div>
  </div>
<?php endforeach; ?>
</div>