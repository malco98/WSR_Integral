<?php  

	class RolesModel extends Mysql
	{
		public $intIdrol;
		public $strNombre;
		public $strDescripcion;
		public $intStatus;

		public function __construct()
		{
			parent::__construct();
		}

		public function selectRoles()
		{
			$whereAdmin = "";
			if($_SESSION['idUser'] != 1 ){
				$whereAdmin = " and idrol != 1 ";
			}
			$sql = "SELECT * FROM rol WHERE status != 0".$whereAdmin;
			$request =  $this->select_all($sql);
			return $request;
		}

		public function selectRol(int $idrol)
		{
			//BUSCAR ROLE
			$this->intIdrol = $idrol;
			$sql = "SELECT * FROM rol WHERE idrol = $this->intIdrol";
			$request = $this->select($sql);
			return $request;
		}

		public function insertRol(string $nombre, string $descripcion, int $status)
		{
			$return = "";
			$this->strNombre = $nombre;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			$sql = "SELECT * FROM rol WHERE nombre = '{$this->strNombre}' ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert = "INSERT INTO rol(nombre,descripcion,status) VALUES(?,?,?)";
				$arrData = array($this->strNombre, $this->strDescripcion, $this->intStatus);
				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}

		public function updateRol(int $idrol, string $nombre, string $descripcion, int $status){
			$this->intIdrol = $idrol;
			$this->strNombre = $nombre;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			$sql = "SELECT * FROM rol WHERE nombre = '$this->strNombre' AND idrol != $this->intIdrol";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE rol SET nombre = ?, descripcion = ?, status = ? WHERE idrol = $this->intIdrol ";
				$arrData = array($this->strNombre, $this->strDescripcion, $this->intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		}

		public function deleteRol(int $idrol){
			$this->intIdrol = $idrol;
			$sql = "SELECT * FROM usuarios WHERE rolid = $this->intIdrol";
			$request = $this->select_all($sql);
			if(empty($request)){
				$sql = "UPDATE rol SET status = ? WHERE idrol = $this->intIdrol";
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