<?php
	require_once("Libraries/Core/Mysql.php");

	trait CServicio{
		private $con;
		private $strCategoria;
		private $intIdCategoria;
		private $intIdServicio;
		private $strServicio;
		private $cant;
		private $strRuta;
		private $option;

		public function getServiciosC(){
			$this->con = new Mysql();
			$sql = "SELECT s.idservicio,
							s.nombreser,
							s.descripcion,
							s.categoriaid,
							c.nombrecate as categoria,
							s.status,
							s.ruta 
					FROM servicios s 
					INNER JOIN categoria c
					ON s.categoriaid = c.idcategoria
					WHERE s.status != 0 ";
					$request = $this->con->select_all($sql);
					if(count($request) > 0 ){
						for ($c=0; $c < count($request) ; $c++) { 
							# code...
							$intIdServicio = $request[$c]['idservicio'];
							$sqlImg = "SELECT img
									FROM imagen
									WHERE servicioid = $intIdServicio";
					 		$arrImagen = $this->con->select_all($sqlImg);
					 		if (count($arrImagen) > 0) {
					 			# code...
					 			for ($i=0; $i < count($arrImagen) ; $i++) { 
					 				# code...
					 				$arrImagen[$i]['url_image']  = media().'/images/uploads/'.$arrImagen[$i]['img'];
					 			}
					 		}
					 		$request[$c]['image'] = $arrImagen;
						}
					}
			return $request;
		}

		public function getServiciosCategoriaC(int $idcategoria, string $ruta){
			$this->intIdCategoria = $idcategoria;
			$this->strRuta = $ruta;
			$this->con = new Mysql();
			$sql_cat = "SELECT idcategoria,nombrecate FROM categoria WHERE idcategoria = '{$this->intIdCategoria}'";
			$request = $this->con->select($sql_cat);

			if (!empty($request)) {
				$this->strCategoria = $request['nombrecate'];
				$sql = "SELECT s.idservicio,
							s.nombreser,
							s.descripcion,
							s.categoriaid,
							c.nombrecate as categoria,
							s.status,
							s.ruta 
					FROM servicios s 
					INNER JOIN categoria c
					ON s.categoriaid = c.idcategoria
					WHERE s.status != 0 AND s.categoriaid = $this->intIdCategoria AND c.ruta = '{$this->strRuta}' ";
					$request = $this->con->select_all($sql);
					if(count($request) > 0 ){
						for ($c=0; $c < count($request) ; $c++) { 
							# code...
							$intIdServicio = $request[$c]['idservicio'];
							$sqlImg = "SELECT img
									FROM imagen
									WHERE servicioid = $intIdServicio";
					 		$arrImagen = $this->con->select_all($sqlImg);
					 		if (count($arrImagen) > 0) {
					 			# code...
					 			for ($i=0; $i < count($arrImagen) ; $i++) { 
					 				# code...
					 				$arrImagen[$i]['url_image']  = media().'/images/uploads/'.$arrImagen[$i]['img'];
					 			}
					 		}
					 		$request[$c]['image'] = $arrImagen;
						}
					}	
					$request = array('idcategoria' => $this->intIdCategoria,
									 'categoria' => $this->strCategoria,
									 'servicios' => $request);
			}			
			return $request;
		}	

		public function getServiciosS(int $idservicio, string $ruta){
			$this->con = new Mysql();
			$this->intIdServicio = $idservicio;
			$this->strRuta = $ruta;
			$sql = "SELECT s.idservicio,
							s.nombreser,
							s.descripcion,
							s.categoriaid,
							c.nombrecate as categoria,
							s.status,
							s.ruta
					FROM servicios s 
					INNER JOIN categoria c
					ON s.categoriaid = c.idcategoria
					WHERE s.status != 0 AND s.idservicio = '{$this->intIdServicio}' AND s.ruta = '{$this->strRuta}' ";
					$request = $this->con->select($sql);
					if(!empty($request)){
						$intIdServicio = $request['idservicio'];
						$sqlImg = "SELECT img
								FROM imagen
								WHERE servicioid = $intIdServicio";
				 		$arrImagen = $this->con->select_all($sqlImg);
				 		if (count($arrImagen) > 0) {
				 			# code...
				 			for ($i=0; $i < count($arrImagen) ; $i++) { 
				 				# code...
				 				$arrImagen[$i]['url_image']  = media().'/images/uploads/'.$arrImagen[$i]['img'];
				 			}
				 		}else{
				 			$arrImagen[0]['url_image']  = media().'/images/uploads/portada_categoria.png';
				 		}
				 		$request['image'] = $arrImagen;
					}
			return $request;
		}

		public function getServiciosRandom(int $idcategoria, int $cant, string $option){
			$this->intIdCategoria = $idcategoria;
			$this->cant = $cant;
			$this->option = $option;

			if($option == "r"){
				$this->option = " RAND() ";
			}else if($option == "a"){
				$this->option = " idservicio ASC ";
			}else{
				$this->option = " idservicio DESC ";
			}

			$this->con = new Mysql();
			$sql = "SELECT s.idservicio,
							s.nombreser,
							s.descripcion,
							s.categoriaid,
							c.nombrecate as categoria,
							s.status, 
							s.ruta
					FROM servicios s 
					INNER JOIN categoria c
					ON s.categoriaid = c.idcategoria
					WHERE s.status != 0 AND s.categoriaid = $this->intIdCategoria
					ORDER BY $this->option LIMIT $this->cant ";
					$request = $this->con->select_all($sql);
					if(count($request) > 0 ){
						for ($c=0; $c < count($request) ; $c++) { 
							# code...
							$intIdServicio = $request[$c]['idservicio'];
							$sqlImg = "SELECT img
									FROM imagen
									WHERE servicioid = $intIdServicio";
					 		$arrImagen = $this->con->select_all($sqlImg);
					 		if (count($arrImagen) > 0) {
					 			# code...
					 			for ($i=0; $i < count($arrImagen) ; $i++) { 
					 				# code...
					 				$arrImagen[$i]['url_image']  = media().'/images/uploads/'.$arrImagen[$i]['img'];
					 			}
					 		}
					 		$request[$c]['image'] = $arrImagen;
						}
					}
			return $request;

		}
	}
?>

<!--ORDER BY s.idservicio DESC -->