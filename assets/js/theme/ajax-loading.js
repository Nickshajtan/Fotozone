/*
* Custom Ajax load more posts
*
*/
jQuery(function($){
    var ajaxurl = hcc_ajax_params.ajaxurl;
    var more_text       = hcc_ajax_params.more_text;
    var error_text      = hcc_ajax_params.error_text;
    var load_text       = hcc_ajax_params.load_text;
    try{
        ajaxMore( $('.we-offer'), service_posts, service_current_page, service_max_pages, ajaxurl );
    }
    catch(e){
        console.log('Problem with ajax custom script for posts');
    }
    try{
        if( typeof portfolio_posts !=="undefined" && typeof portfolio_current_page !=="undefined" && typeof portfolio_max_pages !=="undefined" && typeof ajaxurl !=="undefined" ){
            ajaxMore( $('.we-portfolio'), portfolio_posts, portfolio_current_page, portfolio_max_pages, ajaxurl );   
        }
    }
    catch(e){
        console.log('Problem with ajax custom script for posts');
    }
    
});

function ajaxMore( element, query_posts, current_page, max_pages, url ){
    let button     = element.find('.load-more');
    let textParam  = button.find('.button');
    let errorParam = element.find('.load-error');
    let container  = element.find('.ajax-container');
    let loader     = element.find('.load-loder');
    button.click(function(){
        var data = {
			'action': 'ajax_loadmore',
			'query': query_posts,
			'page' : current_page
		};
        $.ajax({
            url: url,
            data:data,
            type:'POST',
            error: (function(){
                errorParam.removeClass('d-none');
                loader.removeClass('active');
                textParam.text(error_text);
            }),
            beforeSend: (function (){
                textParam.text(load_text).addClass('active');
                loader.addClass('active');
            }),
            success:function(data){
                if( data ) {
                    textParam.text(more_text);
                    container.append(data);
                    current_page++;
                    if(current_page == max_pages){
                        button.remove();
                    }
                }
                else{
                    button.remove();
                }
            }
        }).done(function (){
            loader.removeClass('active');
        });
    });
}