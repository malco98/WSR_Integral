<?php  

	class ServiciosModel extends Mysql
	{
		private $intIdServicio;
		private $strNombreSer;
		private $strDescripcion;
		private $intIdCategoria;
		private $intStatus;
		private $strImagen;
		private $strRuta;


		public function __construct()
		{
			parent::__construct();
		}
 
		public function selectServicios(){
			$sql = "SELECT s.idservicio,
							s.nombreser,
							s.descripcion,
							s.categoriaid,
							c.nombrecate as categoria,
							s.status 
					FROM servicios s 
					INNER JOIN categoria c
					ON s.categoriaid = c.idcategoria
					WHERE s.status != 0 ";
					$request = $this->select_all($sql);
			return $request;
		}	

		public function insertServicio(string $nombre, int $categoria, string $descripcion, int $status, string $ruta){

			$return = 0;
			$this->strNombreSer = $nombre;
			$this->strDescripcion = $descripcion;
			$this->intIdCategoria = $categoria;
			$this->intStatus = $status;
			$this->strRuta = $ruta;
			

			$sql = "SELECT * FROM servicios WHERE nombreser = '{$this->strNombreSer}' ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO servicios(categoriaid,nombreser,descripcion,status,ruta) VALUES(?,?,?,?,?)";
	        	$arrData = array($this->intIdCategoria,
	        					 $this->strNombreSer, 
								 $this->strDescripcion, 
								 $this->intStatus,
								 $this->strRuta);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}

		public function selectServicio(int $idservicio){
			$this->intIdServicio = $idservicio;
			$sql = "SELECT p.idservicio,
							p.nombreser,
							p.descripcion,
							p.categoriaid,
							c.nombrecate as categoria,
							p.status,
							p.datecreated
					FROM servicios p
					INNER JOIN categoria c
					ON p.categoriaid = c.idcategoria
					WHERE idservicio = $this->intIdServicio";
			$request = $this->select($sql);
			return $request;

		}

		public function selectImages(int $idservicio){
			$this->intIdServicio = $idservicio;
			$sql = "SELECT servicioid,img
					FROM imagen
					WHERE servicioid = $this->intIdServicio";
			$request = $this->select_all($sql);
			return $request;
		}


		public function updateServicio(int $idservicio, string $nombre, int $categoria, string $descripcion, int $status, string $ruta){
			$this->intIdServicio = $idservicio;
			$this->strNombreSer = $nombre;
			$this->intIdCategoria = $categoria;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;
			$this->strRuta = $ruta;
			$return = 0;
			$sql = "SELECT * FROM servicios WHERE nombreser = '{$this->strNombreSer}'  AND idservicio != $this->intIdServicio ";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				$sql = "UPDATE servicios
						SET categoriaid=?,
							nombreser=?,
							descripcion=?,
							status=?,
							ruta=? 
						WHERE idservicio = $this->intIdServicio ";
				$arrData = array($this->intIdCategoria,
								$this->strNombreSer,
        						$this->strDescripcion,
        						$this->intStatus,
        						$this->strRuta);

	        	$request = $this->update($sql,$arrData);
	        	$return = $request;
			}else{
				$return = "exist";
			}
	        return $return;
		}

		public function deleteServicio(int $idservicio){
			$this->intIdServicio = $idservicio;
			$sql = "UPDATE servicios SET status = ? WHERE idservicio = $this->intIdServicio ";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
		}

		public function insertImage(int $idservicio, string $imagen){
			$this->intIdServicio = $idservicio;
			$this->strImagen = $imagen;
			$query_insert  = "INSERT INTO imagen(servicioid,img) VALUES(?,?)";
	        $arrData = array($this->intIdServicio,
        					$this->strImagen);
	        $request_insert = $this->insert($query_insert,$arrData);
	        return $request_insert;
		}

		public function deleteImage(int $idservicio, string $imagen){
			$this->intIdServicio = $idservicio;
			$this->strImagen = $imagen;
			$query  = "DELETE FROM imagen 
						WHERE servicioid = $this->intIdServicio 
						AND img = '{$this->strImagen}'";
	        $request_delete = $this->delete($query);
	        return $request_delete;
		}

		
	}


?>