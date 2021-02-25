<!-- Modal -->
<div class="modal fade" id="modalFormCliente" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCliente" name="formCliente" class="form-horizontal">
          <input type="hidden" id="idUsuario" name="idUsuario" value="">
          <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
          <div class="form-row">
              <div class="form-group col-md-4">
                <label for="txtIdentificacion">Identificacion<span class="required">*</span></label>
                <input class="form-control" id="txtIdentificacion" name="txtIdentificacion" type="text" required="">
              </div>
              <div class="form-group col-md-4">
                <label for="txtNombre">Nombre<span class="required">*</span></label>
                <input class="form-control valid validText" id="txtNombre" name="txtNombre" type="text" required="">
              </div>
              <div class="form-group col-md-4">
                <label for="txtApellido">Apellido<span class="required">*</span></label>
                <input class="form-control valid validText" id="txtApellido" name="txtApellido" type="text" required="">
              </div>
          </div>
          <div class="form-row">
              <div class="form-group col-md-4">
                <label for="txtCorreo">Correo<span class="required">*</span></label>
                <input class="form-control valid validEmail" id="txtCorreo" name="txtCorreo" type="text" required="">
              </div>
              <div class="form-group col-md-4">
                <label for="txtTelefono">Telefono<span class="required">*</span></label>
                <input class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" type="text" required="" onkeypress="return controlTag(event);">
              </div>
              <div class="form-group col-md-4">
                <label for="txtPassword">Contraseña</label>
                <input class="form-control" id="txtPassword" name="txtPassword" type="password">
              </div>
          </div>
          <hr>
          <p class="text-primary">Datos Adicionales.</p>
          <div class="form-row">
                <div class="form-group col-md-4">
                  <label>RFC<span class="required">*</span></label>
                  <input class="form-control" type="text" id="txtRfc" name="txtRfc" required="">
                </div>
                <div class="form-group col-md-4">
                  <label>Nombre Social <span class="required">*</span></label>
                  <input class="form-control valid validText" type="text" id="txtNombreSocial" name="txtNombreSocial" required="" >
                </div>
                <div class="form-group col-md-4">
                  <label>Calle <span class="required">*</span></label>
                  <input class="form-control valid validText" type="text" id="txtCalle" name="txtCalle" required="" >
                </div>
          </div>
          <div class="form-row">
                <div class="form-group col-md-2">
                  <label>Num. Exterior <span class="required">*</span></label>
                  <input class="form-control valid validNumber" type="text" id="txtExterior" name="txtExterior" required="" onkeypress="return controlTag(event);">
                </div>
                <div class="form-group col-md-2">
                  <label>Num. Interior<span class="required">*</span></label>
                  <input class="form-control valid validNumber" type="text" id="txtInterior" name="txtInterior" required="" onkeypress="return controlTag(event);">
                </div>
                <div class="form-group col-md-4">
                  <label>Colonia <span class="required">*</span></label>
                  <input class="form-control valid validText" type="text" id="txtColonia" name="txtColonia" required="" >
                </div>
                <div class="form-group col-md-4">
                  <label>C.P. <span class="required">*</span></label>
                  <input class="form-control valid validNumber" type="text" id="txtCp" name="txtCp" required="" onkeypress="return controlTag(event);" >
                </div>
          </div>
          <div class="form-row">
                <div class="form-group col-md-4">
                  <label>Municipio<span class="required">*</span></label>
                  <input class="form-control valid validText" type="text" id="txtMunicipio" name="txtMunicipio" required="">
                </div>
                <div class="form-group col-md-4">
                  <label>Estado<span class="required">*</span></label>
                  <input class="form-control valid validText" type="text" id="txtEstado" name="txtEstado" required="" >
                </div>
                <div class="form-group col-md-4">
                  <label>Pais<span class="required">*</span></label>
                  <input class="form-control valid validText" type="text" id="txtPais" name="txtPais" required="" >
                </div>
          </div>
          <div class="tile-footer">
            <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
            <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewCliente" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Identificación:</td>
              <td id="celIdentificacion">6453456566</td>
            </tr>
            <tr>
              <td>Nombre:</td>
              <td id="celNombre">Jacob</td>
            </tr>
            <tr>
              <td>Apellidos:</td>
              <td id="celApellido">Tapia</td>
            </tr>
            <tr>
              <td>Telefono:</td>
              <td id="celTelefono">Larry</td>
            </tr>
            <tr>
              <td>Email:</td>
              <td id="celEmail">Larry</td>
            </tr>
            <tr>
              <td>RFC:</td>
              <td id="celRfc">Larry</td>
            </tr>
            <tr>
              <td>NomSocial:</td>
              <td id="celNomSocial">Larry</td>
            </tr>
            <tr>
              <td>Calle:</td>
              <td id="celCalle">Larry</td>
            </tr>
            <tr>
              <td>Fecha registro:</td>
              <td id="celFechaRegistro">Larry</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>