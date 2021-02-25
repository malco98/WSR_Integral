<?php  
    headerAdmin($data); 
    getModal('modalPerfil', $data);
?>
<main class="app-content">
    <div class="row user">
    <div class="col-md-12">
        <div class="profile">
        <div class="info"><img class="user-img" src="<?= media();?>/images/avatar.png">
            <h4><?= $_SESSION['userData']['nombreusu'].' '.$_SESSION['userData']['apellido']; ?></h4>
            <p><?= $_SESSION['userData']['nombre']; ?></p>
        </div>
        <div class="cover-image"></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="tile p-0">
        <ul class="nav flex-column nav-tabs user-tabs">
            <li class="nav-item"><a class="nav-link active" href="#user-timeline" data-toggle="tab">Datos Personales</a></li>
            <li class="nav-item"><a class="nav-link" href="#user-settings" data-toggle="tab">Datos Fiscales</a></li>
        </ul>
        </div>
    </div>
    <div class="col-md-9">
        <div class="tab-content">
        <div class="tab-pane active" id="user-timeline">
            <div class="timeline-post">
                <div class="post-media">
                    <div class="content">
                        <h5>DATOS PERSONALES <button class="btn btn-sm btn-info" type="button" onclick="openModalPerfil();"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button></h5>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                        <td style="width:150px;">Identificación:</td>
                        <td><?= $_SESSION['userData']['identificacion']; ?></td>
                        </tr>
                        <tr>
                        <td>Nombres:</td>
                        <td><?= $_SESSION['userData']['nombreusu']; ?></td>
                        </tr>
                        <tr>
                        <td>Apellidos:</td>
                        <td><?= $_SESSION['userData']['apellido']; ?></td>
                        </tr>
                        <tr>
                        <td>Teléfono:</td>
                        <td><?= $_SESSION['userData']['telefono']; ?></td>
                        </tr>
                        <tr>
                        <td>Email (Usuario):</td>
                        <td><?= $_SESSION['userData']['email']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="user-settings">
            <div class="tile user-settings">
            <h4 class="line-head">Datos fiscales</h4>
            <form id="formDataFiscal" name="formDataFiscal">
            <div class="row mb-4">
                <div class="col-md-4">
                  <label>RFC</label>
                  <input class="form-control" type="text" id="txtRfc" name="txtRfc" value="<?= $_SESSION['userData']['rfc']; ?>">
                </div>
                <div class="col-md-4">
                  <label>Nombre Social</label>
                  <input class="form-control" type="text" id="txtNombreSocial" name="txtNombreSocial" value="<?= $_SESSION['userData']['nombresocial']; ?>" >
                </div>
                <div class="col-md-4">
                  <label>Calle</label>
                  <input class="form-control" type="text" id="txtCalle" name="txtCalle" value="<?= $_SESSION['userData']['calle']; ?>">
                </div>
              </div>
              <div class="row  mb-4">
               <div class="col-md-2">
                  <label>NumExterno</label>
                  <input class="form-control" type="text" id="txtNExterno" name="txtNExterno" value="<?= $_SESSION['userData']['numexterior']; ?>">
                </div>
                <div class="col-md-2">
                  <label>NumInterior</label>
                  <input class="form-control" type="text" id="txtNInterior" name="txtNInterior" value="<?= $_SESSION['userData']['numinterior']; ?>" >
                </div>
                <div class="col-md-4">
                  <label>Colonia</label>
                  <input class="form-control" type="text" id="txtColonia" name="txtColonia" value="<?= $_SESSION['userData']['colonia']; ?>">
                </div>
                <div class="col-md-4">
                  <label>CP</label>
                  <input class="form-control" type="text" id="txtCP" name="txtCP" value="<?= $_SESSION['userData']['cp']; ?>">
                </div>
              </div>
              <div class="row  mb-4">
               <div class="col-md-4">
                  <label>Municipio</label>
                  <input class="form-control" type="text" id="txtMunicipio" name="txtMunicipio" value="<?= $_SESSION['userData']['municipio']; ?>">
                </div>
                <div class="col-md-4">
                  <label>Estado</label>
                  <input class="form-control" type="text" id="txtEstado" name="txtEstado" value="<?= $_SESSION['userData']['estado']; ?>" >
                </div>
                <div class="col-md-4">
                  <label>Pais</label>
                  <input class="form-control" type="text" id="txtPais" name="txtPais" value="<?= $_SESSION['userData']['pais']; ?>">
                </div>
              </div>
              <div class="row mb-10">
                <div class="col-md-12">
                  <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i> Guardar</button>
                </div>
              </div>
            </form>
            </div>
        </div>
        </div>
    </div>
    </div>
</main>
<?php footerAdmin($data); ?>  