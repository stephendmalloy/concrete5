<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<style>
    .ccm-card-carousel-container .btn-success { margin-bottom:20px; }
    .ccm-card-entry { position:relative; }
    .ccm-card-entry.well { margin-bottom:10px; padding:28px 10px 10px; }
    .ccm-card-entry.entry-closed { height:57px; padding:0 0 0 15px; }
    .ccm-card-entry.entry-closed .entry-collapse-text { display:block; line-height:57px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; width:335px; }
    .ccm-card-entry.entry-closed .form-group { display:none; }
    .ccm-card-entry .form-group:last-of-type { margin-bottom:0; }
    .ccm-edit-entry { position:absolute; right:127px; top:10px; }
    .ccm-delete-card-entry { position:absolute; right:41px; top:10px; }
    .ccm-card-carousel-container i.fa-arrows { cursor:move; font-size:20px; padding:5px; position:absolute; right:5px; top:6px; }
    .ccm-card-carousel-container .ui-state-highlight { height:57px; margin-bottom:10px; }
</style>
<div class="ccm-card-carousel-container">
    <button type="button" class="btn btn-success ccm-add-card-entry"><?=t('Add Card')?></button>
    <?php if (isset($rows) && count($rows)) { foreach ($rows as $row) { ?>
        <div class="ccm-card-entry well entry-closed">
            <p class="entry-collapse-text"><?php echo h($row['title']); ?></p>
            <div class="form-group">
                <label class="control-label"><?=t('Icon')?></label>
                <div class="ccm-pick-icon">
                    <?php if ($row['iconFID']) { $f=File::getByID($row['iconFID']); if ($f) { echo $f->getThumbnailTag('file_manager_listing'); } } ?>
                </div>
                <input type="hidden" name="iconFID[]" class="icon-fid" value="<?php echo intval($row['iconFID']); ?>">
            </div>
            <div class="form-group">
                <label class="control-label"><?=t('Title')?></label>
                <input class="form-control" type="text" name="title[]" value="<?php echo h($row['title']); ?>">
            </div>
            <div class="form-group">
                <label class="control-label"><?=t('Description')?></label>
                <textarea class="editor-content" name="description[]"><?php echo LinkAbstractor::translateFromEditMode($row['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label class="control-label"><?=t('Link Type')?></label>
                <select data-field="entry-link-type" name="linkType[]" class="form-control">
                    <option value="0" <?php if ((int)$row['linkType']===0) echo 'selected'; ?>><?=t('None')?></option>
                    <option value="1" <?php if ((int)$row['linkType']===1) echo 'selected'; ?>><?=t('Internal Page')?></option>
                    <option value="2" <?php if ((int)$row['linkType']===2) echo 'selected'; ?>><?=t('External URL')?></option>
                    <option value="3" <?php if ((int)$row['linkType']===3) echo 'selected'; ?>><?=t('File')?></option>
                </select>
            </div>
            <div data-link-type="1" class="form-group link-field link-field-1">
                <label class="control-label"><?=t('Choose Page:')?></label>
                <div data-field="page-selector"></div>
            </div>
            <div data-link-type="2" class="form-group link-field link-field-2">
                <label class="control-label"><?=t('URL')?></label>
                <input type="text" name="linkURL[]" class="form-control" value="<?php echo h($row['linkURL']); ?>">
            </div>
            <div data-link-type="3" class="form-group link-field link-field-3">
                <label class="control-label"><?=t('File')?></label>
                <div class="ccm-pick-link-file">
                    <?php if ($row['fileLinkFID']) { $lf=File::getByID($row['fileLinkFID']); if ($lf) { echo $lf->getThumbnailTag('file_manager_listing'); } } ?>
                </div>
                <input type="hidden" name="fileLinkFID[]" class="file-link-fid" value="<?php echo intval($row['fileLinkFID']); ?>">
            </div>
            <button type="button" class="btn btn-sm btn-default ccm-edit-entry" data-entry-close-text="<?=t('Collapse Card')?>" data-entry-edit-text="<?=t('Edit Card')?>"><?=t('Edit Card')?></button>
            <button type="button" class="btn btn-sm btn-danger ccm-delete-card-entry"><?=t('Remove')?></button>
            <i class="fa fa-arrows"></i>
            <input class="ccm-card-entry-sort" type="hidden" name="sortOrder[]" value="<?php echo intval($row['sortOrder']); ?>">
        </div>
    <?php } } else { ?>
        <script>_.defer(function(){ $('.ccm-add-card-entry').click(); });</script>
    <?php } ?>
    <div class="ccm-card-entry well ccm-card-entry-template" style="display:none;">
        <p class="entry-collapse-text"></p>
        <div class="form-group">
            <label class="control-label"><?=t('Icon')?></label>
            <div class="ccm-pick-icon"></div>
            <input type="hidden" name="iconFID[]" class="icon-fid" value="">
        </div>
        <div class="form-group">
            <label class="control-label"><?=t('Title')?></label>
            <input class="form-control" type="text" name="title[]" value="">
        </div>
        <div class="form-group">
            <label class="control-label"><?=t('Description')?></label>
            <textarea class="editor-content" name="description[]"></textarea>
        </div>
        <div class="form-group">
            <label class="control-label"><?=t('Link Type')?></label>
            <select data-field="entry-link-type" name="linkType[]" class="form-control">
                <option value="0"><?=t('None')?></option>
                <option value="1"><?=t('Internal Page')?></option>
                <option value="2"><?=t('External URL')?></option>
                <option value="3"><?=t('File')?></option>
            </select>
        </div>
        <div data-link-type="1" class="form-group link-field link-field-1">
            <label class="control-label"><?=t('Choose Page:')?></label>
            <div data-field="page-selector"></div>
        </div>
        <div data-link-type="2" class="form-group link-field link-field-2">
            <label class="control-label"><?=t('URL')?></label>
            <input type="text" name="linkURL[]" class="form-control" value="">
        </div>
        <div data-link-type="3" class="form-group link-field link-field-3">
            <label class="control-label"><?=t('File')?></label>
            <div class="ccm-pick-link-file"></div>
            <input type="hidden" name="fileLinkFID[]" class="file-link-fid" value="">
        </div>
        <button type="button" class="btn btn-sm btn-default ccm-edit-entry" data-entry-close-text="<?=t('Collapse Card')?>" data-entry-edit-text="<?=t('Edit Card')?>"><?=t('Edit Card')?></button>
        <button type="button" class="btn btn-sm btn-danger ccm-delete-card-entry"><?=t('Remove')?></button>
        <i class="fa fa-arrows"></i>
        <input class="ccm-card-entry-sort" type="hidden" name="sortOrder[]" value="">
    </div>
</div>
<?php
$editorJavascript = Core::make('editor')->outputStandardEditorInitJSFunction();
?>
<script>
var launchEditor = <?=$editorJavascript?>;
$(function(){
    var container = $('.ccm-card-carousel-container');
    function doSort(){
        container.find('.ccm-card-entry').each(function(i){
            $(this).find('.ccm-card-entry-sort').val(i);
        });
    }
    function attach(entry){
        entry.find('.ccm-delete-card-entry').click(function(){
            if(confirm('<?=t('Are you sure?')?>')){
                var id = entry.find('.editor-content').attr('id');
                if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances[id]) {
                    CKEDITOR.instances[id].destroy();
                }
                entry.remove();
                doSort();
            }
        });
        entry.find('.ccm-pick-icon').click(function(){
            var holder = $(this);
            ConcreteFileManager.launchDialog(function(data){
                ConcreteFileManager.getFileDetails(data.fID, function(r){
                    var file = r.files[0];
                    holder.html(file.resultsThumbnailImg);
                    holder.next('.icon-fid').val(file.fID);
                });
            });
        });
        entry.find('.ccm-pick-link-file').click(function(){
            var holder = $(this);
            ConcreteFileManager.launchDialog(function(data){
                ConcreteFileManager.getFileDetails(data.fID, function(r){
                    var file = r.files[0];
                    holder.html(file.resultsThumbnailImg);
                    holder.next('.file-link-fid').val(file.fID);
                });
            });
        });
        entry.find('div[data-field=page-selector]').concretePageSelector({inputName:'internalLinkCID[]'});
        entry.find('select[data-field=entry-link-type]').change(function(){
            var val = parseInt($(this).val());
            entry.find('.link-field').hide();
            entry.find('.link-field-' + val).show();
        }).trigger('change');
    }
    var template = $('.ccm-card-entry-template').clone();
    $('.ccm-card-entry-template').remove();
    container.find('.ccm-card-entry').each(function(){
        $(this).find('.editor-content').attr('id', _.uniqueId());
        launchEditor($(this).find('.editor-content'));
        attach($(this));
    });
    $('.ccm-add-card-entry').click(function(){
        var newEntry = template.clone();
        newEntry.removeClass('ccm-card-entry-template').addClass('ccm-card-entry');
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
