<?php 
	require_once("Models/SCategoria.php");
	require_once("Models/CServicio.php");
	class Sistema extends Controllers{
		use SCategoria, CServicio;
		public function __construct()
		{
			parent::__construct();
		}

		public function sistema()
		{
			$data['page_tag'] = "WSR Integral";
			$data['page_title'] = "WSR Integral";
			$data['page_name'] = "Sistema WSR";
			$data['servicios'] = $this->getServiciosC();
			$this->views->getView($this,"sistema", $data);
		}

		public function categoria($params){
			if (empty($params)) {
				header("Location:".base_url());
			}else{
				$arrParams = explode(",", $params);
				$idcategoria = intval($arrParams[0]);
				$ruta = strClean($arrParams[1]);
				$infoCategoria = $this->getServiciosCategoriaC($idcategoria,$ruta);
				$categoria = strClean($params);
				$data['page_tag'] = NOMBRE_EMPESA ." - ". $infoCategoria['categoria'];
				$data['page_title'] = $infoCategoria['categoria'];
				$data['page_name'] = "categoria";
				$data['servicios'] = $infoCategoria['servicios'];
				$this->views->getView($this,"categoria", $data);
			}
		}

		public function servicio($params){
			if (empty($params)) {
				header("Location:".base_url());
			}else{
				$arrParams = explode(",", $params);
				$idservicio = intval($arrParams[0]);
				$ruta = strClean($arrParams[1]);
				$infoServicio = $this->getServiciosS($idservicio,$ruta);
				if(empty($infoServicio)){
					header("Location:".base_url());
				}
				$data['page_tag'] = NOMBRE_EMPESA ." - ". $infoServicio['nombreser'];
				$data['page_title'] = $infoServicio['nombreser'];
				$data['page_name'] = "servicio";
				$data['servicio'] = $infoServicio;
				$data['servicios'] = $this->getServiciosRandom($infoServicio['categoriaid'],6,"r");
				$this->views->getView($this,"servicio", $data);
			}
		}
	} 
?>
