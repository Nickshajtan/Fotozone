<?php $modal = get_option('hcc-theme-cf-modal');
      $title = get_option('hcc-theme-cf-modal-title'); 
if( $modal ) : ?>
<div class="modal modal-form ml-auto mr-auto cf">
          <div class="modal-wrapper align-items-center justify-content-center ml-auto mr-auto d-flex h-100 w-100">
            <div class="modal-content align-items-center justify-content-center d-flex ml-auto mr-auto">
                <div class="closer">
                    <div>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <?php if( $title ) : ?>
                <div class="modal-header w-100 text-center align-items-center justify-content-center d-flex">
                    <?php echo $title; ?>
                </div>
                <?php endif; ?>
                <div class="modal-body w-100 text-center align-items-center justify-content-center d-flex">
                    <form action="" method="post" class="custom-form col-12 col-lg-8 ml-auto mr-auto needs-validation" novalidate>
                            <textarea name="comment" class="hd"></textarea>
                            <textarea name="message" class="hd"></textarea>
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label for="name-modal" class="sr-only"><?php echo __('Ваше имя', 'hcc'); ?></label>
                                        <div class="input-group validation-group">
                                            <div class="input-group-prepend d-none">
                                                <div class="input-group-text ">
                                                    <!-- icon, text, etc -->
                                                </div>
                                            </div>
                                            <input name="name" type="text" class="form-control w-100 form-element-validation" id="name-modal" aria-describedby="name" maxlength="30" placeholder="<?php echo __('Ваше имя', 'hcc'); ?>" required="required">
                                            <span id="help-text" class="text-muted form-help d-none"><!-- help text --></span>
                                            <div class="valid-feedback valid-helper"><?php echo __('Выглядит неплохо, все верно!', 'hcc'); ?></div>
                                            <div class="valid-warning-feedback valid-helper"><?php echo __('Необязательно, но было бы недурно узнать', 'hcc'); ?></div>
                                            <div class="invalid-feedback valid-helper"><?php echo __('Пожалуйста, проверьте еще раз', 'hcc'); ?></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone-modal" class="sr-only"><?php echo __('Ваш телефон', 'hcc'); ?></label>
                                        <div class="input-group validation-group">
                                            <div class="input-group-prepend d-none">
                                                <div class="input-group-text ">
                                                    <!-- icon, text, etc -->
                                                </div>
                                            </div>
                                            <input name="phone" type="tel" class="form-control w-100 form-element-validation" id="phone-modal" aria-describedby="tel" placeholder="<?php echo __('Ваш телефон', 'hcc'); ?>" minlength="10" maxlength="15" required="required">
                                            <span id="help-tel" class="text-muted form-help d-none"><!-- help text --></span>
                                            <div class="valid-feedback valid-helper"><?php echo __('Выглядит неплохо, все верно!', 'hcc'); ?></div>
                                            <div class="valid-warning-feedback valid-helper"><?php echo __('Необязательно, но было бы недурно узнать', 'hcc'); ?></div>
                                            <div class="invalid-feedback valid-helper"><?php echo __('Пожалуйста, проверьте еще раз', 'hcc'); ?></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email-modal" class="sr-only"><?php echo __('Ваш E-mail', 'hcc'); ?></label>
                                        <div class="input-group validation-group">
                                            <div class="input-group-prepend d-none">
                                                <div class="input-group-text ">
                                                    <!-- icon, text, etc -->
                                                </div>
                                            </div>
                                            <input name="email" type="email" class="form-control w-100 form-element-validation" id="email-modal" aria-describedby="email" placeholder="<?php echo __('Ваш E-mail', 'hcc'); ?>">
                                            <span id="help-email" class="text-muted form-help d-none"><!-- help text --></span>
                                            <div class="valid-feedback valid-helper"><?php echo __('Выглядит неплохо, все верно!', 'hcc'); ?></div>
                                            <div class="valid-warning-feedback valid-helper"><?php echo __('Необязательно, но было бы недурно узнать', 'hcc'); ?></div>
                                            <div class="invalid-feedback valid-helper"><?php echo __('Пожалуйста, проверьте еще раз', 'hcc'); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label for="question-modal" class="sr-only"><?php echo __('Ваш вопрос', 'hcc'); ?></label>
                                        <div class="input-group validation-group">
                                            <textarea name="question" id="question-modal" cols="30" rows="6" placeholder="<?php echo __('Ваш вопрос...', 'hcc'); ?>" class="form-control w-100 form-element-validation" required="required"></textarea>
                                            <span id="help-textarea" class="text-muted form-help d-none"><!-- help text --></span>
                                            <div class="valid-feedback valid-helper"><?php echo __('Выглядит неплохо, все верно!', 'hcc'); ?></div>
                                            <div class="valid-warning-feedback valid-helper"><?php echo __('Необязательно, но было бы недурно узнать', 'hcc'); ?></div>
                                            <div class="invalid-feedback valid-helper"><?php echo __('Пожалуйста, проверьте еще раз', 'hcc'); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-center align-items-center">
                                    <input type="submit" value="<?php echo __('Отправить', 'hcc'); ?>">
                                </div>
                             </div>
                       </form>
                    </div>
            </div>
          </div>
</div>


<?php endif; ?>