jQuery(document).ready(function( $ ) {  
    var currentlyClickedElement = '';
  	
    $('.color-pick-color').bind("click", function(){ 
        currentlyClickedElement = this;
    });
  	
    $('.color-pick-color').ColorPicker({
        onSubmit: function(hsb, hex, rgb, el) {
            $(el).css("background","#"+hex);
            $(el).attr("data-value", "#"+hex);
            $(el).parent().children(".color-pick").val("#"+hex);
            $(el).ColorPickerHide();
        },
        onBeforeShow: function () {
            $(this).ColorPickerSetColor($(this).attr("data-value"));
        },
        onChange: function (hsb, hex, rgb) {
            $(currentlyClickedElement).css("background","#"+hex);
            $(currentlyClickedElement).attr("data-value", "#"+hex);
            $(currentlyClickedElement).parent().children(".color-pick").val("#"+hex);
        }
    })
    .bind('keyup', function(){
        $(this).ColorPickerSetColor(this.value);
    });
	 
 
    $('.color-pick').bind('keyup', function(){
        $(this).parent().children(".color-pick-color").css("background", $(this).val());
    });
    
    // 17 - var default = new Array("" , "", "", "", "", "");
    var default_val = new Array( "#959595" , "#4c413f", "#d6b17c", "#000000", "#000000", "#4c413f",  "#c1c1c1");
    var wisteriaPurple = new Array("#959595" , "#8e44ad", "#9b59b6", "#000000", "#000000", "#8e44ad",  "#c1c1c1");
    var pumpkinOrange = new Array("#959595" , "#d35400", "#e67e22", "#000000", "#000000", "#d35400",  "#c1c1c1");
    var midnightBlue   = new Array("#959595" , "#2c3e50", "#34495e", "#000000", "#000000", "#2c3e50",  "#c1c1c1");
    $("#predefined_colors").bind("change", function(){
    	
        var table;
    	
        switch( $(this).val() ) {
            case "default" :
                table = default_val;
                break;
            case "wisteria-purple" :
                table = wisteriaPurple;
                break;
            case "pumpkin-orange" :
                table = pumpkinOrange;
                break;
            case "midnight-blue" :
                table = midnightBlue;
                break;
        }
    	
        $(".color-pick").each(function(index){
            $(".color-pick").eq(index).val(table[index]);
            $(".color-pick").eq(index).parent().children(".color-pick-color").css("background", table[index]);
            $(".color-pick").eq(index).parent().children(".color-pick-color").attr("data-value", table[index]);
        });
    });
    $(".input-type").change(function(){
        if($(this).val() == "dropdown") {
            $(this).parent().parent().children(".validation").hide();
            $(this).parent().parent().children(".label-place-val").children("label").html("Values");
        }
        else {
            $(this).parent().parent().children(".validation").show();
            $(this).parent().parent().children(".label-place-val").children("label").html("Placeholder");
        }
    });
});