<script src="<?php echo site_url('app/venta_cfae/mvcjs'); ?>"></script>
<div class="page-header">
    <div class="page-title">
        <h3>Control de Ventas</h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="javascript:;">Venta</a></li>
        <li class="active">CFAE</li>
    </ul>
    <div class="visible-xs breadcrumb-toggle">
        <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
    </div>
</div>
<div class="panel panel-info">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-table2"></i> Listado de Ventas</h6>
    </div>
    <ul class="panel-toolbar">        
        <li>
            <a title="" class="action-popup-new" href="javascript:;">
                <i class="icon-plus-circle"></i> Nuevo
            </a>
        </li>
    </ul>
    <div class="panel-body">
        <div class="datatable">
            <table class="table" >
                <thead>
                    <tr>
                        <th style="text-align: center">Documento</th>
                        <th style="text-align: center">Apellidos/Nombres</th>
                        <th style="text-align: center">Sede</th>
                        <th style="text-align: center">Curso</th>
                        <th style="text-align: center">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Form modal -->
<div id="form_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-file6"></i><span></span> Venta</h4>
            </div>
            <form action="javascript:;" role="form">
                <input type="hidden" name="id_venta_cfae" value="0" />
                <div class="modal-body with-padding">
                    <div class="well block">
                        <div class="tabbable">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tabPersonal" data-toggle="tab">Personal</a></li>
                                <li><a href="#tabDireccion" data-toggle="tab">Dirección</a></li>
                                <li><a href="#tabReferencia" data-toggle="tab">Referencias</a></li>
                            </ul>
                            <div class="tab-content with-padding">
                                <div class="tab-pane fade in active" id="tabPersonal">
                                    <!-- Vertical form outside panel -->
                                    <div class="block">
                                        <h6 class="heading-hr"><i class="icon-user"></i> Información Personal</h6>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Tipo de identificación:</label>
                                                    <span class="el-finding el-fin-tipo-documeno text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                                    <select class="select-full select-search" name="tipo_documento"></select>
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Número de Identificación: <span class="el-finding-document" style="color: rgb(253, 123, 18);">Buscando...</span></label>
                                                    <input type="text" class="form-control" name="document">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Nacionalidad:</label>
                                                    <span class="el-finding el-fin-tipo-documeno text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                                    <select class="select-full select-search" name="id_nationality"></select>
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Nombres:</label>
                                                    <input type="text" class="form-control" name="name">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Apellidos:</label>
                                                    <input type="text" class="form-control" name="surname">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Género:</label>
                                                    <span class="el-finding el-fin-genero text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                                    <select class="select-full select-search" name="gender"></select>
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Fecha de Nácimiento:</label>
                                                    <input type="text" data-mask="9999-99-99" placeholder="YYYY-MM-DD" class="form-control pull-right" name="birthday">
                                                    <span class="help-block text-left">YYYY-MM-DD</span>
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Estado Civil:</label>
                                                    <span class="el-finding el-fin-estado-civil text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                                    <select class="select-full select-search" name="estado_civil"></select>
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Tipo de Sangre:</label>
                                                    <span class="el-finding el-fin-tipo-sangre text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                                    <select class="select-full select-search" name="tipo_sangre"></select>
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Discapacidad:</label>
                                                    <span class="el-finding el-fin-discapacidad text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                                    <select class="select-full select-search" name="discapacidad"></select>
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Email:</label>
                                                    <input type="text" class="form-control" name="email">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Nivel Académico:</label>
                                                    <span class="el-finding el-fin-nivel-academico text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                                    <select class="select-full select-search" name="nivel_academico"></select>
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Sede:</label>
                                                    <span class="el-finding el-fin-sede text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                                    <select class="select-full select-search" name="id_sede"></select>
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Curso de Capacitación:</label>
                                                    <span class="el-finding el-fin-curso-capacitacion text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                                    <select class="select-full select-search" name="id_curso_capacitacion"></select>
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /vertical form outside panel -->
                                </div>
                                <div class="tab-pane fade" id="tabDireccion">
                                    <!-- Vertical form outside panel -->
                                    <div class="block">
                                        <h6 class="heading-hr"><i class="icon-location2"></i> Dirección Permanente</h6>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Pais:</label>
                                                    <span class="el-finding el-fin-pais text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                                    <select class="select-full select-search" name="id_pais"></select>
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Provincia:</label>
                                                    <span class="el-finding el-fin-provincia text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                                    <select class="select-full select-search" name="id_provincia"></select>
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Ciudad:</label>
                                                    <span class="el-finding el-fin-ciudad text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                                    <select class="select-full select-search" name="id_ciudad"></select>
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Calle Principal:</label>
                                                    <input type="text" class="form-control" name="calle_principal">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Calle Secundaria:</label>
                                                    <input type="text" class="form-control" name="calle_secundaria">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Referencia:</label>
                                                    <input type="text" class="form-control" name="referencia_domicilio">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Número de Casa:</label>
                                                    <input type="text" class="form-control" name="num_casa">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Telefono de Casa:</label>
                                                    <input type="text" class="form-control" name="telefono_casa">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Lugar de Trabajo:</label>
                                                    <input type="text" class="form-control" name="lugar_trabajo">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Telefono del Trabajo:</label>
                                                    <input type="text" class="form-control" name="telefono_trabajo">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label><i class=""></i> Correo Electrónico Trabajo:</label>
                                                    <input type="text" class="form-control" name="email_trabajo">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label><i class=""></i> Correo Electrónico Alterno:</label>
                                                    <input type="text" class="form-control" name="email_alterno">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Teléfono Celular  No.1:</label>
                                                    <input type="text" class="form-control" name="telefono_cell_1">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Teléfono Celular  No.2:</label>
                                                    <input type="text" class="form-control" name="telefono_cell_2">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /vertical form outside panel -->
                                </div>
                                <div class="tab-pane fade" id="tabReferencia">
                                    <!-- Vertical form outside panel -->
                                    <div class="block">
                                        <h6 class="heading-hr"><i class="icon-user"></i> Referencia Personal No. 1</h6>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Apellidos y Nombres: <span class="el-finding-document" style="color: rgb(253, 123, 18);">Buscando...</span></label>
                                                    <input type="text" class="form-control" name="ref_1_surname_name">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Dirección de Domicilio:</label>
                                                    <input type="text" class="form-control" name="ref_1_direccion">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Teléfono Fijo o Celular: <span class="el-finding-document" style="color: rgb(253, 123, 18);">Buscando...</span></label>
                                                    <input type="text" class="form-control" name="ref_1_tlfo_fijo_cell">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Parentesco:</label>
                                                    <input type="text" class="form-control" name="ref_1_parentesco">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                        </div>
                                        <h6 class="heading-hr"><i class="icon-user"></i> Referencia Personal No. 2</h6>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Apellidos y Nombres: <span class="el-finding-document" style="color: rgb(253, 123, 18);">Buscando...</span></label>
                                                    <input type="text" class="form-control" name="ref_2_surname_name">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Dirección de Domicilio:</label>
                                                    <input type="text" class="form-control" name="ref_2_direccion">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Teléfono Fijo o Celular: <span class="el-finding-document" style="color: rgb(253, 123, 18);">Buscando...</span></label>
                                                    <input type="text" class="form-control" name="ref_2_tlfo_fijo_cell">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Parentesco:</label>
                                                    <input type="text" class="form-control" name="ref_2_parentesco">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /vertical form outside panel -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-xs-4">
                        <div id="form-loading" class="loading" style="text-align:left;"><img src="resources/img/loading.gif" /> <span>Espere...</span></div>
                    </div>
                    <div class="col-xs-8">
                        <button type="submit" class="btn btn-success action-save"><i class="icon-disk"></i>Guardar</button>
                        <button type="button" class="btn btn-primary action-edit"><i class="icon-pencil3"></i>Editar</button>
                        <button type="button" class="btn btn-danger action-close" data-dismiss="modal"><i class="icon-cancel-circle2"></i>Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>