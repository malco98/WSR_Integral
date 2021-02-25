<!-- Modal -->
<div class="modal fade" id="modalFormDocumento" tabindex="-1" role="dialog" aria-hidden="true">
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