@extends('template.base')

@section('title', 'Lista de Usuários')

@section ('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="container-list-users">
                <div class="row">
                    <div class="col-md-12">
                        <div class="menu">
                            <a class="links" href="{{route('user')}}">Voltar</a>
                        </div>
                    </div>
                </div>
                <div class="table-list">
                    <h5 class="text-center">Lista de usuários</h5>
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Sobrenome</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-list">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade " id="staticBackdrop" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="errors text-center"></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-edit-user" id="form_edit_user">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm" id="user_name" name="user_name" placeholder="Nome">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm" id="user_lastname" name="user_lastname" placeholder="Sobrenome">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control form-control-sm" id="user_email" name="user_email" placeholder="E-mail">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm" id="user_birthdate" name="user_birthdate" data-mask="00/00/0000" placeholder="Data de nascimento">
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-3">
                                <input type="text" class="form-control form-control-sm" id="user_zip" name="user_zip" data-mask="00.000-000" placeholder="Cep">
                            </div>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="user_public_place" name="user_public_place" placeholder="Logradouro">
                            </div>
                            <div class="col-2">
                                <input type="text" class="form-control form-control-sm" id="user_number" name="user_number" placeholder="Número">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-6">
                                <input type="text" class="form-control form-control-sm" id="user_complement" name="user_complement" placeholder="Complemento">
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control form-control-sm" id="user_district" name="user_district" placeholder="Bairro">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-10">
                                <input type="text" class="form-control form-control-sm" id="user_city" name="user_city" placeholder="Cidade">
                            </div>
                            <div class="col-2">
                                <input type="text" class="form-control form-control-sm" id="user_state" name="user_state" placeholder="Estado">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-6">
                                <input type="text" class="form-control form-control-sm user-phone" phone_id="" id="user_phone_00" name="user_phones[]" data-mask="(00) 00000-0000" placeholder="Telefone 1">
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control form-control-sm user-phone" phone_id="" id="user_phone_01" name="user_phones[]" data-mask="(00) 00000-0000" placeholder="Telefone 2">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-6">
                                <input type="text" class="form-control form-control-sm user-phone" phone_id="" id="user_phone_02" name="user_phones[]" data-mask="(00) 00000-0000" placeholder="Telefone 3">
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control form-control-sm user-phone" phone_id="" id="user_phone_03" name="user_phones[]" data-mask="(00) 00000-0000" placeholder="Telefone 4">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-6">
                                <input type="text" class="form-control form-control-sm user-phone" phone_id="" id="user_phone_04" name="user_phones[]" data-mask="(00) 00000-0000" placeholder="Telefone 5">
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control form-control-sm user-phone" phone_id="" id="user_phone_05" name="user_phones[]" data-mask="(00) 00000-0000" placeholder="Telefone 6">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="user_id_edit" name="user_id_edit">
                    <input type="hidden" id="address_id_edit" name="address_id_edit">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary" id="btn_form_edit_user">Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script src="{{asset('js/jquery.mask.min.js')}}"></script>

<script>
    $('#form_edit_user').submit(function() {

        var user_id = $('#user_id_edit').val();

        var user = {
            name: $('#user_name').val(),
            lastname: $('#user_lastname').val(),
            birthdate: $('#user_birthdate').val(),
            email: $('#user_email').val(),
        };

        putUser(user, user_id);

        var address_id = $('#address_id_edit').val();

        var address = {
            zip: $('#user_zip').val().replace(/\D/g, ''),
            public_place: $('#user_public_place').val(),
            number: $('#user_number').val(),
            complement: $('#user_complement').val(),
            district: $('#user_district').val(),
            city: $('#user_city').val(),
            state: $('#user_state').val(),
        };


        putAddress(address, address_id);

        for (var i = 0; i < 6; i++) {
            var phone_id = $('#user_phone_0' + i).attr('phone_id');
            var dddPhone = $('#user_phone_0' + i).val();
            var returnPhone = dddPhone.split(' ');
            if (dddPhone != '') {
                var phone = {
                    ddd: returnPhone[0].replace(/\D/g, ''),
                    phone: returnPhone[1].replace(/\D/g, ''),
                };
                putPhone(phone, phone_id);
            }
        }
        return false;
    });

    function putUser(data, user_id) {
        $.ajax({
            type: 'put',
            url: '{{url("/")}}/api/users/' + user_id,
            dataType: 'json',
            data: data,
            success: function(data) {
                $('#staticBackdrop').modal('hide');
                listUsers();
            }
        });
    }

    function putAddress(data, address_id) {
        $.ajax({
            type: 'put',
            url: '{{url("/")}}/api/addresses/' + address_id,
            dataType: 'json',
            data: data,
            success: function(data) {
                $('#staticBackdrop').modal('hide');
                listUsers();
            }
        });
    }

    function putPhone(data, phone_id) {
        $.ajax({
            type: 'put',
            url: '{{url("/")}}/api/phones/' + phone_id,
            dataType: 'json',
            data: data,
            success: function(data) {
                $('#staticBackdrop').modal('hide');
                listUsers();
            }
        });
    }

    $(document).on('click', '#btn_edit_user', function() {
        $('#form_edit_user')[0].reset();

        var user_id = $(this).attr('user_id');
        $.ajax({
            type: 'get',
            url: '{{url("/")}}/api/users/' + user_id,
            dataType: 'json',
            success: function(json) {
                $('#user_id_edit').val(user_id);
                $('#user_name').val(json.user.name);
                $('#user_lastname').val(json.user.lastname);
                $('#user_email').val(json.user.email);
                $('#user_birthdate').val(json.user.birthdate);
                $('#address_id_edit').val(json.address[0].id);
                $('#user_zip').val(json.address[0].zip);
                $('#user_public_place').val(json.address[0].public_place);
                $('#user_number').val(json.address[0].number);
                $('#user_complement').val(json.address[0].complement);
                $('#user_district').val(json.address[0].district);
                $('#user_city').val(json.address[0].city);
                $('#user_state').val(json.address[0].state);
                $.each(json.phones, function(index, phones) {
                    if (phones != '') {
                        $('#user_phone_0' + index).attr('phone_id', json.phones[index].id);
                        $('#user_phone_0' + index).val('(' + json.phones[index].ddd + ') ' + json.phones[index].phone);
                    }
                });
                for (var i = 0; i < 6; i++) {
                    $('#user_phone_0' + i).removeAttr('disabled');
                    if ($('#user_phone_0' + i).val() == '') {
                        $('#user_phone_0' + i).attr('disabled', '');
                    }
                }
            }
        });
    });

    $('#user_zip').change(function() {
        var zip = $(this).val().replace(/\D/g, '');
        $.ajax({
            type: 'get',
            url: 'https://viacep.com.br/ws/' + zip + '/json/',
            dataType: 'json',
            success: function(json) {
                if (!("erro" in json)) {
                    $('#user_public_place').val(json.logradouro);
                    $('#user_complement').val(json.complemento);
                    $('#user_district').val(json.bairro);
                    $('#user_city').val(json.localidade);
                    $('#user_state').val(json.uf);
                } else {
                    alert('Cep não localizado')
                }
            }
        });
    });

    $(document).ready(function() {
        listUsers();
    });

    function listUsers() {
        $.ajax({
            type: 'get',
            url: '{{url("/")}}/api/users',
            dataType: 'json',
            beforeSend: function() {
                $('#tbody-list').html('<tr class="text-center"><td colspan="4"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></td></tr>').show();
            },
            success: function(json) {
                var tbody = '';
                $.each(json, function(index, users) {
                    tbody += '<tr><td>' + users.user.name + '</td>' +
                        '<td>' + users.user.lastname + '</td>' +
                        '<td>' + users.user.email + '</td>' +
                        '<td><button type="button" class="btn btn-warning" user_id="' + users.user.id + '" id="btn_edit_user" data-toggle="modal" data-target="#staticBackdrop">+</button></td></tr>';
                });
                $('#tbody-list').html(tbody).show();
            }
        });
    }
</script>


@endsection