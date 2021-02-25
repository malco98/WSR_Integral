 <?php 
    headerAdmin($data); 
    getModal('modalCotizacion', $data);
    getModal('modalDescargaArchivo', $data);
 ?>
    <main class="app-content">
      <?php
        //dep($_SESSION['permisos']);
        //dep($_SESSION['permisosMod']);
      ?>
      <div class="app-title">
        <div>
          <h1><i class="fas fa-box-tissue"></i> <?= $data['page_title'] ?>
          <?php if($_SESSION['permisosMod']['w']){ ?>
            <button class="btn btn-primary" type="button" onclick="openModal();"><i class="fas fa-plus"></i>&nbsp; Nuevo</button>
            <?php } ?>
             <!--<button class="btn btn-primary" type="button" onclick="openModal();"><i class="fas fa-file-word"></i> &nbsp; Descargar Archivo</button>-->
          </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/cotizacion"><?= $data['page_name'] ?></a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tableCotizacion">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nº Cotizacion</th>
                      <th>Descripcion</th>
                      <th>Cliente</th>
                      <th>Servicio</th>
                      <th>Prioridad</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
 <?php footerAdmin($data); ?>    
   