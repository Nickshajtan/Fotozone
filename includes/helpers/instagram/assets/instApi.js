jQuery(function($){
    /* -- start of file -- */
    var token     = hcc_instagram_params.token; // Access Token, important
    var name      = hcc_instagram_params.name;
    var tag       = hcc_instagram_params.tag;
    var items     = hcc_instagram_params.items;
    var row       = hcc_instagram_params.row;
    var host      = hcc_instagram_params.host;
    var container = $(document).find('.instagram-feed');
    
    try{
        if( typeof token !=="undefined" && token !== null ){
            try{
                token = hcc_decode( token );
            }
            catch(e){
                console.log('Error on Instagram API JS script: token decode function fail');
            }
            var base_url = host + '/v1/users/';
            
            /* check tag name */
            if( typeof tag === "undefined" || tag === null ){
                try{
                    name_ajax_request( base_url );
                }
                catch(e){
                    console.log('Error on Instagram API JS script with name');
                }
            }
            /* check user name */
            else if( typeof name === "undefined" || name === null ){
                try{
                    var url = host + '/v1/tags/' + tag + '/media/recent';
                    tag_ajax_request( url );
                }
                catch(e){
                    console.log('Error on Instagram API JS script with tag');
                }
            }
            /* else */
            else{
                if( typeof tag !== "undefined" && tag !== null ){
                    var url2 = '/tags/' + tag;
                }
                else{
                    var url2 = '';
                }
                try{
                    inst_ajax_request( base_url, url2 );
                }
                catch(e){
                    console.log('Error on Instagram API JS script with user name & tag');
                }
            }
        }
    }
    catch(e){
        console.log('Error on Instagram API JS script');
    }
    /*
    *  Ajax request for user name & empty tag name
    *
    */
    
    function name_ajax_request( base_url ){
        $.ajax({
                        url: base_url + 'search',
                        dataType: 'jsonp',
                        type: 'GET',
                        data: {access_token: token, q: name},
                        success: function(result){
                            $.ajax({
                                url: base_url + result.data[0].id + '/media/recent',
                                dataType: 'jsonp',
                                type: 'GET',
                                data: {access_token: token, count: items},
                                success: function(result2){
                                    container_append( container, result.data );
                                },
                                error: function(result2){
                                    console.log('Error on Instagram API JS script:' + result2);
                                }
                            });
                        },
                        error: function(result){
                            console.log('Error on Instagram API JS script:' + result);
                        }
        });
    }
    
    /*
    *  Ajax request for tag & empty user name
    *
    */
    
    function tag_ajax_request( base_url ){
        $.ajax({
                        url: base_url,
                        dataType: 'jsonp',
                        type: 'GET',
                        data: {access_token: token, q: name},
                        success: function(result){
                             container_append( container, result.data );
                        },
                        error: function(result){
                            console.log('Error on Instagram API JS script:' + result);
                        }
        });
    }
            
    /*
    *  Ajax request for tag & user name
    *
    */
    
    function inst_ajax_request( base_url, url2 ){ 
        $.ajax({
                        url: base_url + 'search',
                        dataType: 'jsonp',
                        type: 'GET',
                        data: {access_token: token, q: name},
                        success: function(result){
                            $.ajax({
                                url: base_url + result.data[0].id + url2 + '/media/recent',
                                dataType: 'jsonp',
                                type: 'GET',
                                data: {access_token: token, count: items},
                                success: function(result2){
                                    container_append( container, result.data );
                                },
                                error: function(result2){
                                    console.log('Error on Instagram API JS script:' + result2);
                                }
                            });
                        },
                        error: function(result){
                            console.log('Error on Instagram API JS script:' + result);
                        }
        });
    }        
    
    /*
    *  Insert result of Ajax request
    *
    */
    function container_append( container, data ){
        try{
            container.append('<div class="instagram_gallery"></div>');
            for( x in data.data ){
                container.find('.instagram_gallery').append('<a class="instagram-tape instagram-item instagram-image portfolio-wrap" data-id="' + result.data[x].id + '" href="' + result.data[x].link + '"><img src="' + result.data[x].images.standard_resolution.url + '" class="portfolio-image img-inner"><div class="instagram-caption caption-item portfolio-content">' + result.data[x].caption.text + '</div></a>');
            }
        }
        catch(e){
            console.log('Error of inserting Instagram ajax result');
        }
    }
    /* -- end of file -- */
});

/*
 * Encrypt decode Function : base85 code mode
 *
 */
function hcc_decode(t){
  t = t.replace(/!/g,'\\');
  var l = t.length, 
      o="", 
      pad="00000000";
    
  for(var i=1;i<l;i+=5) {
    for(var j=0,n=0,m=1;j<5;j++){ 
        n+=(t.charCodeAt(i+j)-42)*m; 
        m*=85; 
    }
    var s=n.toString(16);
    s=pad.substring(0,8-s.length)+s;
    o+=s.replace(/(..)/g,"%$1");
  }
  return decodeURIComponent(o.substring(0,o.length-t[0]*3));
}