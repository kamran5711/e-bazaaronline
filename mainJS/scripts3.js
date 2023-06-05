$('.btn-action').click(function(){
    
    var urlbase = $(this).data("url"); 
    
    var url = $(this).attr("url"); 
    // /alert(url);
    $.ajax({
        url: url,
        dataType: 'json',
        success: function(res) {

            // get the ajax response data
            var data = '';
            if(res.header_theme!=''){
                 data +='<img src="'+urlbase+'/builder/components/theme/' + res.header_theme + '.jpg" >';     
            }

            if(res.search_theme!=''){
                 data +='<img src="'+urlbase+'/builder/components/theme/' + res.search_theme + '.jpg" >';     
            }
            
            if(res.flights_theme!=''){
                 data +='<img src="'+urlbase+'/builder/components/theme/' + res.flights_theme + '.jpg" >';     
            }
            
            if(res.destinations_theme!=''){
                 data +='<img src="'+urlbase+'/builder/components/theme/' + res.destinations_theme + '.jpg" >';     
            }
            
            if(res.deals_theme!=''){
                 data +='<img src="'+urlbase+'/builder/components/theme/' + res.deals_theme + '.jpg" >';     
            }
            
            if(res.partners_theme!=''){
                 data +='<img src="'+urlbase+'/builder/components/theme/' + res.partners_theme + '.jpg" >';     
            }
            
            if(res.footer_theme!=''){
                 data +='<img src="'+urlbase+'/builder/components/theme/' + res.footer_theme + '.jpg" >';     
            }
            
            // update modal content here
            // you may want to format data or 
            // update other modal elements here too
            $('#modal-body').html(data);

            // show modal
            $('#exampleModal').modal('show');

        },
        error:function(request, status, error) {
            console.log("ajax call went wrong:" + request.responseText);
        }
    });
});
