$.fn.modal.Constructor.prototype.enforceFocus = function () {
};

var ControlVentaCFAE_Controller = {
    init: function ()
    {
        var self = this;
        self.$table = $('.datatable table');

        if (!ControlVentaCFAE_Base.permissions.create) {
            $('.panel-toolbar').hide();
        }

        self.$table.dataTable({
            bJQueryUI: false,
            bAutoWidth: false,
            bProcessing: false,
            bServerSide: true,
            bSort: false,
            sPaginationType: "full_numbers",
            sDom: '<"datatable-header"Tfl><"datatable-scroll"tr><"datatable-footer"ip>',
            sAjaxSource: Core.site_url(ControlVentaCFAE_Base.linkx + "/process/list-venta-cfae"),
            fnServerParams: function (aoData)
            {
                Core.Loading.wait(true, $('tbody', $(this)));
            },
            aoColumnDefs: [
                {sClass: "center", "aTargets": [0]},
                {sClass: "center", "aTargets": [1]},
                {sClass: "center", "aTargets": [2]},
                {sClass: "center", "aTargets": [3]},
                {sClass: "center", "aTargets": [4]},
                {
                    aTargets: [4], mRender: function (data, type, row)
                    {
                        return '<input type="hidden" class="dt-col-option" value="' + (data) + '"/>';
                    }
                }
            ],
            fnDrawCallback: function ()
            {
                Core.Loading.wait(false, $('tbody', $(this)));
                // aTargets: [4]
                $('.dt-col-option').each(function () {
                    var data = $(this).val();

                    var html = ControlVentaCFAE_View.dtOptionsTable();
                    var $html = $(html);

                    $('.dt-action-view', $html).click(function () {
                        Modal_VentaCFAE.open(data, true);
                    });

                    $('.dt-action-edit', $html).click(function () {
                        Modal_VentaCFAE.open(data);
                    });

                    $(this).after($html);
                });
                $('.tip').tooltip();
            }
        });

        if (ControlVentaCFAE_Base.permissions.create) {
            $('.action-popup-new').click(function () {
                Modal_VentaCFAE.open();
            });
        }

        Modal_VentaCFAE.init();
    },
    refresDataTable: function (isDraw /*=true*/)
    {
        var self = this;

        setInterval(self.$table.dataTable().fnDraw(isDraw), 3000);
    }

};

