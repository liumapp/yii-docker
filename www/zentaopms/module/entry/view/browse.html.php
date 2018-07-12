<?php
/**
 * The browse view file of entry module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2017 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Gang Liu <liugang@cnezsoft.com>
 * @package     entry 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include 'header.html.php';?>
<?php js::set('confirmDelete', $lang->entry->confirmDelete);?>
<form id='ajaxForm' method='post'>
  <table id='entryList' class='table table-condensed table-hover table-striped tablesorter'>
    <thead>
      <tr>
        <?php $vars = "orderBy=%s&recTotal=$pager->recTotal&recPerPage=$pager->recPerPage&pageID=$pager->pageID";?>
        <th class='w-50px'><?php  common::printOrderLink('id',   $orderBy, $vars, $lang->entry->id);?></th>
        <th class='w-200px'><?php common::printOrderLink('name', $orderBy, $vars, $lang->entry->name);?></th>
        <th class='w-100px'><?php common::printOrderLink('code', $orderBy, $vars, $lang->entry->code);?></th>
        <th class='w-200px'><?php common::printOrderLink('key',  $orderBy, $vars, $lang->entry->key);?></th>
        <th class='w-200px'><?php common::printOrderLink('ip',   $orderBy, $vars, $lang->entry->ip);?></th>
        <th><?php echo common::printOrderLink('desc', $orderBy, $vars, $lang->entry->desc);?></th>
        <th class='w-80px'><?php echo html::a('###', $lang->actions);?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($entries as $id => $entry):?>
      <tr>
        <td class='text-center'><?php echo $id;?></td>
        <td title='<?php echo $entry->name;?>'><?php echo $entry->name;?></td>
        <td><?php echo $entry->code;?></td>
        <td title='<?php echo $entry->key;?>'><?php echo $entry->key;?></td>
        <td title='<?php echo $entry->ip;?>'><?php echo $entry->ip;?></td>
        <td title='<?php echo $entry->desc;?>'><?php echo $entry->desc;?></td>
        <td class='text-right'>
          <?php 
          common::printIcon('entry', 'log', "entryID=$id", '', 'list', 'file-text-o');
          common::printIcon('entry', 'edit', "entryID=$id", '', 'list');
          if(common::hasPriv('entry', 'delete'))
          {
              $deleteURL = $this->createLink('entry', 'delete', "entryID=$id&confirm=yes");
              echo html::a("javascript:ajaxDelete(\"$deleteURL\",\"entryList\",confirmDelete)", '<i class="icon-remove"></i>', '', "title='{$lang->entry->delete}' class='btn-icon'");
          }
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan='7'><?php $pager->show();?></td>
      </tr>
    </tfoot>
  </table>
</form>
<?php include '../../common/view/footer.html.php';?>
