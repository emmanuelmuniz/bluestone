$(document).ready(function(){

    var lenguaje_espanol = {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
        "buttons": {
            "copy": "Copiar",
            "colvis": "Visibilidad"
        }
    }

    crearDatatable();
    
    function crearDatatable(){
        $(table).DataTable().destroy();
        var table = $("#tablaUsuarios").DataTable({
            "ajax": {
                "method": "POST",
                "url": "usuarios.php"
            },
            "columns": [
                {"data": "idUsuario"},
                {"data": "nombre"},
                {"data": "apellido"},
                {"data": "email"},
                {"defaultContent": "<a type='button'class='eliminar'><i class='fa fa-trash' aria-hidden='true'></i></a>"}
            ],
            "columnDefs": [
                {
                    "targets": 0,
                    "visible": false
                },
                {
                    "targets": 1,
                    className : "nombre"
                },
                {
                    "targets": 2,
                    className : "apellido"
                },
                {
                    "targets": 3,
                    className : "correo"
                },
                {
                    "targets": 4,
                    className : "borrar"
                }
            ],
            "language": lenguaje_espanol
        });

        getData("#tablaUsuarios tbody", table);
    }

    function getData(tbody, table){
        $(tbody).on("click", "a.eliminar", function(){
            var data = table.row($(this).parents("tr")).data();
            
            console.log(data.idUsuario);

            var respuesta = confirm("¿Desea eliminar este usuario?");

            if(respuesta==true){           
                window.location.href = "../index.php";
            }
        }); 
    }   
});

