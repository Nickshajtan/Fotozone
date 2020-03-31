/* 
for more info see: 
	https://developer.wordpress.org/block-editor/developers/filters/block-filters 
*/
try{
  var el            = wp.element.createElement,
  registerBlockType = wp.blocks.registerBlockType,
  withSelect        = wp.data.withSelect;
  
  //Static block : Example
  registerBlockType('hcc/smile', {
        title: 'Simple Box',
        icon: 'smiley',
        category: 'hcc-blocks',
        attributes: {
            content: {type: 'string'},
            color: {type: 'string'}
        },
        edit: function(props) {
            function updateContent(event) {
                props.setAttributes({content: event.target.value})
            }
            function updateColor(value) {
                props.setAttributes({color: value.hex})
            }
            return React.createElement(
                "div",
                null,
                React.createElement(
                    "h3",
                    null,
                    "Simple Box"
                ),
                React.createElement("input", { type: "text", value: props.attributes.content, onChange: updateContent }),
                React.createElement(wp.components.ColorPicker, { color: props.attributes.color, onChangeComplete: updateColor })
            );
        },
        save: function(props) {
            return wp.element.createElement(
                "h3",
                { style: { border: "3px solid " + props.attributes.color } },
                props.attributes.content
            );
        }
    });
    //Dynamic block: Example
    ( function( blocks, element, serverSideRender ) {
        var el = element.createElement,
        registerBlockType = blocks.registerBlockType,
        ServerSideRender = serverSideRender;
        
        registerBlockType( 'hcc/get-post', {
            title: 'Get Posts',
            icon: 'megaphone',
            category: 'hcc-blocks',
            attributes: {
                title: {
                    type: 'string',
                    meta: 'book-title',
                    source: 'meta'
                },
            },

            edit: withSelect( function( select ) {
                var selectCore   = select( 'core' );
                var selectEditor = select( 'core/editor' );

                var postTypeSlug   = selectEditor.getEditedPostAttribute( 'type' );
                //console.log( postTypeSlug );
                var postType       = selectCore.getPostType( postTypeSlug );
                var isHierarchical = postType && postType.hierarchical;
                var query = {
                    per_page: 3,
                    order:  'desc',
                    status: 'publish',
                };
                var title = props.attributes.title;
                function updateTitle( event ) {
                    props.setAttributes( { title: event.target.value } );
                }
                return {
                    posts: isHierarchical ?
                        selectCore.getEntityRecords( 'postType', postTypeSlug, query ) : selectCore.getEntityRecords( 'postType', postTypeSlug, query ),
                    html: el(
                        'p', 
                        { className: className },
                        el(
                            'textarea',
                            { value: title, onChange: updateTitle }
                        ) 
                    ),
                };
            } )( function( props ) {
                if ( ! props.posts ) {
                    return 'Loading...';
                }
                if ( props.posts && props.posts.length === 0 ) {
                    return 'Error: no posts';
                }
                var className = props.className;
                var post      = props.posts;
                var data      = {};
                
                var i = 0;
                for ( var key in post ){
                    let title = post[ i ].title.rendered;
                    let link  = '<a href="' + post[ i ].link + '" class="' + className + '">' +  title + '</a><br />';
                    data[ i ] = { link: link };
                    i = i+1;
                }
                
                var finalData = '';
                var i = 0;
                for ( var key in data ){
                    finalData = finalData + data[ i ]['link'];
                    i = i+1;
                }
                
                
                return el(
                            'div',
                            { className: className + '-wrap'},
                            finalData
                );
                
                //Server render 
                /*
                return el( ServerSideRender, {
                        block: 'hcc/get-post',
                        attributes: props.attributes,
                });
                */
            }),

            save: function() {
                // Rendering in PHP
                return null;
            },
        });
    }(
        window.wp.blocks,
        window.wp.element,
        window.wp.data,
    ));
}
catch(e){
    console.log('Problem with gtn-api.js Gutenberg registration script');
}