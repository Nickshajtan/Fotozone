<?php 
/*
* ACF Google Map
* This file is template for Google Maps : many maps
*
*/
$locations = get_field('locations','options');

if( $locations ) : ?>
<section class="acf-google-map">
        
    <?php foreach( $locations as $map ) :
          $location = $map['location'];
          $title    = wp_kses_post( $map['title'] );
          $text     = wp_kses_post( $map['description'] );
          $addr     = wp_kses_post( $location['address'] );
          if( $location ) : ?>
                <div class="map acf-map">
                        <div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
                            <?php if( $title ) : ?>
                                <h4><?php echo $title; ?></h4>
                            <?php endif; 
                            if( $addr ) : ?>
                                <p class="address"><?php echo $addr; ?></p>
                            <?php endif; 
                            if( $text ) : ?>
                                <p><?php echo $text; ?></p>
                            <?php endif; ?>
                        </div>
                </div>      
          <?php endif; 
    endforeach; ?>
    
</section>
<?php endif; ?>