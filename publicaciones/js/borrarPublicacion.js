$(document).ready(function(){

    $('[data-toggle="tooltip"]').tooltip();

    var botonBorrar = $(".borrarPublicacion");

    botonBorrar.click(function(event){ 
        event.preventDefault();
        swal({
            title: "Está seguro?",
            text: "Una vez eliminada la publicación no podrá volver atrás!",
            icon: "warning",
            closeOnEsc: true,
            buttons: {
                cancel: "Cancelar",
                borrar: {
                    text: "Si, estoy seguro",
                    value: "borrar",  
                },
            }
            })
            .then((valor) => {
                if(valor == "borrar"){
                    window.location.href = $(this).attr('href');
                }
            });   
    });

    

});