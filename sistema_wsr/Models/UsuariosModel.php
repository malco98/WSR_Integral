<?php  

	class UsuariosModel extends Mysql
	{
		private $intIdUsuario;
		private $strIdentificador;
		private $strNombre;
		private $strApellido;
		private $intTelefono;
		private $strEmail;
		private $strPassword;
		private $strToken;
		private $intTipousuario;
		private $intStatus;
		private $strRfc;
		private $strNomSocial;
		private $strCalle;
		private $intInterior;
		private $intExterior;
		private $strColonia;
		private $intCP;
		private $strMunicipio;
		private $strEstado;
		private $strPais;

		public function __construct()
		{
			parent::__construct();
		}

		public function insertUsuario(string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid, int $status){

			$this->strIdentificador = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intTipousuario = $tipoid;
			$this->intStatus = $status;
			$return = 0;

			$sql = "SELECT * FROM usuarios WHERE 
					email = '{$this->strEmail}' or identificacion = '{$this->strIdentificador}' ";
			$request = $this->select_all($sql);
		

			if(empty($request))
			{
				$query_insert = "INSERT INTO usuarios(identificacion,nombreusu,apellido,telefono,email,password,rolid,status)VALUES(?,?,?,?,?,?,?,?)";
				$arrData = array($this->strIdentificador,
								$this->strNombre,
								$this->strApellido,
								$this->intTelefono,
								$this->strEmail,
								$this->strPassword,
								$this->intTipousuario,
								$this->intStatus);
				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}

		public function selectUsuarios(){
			$whereAdmin = "";
			if($_SESSION['idUser'] != 1 ){
				$whereAdmin = " and u.idusuario != 1 ";
			}
			$sql = "SELECT u.idusuario,u.identificacion,u.nombreusu,u.apellido,u.telefono,u.email,u.status,r.idrol,r.nombre
				FROM usuarios u 
				INNER JOIN rol r
				ON u.rolid = r.idrol
				WHERE u.status != 0".$whereAdmin;
				$request = $this->select_all($sql);
				return $request;
		}

		public function selectUsuario(int $idusuario){
			$this->intIdUsuario = $idusuario;
			$sql = "SELECT u.idusuario,u.identificacion,u.nombreusu,u.apellido,u.telefono,u.email,r.idrol,r.nombre,u.status, DATE_FORMAT(u.datecreated, '%d-%m-%Y') as fechaRegistro
				FROM usuarios u
				INNER JOIN rol r
				ON u.rolid = r.idrol
				WHERE u.idusuario = $this->intIdUsuario";
			$request = $this->select($sql);
			return $request;
		}

		public function updateUsuario(int $idusuario, string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid, int $status){

			$this->intIdUsuario = $idusuario;
			$this->strIdentificador = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intTipousuario = $tipoid;
			$this->intStatus = $status;

			$sql = "SELECT * FROM usuarios WHERE (email = '{$this->strEmail}' AND idusuario != $this->intIdUsuario) OR (identificacion = '{$this->strIdentificador}' AND idusuario != $this->intIdUsuario) ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				if($this->strPassword != "")
				{
					$sql = "UPDATE usuarios SET identificacion=?, nombreusu=?, apellido=?, telefono=?, email=?, password=?, rolid=?, status=? WHERE idusuario = $this->intIdUsuario ";
					$arrData = array($this->strIdentificador,
									$this->strNombre,
									$this->strApellido,
									$this->intTelefono,
									$this->strEmail,
									$this->strPassword,
									$this->intTipousuario,
									$this->intStatus);
				}else{
					$sql = "UPDATE usuarios SET identificacion=?, nombreusu=?, apellido=?, telefono=?, email=?, rolid=?, status=? WHERE idusuario = $this->intIdUsuario ";
					$arrData = array($this->strIdentificador,
									$this->strNombre,
									$this->strApellido,
									$this->intTelefono,
									$this->strEmail,
									$this->intTipousuario,
									$this->intStatus);
				}
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		}

		public function deleteUsuario(int $intIdusuario){
			$this->intIdUsuario = $intIdusuario;
			$sql = "UPDATE usuarios SET status = ? WHERE idusuario = $this->intIdUsuario ";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
		}
		
		public function updatePerfil(int $idusuario, string $nombre, string $apellido, int $telefono, string $password){
			$this->intIdUsuario = $idusuario;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->intTelefono = $telefono;
			$this->strPassword = $password;

			if($this->strPassword != "")
			{
				$sql = "UPDATE usuarios SET nombreusu=?, apellido=?, telefono=?, password=? WHERE idusuario = $this->intIdUsuario ";
				$arrData = array($this->strNombre,
								$this->strApellido,
								$this->intTelefono,
								$this->strPassword	);
			}else{
				$sql = "UPDATE usuarios SET nombreusu=?, apellido=?, telefono=? WHERE idusuario = $this->intIdUsuario ";
				$arrData = array($this->strNombre,
								$this->strApellido,
								$this->intTelefono);
			}
			$request = $this->update($sql,$arrData);
			return $request;
		}

		public function updateDataFiscal(int $idusuario, string $Rfc, string $NomSocial, string $Calle, int $interior, int $exterior, string $colonia, int $CP, string $municipio, string $estado, string $pais){
			$this->intIdUsuario = $idusuario;
			$this->strRfc = $Rfc;
			$this->strNomSocial = $NomSocial;
			$this->strCalle = $Calle;
			$this->intInterior = $interior;
			$this->intExterior = $exterior;
			$this->strColonia = $colonia;
			$this->intCP = $CP;
			$this->strMunicipio = $municipio;
			$this->strEstado = $estado;
			$this->strPais = $pais;
			$sql = "UPDATE usuarios SET rfc=?, nombresocial=?, calle=?, numinterior=?, numexterior=?, colonia=?, cp=?, municipio=?, estado=?, pais=? WHERE idusuario = $this->intIdUsuario ";
			$arrData = array($this->strRfc,
							$this->strNomSocial,
							$this->strCalle,
							$this->intInterior,
							$this->intExterior,
							$this->strColonia,
							$this->intCP,
							$this->strMunicipio,
							$this->strEstado,
							$this->strPais);
			$request = $this->update($sql,$arrData);
		    return $request;
		}
	}
?> 