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

/* @var $form sclForumForm */
?>

<form action="<?php echo url_for_form($form,'@scl_forum') ?>" method="POST">
  <table>
    <tbody><?php echo $form ?></tbody>
    <tfoot>
      <tr>
        <td colspan="2"><input type="submit" value="Save" /></td>
      </tr>
    </tfoot>
  </table>
</form>