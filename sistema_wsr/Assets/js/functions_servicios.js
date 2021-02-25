let tableServicios;
let divLoading = document.querySelector("#divLoading");
let rowTable = "";

$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-dialog").length) { 
        e.stopImmediatePropagation();
    }
});

tableServicios = $('#tableServicios').DataTable({
    "aProcessing":true,
    "aServerside":true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax":{
        "url": " "+base_url+"/Servicios/getServicios",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
    "dataSrc":""
    },
    "columns":[/* Campos de la base de datos*/
        {"data":"idservicio"},
        {"data":"nombreser"},
        {"data":"categoria"},
        {"data":"descripcion"},
        {"data":"status"},
        {"data":"options"}
    ],
    "columnDefs": [
                    {'className': "textcenter", "targets": [2] },
                    {'className': "textcenter", "targets": [4] }
    ],
    'dom': 'lBfrtip',
    'buttons': [
        {
            "extend": "copyHtml5",
            "text": "<i class='far fa-copy'></i> Copiar",
            "titleAttr":"Copiar",
            "className": "btn btn-secondary",
            "exportOptions": { 
            "columns": [ 0, 1, 2, 3, 4] 
        }
        },{
            "extend": "excelHtml5",
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr":"Esportar a Excel",
            "className": "btn btn-success",
            "exportOptions": { 
            "columns": [ 0, 1, 2, 3, 4] 
        }
        },{
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr":"Esportar a PDF",
            "className": "btn btn-danger",
            "exportOptions": { 
            "columns": [ 0, 1, 2, 3, 4] 
        }
        },{
            "extend": "csvHtml5",
            "text": "<i class='fas fa-file-csv'></i> CSV",
            "titleAttr":"Esportar a CSV",
            "className": "btn btn-info",
            "exportOptions": { 
            "columns": [ 0, 1, 2, 3, 4] 
        }
        }
    ],
    "resonsieve":"true",
    "bDestroy": true,
    "iDisplayLength": 10, 
    "order":[[0,"desc"]] 
});

