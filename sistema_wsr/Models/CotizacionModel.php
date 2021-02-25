<?php  

	class CotizacionModel extends Mysql
	{
		public $intIdCotizacion;
		public $intNumeroCoti;
		public $intClienteId;
		public $intServicioId;
		public $strDescripcion;
		public $intStatus;
		public $intPrioridad;
		public $strTipoPago;


		public function __construct()
		{
			parent::__construct();
		}

		public function selectCotizaciones(){
			$sql = "SELECT c.idcotizacion,
			       c.numcotizacion,
			       c.descripcion,
			       c.usuarioid,
			       u.nombreusu as cliente,
			       c.servicioid,
			       s.nombreser as servicio,
			       c.archivo,
			       c.total,
			       c.formapago,
			       c.status,
			       c.prioridad
			       FROM cotizacion c 
			       INNER JOIN usuarios u
			       ON c.usuarioid = u.idusuario
			       INNER JOIN servicios s
			       ON c.servicioid = s.idservicio
			       WHERE c.status != 0 ";
					$request = $this->select_all($sql);
			return $request;
		}	

		public function insertCotizacion(int $cliente, int $cotizacion, int $prioridad, int $servicio, string $tipopago, int $status, string $descripcion ){

			$return = 0;
			$this->intClienteId = $cliente;
			$this->intNumeroCoti = $cotizacion;
			$this->intPrioridad = $prioridad;
			$this->intServicioId = $servicio;
			$this->strTipoPago = $tipopago;
			$this->intStatus = $status;
			$this->strDescripcion = $descripcion;
			

			$sql = "SELECT * FROM cotizacion WHERE numcotizacion = '{$this->intNumeroCoti}' ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO cotizacion(usuarioid,servicioid,numcotizacion,descripcion,formapago,status,prioridad) VALUES(?,?,?,?,?,?,?)";
	        	$arrData = array($this->intClienteId,
	        					 $this->intServicioId, 
								 $this->intNumeroCoti, 
								 $this->strDescripcion,
								 $this->strTipoPago,
								 $this->intStatus,
								 $this->intPrioridad);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}

		public function selectCotizacion(int $idcotizacion){
			$this->intIdCotizacion = $idcotizacion;
			$sql = "SELECT c.idcotizacion,
			       c.numcotizacion,
			       c.descripcion,
			       c.usuarioid,
			       u.nombreusu as cliente,
			       c.servicioid,
			       s.nombreser as servicio,
			       c.archivo,
			       c.total,
			       c.formapago,
			       c.status,
			       c.prioridad
			       FROM cotizacion c 
			       INNER JOIN usuarios u
			       ON c.usuarioid = u.idusuario
			       INNER JOIN servicios s
			       ON c.servicioid = s.idservicio
			       WHERE idcotizacion =  $this->intIdCotizacion";
			$request = $this->select($sql);
			return $request;
		}

			public function updateCotizacion(int $idcotizacion, int $cliente, int $cotizacion, int $prioridad, int $servicio, string $tipopago, int $status, string $descripcion){
			$this->intIdCotizacion = $idcotizacion;
			$this->intClienteId = $cliente;
			$this->intNumeroCoti = $cotizacion;
			$this->intPrioridad = $prioridad;
			$this->intServicioId = $servicio;
			$this->strTipoPago = $tipopago;
			$this->intStatus = $status;
			$this->strDescripcion = $descripcion;
			$return = 0;
			$sql = "SELECT * FROM cotizacion WHERE numcotizacion = '{$this->intNumeroCoti}'  AND idcotizacion != $this->intIdCotizacion ";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				$sql = "UPDATE cotizacion
						SET usuarioid=?,
							servicioid=?,
							numcotizacion=?,
							descripcion=?,
							formapago=?,
							status=?,
							prioridad=? 
						WHERE idcotizacion = $this->intIdCotizacion ";
				$arrData = array($this->intClienteId,
								$this->intServicioId,
        						$this->intNumeroCoti,
        						$this->strDescripcion,
        						$this->strTipoPago,
        						$this->intStatus,
        						$this->intPrioridad,
        						);
	        	$request = $this->update($sql,$arrData);
	        	$return = $request;
			}else{
				$return = "exist";
			}
	        return $return;
		}

		public function deleteCotizacion(int $idcotizacion){
			$this->intIdCotizacion = $idcotizacion;
			$sql = "UPDATE cotizacion SET status = ? WHERE idcotizacion = $this->intIdCotizacion ";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
		}

	}
?>