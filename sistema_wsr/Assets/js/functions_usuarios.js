let tableUsuarios;
let divLoading = document.querySelector("#divLoading");
let rowTable = "";
document.addEventListener('DOMContentLoaded', function(){

	tableUsuarios = $('#tableUsuarios').DataTable({
		"aProcessing":true,
		"aServerside":true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url": " "+base_url+"/Usuarios/getUsuarios",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
		"dataSrc":""
		},
		"columns":[/* Campos de la base de datos*/
			{"data":"idusuario"},
			{"data":"nombreusu"},
			{"data":"apellido"},
			{"data":"email"},
			{"data":"telefono"},
			{"data":"nombre"},
			{"data":"status"},
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

	if(document.querySelector("#formUsuario")){
		let formUsuario = document.querySelector("#formUsuario");
		formUsuario.onsubmit = function(e){
			e.preventDefault();
			let strIdentificador = document.querySelector('#txtIdentificacion').value;
			let strNombre = document.querySelector('#txtNombre').value;
			let strApellido = document.querySelector('#txtApellido').value;
			let strEmail = document.querySelector('#txtCorreo').value;
			let intTelefono = document.querySelector('#txtTelefono').value;
			let intTipousuario = document.querySelector('#listRolid').value;
			let strPassword = document.querySelector('#txtPassword').value;
			let intStatus = document.querySelector('#listStatus').value;

			if(strIdentificador == '' || strNombre == '' || strApellido == '' || strEmail == '' || intTelefono == '' || intTipousuario == '')
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
			let ajaxUrl = base_url+'/Usuarios/setUsuario';
			let formData = new FormData(formUsuario);
			request.open("POST",ajaxUrl,true);
			request.send(formData);
			request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200){
					let objData = JSON.parse(request.responseText);
					if(objData.status)
					{
						if(rowTable == ""){
							tableUsuarios.ajax.reload();
						}else{
							htmlStatus = intStatus == 1 ?
							'<span class="badge-success">Activo</span>':
							'<span class="badge-danger">Inactivo</span>';

							rowTable.cells[1].textContent = strNombre;
							rowTable.cells[2].textContent = strApellido;
							rowTable.cells[3].textContent = strEmail;
							rowTable.cells[4].textContent = intTelefono;
							rowTable.cells[5].textContent = document.querySelector("#listRolid").selectedOptions[0].text;
							rowTable.cells[6].innerHTML = htmlStatus;
						}
						$('#modalFormUsuario').modal("hide");
						formUsuario.reset();
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
	//Actualizar Usuario Perfil
	if(document.querySelector("#formPerfil")){
		let formPerfil = document.querySelector("#formPerfil");
		formPerfil.onsubmit = function(e){
			e.preventDefault();
			let strNombre = document.querySelector('#txtNombre').value;
			let strApellido = document.querySelector('#txtApellido').value;
			let intTelefono = document.querySelector('#txtTelefono').value;
			let strPassword = document.querySelector('#txtPassword').value;
            let strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;

			if(strNombre == '' || strApellido == '' || intTelefono == '')
			{
				swal("Atencion", "Todos los campos son obligatorios.", "error");
				return false;
			}

			if(strPassword != "" || strPasswordConfirm != "")
            {   
                if( strPassword != strPasswordConfirm ){
                    swal("Atención", "Las contraseñas no son iguales." , "info");
                    return false;
                }           
                if(strPassword.length < 5 ){
                    swal("Atención", "La contraseña debe tener un mínimo de 5 caracteres." , "info");
                    return false;
                }
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
			let ajaxUrl = base_url+'/Usuarios/putPerfil';
			let formData = new FormData(formPerfil);
			request.open("POST",ajaxUrl,true);
			request.send(formData);
			request.onreadystatechange = function(){
				if(request.readyState != 4) return;
				if(request.status == 200){
					let objData = JSON.parse(request.responseText);
					if(objData.status)
					{
						$('#modalFormPerfil').modal("hide");
                        swal({
                            title: "",
                            text: objData.msg,
                            type: "success",
                            confirmButtonText: "Aceptar",
                            closeOnConfirm: false,
                        }, function(isConfirm) {
                            if (isConfirm) {
                                location.reload();
                            }
                        });
					}else{
						swal("Error", objData.msg , "error");
					}
				}
				divLoading.style.display = "none";
				return false;
			}

		}
	}
	//Actualizar Datos fiscales
	if(document.querySelector("#formDataFiscal")){
		let formDataFiscal = document.querySelector("#formDataFiscal");
		formDataFiscal.onsubmit = function(e){
			e.preventDefault();
			let strRfc = document.querySelector('#txtRfc').value;
            let strNombreSocial = document.querySelector('#txtNombreSocial').value;
            let strCalle = document.querySelector('#txtCalle').value;
            let intInterior = document.querySelector('#txtNInterior').value;
            let intExterior = document.querySelector('#txtNExterno').value;
            let strColonia = document.querySelector('#txtColonia').value;
            let intCP = document.querySelector('#txtCP').value;
            let strMunicipio = document.querySelector('#txtMunicipio').value;
            let strEstado = document.querySelector('#txtEstado').value;
            let strPais = document.querySelector('#txtPais').value;

			if(strRfc == '' || strNombreSocial == '' || strCalle == '' || intInterior == '' || intExterior == '' || strColonia == '' || intCP == '' || strMunicipio == '' || strEstado == ''|| strPais == '')
			{
				swal("Atencion", "Todos los campos son obligatorios.", "error");
				return false;
			}
			divLoading.style.display = "flex";
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Usuarios/putDFiscal';
			let formData = new FormData(formDataFiscal);
			request.open("POST",ajaxUrl,true);
			request.send(formData);
			request.onreadystatechange = function(){
				if(request.readyState != 4) return;
				if(request.status == 200){
					let objData = JSON.parse(request.responseText);
					if(objData.status)
					{
						$('#modalFormPerfil').modal("hide");
                        swal({
                            title: "",
                            text: objData.msg,
                            type: "success",
                            confirmButtonText: "Aceptar",
                            closeOnConfirm: false,
                        }, function(isConfirm) {
                            if (isConfirm) {
                                location.reload();
                            }
                        });
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

window.addEventListener('load', function(){
	fntRolesUsuario();
	//fntViewUsuario();
	//fntEditUsuario();
	//fntDelUsuario();
}, false);


function fntRolesUsuario(){
	if(document.querySelector('#listRolid')){
		let ajaxUrl = base_url+'/Roles/getSelectRoles';
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		request.open("GET", ajaxUrl, true);
		request.send();

		request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200){
				document.querySelector('#listRolid').innerHTML = request.responseText;
				//document.querySelector('#listRolid').value = 1;
				$('#listRolid').selectpicker('render');
			}
		}
	}
}

function fntViewUsuario(idusuario){ 
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	let ajaxUrl = base_url+'/Usuarios/getUsuario/'+idusuario;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			let objData = JSON.parse(request.responseText);
			if(objData.status)
			{
				let estadoUsuario = objData.data.status == 1?
				'<span class="badge badge-success">Activo</span>' :
				'<span class="badge badge-danger">Inactivo</span>';
				document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
				document.querySelector("#celNombre").innerHTML = objData.data.nombreusu;
				document.querySelector("#celApellido").innerHTML = objData.data.apellido;
				document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
				document.querySelector("#celEmail").innerHTML = objData.data.email;
				document.querySelector("#celTipoUsuario").innerHTML = objData.data.nombre;
				document.querySelector("#celEstado").innerHTML = estadoUsuario;
				document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro;
				$('#modalViewUser').modal('show');
			}else{
				swal("Error", objData.msg , "error");
			}
		}
	}
}


function fntEditUsuario(element, idusuario){
	rowTable = element.parentNode.parentNode.parentNode;
	document.querySelector('#titleModal').innerHTML ="Actualizar Usuario";
	document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
	document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
	document.querySelector('#btnText').innerHTML ="Actualizar";
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	let ajaxUrl = base_url+'/Usuarios/getUsuario/'+idusuario;
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
				document.querySelector('#listRolid').value = objData.data.idrol;
				$('#listRolid').selectpicker('render');

				if(objData.data.status == 1){
					document.querySelector("#listStatus").value = 1;
				}else{
					document.querySelector("#listStatus").value = 2;
				}
				$('#listStatus').selectpicker('render');
			}
		}
		$('#modalFormUsuario').modal('show');
	}
}

function fntDelUsuario(idusuario){
    swal({
        title: "Eliminar Usuario",
        text: "¿Realmente quiere eliminar el Usuario?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm) 
        {
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Usuarios/delUsuario';
            var strData = "idUsuario="+idusuario;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminar!", objData.msg , "success");
                        tableUsuarios.ajax.reload();
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
	document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
	document.querySelector('#formUsuario').reset();
	$('#modalFormUsuario').modal('show');
}

function openModalPerfil()
{
	$('#modalFormPerfil').modal('show');
}