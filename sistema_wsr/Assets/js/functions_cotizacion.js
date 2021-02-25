let tableCotizacion;
let divLoading = document.querySelector("#divLoading");
 
document.addEventListener('DOMContentLoaded', function(){

    tableCotizacion = $('#tableCotizacion').DataTable({
        "aProcessing":true,
        "aServerside":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Cotizacion/getCotizaciones",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
        "dataSrc":""
        },
        "columns":[/* Campos de la base de datos*/
            {"data":"idcotizacion"},
            {"data":"numcotizacion"},
            {"data":"descripcion"},
            {"data":"cliente"},
            {"data":"servicio"},
            {"data":"prioridad"},
            {"data":"options"}
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary",
                "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4, 5] 
            }
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Esportar a Excel",
                "className": "btn btn-success",
                "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4, 5] 
            }
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Esportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4, 5] 
            }
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Esportar a CSV",
                "className": "btn btn-info",
                "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4, 5] 
            }
            }
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10, 
        "order":[[0,"desc"]] 
    });

    if(document.querySelector("#formCotizacion")){
        let formCotizacion = document.querySelector("#formCotizacion");
        formCotizacion.onsubmit = function(e) {
            e.preventDefault();
            let intCliente = document.querySelector('#listCliente').value;
            let intServicio = document.querySelector('#listServicioo').value;
            let intNCotizacion = document.querySelector('#txtCotizacion').value;
            let strDescripcion = document.querySelector('#txtDescripcion').value;
            let strTipoPago = document.querySelector('#txtPago').value;
            let intStatus = document.querySelector('#listStatus').value;
            let intPrioridad = document.querySelector('#listPrioridad').value;
            
            if(intCliente == '' || intServicio == '' || intNCotizacion == '' || strTipoPago == '' || intPrioridad == '' )
            {
                swal("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }
            
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? 
                            new XMLHttpRequest() : 
                            new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Cotizacion/setCotizacion'; 
            let formData = new FormData(formCotizacion);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("", objData.msg ,"success");
                        $('#modalFormCotizacion').modal("hide");
                        formCotizacion.reset();
                        tableCotizacion.ajax.reload();
                        
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }
    fntClientes();
    
}, false);

window.addEventListener('load', function(){
    fntServicios();
}, false);


function fntServicios(){
    if(document.querySelector('#listServicioo')){
        var ajaxUrl = base_url+'/Servicios/getSelectServicios';
        var request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#listServicioo').innerHTML = request.responseText;
                $('#listServicioo').selectpicker('render');
            }
        }
    }
}

function fntClientes(){  
  if(document.querySelector('#listCliente')){
        let ajaxUrl = base_url+'/Clientes/getSelectClientes';
        let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#listCliente').innerHTML = request.responseText;
                $('#listCliente').selectpicker('render');
            }
        }
    }
}


function fntViewInfo(idcotizacion){ 
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Cotizacion/getCotizacion/'+idcotizacion;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                let estado = objData.data.status == 1 ?
                '<span class="badge badge-success">Activo</span>' :
                '<span class="badge badge-danger">Inactivo</span>';

                let priori = objData.data.prioridad == 1 ? 
                '<span class="badge badge-success">Bajo</span>' :
                objData.data.prioridad == 2 ?
                '<span class="badge badge-warning">Media</span>' :
                '<span class="badge badge-danger">Alta</span>';

                document.querySelector("#celNCotizacion").innerHTML = objData.data.numcotizacion;
                document.querySelector("#celCliente").innerHTML = objData.data.cliente;
                document.querySelector("#celServicio").innerHTML = objData.data.servicio;
                document.querySelector("#celTiPago").innerHTML = objData.data.formapago;
                document.querySelector("#celDescripcion").innerHTML = objData.data.descripcion;
                document.querySelector("#celEstatus").innerHTML = objData.data.status;
                document.querySelector("#celEstatus").innerHTML = estado;
                document.querySelector("#celPrioridad").innerHTML = objData.data.prioridad;
                document.querySelector("#celPrioridad").innerHTML = priori;
                $('#modalViewCotizacion').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditInfo(idcotizacion){ 
    document.querySelector('#titleModal').innerHTML ="Actualizar Cotizacion";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Cotizacion/getCotizacion/'+idcotizacion;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#idCotizacion").value = objData.data.idcotizacion;
                document.querySelector("#listCliente").value = objData.data.usuarioid;
                document.querySelector("#txtCotizacion").value = objData.data.numcotizacion;
                document.querySelector("#listPrioridad").value = objData.data.prioridad;
                document.querySelector("#listServicioo").value = objData.data.servicioid;
                document.querySelector("#txtPago").value = objData.data.formapago;
                document.querySelector("#listStatus").value = objData.data.status;
                document.querySelector("#txtDescripcion").value = objData.data.descripcion;
                $('#listStatus').selectpicker('render');
                $('#listPrioridad').selectpicker('render');
                $('#listCliente').selectpicker('render');
                $('#listServicioo').selectpicker('render');


                if(objData.data.status == 1){
                    document.querySelector("#listStatus").value = 1;
                }else{
                    document.querySelector("#listStatus").value = 2;
                }
                $('#listStatus').selectpicker('render');

                if(objData.data.prioridad == 1){
                    document.querySelector("#listPrioridad").value = 1;
                }else if(objData.data.prioridad == 2){
                    document.querySelector("#listPrioridad").value = 2;
                }else{
                    document.querySelector("#listPrioridad").value = 3;
                }
                $('#listPrioridad').selectpicker('render');

                $('#modalFormCotizacion').modal('show');

            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntDelInfo(idcotizacion){
    swal({
        title: "Eliminar Cotizacion",
        text: "¿Realmente quiere eliminar la cotizacion?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm) 
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Cotizacion/delCotizacion';
            let strData = "idCotizacion="+idcotizacion;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminar!", objData.msg , "success");
                        tableCotizacion.ajax.reload();
                    }else{
                        swal("Atención!", objData.msg , "error");
                    }
                }
            }
        }

    });
}

function openModal()
{
	document.querySelector('#idCotizacion').value ="";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Solicitud de Cotizacion";
	document.querySelector('#formCotizacion').reset();
	$('#modalFormCotizacion').modal('show');
}
