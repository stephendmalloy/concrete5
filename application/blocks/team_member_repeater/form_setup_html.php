<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<style>
    .ccm-team-container .btn-success { margin-bottom:20px; }
    .ccm-team-entry { position:relative; }
    .ccm-team-entry.well { margin-bottom:10px; padding:28px 10px 10px; }
    .ccm-team-entry.entry-closed { height:57px; padding:0 0 0 15px; }
    .ccm-team-entry.entry-closed .entry-collapse-text { display:block; line-height:57px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; width:335px; }
    .ccm-team-entry.entry-closed .form-group { display:none; }
    .ccm-team-entry .form-group:last-of-type { margin-bottom:0; }
    .ccm-edit-entry { position:absolute; right:127px; top:10px; }
    .ccm-delete-team-entry { position:absolute; right:41px; top:10px; }
    .ccm-team-container i.fa-arrows { cursor:move; font-size:20px; padding:5px; position:absolute; right:5px; top:6px; }
    .ccm-team-container .ui-state-highlight { height:57px; margin-bottom:10px; }
</style>
<div class="form-group">
    <label class="control-label"><?=t('Header Title')?></label>
    <input class="form-control" type="text" name="headerTitle" value="<?php echo h($headerTitle); ?>">
</div>
<div class="form-group">
    <label class="control-label"><?=t('Header Description')?></label>
    <textarea class="editor-content-header" name="headerDescription"><?php echo h($headerDescription); ?></textarea>
</div>
<div class="form-group">
    <label class="control-label"><?=t('Button One Text')?></label>
    <input class="form-control" type="text" name="buttonOneText" value="<?php echo h($buttonOneText); ?>">
</div>
<div class="form-group">
    <label class="control-label"><?=t('Button One Link')?></label>
    <input class="form-control" type="text" name="buttonOneLink" value="<?php echo h($buttonOneLink); ?>">
</div>
<div class="form-group">
    <label class="control-label"><?=t('Button Two Text')?></label>
    <input class="form-control" type="text" name="buttonTwoText" value="<?php echo h($buttonTwoText); ?>">
</div>
<div class="form-group">
    <label class="control-label"><?=t('Button Two Link')?></label>
    <input class="form-control" type="text" name="buttonTwoLink" value="<?php echo h($buttonTwoLink); ?>">
