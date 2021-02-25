<?php 
	class Clientes extends Controllers{
		public function __construct()
		{
			parent::__construct(); 
			session_start();
			session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(4);	
		}
		public function clientes()
		{
            if(empty($_SESSION['permisosMod']['r'])){
				header('Location: '.base_url().'/dashboard');
			}
			
			$data['page_tag'] = "Clientes - WSR Integral";
			$data['page_title'] = "clientes";
			$data['page_name'] = "CLIENTES";
			$data['page_functions_js'] = "functions_clientes.js";
			$this->views->getView($this,"clientes", $data);
		}

		public function setCliente(){
			error_reporting(0);
			if($_POST){

				if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtCorreo']) || empty($_POST['txtTelefono']) || empty($_POST['txtRfc']) || empty($_POST['txtNombreSocial']) || empty($_POST['txtCalle']) || empty($_POST['txtInterior']) || empty($_POST['txtExterior']) || empty($_POST['txtColonia']) || empty($_POST['txtCp']) || empty($_POST['txtMunicipio']) || empty($_POST['txtEstado']) || empty($_POST['txtPais']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					$idUsuario = intval($_POST['idUsuario']);
					$strIdentificador = strClean($_POST['txtIdentificacion']);
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strApellido = ucwords(strClean($_POST['txtApellido']));
					$strEmail = strtolower(strClean($_POST['txtCorreo']));
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strRfc = strClean($_POST['txtRfc']);
					$strNomSocial = strClean($_POST['txtNombreSocial']);
					$strCalle = strClean($_POST['txtCalle']);
					$intInterior = intval(strClean($_POST['txtInterior']));
					$intExterior = intval(strClean($_POST['txtExterior']));
					$strColonia = strClean($_POST['txtColonia']);
					$intCp = intval(strClean($_POST['txtCp']));
					$strMunicipio = strClean($_POST['txtMunicipio']);
					$strEstado = strClean($_POST['txtEstado']);
					$strPais = strClean($_POST['txtPais']);
					$intTipoId = 4;
					$intStatus = 1;
					$request_user = "";

					if($idUsuario == 0)
					{
						$option = 1;
						$strPassword =  empty($_POST['txtPassword']) ? passGenerator() : $_POST['txtPassword'];
						$strPasswordEncript = hash("SHA256",$strPassword);
						if($_SESSION['permisosMod']['w']){
							$request_user = $this->model->insertCliente($strIdentificador,
																	$strNombre,
																	$strApellido,
																	$intTelefono,
																	$strEmail,
																	$strPasswordEncript,
																	$intTipoId,
																	$intStatus,
																	$strRfc,
																	$strNomSocial,
																	$strCalle,
																	$intInterior,
																	$intExterior,
																	$strColonia,
																	$intCp,
																	$strMunicipio,
																	$strEstado,
																	$strPais);
						}	
					}else{
						$option = 2;
						$strPassword = empty($_POST['txtPassword']) ? "" : hash("SHA256",$_POST['txtPassword']);
						if($_SESSION['permisosMod']['u']){
							$request_user = $this->model->updateCliente($idUsuario,
																	$strIdentificador,
																	$strNombre,
																	$strApellido,
																	$intTelefono,
																	$strEmail,
																	$strPassword,
																	$strRfc,
																	$strNomSocial,
																	$strCalle,
																	$intInterior,
																	$intExterior,
																	$strColonia,
																	$intCp,
																	$strMunicipio,
																	$strEstado,
																	$strPais); 
						}	
					}

					
					if($request_user > 0)
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
							$nombreUsuario = $strNombre.' '.$strApellido;
							$dataUsuario = array('nombreUsuario' => $nombreUsuario,
											 'email' => $strEmail,
											 'password' => $strPassword,
											 'asunto' => 'Bienvenido a WSR Integral');
							sendEmail($dataUsuario,'email_bienvenida');
						}else{
							$arrResponse = array('status' => true, 'msg' => 'Datos atualizados correctamente.');
						}
					}else if($request_user == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atencion! el email o la identificacion ya existe, ingrese otro.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
					}

				}

				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getClientes()
		{
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectClientes();
				for ($i=0; $i < count($arrData); $i++){
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idusuario'].')" title="Ver cliente"><i class="fas fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['idusuario'].')" title="Editar cliente"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idusuario'].')" title="Eliminar cliente"><i class="far fa-trash-alt"></i></button>';
					}
					
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getCliente($idusuario){
			if($_SESSION['permisosMod']['r']){
				$idpersona = intval($idusuario);
				if($idpersona > 0)
				{
					$arrData = $this->model->selectCliente($idpersona);
					if(empty($arrData))
					{
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}	
			die();
		}

		public function delCliente(){
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdusuario = intval($_POST['idUsuario']);
					$requestDelete = $this->model->deleteCliente($intIdusuario);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el cliente.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el cliente.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}	
			}
			die();
		}

		public function getSelectClientes(){
			$htmlOptions = "";
			$arrData = $this->model->selectClientes();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					if($arrData[$i]['status'] == 1 ){
					$htmlOptions .= '<option value="'.$arrData[$i]['idusuario'].'">'.$arrData[$i]['nombreusu'].' '.$arrData[$i]['apellido'].'</option>';
					}
				}
			}
			echo $htmlOptions;
			die();	
		}
	}
 ?> 