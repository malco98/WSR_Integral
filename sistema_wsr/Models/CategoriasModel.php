<?php  

	class CategoriasModel extends Mysql
	{
		public $intIdCategoria;
		public $strNombre;
		public $strDescripcion;
		public $intStatus;
		public $strPortada;
		public $strRuta;

		public function __construct()
		{
			parent::__construct();
		}

		public function insertCategoria(string $nombre, string $descripcion, string $portada, int $status, string $ruta)
		{
			$return = 0;
			$this->strNombre = $nombre;
			$this->strDescripcion = $descripcion;
			$this->strPortada = $portada;
			$this->intStatus = $status;
			$this->strRuta = $ruta;

			$sql = "SELECT * FROM categoria WHERE nombrecate = '{$this->strNombre}' ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert = "INSERT INTO categoria(nombrecate,descripcion,portada,status,ruta) VALUES(?,?,?,?,?)";
				$arrData = array($this->strNombre, $this->strDescripcion, $this->strPortada ,$this->intStatus, $this->strRuta);
				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}

		public function selectCategorias(){
			$sql = "SELECT * FROM categoria
				WHERE status != 0 ";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectCategoria(int $idcategoria)
		{
			//BUSCAR ROLE
			$this->intIdCategoria = $idcategoria;
			$sql = "SELECT * FROM categoria WHERE idcategoria = $this->intIdCategoria";
			$request = $this->select($sql);
			return $request;
		}

		public function updateCategoria(int $idcategoria, string $nombre, string $descripcion, string $portada, int $status, string $ruta){
			$this->intIdCategoria = $idcategoria;
			$this->strNombre = $nombre;
			$this->strDescripcion = $descripcion;
			$this->strPortada = $portada;
			$this->intStatus = $status;
			$this->strRuta = $ruta;

			$sql = "SELECT * FROM categoria WHERE nombrecate = '{$this->strNombre}' AND idcategoria != $this->intIdCategoria";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE categoria SET nombrecate = ?, descripcion = ?, portada = ?, status = ?, ruta = ? WHERE idcategoria = $this->intIdCategoria ";
				$arrData = array($this->strNombre, 
								 $this->strDescripcion, 
								 $this->strPortada, 
								 $this->intStatus,
								 $this->strRuta);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
		    return $request;			
		}
	
		public function deleteCategoria(int $idcategoria){
			$this->intIdCategoria = $idcategoria;
			$sql = "SELECT * FROM servicios WHERE categoriaid = $this->intIdCategoria";
			$request = $this->select_all($sql);
			if(empty($request)){
				$sql = "UPDATE categoria SET status = ? WHERE idcategoria = $this->intIdCategoria";
				$arrData = array(0);
				$request = $this->update($sql,$arrData);
				if($request){
					$request = 'ok';
				} else{
					$request = 'error';
				} 
			} else {
				$request = 'exist';
			}
			return $request;
		}		
	}
?>