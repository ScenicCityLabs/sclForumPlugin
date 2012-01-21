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

/* @var $sclForum sclForum */
/* @var $record sclTopic */
?>
<div class="page-header">
  <h1><?php echo $sclForum->getTitle() ?></h1>
</div>

<div class="topic-actions">
  <?php echo link_to('New Topic','scl_topic_new',$sclForum) ?>
</div>

<div class="topic-list">
<?php foreach($pager->getResults() as $record): ?>
  <div class="topic-wrapper">
    <div class="topic-title"><?php echo link_to($record->getTitle(),'scl_topic_show',$record) ?></div>
  </div>
<?php endforeach; ?>
</div>