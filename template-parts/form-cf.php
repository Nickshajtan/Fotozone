<?php $form = get_field('main_form'); 
if( $form ) : ?>
<section class="cf">
    <div class="container">
        <div class="row">
            <?php foreach( $form as $post ) : 
                  setup_postdata($post);
                  the_content();
            endforeach; ?>
        </div>
    </div>
</section> 
<?php wp_reset_postdata(); endif; ?>