window.addEventListener('load', function() {
 
    if(document.querySelector("#formServicio")){
        let formServicio = document.querySelector("#formServicio");
        formServicio.onsubmit = function(e) {
            e.preventDefault();
            let strNombre = document.querySelector('#txtNombre').value;
            let intCategoria = document.querySelector('#listCategoria').value;
            let intStatus = document.querySelector('#listStatus').value;
            let strDescripcion = document.querySelector('#txtDescripcion').value;
            if(strNombre == '' || intCategoria == '' || intStatus == '' )
            {
                swal("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }
            
            divLoading.style.display = "flex";
            tinyMCE.triggerSave();
            let request = (window.XMLHttpRequest) ? 
                            new XMLHttpRequest() : 
                            new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Servicios/setServicio'; 
            let formData = new FormData(formServicio);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("", objData.msg ,"success");
                        document.querySelector("#idServicio").value = objData.idservicio;
                        document.querySelector("#containerGallery").classList.remove("notblock");

                        if(rowTable == ""){
                            tableServicios.ajax.reload();
                             
                        }else{
                           htmlStatus = intStatus == 1 ? 
                            '<span class="badge badge-success">Activo</span>' : 
                            '<span class="badge badge-danger">Inactivo</span>';
                            rowTable.cells[1].textContent = strNombre;
                            rowTable.cells[2].textContent = intCategoria;
                            rowTable.cells[3].textContent = strDescripcion;
                            rowTable.cells[4].innerHTML =  htmlStatus;
                            rowTable = ""; 
                        }
                    	//$('#modalFormServicio').modal("hide");
                    	//formServicio.reset();
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }

    if(document.querySelector(".btnAddImage")){
       let btnAddImage =  document.querySelector(".btnAddImage");
       btnAddImage.onclick = function(e){
        let key = Date.now();
        let newElement = document.createElement("div");
        newElement.id= "div"+key;
        newElement.innerHTML = `
            <div class="prevImage"></div>
            <input type="file" name="foto" id="img${key}" class="inputUploadfile">
            <label for="img${key}" class="btnUploadfile"><i class="fas fa-upload "></i></label>
            <button class="btnDeleteImage notblock" type="button" onclick="fntDelItem('#div${key}')"><i class="fas fa-trash-alt"></i></button>`;
        document.querySelector("#containerImages").appendChild(newElement);
        document.querySelector("#div"+key+" .btnUploadfile").click();
        fntInputFile();
       }
    }
    
    fntInputFile();
	fntCategorias();
}, false);

function fntInputFile(){
    let inputUploadfile = document.querySelectorAll(".inputUploadfile");
    inputUploadfile.forEach(function(inputUploadfile) {
        inputUploadfile.addEventListener('change', function(){
            let idServicio = document.querySelector("#idServicio").value;
            let parentId = this.parentNode.getAttribute("id");
            let idFile = this.getAttribute("id");            
            let uploadFoto = document.querySelector("#"+idFile).value;
            let fileimg = document.querySelector("#"+idFile).files;
            let prevImg = document.querySelector("#"+parentId+" .prevImage");
            let nav = window.URL || window.webkitURL;
            if(uploadFoto !=''){
                let type = fileimg[0].type;
                let name = fileimg[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){
                    prevImg.innerHTML = "Archivo no válido";
                    uploadFoto.value = "";
                    return false;
                }else{
                    let objeto_url = nav.createObjectURL(this.files[0]);
                    prevImg.innerHTML = `<img class="loading" src="${base_url}/Assets/images/loading.svg" >`;

                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = base_url+'/Servicios/setImage'; 
                    let formData = new FormData();
                    formData.append('idservicio',idServicio);
                    formData.append("foto", this.files[0]);
                    request.open("POST",ajaxUrl,true);
                    request.send(formData);
                    request.onreadystatechange = function(){
                        if(request.readyState != 4) return;
                        if(request.status == 200){
                            let objData = JSON.parse(request.responseText);
                            if(objData.status){
                                prevImg.innerHTML = `<img src="${objeto_url}">`;
                                document.querySelector("#"+parentId+" .btnDeleteImage").setAttribute("imgname",objData.imgname);
                                document.querySelector("#"+parentId+" .btnUploadfile").classList.add("notblock");
                                document.querySelector("#"+parentId+" .btnDeleteImage").classList.remove("notblock");
                            }else{
                                swal("Error", objData.msg , "error");
                            }
                        }
                    }

                }
            }

        });
    });
}

function fntDelItem(element){
    let nameImg = document.querySelector(element+' .btnDeleteImage').getAttribute("imgname");
    let idServicio = document.querySelector("#idServicio").value;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Servicios/delFile'; 

    let formData = new FormData();
    formData.append('idservicio',idServicio);
    formData.append("file",nameImg);
    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange = function(){
        if(request.readyState != 4) return;
        if(request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                let itemRemove = document.querySelector(element);
                itemRemove.parentNode.removeChild(itemRemove);
            }else{
                swal("", objData.msg , "error");
            }
        }
    }
}

function fntViewInfo(idservicio){
    let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Servicios/getServicio/'+idservicio;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                let htmlImage = "";
                let objServicio = objData.data;
                let estadoServicio = objServicio.status == 1 ? 
                '<span class="badge badge-success">Activo</span>' : 
                '<span class="badge badge-danger">Inactivo</span>';

                document.querySelector("#celId").innerHTML = objServicio.idservicio;
                document.querySelector("#celNombre").innerHTML = objServicio.nombreser;
                document.querySelector("#celCategoria").innerHTML = objServicio.categoria;
                document.querySelector("#celDescripcion").innerHTML = objServicio.descripcion;
                document.querySelector("#celEstado").innerHTML = estadoServicio;

                if(objServicio.images.length > 0){
                    let objServicios = objServicio.images;
                    for (let p = 0; p < objServicios.length; p++) {
                        htmlImage +=`<img src="${objServicios[p].url_image}"></img>`;
                    }
                }
                document.querySelector("#celFotos").innerHTML = htmlImage;
                $('#modalViewCategoria').modal('show');

            }else{
                swal("Error", objData.msg , "error");
            }
        }
    } 
}

