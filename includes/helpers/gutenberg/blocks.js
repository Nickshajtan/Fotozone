/* 
for more info see: 
	https://developer.wordpress.org/block-editor/developers/filters/block-filters 
*/
//Examples
try{
    wp.blocks.registerBlockStyle( 'acf/banner', {
	 	name: 'overlap_left',
	 	label: 'Overlap left',
        isDefault: false,
    } );
    wp.blocks.registerBlockStyle( 'acf/grid', [
            {
                name: 'two-column',
                label: 'Two column',
                isDefault: false,
            },
            {
                name: 'with-button',
                label: 'Grid with button',
                isDefault: false,
            },
            {
                name: 'with-bg',
                label: 'Grid with section image',
                isDefault: false,
            },  
            {
                name: 'with-bg-long',
                label: 'Grid with section image and long header',
                isDefault: false,
            },  
            {
                name: 'central',
                label: 'Two column grid with center position',
                isDefault: false,
            },  
    ]);
}
catch(e){
    console.log('Problem with block.js Gutenberg registration script');
}