

function consulta_cep() {
    var url = 'https://viacep.com.br/ws/' + $('#cep').val() + '/json/';

    $.ajax({
        url: url,
        type: 'GET',
        beforeSend: function () {
            $("#resultado").html("ENVIANDO...");
        },
        success: function (data) {
            $("#endereco").val(data['logradouro']);
            $("#municipio").val(data['localidade']);
            $("#uf").val(data['uf']);

        },
        error: function () {
            alert('Não foi possível consulta o CEP.');
        },
        complete: function () {

        }
    });

};

function consulta_cnpj() {
    var cnpj = $("#cpf_cnpj").val();
    var url = 'https://www.receitaws.com.br/v1/cnpj/' + cnpj.replace(/[^\d]+/g,'');

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'jsonp',
        beforeSend: function () {
            $("#resultado").html("ENVIANDO...");
        },
        success: function (data) {
            $("#nome").val(data['fantasia']);
            $("#municipio").val(data['municipio']);
            $("#uf").val(data['uf']);
            $("#tel").val(data['telefone']);
            $("#endereco").val(data['logradouro']);
            $("#razao").val(data['nome']);
            $("#cep").val(data['cep']);
        },
        error: function () {
            alert('Não foi possível consulta o CNPJ.');
        },
        complete: function () {

        }
    });
};