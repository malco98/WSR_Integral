<?php 

	class LoginModel extends Mysql
	{
		private $intIdUsuario;
		private $strUsuario;
		private $strPassword;
		private $strToken;

		public function __construct()
		{
			parent::__construct();
		}	

		public function loginUser(string $usuario, string $password)
		{
			$this->strUsuario = $usuario;
			$this->strPassword = $password;
			$sql = "SELECT idusuario,status FROM usuarios WHERE 
					email = '$this->strUsuario' and 
					password = '$this->strPassword' and 
					status != 0 ";
			$request = $this->select($sql);
			return $request;
		}

		public function sessionLogin(int $iduser){
			$this->intIdUsuario = $iduser;
			//BUSCAR ROLE 
			$sql = "SELECT u.idusuario,
							u.identificacion,
							u.nombreusu,
							u.apellido,
							u.email,
							u.telefono,
							u.rfc,
							u.nombresocial,
							u.calle,
							u.numinterior,
							u.numexterior,
							u.colonia,
							u.cp,
							u.municipio,
							u.estado,
							u.pais,
							r.idrol,r.nombre,
							u.status 
					FROM usuarios u
					INNER JOIN rol r
					ON u.rolid = r.idrol
					WHERE u.idusuario = $this->intIdUsuario";
			$request = $this->select($sql);
			$_SESSION['userData'] = $request;
			return $request;
		}

		public function getUserEmail(string $strEmail){
			$this->strUsuario = $strEmail;
			$sql = "SELECT idusuario,nombreusu,apellido,status FROM usuarios WHERE
					email = '$this->strUsuario' and
					status = 1 ";
			$request = $this->select($sql);
			return $request;
		}

		public function setTokenUser(int $idusuario, string $token){
			$this->intIdUsuario = $idusuario;
			$this->strToken = $token;
			$sql = "UPDATE usuarios SET token = ? WHERE idusuario = $this->intIdUsuario";
			$arrData = array($this->strToken);
			$request = $this->update($sql,$arrData);
			return $request;
		}

		public function getUsuario(string $email, string $token){
			$this->strUsuario = $email;
			$this->strToken = $token;
			$sql = "SELECT idusuario FROM usuarios WHERE 
					email = '$this->strUsuario' and 
					token = '$this->strToken' and 
					status = 1 ";
			$request = $this->select($sql);
			return $request;
		}

		public function insertPassword(int $idusuario, string $password){
			$this->intIdUsuario = $idusuario;
			$this->strPassword = $password;
			$sql = "UPDATE usuarios SET password = ?, token = ? WHERE idusuario = $this->intIdUsuario ";
			$arrData = array($this->strPassword,"");
			$request = $this->update($sql,$arrData);
			return $request;
		}
	}
 ?>