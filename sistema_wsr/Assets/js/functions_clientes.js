let tableClientes;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");

document.addEventListener('DOMContentLoaded', function(){

	tableClientes = $('#tableClientes').DataTable({
		"aProcessing":true,
		"aServerside":true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url": " "+base_url+"/Clientes/getClientes",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
		"dataSrc":""
		},
		"columns":[/* Campos de la base de datos*/
			{"data":"idusuario"},
			{"data":"identificacion"},
			{"data":"nombreusu"},
			{"data":"apellido"},
			{"data":"email"},
			{"data":"telefono"},
			{"data":"options"},
		],
		'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Esportar a Excel",
                "className": "btn btn-success"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Esportar a PDF",
                "className": "btn btn-danger"
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Esportar a CSV",
                "className": "btn btn-info"
            }
        ],
		"resonsieve":"true",
		"bDestroy": true,
		"iDisplayLength": 10, 
		"order":[[0,"desc"]] 
	});


	if(document.querySelector("#formCliente")){
		let formCliente = document.querySelector("#formCliente");
		formCliente.onsubmit = function(e){
			e.preventDefault();
			let strIdentificador = document.querySelector('#txtIdentificacion').value;
            let strNombre = document.querySelector('#txtNombre').value;
            let strApellido = document.querySelector('#txtApellido').value;
            let strEmail = document.querySelector('#txtCorreo').value;
            let intTelefono = document.querySelector('#txtTelefono').value;
            let strRfc = document.querySelector('#txtRfc').value;
            let strNomSocial = document.querySelector('#txtNombreSocial').value;
            let strCalle = document.querySelector('#txtCalle').value;
            let strPassword = document.querySelector('#txtPassword').value;
            let intInterior = document.querySelector('#txtInterior').value;
            let intExterior = document.querySelector('#txtExterior').value;
            let strColonia = document.querySelector('#txtColonia').value;
            let intCp = document.querySelector('#txtCp').value;
            let strMunicipio = document.querySelector('#txtMunicipio').value;
            let strEstado = document.querySelector('#txtEstado').value;
            let strPais = document.querySelector('#txtPais').value;

			if(strIdentificador == '' || strNombre == '' || strApellido == '' || strEmail == '' || intTelefono == '' || strRfc == '' || strNomSocial == '' || strCalle == '' 
				|| intInterior == '' || intExterior == '' || strColonia == '' || intCp == '' || strMunicipio == '' || strEstado == '' || strPais == '')
			{
				swal("Atencion", "Todos los campos son obligatorios.", "error");
				return false;
			}

			let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    swal("Atención", "Por favor verifique los campos en rojo." , "error");
                    return false;
                } 
            } 

			divLoading.style.display = "flex";
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Clientes/setCliente';
			let formData = new FormData(formCliente);
			request.open("POST",ajaxUrl,true);
			request.send(formData);
			request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200){
					let objData = JSON.parse(request.responseText);
					if(objData.status)
					{
						if(rowTable == ""){
							tableClientes.ajax.reload();
						}else{
							rowTable.cells[1].textContent = strIdentificador;
							rowTable.cells[2].textContent = strNombre;
							rowTable.cells[3].textContent = strApellido;
							rowTable.cells[4].textContent = strEmail;
							rowTable.cells[5].textContent = intTelefono;
							rowTable = "";
						}
						$('#modalFormCliente').modal("hide");
						formCliente.reset();
						swal("Usuarios", objData.msg , "success");
						
						
					}else{
						swal("Error", objData.msg , "error");
					}
				}
				divLoading.style.display = "none";
				return false;
			}

		}
	}

}, false);

function fntViewInfo(idusuario){ 
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	let ajaxUrl = base_url+'/Clientes/getCliente/'+idusuario;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			let objData = JSON.parse(request.responseText);
			if(objData.status)
			{
				document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
				document.querySelector("#celNombre").innerHTML = objData.data.nombreusu;
				document.querySelector("#celApellido").innerHTML = objData.data.apellido;
				document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
				document.querySelector("#celEmail").innerHTML = objData.data.email;
				document.querySelector("#celRfc").innerHTML = objData.data.rfc;
				document.querySelector("#celNomSocial").innerHTML = objData.data.nombresocial;
				document.querySelector("#celCalle").innerHTML = objData.data.calle;
				document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro;
				$('#modalViewCliente').modal('show');
			}else{
				swal("Error", objData.msg , "error");
			}
		}
	}
}

function fntEditInfo(element, idusuario){
	rowTable = element.parentNode.parentNode.parentNode;
	document.querySelector('#titleModal').innerHTML ="Actualizar Cliente";
	document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
	document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
	document.querySelector('#btnText').innerHTML ="Actualizar";
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	let ajaxUrl = base_url+'/Clientes/getCliente/'+idusuario;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		
		if(request.readyState == 4 && request.status == 200){
			let objData = JSON.parse(request.responseText);

			if(objData.status)
			{
				document.querySelector('#idUsuario').value = objData.data.idusuario;
				document.querySelector('#txtIdentificacion').value = objData.data.identificacion;
				document.querySelector('#txtNombre').value = objData.data.nombreusu;
				document.querySelector('#txtApellido').value = objData.data.apellido;
				document.querySelector('#txtCorreo').value = objData.data.email;
				document.querySelector('#txtTelefono').value = objData.data.telefono;
				document.querySelector('#txtRfc').value = objData.data.rfc;
				document.querySelector('#txtNombreSocial').value = objData.data.nombresocial;
				document.querySelector('#txtCalle').value = objData.data.calle;
				document.querySelector('#txtInterior').value = objData.data.numinterior;
				document.querySelector('#txtExterior').value = objData.data.numexterior;
				document.querySelector('#txtColonia').value = objData.data.colonia;
				document.querySelector('#txtCp').value = objData.data.cp;
				document.querySelector('#txtMunicipio').value = objData.data.municipio;
				document.querySelector('#txtEstado').value = objData.data.estado;
				document.querySelector('#txtPais').value = objData.data.pais;
			}
		}
		$('#modalFormCliente').modal('show');
	}
}

function fntDelInfo(idusuario){
    swal({
        title: "Eliminar Cliente",
        text: "¿Realmente quiere eliminar al cliente?",
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
            let ajaxUrl = base_url+'/Clientes/delCliente';
            let strData = "idUsuario="+idusuario;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminar!", objData.msg , "success");
                        tableClientes.ajax.reload();
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
	rowTable = "";
	document.querySelector('#idUsuario').value ="";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nuevo Cliente";
	document.querySelector('#formCliente').reset();
	$('#modalFormCliente').modal('show');
}