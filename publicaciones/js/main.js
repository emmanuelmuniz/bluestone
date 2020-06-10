$(document).ready(function(){
    

    var botonBorrar = $("#borrarPublicacion");

    botonBorrar.click(function(event){      
        var respuesta = confirm("¿Desea eliminar esta publicación?");

        if(respuesta==false){
            event.preventDefault();
        }
    });

});