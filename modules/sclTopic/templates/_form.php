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

/* @var $form sclTopicForm */
$route  = $form->isNew() ? 'scl_topic_create' : 'scl_topic_update';
$object = $form->isNew() ? $form->getSclForum() : $form->getObject();
?>
<form action="<?php echo url_for($route,$object) ?>" method="POST">
  <table>
    <tbody><?php echo $form ?></tbody>
    <tfoot>
      <tr>
        <td colspan="2"><input type="submit" value="Post Topic" /></td>
      </tr>
    </tfoot>
  </table>
</form>