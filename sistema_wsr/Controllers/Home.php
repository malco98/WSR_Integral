<?php 
	require_once("Models/SCategoria.php");
	require_once("Models/CServicio.php");
	class Home extends Controllers{
		use SCategoria, CServicio;
		public function __construct()
		{
			parent::__construct();
		}

		public function home()
		{
			$data['page_tag'] = "WSR Integral";
			$data['page_title'] = "WSR Integral";
			$data['page_name'] = "Sistema WSR";
			$data['slider'] = $this->getCategoriasS(CAT_SLIDER);
			$data['banner'] = $this->getCategoriasS(CAT_BANNER);
			$data['servicios'] = $this->getServiciosC();
			$this->views->getView($this,"home", $data);
		}
	} 
?>
 