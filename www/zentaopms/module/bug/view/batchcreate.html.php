<?php
/**
 * The batch create view of story module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Yangyang Shi <shiyangyang@cnezsoft.com>
 * @package     story
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<div id='titlebar'>
  <div class='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['bug']);?></span>
    <strong>
      <small class='text-muted'><?php echo html::icon($lang->icons['batchCreate']);?></small>
      <?php echo $lang->bug->batchCreate;?>
      <?php if($this->session->currentProductType !== 'normal') echo '<span class="label label-info">' . $branches[$branch] . '</span>';?>
    </strong>
    <div class='actions'>
      <?php if(common::hasPriv('file', 'uploadImages')) echo html::a($this->createLink('file', 'uploadImages', 'module=bug&params=' . helper::safe64Encode("productID=$productID&projectID=$projectID&moduleID=$moduleID")), $lang->uploadImages, '', "data-toggle='modal' data-type='iframe' class='btn btn-primary' data-width='70%'")?>
      <?php echo html::commonButton($lang->pasteText, "data-toggle='myModal'", 'btn btn-primary')?>
      <button type="button" class="btn btn-default" data-toggle="customModal"><i class='icon icon-cog'></i> </button>
    </div>
  </div>
</div>
<?php
$visibleFields  = array();
$requiredFields = array();
foreach(explode(',', $showFields) as $field)
{
    if($field) $visibleFields[$field] = '';
}
foreach(explode(',', $this->config->bug->create->requiredFields) as $field)
{
    if($field)
    {
        $requiredFields[$field] = '';
        if(strpos(",{$config->bug->list->customBatchCreateFields},", ",{$field},") !== false) $visibleFields[$field] = '';
    }
}
?>
<form class='form-condensed' class='form-condensed' method='post' target='hiddenwin'>
  <table class='table table-fixed table-form with-border'>
    <thead>
      <tr>
        <th class='w-50px'>  <?php echo $lang->idAB;?></th> 
        <th class='w-120px<?php echo zget($visibleFields, $product->type, ' hidden')?>'> <?php echo $lang->product->branch;?></th>
        <th class='w-120px'> <?php echo $lang->bug->module;?> <span class='required'></span></th>
        <th class='w-130px<?php echo zget($visibleFields, 'project', ' hidden')?>'>
          <?php echo $lang->bug->project;?>
          <?php if(isset($requiredFields['project'])) echo " <span class='required'></span>";?>
        </th>
        <th><?php echo $lang->bug->openedBuild;?> <span class='required'></span></th>
        <th><?php echo $lang->bug->title;?> <span class='required'></span></th>
        <th class='<?php echo zget($visibleFields, 'deadline', 'hidden')?>'>
          <?php echo $lang->bug->deadline;?>
          <?php if(isset($requiredFields['deadline'])) echo " <span class='required'></span>";?>
        </th>
        <th class='<?php echo zget($visibleFields, 'steps', 'hidden')?>'>
          <?php echo $lang->bug->steps;?>
          <?php if(isset($requiredFields['steps'])) echo " <span class='required'></span>";?>
        </th>
        <th class='w-100px<?php echo zget($visibleFields, 'type', ' hidden')?>'>
          <?php echo $lang->typeAB;?>
          <?php if(isset($requiredFields['type'])) echo " <span class='required'></span>";?>
        </th>
        <th class='w-80px<?php echo zget($visibleFields, 'pri', ' hidden')?>'>
          <?php echo $lang->bug->pri;?>
          <?php if(isset($requiredFields['pri'])) echo " <span class='required'></span>";?>
        </th>
        <th class='w-80px<?php echo zget($visibleFields, 'severity', ' hidden')?>'>
          <?php echo $lang->bug->severity;?>
          <?php if(isset($requiredFields['severity'])) echo " <span class='required'></span>";?>
        </th>
        <th class='w-120px<?php echo zget($visibleFields, 'os', ' hidden')?>'>
          <?php echo $lang->bug->os;?>
          <?php if(isset($requiredFields['os'])) echo " <span class='required'></span>";?>
        </th>
        <th class='w-100px<?php echo zget($visibleFields, 'browser', ' hidden')?>'>
          <?php echo $lang->bug->browser;?>
          <?php if(isset($requiredFields['browser'])) echo " <span class='required'></span>";?>
        </th>
        <th class='<?php echo zget($visibleFields, 'keywords', ' hidden')?>'>
          <?php echo $lang->bug->keywords;?>
          <?php if(isset($requiredFields['keywords'])) echo " <span class='required'></span>";?>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php
      /* Remove the unused types. */
      unset($lang->bug->typeList['designchange']);
      unset($lang->bug->typeList['newfeature']);
      unset($lang->bug->typeList['trackthings']);

      $moduleOptionMenu       += array('ditto' => $lang->bug->ditto);
      $projects               += array('ditto' => $lang->bug->ditto);
      $lang->bug->typeList    += array('ditto' => $lang->bug->ditto);
      $lang->bug->priList     += array('ditto' => $lang->bug->ditto);
      $lang->bug->osList      += array('ditto' => $lang->bug->ditto);
      $lang->bug->browserList += array('ditto' => $lang->bug->ditto);
      ?>
      <?php $i = 0; ?>
      <?php if(!empty($titles)):?>
      <?php foreach($titles as $bugTitle => $fileName):?>
      <?php
      $moduleID  = $i == 0 ? $moduleID  : 'ditto';
      $projectID = $i == 0 ? $projectID  : 'ditto';
      $type      = $i == 0 ? '' : 'ditto';
      $pri       = $i == 0 ? 0  : 'ditto';
      $os        = $i == 0 ? '' : 'ditto';
      $browser   = $i == 0 ? '' : 'ditto';
      ?>
      <tr class='text-left'>
        <td><?php echo $i+1;?></td>
        <td class='text-left<?php echo zget($visibleFields, $product->type, ' hidden')?>' style='overflow:visible'><?php echo html::select("branches[$i]", $branches, $branch, "class='form-control chosen' onchange='setBranchRelated(this.value, $productID, $i)'");?></td>
        <td class='text-left<?php echo zget($visibleFields, 'module', ' hidden')?>'  style='overflow:visible'><?php echo html::select("modules[$i]", $moduleOptionMenu, $moduleID, "class='form-control chosen'");?></td>
        <td class='text-left<?php echo zget($visibleFields, 'project', ' hidden')?>' style='overflow:visible'><?php echo html::select("projects[$i]", $projects, $projectID, "class='form-control chosen' onchange='loadProjectBuilds($productID, this.value, $i)'");?></td>
        <td class='text-left' style='overflow:visible' id='buildBox<?php echo $i;?>'><?php echo html::select("openedBuilds[$i][]", $builds, 'trunk', "class='form-control chosen' multiple");?></td>
        <td style='overflow:visible'>
          <div class='input-group'>
          <?php echo html::hidden("color[$i]", '', "data-provide='colorpicker' data-wrapper='input-group-btn fix-border-right' data-pull-menu-right='false' data-btn-tip='{$lang->bug->colorTag}' data-update-text='#title\\[{$i}\\]'");?>
          <?php echo html::input("title[$i]", $bugTitle, "class='form-control' autocomplete='off'") . html::hidden("uploadImage[$i]", $fileName);?>
          </div>
        </td>
        <td class='<?php echo zget($visibleFields, 'deadline', 'hidden')?>'><?php echo html::input("deadlines[$i]", '', "class='form-control form-date'");?></td>
        <td class='<?php echo zget($visibleFields, 'steps', 'hidden')?>'><?php echo html::textarea("stepses[$i]", '', "rows='1' class='form-control autosize'");?></td>
        <td class='<?php echo zget($visibleFields, 'type', 'hidden')?>' style='overflow:visible'>    <?php echo html::select("types[$i]", $lang->bug->typeList, $type, "class='form-control chosen'");?></td>
        <td class='<?php echo zget($visibleFields, 'pri', 'hidden')?>' style='overflow:visible'>     <?php echo html::select("pris[$i]", $lang->bug->priList, $pri, "class='form-control chosen'");?></td>
        <td class='<?php echo zget($visibleFields, 'severity', 'hidden')?>' style='overflow:visible'><?php echo html::select("severities[$i]", $lang->bug->severityList, '', "class='form-control chosen'");?></td>
        <td class='<?php echo zget($visibleFields, 'os', 'hidden')?>' style='overflow:visible'>      <?php echo html::select("oses[$i]", $lang->bug->osList, $os, "class='form-control chosen'");?></td>
        <td class='<?php echo zget($visibleFields, 'browser', 'hidden')?>' style='overflow:visible'> <?php echo html::select("browsers[$i]", $lang->bug->browserList, $browser, "class='form-control chosen'");?></td>
        <td class='<?php echo zget($visibleFields, 'keywords', 'hidden')?>'><?php echo html::input("keywords[$i]", '', "class='form-control' autocomplete='off'");?></td>
      </tr>
      <?php $i++;?>
      <?php endforeach;?>
      <?php endif;?>
      <?php $nextStart = $i;?>
      <?php for($i = $nextStart; $i < $config->bug->batchCreate; $i++):?>
      <?php
      $moduleID  = $i - $nextStart == 0 ? $moduleID  : 'ditto';
      $projectID = $i - $nextStart == 0 ? $projectID  : 'ditto';
      $type      = $i - $nextStart == 0 ? '' : 'ditto';
      $pri       = $i - $nextStart == 0 ? 0  : 'ditto';
      $os        = $i - $nextStart == 0 ? '' : 'ditto';
      $browser   = $i - $nextStart == 0 ? '' : 'ditto';
      ?>
      <tr class='text-left'>
        <td><?php echo $i+1;?></td>
        <td class='text-left<?php echo zget($visibleFields, $product->type, ' hidden')?>' style='overflow:visible'><?php echo html::select("branches[$i]", $branches, $branch, "class='form-control chosen' onchange='setBranchRelated(this.value, $productID, $i)'");?></td>
        <td class='text-left<?php echo zget($visibleFields, 'module', ' hidden')?>'  style='overflow:visible'><?php echo html::select("modules[$i]", $moduleOptionMenu, $moduleID, "class='form-control chosen'");?></td>
        <td class='text-left<?php echo zget($visibleFields, 'project', ' hidden')?>' style='overflow:visible'><?php echo html::select("projects[$i]", $projects, $projectID, "class='form-control chosen' onchange='loadProjectBuilds($productID, this.value, $i)'");?></td>
        <td class='text-left' style='overflow:visible' id='buildBox<?php echo $i;?>'><?php echo html::select("openedBuilds[$i][]", $builds, '', "class='form-control chosen' multiple");?></td>
        <td style='overflow:visible'>
          <div class='input-group'>
          <?php echo html::hidden("color[$i]", '', "data-provide='colorpicker' data-wrapper='input-group-btn fix-border-right' data-pull-menu-right='false' data-btn-tip='{$lang->bug->colorTag}' data-update-text='#title\\[{$i}\\]'");?>
          <?php echo html::input("title[$i]", '', "class='form-control' autocomplete='off'");?>
          </div>
        </td>
        <td class='<?php echo zget($visibleFields, 'deadline', 'hidden')?>'><?php echo html::input("deadlines[$i]", '', "class='form-control form-date'");?></td>
        <td class='<?php echo zget($visibleFields, 'steps', 'hidden')?>'><?php echo html::textarea("stepses[$i]", '', "rows='1' class='form-control autosize'");?></td>
        <td class='<?php echo zget($visibleFields, 'type', 'hidden')?>' style='overflow:visible'>    <?php echo html::select("types[$i]", $lang->bug->typeList, $type, "class='form-control chosen'");?></td>
        <td class='<?php echo zget($visibleFields, 'pri', 'hidden')?>' style='overflow:visible'>     <?php echo html::select("pris[$i]", $lang->bug->priList, $pri, "class='form-control chosen'");?></td>
        <td class='<?php echo zget($visibleFields, 'severity', 'hidden')?>' style='overflow:visible'><?php echo html::select("severities[$i]", $lang->bug->severityList, '', "class='form-control chosen'");?></td>
        <td class='<?php echo zget($visibleFields, 'os', 'hidden')?>' style='overflow:visible'>      <?php echo html::select("oses[$i]", $lang->bug->osList, $os, "class='form-control chosen'");?></td>
        <td class='<?php echo zget($visibleFields, 'browser', 'hidden')?>' style='overflow:visible'> <?php echo html::select("browsers[$i]", $lang->bug->browserList, $browser, "class='form-control chosen'");?></td>
        <td class='<?php echo zget($visibleFields, 'keywords', 'hidden')?>'><?php echo html::input("keywords[$i]", '', "class='form-control' autocomplete='off'");?></td>
      </tr>
      <?php endfor;?>
    </tbody>
    <tfoot>
      <tr><td colspan='<?php echo count($visibleFields) + 3?>' class='text-center'><?php echo html::submitButton() . html::backButton();?></td></tr>
    </tfoot>
  </table>
