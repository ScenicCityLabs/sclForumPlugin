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

/* @var $sclTopic sclTopic */
/* @var $pager sfDoctrinePager */
/* @var $record sclPost */
?>
<div class="page-header">
  <h1><?php echo $sclTopic->getTitle() ?></h1>
</div>

<div class="topic-body">
  <p><?php echo $sclTopic->getBody() ?></p>
</div>

<div class="post-list">
<?php foreach($pager->getResults() as $record): ?>
  <div class="post-wrapper">
    <div class="post-title"><?php echo $record->getTitle() ?></div>
    <div class="post-body"><?php echo $record->getBody() ?></div>
  </div>
<?php endforeach; ?>
</div>

<div class="post-actions">
  <?php echo link_to('Post Reply','scl_post_new',$sclTopic) ?>
</div>