</div>
<div class="ccm-team-container">
    <button type="button" class="btn btn-success ccm-add-team-entry"><?=t('Add Member')?></button>
    <?php if (isset($rows) && count($rows)) { foreach ($rows as $row) { ?>
        <div class="ccm-team-entry well entry-closed">
            <p class="entry-collapse-text"><?php echo h($row['firstName'] . ' ' . $row['lastName']); ?></p>
            <div class="form-group">
                <label class="control-label"><?=t('First Name')?></label>
                <input class="form-control" type="text" name="firstName[]" value="<?php echo h($row['firstName']); ?>">
            </div>
            <div class="form-group">
                <label class="control-label"><?=t('Last Name')?></label>
                <input class="form-control" type="text" name="lastName[]" value="<?php echo h($row['lastName']); ?>">
            </div>
            <div class="form-group">
                <label class="control-label"><?=t('Headshot')?></label>
                <div class="ccm-pick-headshot">
                    <?php if ($row['headshotFID']) { $f=File::getByID($row['headshotFID']); if ($f) { echo $f->getThumbnailTag('file_manager_listing'); } } ?>
                </div>
                <input type="hidden" name="headshotFID[]" class="headshot-fid" value="<?php echo intval($row['headshotFID']); ?>">
            </div>
            <div class="form-group">
                <label class="control-label"><?=t('Bio')?></label>
                <textarea class="editor-content" name="bio[]"><?php echo LinkAbstractor::translateFromEditMode($row['bio']); ?></textarea>
            </div>
            <button type="button" class="btn btn-sm btn-default ccm-edit-entry" data-entry-close-text="<?=t('Collapse Member')?>" data-entry-edit-text="<?=t('Edit Member')?>"><?=t('Edit Member')?></button>
            <button type="button" class="btn btn-sm btn-danger ccm-delete-team-entry"><?=t('Remove')?></button>
            <i class="fa fa-arrows"></i>
            <input class="ccm-team-entry-sort" type="hidden" name="sortOrder[]" value="<?php echo intval($row['sortOrder']); ?>">
        </div>
    <?php } } else { ?>
        <script>_.defer(function(){ $('.ccm-add-team-entry').click(); });</script>
    <?php } ?>
    <div class="ccm-team-entry well ccm-team-entry-template" style="display:none;">
        <p class="entry-collapse-text"></p>
        <div class="form-group">
            <label class="control-label"><?=t('First Name')?></label>
            <input class="form-control" type="text" name="firstName[]" value="">
        </div>
        <div class="form-group">
            <label class="control-label"><?=t('Last Name')?></label>
            <input class="form-control" type="text" name="lastName[]" value="">
        </div>
        <div class="form-group">
            <label class="control-label"><?=t('Headshot')?></label>
            <div class="ccm-pick-headshot"></div>
            <input type="hidden" name="headshotFID[]" class="headshot-fid" value="">
        </div>
        <div class="form-group">
            <label class="control-label"><?=t('Bio')?></label>
            <textarea class="editor-content" name="bio[]"></textarea>
        </div>
        <button type="button" class="btn btn-sm btn-default ccm-edit-entry" data-entry-close-text="<?=t('Collapse Member')?>" data-entry-edit-text="<?=t('Edit Member')?>"><?=t('Edit Member')?></button>
        <button type="button" class="btn btn-sm btn-danger ccm-delete-team-entry"><?=t('Remove')?></button>
        <i class="fa fa-arrows"></i>
        <input class="ccm-team-entry-sort" type="hidden" name="sortOrder[]" value="">
    </div>
</div>
<?php
$editorJavascript = Core::make('editor')->outputStandardEditorInitJSFunction();
?>
<script>
var launchEditor = <?=$editorJavascript?>;
$(function(){
    var container = $('.ccm-team-container');
    function doSort(){
        container.find('.ccm-team-entry').each(function(i){
            $(this).find('.ccm-team-entry-sort').val(i);
        });
    }
    function attach(entry){
        entry.find('.ccm-delete-team-entry').click(function(){
            if(confirm('<?=t('Are you sure?')?>')){
                var id = entry.find('.editor-content').attr('id');
                if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances[id]) {
                    CKEDITOR.instances[id].destroy();
                }
                entry.remove();
                doSort();
            }
        });
        entry.find('.ccm-pick-headshot').click(function(){
            var holder = $(this);
            ConcreteFileManager.launchDialog(function(data){
                ConcreteFileManager.getFileDetails(data.fID, function(r){
                    var file = r.files[0];
                    holder.html(file.resultsThumbnailImg);
                    holder.next('.headshot-fid').val(file.fID);
                });
            });
        });
    }
    var template = $('.ccm-team-entry-template').clone();
    $('.ccm-team-entry-template').remove();
    container.find('.ccm-team-entry').each(function(){
        $(this).find('.editor-content').attr('id', _.uniqueId());
        launchEditor($(this).find('.editor-content'));
        attach($(this));
    });
    $('.ccm-add-team-entry').click(function(){
        var newEntry = template.clone();
        newEntry.removeClass('ccm-team-entry-template').addClass('ccm-team-entry');
        newEntry.find('.editor-content').attr('id', _.uniqueId());
        launchEditor(newEntry.find('.editor-content'));
        container.append(newEntry);
        attach(newEntry);
        doSort();
    });
    container.sortable({
        handle:'i.fa-arrows',
        axis:'y',
        cursor:'move',
        placeholder:'ui-state-highlight',
        update:doSort
    });
    doSort();
});
</script>
