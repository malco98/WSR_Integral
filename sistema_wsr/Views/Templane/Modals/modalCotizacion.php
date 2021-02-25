<!-- Modal -->
<div class="modal fade" id="modalFormCotizacion" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Solicitud de Cotizacion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span> 
        </button>
      </div>
      <div class="modal-body">
        <form id="formCotizacion" name="formCotizacion" class="form-horizontal">
          <input type="hidden" id="idCotizacion" name="idCotizacion" value="">
          <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                  <label for="listCliente">Nombre del Cliente<span class="required">*</span></label>
                  <select class="form-control" data-live-search="true" id="listCliente" name="listCliente" required=""></select>
                </div>
                <div class="form-group">
                  <label class="control-label">N° Cotizacion<span class="required">*</span></label>
                  <input class="form-control" id="txtCotizacion" name="txtCotizacion" type="text" placeholder="Numero de Cotizacion" required="">
                </div>
                <div class="form-group">
                  <label for="exampleSelect3">Prioridad<span class="required">*</span></label>
                  <select class="form-control" id="listPrioridad" name="listPrioridad" required="">
                    <option value="1">Baja</option>
                    <option value="2">Media</option>
                    <option value="3">Alta</option>
                  </select>
                </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <label for="listServicioo">Servicio<span class="required">*</span></label>
                  <select class="form-control" data-live-search="true" id="listServicioo" name="listServicioo" required=""></select>
                </div>
              <div class="form-group">
                  <label class="control-label">Forma de pago<span class="required">*</span></label>
                  <input class="form-control" id="txtPago" name="txtPago" type="text" placeholder="Forma de pago" required="">
              </div>
              <div class="form-group">
                <label for="exampleSelect2">Estado<span class="required">*</span></label>
                <select class="form-control" id="listStatus" name="listStatus" required="">
                  <option value="1">Activo</option>
                  <option value="2">Inactivo</option>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Descripcion</label>
                <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="2" placeholder="Escribe mas detalles del proyecto" required=""></textarea>
              </div>
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
<div class="modal fade" id="modalViewCotizacion" tabindex="-1" role="dialog" aria-hidden="true">
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
              <td>Numero de Cotizacion:</td>
              <td id="celNCotizacion">6453456566</td>
            </tr>
            <tr>
              <td>Cliente:</td>
              <td id="celCliente">Jacob</td>
            </tr>
            <tr>
              <td>Servicio:</td>
              <td id="celServicio">Tapia</td>
            </tr>
            <tr>
              <td>Prioridad:</td>
              <td id="celPrioridad">Larry</td>
            </tr>
            <tr>
              <td>Tipo de Pago:</td>
              <td id="celTiPago">Larry</td>
            </tr>
            <tr>
              <td>Descripcion:</td>
              <td id="celDescripcion">Larry</td>
            </tr>
            <tr>
              <td>Estado:</td>
              <td id="celEstatus">Larry</td>
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