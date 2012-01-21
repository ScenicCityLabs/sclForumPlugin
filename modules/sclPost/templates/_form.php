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

/* @var $form sclPostForm */
?>
<form action="<?php echo url_for('scl_post_create',$form->getSclTopic()) ?>" method="POST">
  <table>
    <tbody><?php echo $form ?></tbody>
    <tfoot>
      <tr>
        <td colspan="2"><input type="submit" value="Reply" /></td>
      </tr>
    </tfoot>
  </table>
</form>