var Modal_VentaCFAE = {
    init: function ()
    {
        var self = this;

        self.$modal = $('#form_modal');

        $('.el-finding-document', self.$modal).hide(); /*ocultar el buscando*/

        if (ControlVentaCFAE_Base.permissions.update)
        {
            $('button.action-save', self.$modal).click(function () {
                self.actionSave();
            });

            $('button.action-edit', self.$modal).click(function () {
                self.formReadOnly(false);
                self.formType('edit');
            });
        }

        $('select[name="id_pais"]', self.$modal).on('change', function () {
            self.loadProvincia();
        });

        $('select[name="id_provincia"]', self.$modal).on('change', function () {
            self.loadCiudad();
        });

        self.$modal.on("show.bs.modal", function () {
            //alert('show form');
        });

        self.$modal.on("hidden.bs.modal", function () {
            self.formReset();
        });

        $('input[name="document"]', self.$modal).focusout(function ()
        {

            if (!$(this).prop('readonly'))
            {
                var document = $(this).val();
                /*alert(document);*/
                if (document != '' || document != null)
                {
                    self.loadByDocument(document);
                }
            }
        });

    },
    loadByDocument: function (document)
    {
        var self = this;

        $('.el-finding-document', self.$modal).show();

        self.formReadOnly(true);
        self.formLoading('load');
        self.errorClear();
        ControlVentaCFAE_Model.loadPersonByDocument(document, function (oRes)
        {
            $('.el-finding-document', self.$modal).hide();

            if (!oRes.isSuccess)
            {
                Core.Notification.error(oRes.message);
                return;
            }
            self.data(oRes.forms.person, true);

            var fLoad = function ()
            {
                self.formReadOnly(false);
                self.formLoading('none');
            };

            self.loadProvincia(function () {
                fLoad();
            });
        });



    },
    close: function ()
    {
        var self = this;

        self.formReset();
        self.$modal.modal('hide');
    },
    // =======================================================================
    formReset: function ()
    {
        var self = this;
        self.dataDefault();
        self.errorClear();
        self.formReadOnly(false);
        self.formLoading('none');

    },
    dataDefault: function ()
    {
        this.data(ControlVentaCFAE_Base.cfae_form_default);
    },
    errorClear: function ()
    {
        this.formError(ControlVentaCFAE_Base.cfae_form_default);
    },
    formType: function (type /* new, edit, view */)
    {
        var self = this;


        if (type == 'new')
        {
            $('.modal-title span', self.$modal).html('Nuevo');

            $('.action-save', self.$modal).show();
            $('.action-edit', self.$modal).hide();

            self.formReadOnly(false);
        }
        else if (type == 'edit')
        {
            $('.modal-title span', self.$modal).html('Editar');

            $('.action-save', self.$modal).show();
            $('.action-edit', self.$modal).hide();

            self.formReadOnly(false);
        }
        else if (type == 'view')
        {
            $('.modal-title span', self.$modal).html('Ver');

            $('.action-save', self.$modal).hide();

            if (ControlVentaCFAE_Base.permissions.update)
            {
                $('.action-edit', self.$modal).show();
            }
            else
            {
                $('.action-edit', self.$modal).hide();
            }

            self.formReadOnly(true);
        }
    },
    formReadOnly: function (isFormReadOnly)
    {
        var self = this;

        var self = this;
        
        $('[name="tipo_documento"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="document"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="id_nationality"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="name"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="surname"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="gender"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="birthday"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="estado_civil"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="tipo_sangre"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="discapacidad"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="email"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="nivel_academico"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="id_sede"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="id_curso_capacitacion"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="id_pais"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="id_provincia"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="id_ciudad"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="calle_principal"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="calle_secundaria"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="referencia_domicilio"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="num_casa"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="telefono_casa"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="lugar_trabajo"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="telefono_trabajo"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="email_trabajo"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="email_alterno"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="telefono_cell_1"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="telefono_cell_2"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="ref_1_surname_name"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="ref_1_direccion"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="ref_1_tlfo_fijo_cell"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="ref_1_parentesco"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="ref_2_surname_name"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="ref_2_direccion"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="ref_2_tlfo_fijo_cell"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="ref_2_parentesco"]', self.$modal).prop('readonly', isFormReadOnly);

        $.uniform.update();
    },
    formLoading: function (key)
    {
        var self = this;

        switch (key)
        {
            case 'save':
                $('.loading span', self.$modal).html('Guardando...');
                $('.loading', self.$modal).show();

                $('.action-save, .action-edit, .action-close', self.$modal).addClass('disabled');
                break;
            case 'load':
                $('.loading span', self.$modal).html('Cargando...');
                $('.loading', self.$modal).show();
                $('.action-save, .action-edit, .action-close', self.$modal).addClass('disabled');
                break;
            case 'none':
                $('.loading span', self.$modal).html('');
                $('.loading', self.$modal).hide();
                $('.action-save, .action-edit, .action-close', self.$modal).removeClass('disabled');
                break;
        }
    },
    formError: function (data)
    {
        var self = this;

        var $form_group = $('.form-group', self.$modal);

        $form_group.removeClass('has-error');
        $('.label-danger', $form_group).html('').hide();

        for (var field_name in data)
        {
            var $form_group = $('[name="' + (field_name) + '"]', self.$modal).closest('.form-group');
            if (!$.isEmptyObject(data[field_name].error))
            {
                $form_group.addClass('has-error');
                $('.label-danger', $form_group).html(data[field_name].error).show();
            }
        }
    },
    open: function (id_user/*=0*/, isView/*=false*/)
    {
        var self = this;

        id_user = typeof id_user == 'undefined' ? 0 : id_user;
        isView = typeof isView == 'boolean' ? isView : false;

        self.formReset();
        //self.$modal.modal('show');
        self.formLoading('load');
        self.formReadOnly(true);

        if (id_user == 0)
        {
            self.formType('new');
            self.formReadOnly(true);
            var fLoad = function ()
            {
                self.formLoading('none');
                self.formReadOnly(false);
            };
        }
        else
        {
            self.dataLoad(id_user);
            if (isView)
            {
                self.formType('view');
            }
            else
            {
                self.formType('edit');
            }
            self.formReadOnly(true);
            var fLoad = function ()
            {
                self.formLoading('none');
                if (!isView)
                {
                    self.formReadOnly(false);
                }
            };
        }

        self.$modal
                .off('shown.bs.modal')
                .on('shown.bs.modal', function () {
                    self.initLoadComponents(function () {
                        fLoad();
                    });
                })
                .modal('show');

    },
    dataLoad: function (id_user)
    {
        var self = this;
        ControlVentaCFAE_Model.loadAcount(id_user, function (res) {
            if (!res.isSuccess)
            {
                Core.Notification.error(res.message);
                self.close();
                return;
            }
            self.data(res.forms.acount);
        }, function () {
            self.close();
        });
    },
    data: function (data/*=UNDEFINED*/, Tdocument/*=false*/)
    {
        var self = this;

        if (data)
        {
            var id_person = data.id_person.value;
            var tipo_documento = data.tipo_documento.value;
            var document = data.document.value;
            var id_nationality = data.id_nationality.value;
            var name = data.name.value;
            var surname = data.surname.value;
            var gender = data.gender.value;
            var birthday = data.birthday.value;
            var estado_civil = data.estado_civil.value;
            var tipo_sangre = data.tipo_sangre.value;
            var discapacidad = data.discapacidad.value;
            var email = data.email.value;
            var nivel_academico = data.nivel_academico.value;
            var id_sede = data.id_sede.value;
            var id_curso_capacitacion = data.id_curso_capacitacion.value;
            var id_pais = data.id_pais.value;
            var id_provincia = data.id_provincia.value;
            var id_ciudad = data.id_ciudad.value;
            var calle_principal = data.calle_principal.value;
            var calle_secundaria = data.calle_secundaria.value;
            var referencia_domicilio = data.referencia_domicilio.value;
            var num_casa = data.num_casa.value;
            var telefono_casa = data.telefono_casa.value;
            var lugar_trabajo = data.lugar_trabajo.value;
            var telefono_trabajo = data.telefono_trabajo.value;
            var email_trabajo = data.email_trabajo.value;
            var email_alterno = data.email_alterno.value;
            var telefono_cell_1 = data.telefono_cell_1.value;
            var telefono_cell_2 = data.telefono_cell_2.value;
            var ref_1_surname_name = data.telefono_cell_2.value;
            var ref_1_direccion = data.telefono_cell_2.value;
            var ref_1_tlfo_fijo_cell = data.telefono_cell_2.value;
            var ref_1_parentesco = data.telefono_cell_2.value;
            var ref_2_surname_name = data.telefono_cell_2.value;
            var ref_2_direccion = data.telefono_cell_2.value;
            var ref_2_tlfo_fijo_cell = data.telefono_cell_2.value;
            var ref_2_parentesco = data.telefono_cell_2.value;
            
            $('[name="id_person"]', self.$modal).val(id_person);
            $('[name="name"]', self.$modal).val(name);
            $('[name="surname"]', self.$modal).val(surname);
            if (Tdocument)
            {
                $('[name="tipo_documento"]', self.$modal).select2('val', tipo_documento);
                $('[name="gender"]', self.$modal).select2('val', gender);
                $('[name="estado_civil"]', self.$modal).select2('val', estado_civil);
                $('[name="tipo_sangre"]', self.$modal).select2('val', tipo_sangre);
                $('[name="id_pais"]', self.$modal).select2('val', id_pais);
                $('[name="id_nationality"]', self.$modal).select2('val', id_nationality);
                $('[name="discapacidad"]', self.$modal).select2('val', discapacidad);
                $('[name="nivel_academico"]', self.$modal).select2('val', nivel_academico);
            }
            else
            {
                $('[name="document"]', self.$modal).val(document);
                $('[name="tipo_documento"]', self.$modal).attr('_value', tipo_documento);
                $('[name="gender"]', self.$modal).attr('_value', gender);
                $('[name="estado_civil"]', self.$modal).attr('_value', estado_civil);
                $('[name="tipo_sangre"]', self.$modal).attr('_value', tipo_sangre);
                $('[name="id_pais"]', self.$modal).attr('_value', id_pais);
                $('[name="id_nationality"]', self.$modal).attr('_value', id_nationality);
                $('[name="discapacidad"]', self.$modal).attr('_value', discapacidad);
                $('[name="nivel_academico"]', self.$modal).attr('_value', nivel_academico);
            }

            $('[name="birthday"]', self.$modal).val(birthday);
            $('[name="email"]', self.$modal).val(email);
            $('[name="id_provincia"]', self.$modal).attr('_value', id_provincia);
            $('[name="id_ciudad"]', self.$modal).attr('_value', id_ciudad);
            $('[name="id_sede"]', self.$modal).select2('val', id_sede);
            $('[name="id_curso_capacitacion"]', self.$modal).select2('val', id_curso_capacitacion);
            $('[name="calle_principal"]', self.$modal).val(calle_principal);
            $('[name="calle_secundaria"]', self.$modal).val(calle_secundaria);
            $('[name="referencia_domicilio"]', self.$modal).val(referencia_domicilio);
            $('[name="num_casa"]', self.$modal).val(num_casa);
            $('[name="telefono_casa"]', self.$modal).val(telefono_casa);
            $('[name="lugar_trabajo"]', self.$modal).val(lugar_trabajo);
            $('[name="telefono_trabajo"]', self.$modal).val(telefono_trabajo);
            $('[name="email_trabajo"]', self.$modal).val(email_trabajo);
            $('[name="email_alterno"]', self.$modal).val(email_alterno);
            $('[name="telefono_cell_1"]', self.$modal).val(telefono_cell_1);
            $('[name="telefono_cell_2"]', self.$modal).val(telefono_cell_2);
            $('[name="ref_1_surname_name"]', self.$modal).val(ref_1_surname_name);
            $('[name="ref_1_direccion"]', self.$modal).val(ref_1_direccion);
            $('[name="ref_1_tlfo_fijo_cell"]', self.$modal).val(ref_1_tlfo_fijo_cell);
            $('[name="ref_1_parentesco"]', self.$modal).val(ref_1_parentesco);
            $('[name="ref_2_surname_name"]', self.$modal).val(ref_2_surname_name);
            $('[name="ref_2_direccion"]', self.$modal).val(ref_2_direccion);
            $('[name="ref_2_tlfo_fijo_cell"]', self.$modal).val(ref_2_tlfo_fijo_cell);
            $('[name="ref_2_parentesco"]', self.$modal).val(ref_2_parentesco);
            
            
            $.uniform.update();
            return;
        }
        data = {
            /*id_person: $('[name="id_person"]', self.$modal).val(),
            name: $('[name="name"]', self.$modal).val(),
            surname: $('[name="surname"]', self.$modal).val(),
            tipo_documento: $('[name="tipo_documento"]', self.$modal).select2('val'),
            document: $('[name="document"]', self.$modal).val(),
            birthday: $('[name="birthday"]', self.$modal).val(),
            gender: $('[name="gender"]', self.$modal).select2('val'),
            address: $('[name="address"]', self.$modal).val(),
            phone_cell: $('[name="phone_cell"]', self.$modal).val(),
            email: $('[name="email"]', self.$modal).val(),
            estado_civil: $('[name="estado_civil"]', self.$modal).select2('val'),
            tipo_sangre: $('[name="tipo_sangre"]', self.$modal).select2('val'),
            id_ciudad: $('[name="id_ciudad"]', self.$modal).select2('val'),
            id_user: $('[name="id_user"]', self.$modal).val(),
            username: $('[name="username"]', self.$modal).val(),
            password_new: $('[name="password_new"]', self.$modal).val(),
            password_new_repeat: $('[name="password_new_repeat"]', self.$modal).val(),
            id_profile: $('[name="id_profile"]', self.$modal).select2('val'),
            id_company_branchs: $('[name="id_company_branchs"]', self.$modal).select2('val'),
            isActive: $('[name="isActive"]', self.$modal).prop('checked') ? 1 : 0
                    */
        };
        return data;
    },
    initLoadComponents: function (fLoad)
    {
        var self = this;
        ControlVentaCFAE_Model.loadComponents(function (res)
        {
            if (res.data.eCatalogs['TIPO_IDENT'])
            {
                $('.el-fin-tipo-documeno', self.$modal).show();

                var TIPO_IDENT = res.data.eCatalogs['TIPO_IDENT'];
                var html = '';
                if (TIPO_IDENT.length > 0)
                {
                    var isView = 0;
                    var _value = $('select[name="tipo_documento"]', self.$modal).attr('_value');
                    $.each(TIPO_IDENT, function (idx, tipo_identificacion)
                    {
                        if (typeof _value == 'undefined')
                        {
                            if (tipo_identificacion.value == ControlVentaCFAE_Base.cfae_form_default.tipo_documento.value)
                            {
                                isView = tipo_identificacion.value;
                            }
                        }
                        else
                        {
                            if (tipo_identificacion.value == _value)
                            {
                                isView = tipo_identificacion.value;
                            }
                        }

                        html += '<option value="' + (tipo_identificacion.value) + '">' + (tipo_identificacion.text) + '</option>';
                    });
                }
                else
                {
                    html += '<option value="">&lt;VACIO&gt;</option>';
                }
                $('select[name="tipo_documento"]', self.$modal)
                        .html(html)
                        .select2('val', isView != 0 ? isView : $('[name="tipo_documento"]', self.$modal).eq(0).select2("val"))
                        .select2('close');

                $.uniform.update();
                $('.el-fin-tipo-documeno', self.$modal).hide();
            }

            if (res.data.eCatalogs['GENDER'])
            {
                $('.el-fin-genero', self.$modal).show();
                var GENDER = res.data.eCatalogs['GENDER'];
                var html = '';
                if (GENDER.length > 0)
                {
                    var isView = 0;
                    var _value = $('select[name="gender"]', self.$modal).attr('_value');
                    $.each(GENDER, function (idx, genero)
                    {
                        if (typeof _value == 'undefined')
                        {
                            if (genero.value == ControlVentaCFAE_Base.cfae_form_default.gender.value)
                            {
                                isView = genero.value;
                            }
                        }
                        else
                        {
                            if (genero.value == _value)
                            {
                                isView = genero.value;
                            }
                        }
                        html += '<option value="' + (genero.value) + '">' + (genero.text) + '</option>';
                    });
                }
                else
                {
                    html += '<option value="">&lt;VACIO&gt;</option>';
                }
                $('select[name="gender"]', self.$modal)
                        .html(html)
                        .select2('val', isView != 0 ? isView : $('[name="gender"]', self.$modal).eq(0).select2("val"))
                        .select2('close');

                $.uniform.update();
                $('.el-fin-genero', self.$modal).hide();
            }

            if (res.data.eCatalogs['ESTADO_CIVIL'])
            {
                $('.el-fin-estado-civil', self.$modal).show();
                var ESTADO_CIVIL = res.data.eCatalogs['ESTADO_CIVIL'];
                var html = '';
                if (ESTADO_CIVIL.length > 0)
                {
                    var isView = 0;
                    var _value = $('select[name="estado_civil"]', self.$modal).attr('_value');
                    $.each(ESTADO_CIVIL, function (idx, estado_civil)
                    {
                        if (typeof _value == 'undefined')
                        {
                            if (estado_civil.value == ControlVentaCFAE_Base.cfae_form_default.estado_civil.value)
                            {
                                isView = estado_civil.value;
                            }
                        }
                        else
                        {
                            if (estado_civil.value == _value)
                            {
                                isView = estado_civil.value;
                            }
                        }
                        html += '<option value="' + (estado_civil.value) + '">' + (estado_civil.text) + '</option>';
                    });
                }
                else
                {
                    html += '<option value="">&lt;VACIO&gt;</option>';
                }
                $('select[name="estado_civil"]', self.$modal)
                        .html(html)
                        .select2('val', isView != 0 ? isView : $('[name="estado_civil"]', self.$modal).eq(0).select2("val"))
                        .select2('close');

                $.uniform.update();
                $('.el-fin-estado-civil', self.$modal).hide();
            }

            if (res.data.eCatalogs['TIPO_DE_SANGRE'])
            {
                $('.el-fin-tipo-sangre', self.$modal).show();
                var TIPO_DE_SANGRE = res.data.eCatalogs['TIPO_DE_SANGRE'];
                var html = '';
                if (TIPO_DE_SANGRE.length > 0)
                {
                    var isView = 0;
                    var _value = $('select[name="tipo_sangre"]', self.$modal).attr('_value');
                    $.each(TIPO_DE_SANGRE, function (idx, tipo_sangre)
                    {
                        if (typeof _value == 'undefined')
                        {
                            if (tipo_sangre.value == ControlVentaCFAE_Base.cfae_form_default.tipo_sangre.value)
                            {
                                isView = tipo_sangre.value;
                            }
                        }
                        else
                        {

                            if (tipo_sangre.value == _value)
                            {
                                isView = tipo_sangre.value;
                            }
                        }

                        html += '<option value="' + (tipo_sangre.value) + '">' + (tipo_sangre.text) + '</option>';
                    });
                }
                else
                {
                    html += '<option value="">&lt;VACIO&gt;</option>';
                }
                $('select[name="tipo_sangre"]', self.$modal)
                        .html(html)
                        .select2('val', isView != 0 ? isView : $('[name="tipo_sangre"]', self.$modal).eq(0).select2("val"))
                        .select2('close');
                $.uniform.update();
                $('.el-fin-tipo-sangre', self.$modal).hide();
            }
            
            if (res.data.eCatalogs['DISCAPACIDAD'])
            {
                $('.el-fin-discapacidad', self.$modal).show();
                var DISCAPACIDAD = res.data.eCatalogs['DISCAPACIDAD'];
                var html = '';
                if (DISCAPACIDAD.length > 0)
                {
                    var isView = 0;
                    var _value = $('select[name="discapacidad"]', self.$modal).attr('_value');
                    $.each(DISCAPACIDAD, function (idx, discapacidad)
                    {
                        if (typeof _value == 'undefined')
                        {
                            if (discapacidad.value == ControlVentaCFAE_Base.cfae_form_default.discapacidad.value)
                            {
                                isView = discapacidad.value;
                            }
                        }
                        else
                        {

                            if (discapacidad.value == _value)
                            {
                                isView = discapacidad.value;
                            }
                        }

                        html += '<option value="' + (discapacidad.value) + '">' + (discapacidad.text) + '</option>';
                    });
                }
                else
                {
                    html += '<option value="">&lt;VACIO&gt;</option>';
                }
                $('select[name="discapacidad"]', self.$modal)
                        .html(html)
                        .select2('val', isView != 0 ? isView : $('[name="discapacidad"]', self.$modal).eq(0).select2("val"))
                        .select2('close');
                $.uniform.update();
                $('.el-fin-discapacidad', self.$modal).hide();
            }
            
            if (res.data.eCatalogs['NIVEL_ACADEMICO'])
            {
                $('.el-fin-nivel-academico', self.$modal).show();
                var NIVEL_ACADEMICO = res.data.eCatalogs['NIVEL_ACADEMICO'];
                var html = '';
                if (NIVEL_ACADEMICO.length > 0)
                {
                    var isView = 0;
                    var _value = $('select[name="nivel_academico"]', self.$modal).attr('_value');
                    $.each(NIVEL_ACADEMICO, function (idx, nivel_academico)
                    {
                        if (typeof _value == 'undefined')
                        {
                            if (nivel_academico.value == ControlVentaCFAE_Base.cfae_form_default.nivel_academico.value)
                            {
                                isView = nivel_academico.value;
                            }
                        }
                        else
                        {

                            if (nivel_academico.value == _value)
                            {
                                isView = nivel_academico.value;
                            }
                        }

                        html += '<option value="' + (nivel_academico.value) + '">' + (nivel_academico.text) + '</option>';
                    });
                }
                else
                {
                    html += '<option value="">&lt;VACIO&gt;</option>';
                }
                $('select[name="nivel_academico"]', self.$modal)
                        .html(html)
                        .select2('val', isView != 0 ? isView : $('[name="nivel_academico"]', self.$modal).eq(0).select2("val"))
                        .select2('close');
                $.uniform.update();
                $('.el-fin-nivel-academico', self.$modal).hide();
            }
            
            if (res.data.eSedes)
            {

                $('.el-fin-sede', self.$modal).show();

                var eSEDES = res.data.eSedes;
                var html = '';
                if (eSEDES.length > 0)
                {
                    var isView = 0;
                    var _value = $('select[name="id_sede"]', self.$modal).attr('_value');
                    $.each(eSEDES, function (idx, sede)
                    {
                        if (typeof _value == 'undefined')
                        {
                            if (sede.id == ControlVentaCFAE_Base.cfae_form_default.id_sede.value)
                            {
                                isView = sede.id;
                            }
                        }
                        else
                        {
                            if (sede.id == _value)
                            {
                                isView = sede.id;
                            }
                        }

                        html += '<option value="' + (sede.id) + '">' + (sede.name) + '</option>';
                    });
                }
                else
                {
                    html += '<option value="">&lt;VACIO&gt;</option>';
                }
                $('select[name="id_sede"]', self.$modal)
                        .html(html)
                        .select2('val', isView != 0 ? isView : $('[name="id_sede"]', self.$modal).eq(0).select2("val"))
                        .select2('close');

                $.uniform.update();
                $('.el-fin-sede', self.$modal).hide();
            }
            /*
            if (res.data.eCompanyBranches)
            {

                $('.el-fin-company-branchs', self.$modal).show();

                var eCOMPANY_BRANCHS = res.data.eCompanyBranches;
                var html = '';
                if (eCOMPANY_BRANCHS.length > 0)
                {
                    var isView = 0;
                    var _value = ControlVentaCFAE_Base.data_company_branch;
                    //var _value = $('select[name="id_company_branchs"]', self.$modal).attr('_value');
                    $.each(eCOMPANY_BRANCHS, function (idx, company_branch)
                    {
                        if (typeof _value == 'undefined')
                        {
                            if (company_branch.value == ControlVentaCFAE_Base.cfae_form_default.id_company_branchs)
                            {
                                isView = company_branch.value;
                            }
                        }
                        else
                        {
                            if (company_branch.value == _value)
                            {
                                isView = company_branch.value;
                            }
                        }

                        html += '<option value="' + (company_branch.value) + '">' + (company_branch.text) + '</option>';
                    });
                }
                else
                {
                    html += '<option value="">&lt;VACIO&gt;</option>';
                }
                $('select[name="id_company_branchs"]', self.$modal)
                        .html(html)
                        //.select2('val', isView != 0 ? isView : $('[name="id_company_branchs"]', self.$modal).eq(0).select2("val"))
                        .select2('val', isView != 0 ? isView : $('[name="id_company_branchs"]', self.$modal).eq(0).select2("val"))
                        .select2('close');

                $.uniform.update();
                $('.el-fin-company-branchs', self.$modal).hide();
            }*/

        });
        self.loadPais(fLoad);
    },
    loadCursoCapacitacion: function ()
    {
        var self = this;
        $('.el-fin-curso-capacitacion', self.$modal).show();
        ControlVentaCFAE_Model.loadPais(function (res) {
            var html = '';
            var isView = 0;
            if (res.data['cbo-pais'].length > 0)
            {
                var _value = $('select[name="id_pais"]', self.$modal).attr('_value');
                $.each(res.data['cbo-pais'], function (idx, pais)
                {
                    if (typeof _value == 'undefined')
                    {
                        if (pais.value == ControlVentaCFAE_Base.cfae_form_default.id_pais.value)
                        {
                            isView = pais.value;
                        }
                    }
                    else
                    {
                        if (pais.value == _value)
                        {
                            isView = pais.value;
                        }
                    }
                    html += '<option value="' + (pais.value) + '">' + (pais.text) + '</option>';
                });
            }
            else
            {
                html += '<option value="">&lt;VACIO&gt;</option>';
            }
            $('[name="id_pais"]', self.$modal)
                    .html(html)
                    .select2('val', isView != 0 ? isView : $('[name="id_pais"]', self.$modal).eq(0).select2("val"))
                    .select2('close');
            $.uniform.update();
            $('.el-fin-pais', self.$modal).hide();
            self.loadProvincia(fLoad);
        });
    },
    loadPais: function (fLoad)
    {
        var self = this;
        $('.el-fin-pais', self.$modal).show();
        ControlVentaCFAE_Model.loadPais(function (res) {
            var html = '';
            var isView = 0;
            if (res.data['cbo-pais'].length > 0)
            {
                var _value = $('select[name="id_pais"]', self.$modal).attr('_value');
                $.each(res.data['cbo-pais'], function (idx, pais)
                {
                    if (typeof _value == 'undefined')
                    {
                        if (pais.value == ControlVentaCFAE_Base.cfae_form_default.id_pais.value)
                        {
                            isView = pais.value;
                        }
                    }
                    else
                    {
                        if (pais.value == _value)
                        {
                            isView = pais.value;
                        }
                    }
                    html += '<option value="' + (pais.value) + '">' + (pais.text) + '</option>';
                });
            }
            else
            {
                html += '<option value="">&lt;VACIO&gt;</option>';
            }
            $('[name="id_pais"]', self.$modal)
                    .html(html)
                    .select2('val', isView != 0 ? isView : $('[name="id_pais"]', self.$modal).eq(0).select2("val"))
                    .select2('close');
            $.uniform.update();
            $('.el-fin-pais', self.$modal).hide();
            self.loadProvincia(fLoad);
        });
    },
    loadProvincia: function (fLoad/*=undefined*/)
    {
        var self = this;
        var id_pais = $('select[name="id_pais"]', self.$modal).select2('val');
        $('.el-fin-provincia', self.$modal).show();
        ControlVentaCFAE_Model.loadProvincia(id_pais, function (res) {
            var html = '';
            var isView = 0;
            if (res.data['cbo-provincia'].length > 0)
            {
                var _value = $('select[name="id_provincia"]', self.$modal).attr('_value');
                $.each(res.data['cbo-provincia'], function (idx, provincia)
                {
                    if (typeof _value == 'undefined')
                    {
                        if (provincia.value == ControlVentaCFAE_Base.cfae_form_default.id_provincia.value)
                        {
                            isView = provincia.value;
                        }
                    }
                    else
                    {
                        if (provincia.value == _value)
                        {
                            isView = provincia.value;
                        }
                    }
                    html += '<option value="' + (provincia.value) + '">' + (provincia.text) + '</option>';
                });
            }
            else
            {
                html += '<option value="">&lt;VACIO&gt;</option>';
            }
            $('[name="id_provincia"]', self.$modal)
                    .html(html)
                    .select2('val', isView != 0 ? isView : $('[name="id_provincia"]', self.$modal).eq(0).select2("val"))
                    .select2('close');
            $.uniform.update();
            $('.el-fin-provincia', self.$modal).hide();
            self.loadCiudad(fLoad);
        });
    },
    loadCiudad: function (fLoad/*=undefined*/)
    {
        var self = this;
        var id_provincia = $('select[name="id_provincia"]', self.$modal).select2('val');
        $('.el-fin-ciudad', self.$modal).show();
        ControlVentaCFAE_Model.loadCiudad(id_provincia, function (res) {
            var html = '';
            if (res.data['cbo-ciudad'].length > 0)
            {
                var isView = 0;
                var _value = $('select[name="id_ciudad"]', self.$modal).attr('_value');
                $.each(res.data['cbo-ciudad'], function (idx, ciudad)
                {
                    if (typeof _value == 'undefined')
                            //if (_value == 0)
                            {
                                if (ciudad.value == ControlVentaCFAE_Base.cfae_form_default.id_ciudad.value)
                                {
                                    isView = ciudad.value;
                                }
                            }
                    else
                    {
                        if (ciudad.value == _value)
                        {
                            isView = ciudad.value;
                        }
                    }
                    html += '<option value="' + (ciudad.value) + '">' + (ciudad.text) + '</option>';
                });
            }
            else
            {
                html += '<option value="">&lt;VACIO&gt;</option>';
            }
            $('select[name="id_ciudad"]', self.$modal)
                    .html(html)
                    .select2('val', isView != 0 ? isView : $('[name="id_ciudad"]', self.$modal).eq(0).select2("val"))
                    .select2('close');
            $.uniform.update();
            $('.el-fin-ciudad', self.$modal).hide();
            if (fLoad)
            {
                fLoad();
            }
        });
    },
    //====================
    // ACTIONS
    //====================
    actionSave: function ()
    {
        var self = this;
        var data = self.data();
        self.errorClear();
        self.formLoading('save');
        ControlVentaCFAE_Model.saveAcount(data, function (res) {
            if (res.isSuccess)
            {
                Core.Notification.success(res.message);
                self.close();
                ControlVentaCFAE_Controller.refresDataTable(false);
            }
            else
            {
                Core.Notification.error(res.message);
                self.formLoading('none');
                self.formError(res.forms.acount);
                self.formReadOnly(false);
            }

        });
    }
};

Core.addInit(function () {
    ControlVentaCFAE_Controller.init();
});