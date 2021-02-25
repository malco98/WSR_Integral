<?php 
	class Cotizacion extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(7);
		}

		public function cotizacion()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header('Location: '.base_url().'/dashboard');
			}
			$data['page_tag'] = "Cotizacion - WSR Integral";
			$data['page_title'] = "COTIZACION";
			$data['page_name'] = "cotizacion";
			$data['page_functions_js'] = "functions_cotizacion.js";
			$this->views->getView($this,"cotizacion", $data);
		}

		public function getCotizaciones()
		{
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectCotizaciones();
				for ($i=0; $i < count($arrData); $i++){
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}

					if($arrData[$i]['prioridad'] == 1)
				    {
						$arrData[$i]['prioridad'] = '<span class="badge badge-success">Baja</span>';
					}else if($arrData[$i]['prioridad'] == 2) 
					{
						$arrData[$i]['prioridad'] = '<span class="badge badge-warning">Media</span>';
					}else{
						$arrData[$i]['prioridad'] = '<span class="badge badge-danger">Alta</span>';
					}



					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idcotizacion'].')" title="Ver cotizacion"><i class="fas fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm" onClick="fntEditInfo('.$arrData[$i]['idcotizacion'].')" title="Editar cotizacion"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idcotizacion'].')" title="Eliminar cotizacion"><i class="far fa-trash-alt"></i></button>';
					}
					
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function setCotizacion(){
			if($_POST){
				if(empty($_POST['listCliente']) || empty($_POST['txtCotizacion']) || empty($_POST['listPrioridad']) || empty($_POST['listServicioo']) || empty($_POST['txtPago']) || empty($_POST['listStatus']) || empty($_POST['txtDescripcion']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					
					$intIdCotizacion = intval($_POST['idCotizacion']);
					$intCliente = strClean($_POST['listCliente']);
					$intNCotizacion= intval($_POST['txtCotizacion']);
					$intPrioridad = strClean($_POST['listPrioridad']);
					$intServicio = strClean($_POST['listServicioo']);
					$strTipoPago = strClean($_POST['txtPago']);
					$intStatus = strClean($_POST['listStatus']);
					$strDescripcion = strClean($_POST['txtDescripcion']);
					$request_cotizacion = "";

					if($intIdCotizacion == 0)
					{
						//crear
						if($_SESSION['permisosMod']['w']){
							$request_cotizacion = $this->model->insertCotizacion($intCliente, $intNCotizacion, $intPrioridad, $intServicio, $strTipoPago, $intStatus, $strDescripcion);
							$option = 1;
						}
					}else{
						//Actualizar
						if($_SESSION['permisosMod']['u']){
							$request_cotizacion = $this->model->updateCotizacion($intIdCotizacion, $intCliente, $intNCotizacion, $intPrioridad, $intServicio, $strTipoPago, $intStatus, $strDescripcion);
							$option = 2;
						}
					}
					if($request_cotizacion > 0 )
					{
						if($option == 1)
						{
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						}else{
							$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
						}
					}else if($request_cotizacion == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe una cotizacion con ese numero');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}


		public function getCotizacion($idcotizacion)
		{
			if($_SESSION['permisosMod']['r']){
				$intIdCotizacion = intval($idcotizacion);
				if($intIdCotizacion > 0)
				{
					$arrData = $this->model->selectCotizacion($intIdCotizacion);
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

		public function delCotizacion(){
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdCotizacion = intval($_POST['idCotizacion']);
					$requestDelete = $this->model->deleteCotizacion($intIdCotizacion);
					if($requestDelete == 'ok'){
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la cotizacion');
					}else if($requestDelete == 'exist'){
						$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar la cotizacion con un status activo.');
					}else {
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar la cotizacion');
					} 
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}	
			} 
			die();
		}
	}
 ?>  