function fntEditInfo(element,idservicio){//(element,idProducto){
    rowTable = element.parentNode.parentNode.parentNode;
    
    document.querySelector('#titleModal').innerHTML ="Actualizar Servicio";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Servicios/getServicio/'+idservicio;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {

                let htmlImage = "";
                let objServicio = objData.data;
                document.querySelector("#idServicio").value = objServicio.idservicio;
                document.querySelector("#txtNombre").value = objServicio.nombreser;
                document.querySelector("#txtDescripcion").value = objServicio.descripcion;
                document.querySelector("#listCategoria").value = objServicio.categoriaid;
                document.querySelector("#listStatus").value = objServicio.status;
                tinymce.activeEditor.setContent(objServicio.descripcion); 
                $('#listStatus').selectpicker('render');
                $('#listCategoria').selectpicker('render');

                if(objServicio.images.length > 0){
                    let objServicios = objServicio.images;
                    for (let p = 0; p < objServicios.length; p++) {
                        let key = Date.now()+p;
                        htmlImage +=`<div id="div${key}">
                            <div class="prevImage">
                            <img src="${objServicios[p].url_image}"></img>
                            </div>
                            <button type="button" class="btnDeleteImage" onclick="fntDelItem('#div${key}')" imgname="${objServicios[p].img}">
                            <i class="fas fa-trash-alt"></i></button></div>`;
                    }
                }

                document.querySelector("#containerImages").innerHTML = htmlImage; 
                $('#modalFormServicio').modal('show');

            }else{
                swal("Error", objData.msg , "error");
            }
        }
    } 
}
/*function fntViewInfo(idservicio){ 
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Servicios/getServicio/'+idservicio;
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

                document.querySelector("#celId").innerHTML = objData.data.idservicio;
                document.querySelector("#celNombre").innerHTML = objData.data.nombreser;
                document.querySelector("#celCategoria").innerHTML = objData.data.categoria;
                document.querySelector("#celDescripcion").innerHTML = objData.data.descripcion;
                document.querySelector("#celEstado").innerHTML = objData.data.status;
                document.querySelector("#celEstado").innerHTML = estado;
                $('#modalViewCategoria').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}*/

/*function fntEditInfo(idservicio){ 
    document.querySelector('#titleModal').innerHTML ="Actualizar Servicio";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Servicios/getServicio/'+idservicio;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#idServicio").value = objData.data.idservicio;
                document.querySelector("#txtNombre").value = objData.data.nombreser;
                document.querySelector("#txtDescripcion").value = objData.data.descripcion;
                document.querySelector("#listCategoria").value = objData.data.categoriaid;
                tinymce.activeEditor.setContent(objData.data.descripcion); 
                $('#listStatus').selectpicker('render');
                $('#listCategoria').selectpicker('render');


                 if(objData.data.status == 1){
                    document.querySelector("#listStatus").value = 1;
                }else{
                    document.querySelector("#listStatus").value = 2;
                }
                $('#listStatus').selectpicker('render');

                $('#modalFormServicio').modal('show');

            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}*/

function fntDelInfo(idservicio){
    swal({
        title: "Eliminar Servicio",
        text: "¿Realmente quiere eliminar el servicio?",
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
            let ajaxUrl = base_url+'/Servicios/delServicio';
            let strData = "idServicio="+idservicio;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminar!", objData.msg , "success");
                        tableServicios.ajax.reload();
                    }else{
                        swal("Atención!", objData.msg , "error");
                    }
                }
            }
        }

    });

}


function fntCategorias(){
    if(document.querySelector('#listCategoria')){
        let ajaxUrl = base_url+'/Categorias/getSelectCategorias';
        let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#listCategoria').innerHTML = request.responseText;
                $('#listCategoria').selectpicker('render');
            }
        }
    }
}

tinymce.init({
	selector: '#txtDescripcion',
	width: "100%",
    height: 400,    
    statubar: true,
    plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
});



function openModal()
{
    rowTable = "";
	document.querySelector('#idServicio').value ="";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nuevo Servicio";
	document.querySelector('#formServicio').reset();
    document.querySelector("#containerGallery").classList.add("notblock");
    document.querySelector("#containerImages").innerHTML = "";
	$('#modalFormServicio').modal('show');
} 