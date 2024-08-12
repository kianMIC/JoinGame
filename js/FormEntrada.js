$(document).ready(function(){

    //--------------------- SELECCIONAR FOTO ENTRADAS ---------------------
    $("#foto").on("change",function(){
    	var uploadFoto = document.getElementById("foto").value;
        var foto       = document.getElementById("foto").files;
        var nav = window.URL || window.webkitURL;
        var contactAlert = document.getElementById('form_alert');
        
            if(uploadFoto !='')
            {
                var type = foto[0].type;
                var name = foto[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
                {
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';                        
                    $("#img").remove();
                    $(".delPhoto").addClass('notBlock');
                    $('#foto').val('');
                    return false;
                }else{  
                        contactAlert.innerHTML='';
                        $("#img").remove();
                        $(".delPhoto").removeClass('notBlock');
                        var objeto_url = nav.createObjectURL(this.files[0]);
                        $(".prevPhoto").append("<img id='img' src="+objeto_url+">");
                        $(".upimg label").remove();
                        
                    }
              }else{
              	alert("No selecciono foto");
                $("#img").remove();
              }              
    });

    $('.delPhoto').click(function(){
    	$('#foto').val('');
    	$(".delPhoto").addClass('notBlock');
    	$("#img").remove();

    });
    $("#foto2").on("change",function(){
        var uploadFoto = document.getElementById("foto2").value;
        var foto       = document.getElementById("foto2").files;
        var nav = window.URL || window.webkitURL;
        var contactAlert = document.getElementById('form_alert2');
        
            if(uploadFoto !='')
            {
                var type = foto[0].type;
                var name = foto[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
                {
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';                        
                    $("#img2").remove();
                    $(".delPhoto2").addClass('notBlock2');
                    $('#foto2').val('');
                    return false;
                }else{  
                        contactAlert.innerHTML='';
                        $("#img2").remove();
                        $(".delPhoto2").removeClass('notBlock2');
                        var objeto_url = nav.createObjectURL(this.files[0]);
                        $(".prevPhoto2").append("<img id='img2' src="+objeto_url+">");
                        $(".upimg2 label2").remove();
                        
                    }
              }else{
                alert("No selecciono foto");
                $("#img2").remove();
              }              
    });

    $('.delPhoto2').click(function(){
        $('#foto2').val('');
        $(".delPhoto2").addClass('notBlock2');
        $("#img2").remove();

    });

});