</form>
<table class='hide' id='trTemp'>
  <tbody>
    <tr class='text-left'>
      <td>%s</td>
      <td class='text-left<?php echo zget($visibleFields, $product->type, ' hidden')?>' style='overflow:visible'><?php echo html::select("branches[%s]", $branches, $branch, "class='form-control' onchange='setBranchRelated(this.value, $productID, \"%s\")'");?></td>
      <td class='text-left<?php echo zget($visibleFields, 'module', ' hidden')?>'  style='overflow:visible'><?php echo html::select("modules[%s]", $moduleOptionMenu, $moduleID, "class='form-control'");?></td>
      <td class='text-left<?php echo zget($visibleFields, 'project', ' hidden')?>' style='overflow:visible'><?php echo html::select("projects[%s]", $projects, $projectID, "class='form-control' onchange='loadProjectBuilds($productID, this.value, \"%s\")'");?></td>
      <td class='text-left' style='overflow:visible' id='buildBox%s'><?php echo html::select("openedBuilds[%s][]", $builds, '', "class='form-control' multiple");?></td>
      <td style='overflow:visible'>
        <div class='input-group'>
        <?php echo html::hidden("color[%s]", '', "data-wrapper='input-group-btn fix-border-right' data-pull-menu-right='false' data-btn-tip='{$lang->bug->colorTag}' data-update-text='#title\\[%s\\]'");?>
        <?php echo html::input("title[%s]", '', "class='form-control' autocomplete='off'");?>
        </div>
      </td>
      <td class='<?php echo zget($visibleFields, 'deadline', 'hidden')?>'><?php echo html::input("deadlines[%s]", '', "class='form-control form-date'");?></td>
      <td class='<?php echo zget($visibleFields, 'steps', 'hidden')?>'><?php echo html::textarea("stepses[%s]", '', "rows='1' class='form-control autosize'");?></td>
      <td class='<?php echo zget($visibleFields, 'type', 'hidden')?>' style='overflow:visible'>    <?php echo html::select("types[%s]", $lang->bug->typeList, $type, "class='form-control'");?></td>
      <td class='<?php echo zget($visibleFields, 'pri', 'hidden')?>' style='overflow:visible'>     <?php echo html::select("pris[%s]", $lang->bug->priList, '', "class='form-control'");?></td>
      <td class='<?php echo zget($visibleFields, 'severity', 'hidden')?>' style='overflow:visible'><?php echo html::select("severities[%s]", $lang->bug->severityList, '', "class='form-control'");?></td>
      <td class='<?php echo zget($visibleFields, 'os', 'hidden')?>' style='overflow:visible'>      <?php echo html::select("oses[%s]", $lang->bug->osList, $os, "class='form-control'");?></td>
      <td class='<?php echo zget($visibleFields, 'browser', 'hidden')?>' style='overflow:visible'> <?php echo html::select("browsers[%s]", $lang->bug->browserList, $browser, "class='form-control'");?></td>
      <td class='<?php echo zget($visibleFields, 'keywords', 'hidden')?>'><?php echo html::input("keywords[%s]", '', "class='form-control' autocomplete='off'");?></td>
    </tr>
  </tbody>
</table>
<?php js::set('branch', $branch)?>
<?php $customLink = $this->createLink('custom', 'ajaxSaveCustomFields', 'module=bug&section=custom&key=batchCreateFields')?>
<?php include '../../common/view/customfield.html.php';?>
<?php include '../../common/view/pastetext.html.php';?>
<?php include '../../common/view/footer.html.php';?>
