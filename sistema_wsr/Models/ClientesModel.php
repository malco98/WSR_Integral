<?php  

	class ClientesModel extends Mysql
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
		private $intCp;
		private $strMunicipio;
		private $strEstado;
		private $strPais;

		public function __construct()
		{
			parent::__construct();
		}

		public function insertCliente(string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid, int $status, string $rfc, string $nomsocial, string $calle, int $nuinterior, int $nuexterior, string $colonia, int $cp, string $municipio, string $estado, string $pais){

			$this->strIdentificador = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intTipousuario = $tipoid;
			$this->intStatus = $status;
			$this->strRfc = $rfc;
			$this->strNomSocial = $nomsocial;
			$this->strCalle = $calle;
			$this->intInterior = $nuinterior;
			$this->intExterior = $nuexterior;
			$this->strColonia = $colonia;
			$this->intCp = $cp;
			$this->strMunicipio = $municipio;
			$this->strEstado = $estado;
			$this->strPais = $pais;
			$return = 0;

			$sql = "SELECT * FROM usuarios WHERE 
					email = '{$this->strEmail}' or identificacion = '{$this->strIdentificador}' ";
			$request = $this->select_all($sql);
		

			if(empty($request))
			{
				$query_insert = "INSERT INTO usuarios(identificacion,nombreusu,apellido,telefono,email,password,rolid,status,rfc,nombresocial,calle,numinterior,numexterior,colonia,cp,municipio,estado,pais)
				VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$arrData = array($this->strIdentificador,
								$this->strNombre,
								$this->strApellido,
								$this->intTelefono,
								$this->strEmail,
								$this->strPassword,
								$this->intTipousuario,
								$this->intStatus,
								$this->strRfc,
								$this->strNomSocial,
								$this->strCalle,
								$this->intInterior,
								$this->intExterior,
								$this->strColonia,
								$this->intCp,
								$this->strMunicipio,
								$this->strEstado,
								$this->strPais);
				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}

		public function selectClientes(){
			$sql = "SELECT idusuario,identificacion,nombreusu,apellido,telefono,email,rfc,nombresocial,calle,status,numinterior,numexterior,colonia,cp,municipio,estado,pais
				FROM usuarios
				WHERE rolid = 4 and status != 0 ";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectCliente(int $idusuario){
			$this->intIdUsuario = $idusuario;
			$sql = "SELECT idusuario,identificacion,nombreusu,apellido,telefono,email,rfc,nombresocial,calle,status,numinterior,numexterior,colonia,cp,municipio,estado,pais, DATE_FORMAT(datecreated, '%d-%m-%Y') as fechaRegistro
				FROM usuarios
				WHERE idusuario = $this->intIdUsuario and rolid = 4";
			$request = $this->select($sql);
			return $request;
		}

		public function updateCliente(int $idusuario, string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, string $rfc, string $nomsocial, string $calle, int $nuinterior, int $nuexterior, string $colonia, int $cp, string $municipio, string $estado, string $pais){

			$this->intIdUsuario = $idusuario;
			$this->strIdentificador = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->strRfc = $rfc;
			$this->strNomSocial = $nomsocial;
			$this->strCalle = $calle;
			$this->intInterior = $nuinterior;
			$this->intExterior = $nuexterior;
			$this->strColonia = $colonia;
			$this->intCp = $cp;
			$this->strMunicipio = $municipio;
			$this->strEstado = $estado;
			$this->strPais = $pais;

			$sql = "SELECT * FROM usuarios WHERE (email = '{$this->strEmail}' AND idusuario != $this->intIdUsuario) OR (identificacion = '{$this->strIdentificador}' AND idusuario != $this->intIdUsuario) ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				if($this->strPassword != "")
				{
					$sql = "UPDATE usuarios SET identificacion=?, nombreusu=?, apellido=?, telefono=?, email=?, password=?, rfc=?, nombresocial=?, calle=?, numinterior=?, numexterior=?, colonia=?, cp=?, municipio=?, estado=?, pais=? WHERE idusuario = $this->intIdUsuario ";
					$arrData = array($this->strIdentificador,
									$this->strNombre,
									$this->strApellido,
									$this->intTelefono,
									$this->strEmail,
									$this->strPassword,
									$this->strRfc,
									$this->strNomSocial,
									$this->strCalle,
									$this->intInterior,
									$this->intExterior,
									$this->strColonia,
									$this->intCp,
									$this->strMunicipio,
									$this->strEstado,
									$this->strPais);
				}else{
					$sql = "UPDATE usuarios SET identificacion=?, nombreusu=?, apellido=?, telefono=?, email=?, rfc=?, nombresocial=?, calle=?, numinterior=?, numexterior=?, colonia=?, cp=?, municipio=?, estado=?, pais=? WHERE idusuario = $this->intIdUsuario ";
					$arrData = array($this->strIdentificador,
									$this->strNombre,
									$this->strApellido,
									$this->intTelefono,
									$this->strEmail,
									$this->strRfc,
									$this->strNomSocial,
									$this->strCalle,
									$this->intInterior,
									$this->intExterior,
									$this->strColonia,
									$this->intCp,
									$this->strMunicipio,
									$this->strEstado,
									$this->strPais);
				}
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		}

		public function deleteCliente(int $intIdusuario){
			$this->intIdUsuario = $intIdusuario;
			$sql = "UPDATE usuarios SET status = ? WHERE idusuario = $this->intIdUsuario ";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
		}
	}
?> 