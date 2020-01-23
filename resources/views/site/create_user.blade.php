@extends('template.base')

@section('title', 'Cadastro de Usuário')

@section ('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="container-create-user">
                <div class="row">
                    <div class="col-md-12">
                        <div class="menu">
                            <a class="links" href="{{route('user.list')}}">Lista de Usuarios</a>
                        </div>
                    </div>
                </div>
                <h4 class="text-center">Cadastre o usuário</h4>
                <form class="form-create-user" id="form_create_user">
                    <div class="errors text-center"></div>
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
                                <input type="text" class="form-control form-control-sm" id="user_phone_01" name="user_phones[]" data-mask="(00) 00000-0000" placeholder="Telefone 1">
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control form-control-sm" id="user_phone_02" name="user_phones[]" data-mask="(00) 00000-0000" placeholder="Telefone 2">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-6">
                                <input type="text" class="form-control form-control-sm" id="user_phone_03" name="user_phones[]" data-mask="(00) 00000-0000" placeholder="Telefone 3">
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control form-control-sm" id="user_phone_04" name="user_phones[]" data-mask="(00) 00000-0000" placeholder="Telefone 4">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-6">
                                <input type="text" class="form-control form-control-sm" id="user_phone_05" name="user_phones[]" data-mask="(00) 00000-0000" placeholder="Telefone 5">
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control form-control-sm" id="user_phone_06" name="user_phones[]" data-mask="(00) 00000-0000" placeholder="Telefone 6">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-block btn-primary" id="btn_create_user">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script src="{{asset('js/jquery.mask.min.js')}}"></script>

<script>
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

    $('#form_create_user').submit(function() {
        $.ajax({
            type: 'post',
            url: '{{route("user.create")}}',
            dataType: 'json',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
            beforeSend: function() {
                $('#btn_create_user').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Cadastrando...');
            },
            success: function(data) {
                $('#btn_create_user').html('Cadastrar');
                console.log(data);
                if (data['status'] == 1) {
                    $('.errors').html(data['message']).show();
                } else {
                    showErrors(data['id']);
                    $('.errors').html(data['message']).show();
                }
            }
        });
        return false;
    });

    function clearErrors() {
        $(".is-invalid").removeClass("is-invalid");
        $(".invalid-feedback").html("");
    }

    function showErrors(id) {
        clearErrors();

        $.each(id, function(id, message) {
            $(id).addClass("is-invalid");
        })
    }
</script>

@endsection