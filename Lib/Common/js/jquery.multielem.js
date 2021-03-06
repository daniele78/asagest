
var color=Array("red","green","yellow","orange","violet","blue","pink","gray","brown","purple","#7FFFD4","#FFD700","#7DF9FF",
    "#EDC9AF","#F88379","#4B0082","#FF00FF","#40826D","#9CDEAF","#83F879","#004B82","#00FFFF","#82406D",
    "#EDAFC9","#F87980","#4B8200","#FFAF00","#40826D","#9CDEAF","#83F879","#004B82","#00FFCC","#824080");
 
function rand_color(options){
    var num = Math.round((options.length)*Math.random());
    return options[num];
}
 
//alert($("#idtext").closest('tr').html());   
 
 

MyWidget = function(element_id) {
    var object_element=$("#"+element_id).closest('tr');
 	
    $(object_element).children().each(function(){
        $(this).children().removeAttr("tabindex");
        $(this).children().removeAttr("id");
    })
    var code_element=$(object_element).html()   //recupero il codice contenuto nella riga
    $(object_element).html("") //rimuovo l' elemento inserito nella pagina con php per riaggiungerlo dopo
   
    $('#col1_0').before(code_element)   // riaggiungo l' elemento in POS1
      	
    this.init(code_element);
}

$.extend(MyWidget.prototype, {
    // object variables
    textstring:'',
    rowid:-1,
    debug:false,
   
    useDebug:function(){
        this.debug=true
    },

    init: function(code) {
   
        this.textstring=code;
        this.rowid++
   
   
        this.addremovebutton();          //attiva o disattiva il pulsante X
    
        this.listen(this);               //attiva handle eventi
                            
    },
   
    addremovebutton:function(){
        
        if($(".btnremove").size()==1) {
            $(".btnremove").addClass("inactive");
            $(".btnremove").css("opacity","0");
        }
        else {
            $(".btnremove").each(function(){
                $(this).removeClass("inactive"); 
                $(this).css("opacity","1");
            })
            
        }
    },
   
    remRow: function(id) {
     
        var strid=$("#"+id).attr("id")
        var numid=parseInt(strid.substring(5))
        $('#row_'+numid).remove()  
        this.addremovebutton();   
    },
   
    addRowUp: function(id) {
     
        var strid=$("#"+id).attr("id")
        var numid=parseInt(strid.substring(5))
        var colour=' ';   //importante lo spazio
        if(this.debug) colour=' bgcolor="'+rand_color(color)+'" ';
        this.rowid++
        /*
     $('#row_'+numid).before('<tr'+colour+'id="row_'+this.rowid+'">'+
                                       this.textstring+
                                       '<td id="col1_'+this.rowid+'"><br /><input type="button" class="btnup" value="&#9651" title="Aggiungi sopra" /></td>'+
                                       '<td id="col2_'+this.rowid+'"><br /><input type="button" class="btndown" value="&#9661" title="Aggiungi sotto" /></td>'+
                                       '<td class="rem" id="remb_'+this.rowid+'"><br /><input type="button" class="btnremove" value="X" title="Rimuovi riga" /></td>'+  
                                       '</tr>');    
    */
   
        $('#row_'+numid).before('<tr'+colour+'id="row_'+this.rowid+'">'+
            this.textstring+
            '<td id="col1_'+this.rowid+'"><br /><img src="../Lib/Common/icons/freccia_up.png" class="btnup" alt="&#9651" title="Aggiungi sopra" /></td>'+
            '<td id="col2_'+this.rowid+'"><br /><img src="../Lib/Common/icons/freccia_dw.png" class="btndown" alt="&#9661" title="Aggiungi sotto" /></td>'+
            '<td class="rem" id="remb_'+this.rowid+'"><br /><img src="../Lib/Common/icons/button_cancel.png" class="btnremove" alt="X" title="Rimuovi riga" /></td>'+  
            '</tr>');    
   
         this.addremovebutton();
         
        $('#row_'+this.rowid).closest('tr').children().children().each(function(){
            if($(this).attr("name")!=undefined) {   //al primo elemento che ha un name assegno il value
                var tagname=$(this)[0].tagName
                if(tagname=="TEXTAREA" || $(this).attr("type"=="text")) $(this).focus() 
            }
        });
        
         
    },
   
    addRowDown: function(id,val) {
     
        var strid=$("#"+id).attr("id")
        var numid=parseInt(strid.substring(5))
        var colour=' ';   //importante lo spazio
        if(this.debug) colour=' bgcolor="'+rand_color(color)+'" ';
        this.rowid++
        /*
     $('#row_'+numid).after('<tr'+colour+'id="row_'+this.rowid+'">'+
                                       this.textstring+
                                       '<td id="col1_'+this.rowid+'"><br /><input type="button" class="btnup" value="&#9651" /></td>'+
                                       '<td id="col2_'+this.rowid+'"><br /><input type="button" class="btndown" value="&#9661" /></td>'+
                                       '<td class="rem" id="remb_'+this.rowid+'"><br /><input type="button" class="btnremove" value="X" /></td>'+  
                                       '</tr>');   
    */
   
        $('#row_'+numid).after('<tr'+colour+'id="row_'+this.rowid+'">'+
            this.textstring+
            '<td id="col1_'+this.rowid+'"><br /><img src="../Lib/Common/icons/freccia_up.png" class="btnup" alt="&#9651" title="Aggiungi sopra" /></td>'+
            '<td id="col2_'+this.rowid+'"><br /><img src="../Lib/Common/icons/freccia_dw.png" class="btndown" alt="&#9661" title="Aggiungi sotto" /></td>'+
            '<td class="rem" id="remb_'+this.rowid+'"><br /><img src="../Lib/Common/icons/button_cancel.png" class="btnremove" alt="X" title="Rimuovi riga" /></td>'+  
            '</tr>');   
                                        
        //var objhtml=$('#row_'+this.rowid)
    
        //alert($('#row_'+this.rowid).closest('tr').children().children().attr("type"))
      
        this.setvalue(this,val);
                                   
        this.addremovebutton(); 
    },
   
  
  
    //gestione eventi
 
    listen: function(obj){

        $(".btnremove").live("click",function(){ 
            if(!$(this).hasClass("inactive"))
                obj.remRow($(this).parent().attr("id"));
        });
  
        $(".btnup").live("click",function(){
            obj.addRowUp($(this).parent().attr("id"));
        });
  
        $(".btndown").live("click",function(){
            obj.addRowDown($(this).parent().attr("id"),"[]");
        });
        
        
    },
   
    setvalue: function(obj,value_arr){

        var v_arr=JSON.parse(value_arr)
        var id=0;           //in caso di primo inserimento passerò obj = null
        if(obj!=null) id=obj.rowid
   
        var index=0
   
        $('#row_'+id).closest('tr').children().children().each(function(){
    
  
  
            if($(this).attr("name")!=="undefined") {   //al primo elemento che ha un name assegno il value
                var tagname=$(this)[0].tagName
       
                var val=""
                if(v_arr[index]!=undefined && v_arr[index][id]!=undefined) val=v_arr[index][id]      //se aggiungo tramite pulsanti value_arr sarà vuoto e otterò undefined quindi val=""
                //in caso contrario se è assegnato un value, questi verrà riportato nella giusta posizione
                //alert(tagname +" " + $(this).attr("type") + " " + val)
    
                if(tagname=="TEXTAREA"){
                    $(this).append(val)
                    //  $(this).focus()
                    index++;
                }
                else if(tagname=="INPUT" && ($(this).attr("type")=="text" || $(this).attr("type")=="hidden") ) {
                    $(this).val(val)
                    //$(this).focus()
                    index++;
                }
                else if(tagname=="SELECT"){
                    $(this).children().each(function(){
                        if($(this).attr("selected")=="selected") $(this).removeAttr("selected")
                        if($(this).val()==val) $(this).attr("selected","selected")
                    })//close  $(this).children().each(function()
                    index++;   
                }//close else if(tagname=="SELECT")
                else if(tagname=="CENTER"){  //caso particolare del progetto CRI
   
                    if(val=="on") {
                        $(this).find("input:checkbox").attr('checked', true);
                        $(this).find("input:hidden").val('on');
                    }
                    else {   
                        $(this).find("input:checkbox").attr('checked', false);
                        $(this).find("input:hidden").val('off');
                    }
                }// else if(tagname=="CENTER")  close 
            }
     
        });
    } //close setvalue
 
});

  
 