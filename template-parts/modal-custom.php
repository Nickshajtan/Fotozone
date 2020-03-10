<?php
/*
* This file for modal parts of theme
*
*/
?>
<div class="modal modal-error ml-auto mr-auto">
       <div class="modal-wrapper align-items-center justify-content-center ml-auto mr-auto d-flex h-100 w-100">
            <div class="modal-content align-items-center justify-content-center d-flex ml-auto mr-auto">
                <div class="closer">
                    <div>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <div class="modal-header w-100 text-center align-items-center justify-content-center d-flex"><?php echo __('Error', 'hcc'); ?></div>
                <div class="modal-body w-100 text-center align-items-center justify-content-center d-flex"><?php echo __('Sending error', 'hcc'); ?></div>
            </div>
        </div>
</div>
<?php get_template_part('template-parts/form-modal', 'custom'); ?>