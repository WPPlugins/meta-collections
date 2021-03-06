$ = jQuery.noConflict();

function get_yt_metadata(elementID, ytID){
//www.youtube.com/watch?v=jDQH0Le3dx0

	
url 		= (ytID!=undefined) ? ytID : jQuery("#"+elementID).val();
videoid 	= url.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);

if(videoid != null) {//jDQH0Le3dx0
yt_json = "http://gdata.youtube.com/feeds/api/videos/"+videoid[1]+"?v=2&alt=jsonc";

$.getJSON(yt_json, function(data) {
data = data.data;
jQuery.each(data, function(index, value) { 
        
         if($("#yt_"+index).length>0){
	         
	         $("#yt_"+index).val(value);
	         
         }
         
         if(index=="id"){
	          $('#yt_iframe').attr("src", "http://www.youtube.com/embed/"+value).css({"display":"block"});
         }
         
         if(index=="thumbnail"){
	        $('#yt_thumbnail_sqDefault').attr("src", value.sqDefault);
	       }
});
});

} else { 
    alert("The youtube url is not valid.");
}



}

function format_yt_url(){
	var ytID				= jQuery('#yt_id').val();  	
	
	if(ytID.length>6){
	var loopchecked 		= ($('#yt_loop').is(':checked')) ? 1 : 0;
	var showinfochecked 	= ($('#yt_showinfo').is(':checked')) ? 1 : 0;
	var autoplaychecked 	= ($('#yt_autoplay').is(':checked')) ? 1 : 0;
	var autohidechecked 	= ($('#yt_autohide').is(':checked')) ? 1 : 0;
	
	var controlschecked 	= ($('#yt_controls').is(':checked')) ? 1 : 0;
	var theme				= ($('#yt_theme').val()=="") ? "dark"  : $('#yt_theme').val();
	
	url 					= "http://www.youtube.com/embed/"+ytID+"/?showinfo="+showinfochecked+"&amp;autohide="+autohidechecked+"&amp;autoplay="+autoplaychecked+"&amp;theme="+theme+"&amp;controls="+controlschecked+"&amp;loop="+loopchecked;
	$('yt_embed').text(url);
	$('#yt_iframe').attr("src",url).css({"display":"block"});
}else{
	alert("Please fill in a proper YouTube url first");
}

}