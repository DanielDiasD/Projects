$('#pessoa').change(function () {
    if ($('#pessoa').val() == 'Pessoa Física') {
        $('#lblcpf_cnpj').html('CPF');
        $('#lblNome').html('Nome');
        $('#field-razao').hide();
        $('#razao').removeAttr('required');
        $('#btncnpj').hide();
    } else {
        $('#lblNome').html('Nome Fantasia');
        $('#lblcpf_cnpj').html('CNPJ');
        $('#field-razao').show();
        $('#razao').attr('required', 'required');
        $('#btncnpj').show();
    }
});

$('#form_cadastro').submit(function () {
    $.ajax({
        url: 'crud.php',
        type: 'POST',
        dataType: 'json',
        data: $('#form_cadastro').serialize(),
        beforeSend: function () { },
        success: function (data) {
            if (data.Status) {
                $('#codigo').val('');
                $('.btnSubmit').html("Cadastrar");
                $('#form_cadastro')[0].reset();
            }
            alert(data['msg']);
        },
        error: function () {
            alert('Não foi possível realizar o cadastro.');
        },
        complete: function () {

        }
    });
    return false;
});

$(document).on('click', '.btn-del', function () {
    $.ajax({
        url: 'crud.php',
        type: 'GET',
        dataType: 'json',
        data: { del: $(this).attr('data-id') },
        beforeSend: function () { },
        success: function (data) {
            consulta_registros();
            alert(data.msg);
        },
        error: function () {
            alert('Não foi possível deletar o registro.');
        },
        complete: function () {

        }
    });
});

$(document).on('click', '.btn-edit', function () {
    $.ajax({
        url: 'crud.php',
        type: 'GET',
        dataType: 'json',
        data: { search: $(this).attr('data-id'), edt:true },
        beforeSend: function () { },
        success: function (data) {
            if (data['dados'][0]['tipo_de_pessoa'] == 'Pessoa Física') {
                $('#lblcpf_cnpj').html('CPF');
                $('#lblNome').html('Nome');
                $('#razao').removeAttr('required');
                $('#field-razao').hide();
                $('#btncnpj').hide();
            } else {
                $('#lblNome').html('Nome Fantasia');
                $('#lblcpf_cnpj').html('CNPJ');
                $('#razao').attr('required', 'required');
                $('#field-razao').show();
                $('#btncnpj').show();
            }

            $('#cpf_cnpj').unmask();
            if (data['dados'][0]['tipo_de_pessoa'] == 'Pessoa Física') {
                $('#cpf_cnpj').mask('000.000.000-00');
            } else {
                $('#cpf_cnpj').mask('00.000.000/0000-00');
            }

            $('#nav-cadastro-tab').click();
            $('.btnSubmit').html("Alterar");
            $('#codigo').val(data['dados'][0]['codigo']);
            $('#pessoa').val(data['dados'][0]['tipo_de_pessoa']);
            $('#nome').val(data['dados'][0]['nome_fantasia']);
            $('#cpf_cnpj').val(data['dados'][0]['cpf_cnpj']);
            $('#razao').val(data['dados'][0]['razao']);
            $('#endereco').val(data['dados'][0]['endereco']);
            $('#numero').val(data['dados'][0]['numero']);
            $('#complemento').val(data['dados'][0]['complemento']);
            $('#cep').val(data['dados'][0]['cep']);
            $('#municipio').val(data['dados'][0]['municipio']);
            $('#uf').val(data['dados'][0]['uf']);
            $('#e_mail').val(data['dados'][0]['e_mail']);
            $('#tel').val(data['dados'][0]['telefone']);
            $('#cel').val(data['dados'][0]['celular']);
            $("#cliente").prop('checked', data['dados'][0]['cliente'] == '1' ? true : false);
            $("#fornecedor").prop('checked', data['dados'][0]['fornecedor'] == '1' ? true : false);
            $("#funcionario").prop('checked', data['dados'][0]['funcionario'] == '1' ? true : false);
        },
        error: function () {
            alert('Não foi carregar o cadastro');
        }
    });
});

function consulta_registros() {
    $.ajax({
        url: 'crud.php',
        type: 'GET',
        dataType: 'json',
        data: { search: $('#txtSearch').val() },
        beforeSend: function () { },
        success: function (data) {
            $("#todos_registros tbody").html('');
            for (var i = 0; i < data.dados.length; i++) {
                $("#todos_registros tbody").append("<tr><td>" + data.dados[i].codigo +
                    "</td><td>" + data.dados[i].nome_fantasia + "</td>" +
                    "<td>" + data.dados[i].tipo_de_pessoa + "</td>" +
                    "<td>" + data.dados[i].cpf_cnpj + "</td>" +
                    "<td>" +
                    '<button data-id="' + data.dados[i].codigo + '" class="btn btn-success btn-sm btn-edit"><i class="fa fa-edit"></i></button>' +
                    '<button data-id="' + data.dados[i].codigo + '" class="btn btn-danger btn-sm btn-del"><i class="fa fa-close"></i></button>' +
                    "</td>" +
                    "</tr>");
            }
        },
        error: function () {
            alert('Não foi possível consultar os registros.');
        },
        complete: function () {

        }
    });
    return false;
};