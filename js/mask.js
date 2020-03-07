$(document).ready(function(){
    $('#cpf_cnpj').mask('000.000.000-00');  
});

$('#pessoa').change(function () {
    $('#cpf_cnpj').unmask();
    if ($('#pessoa').val() == 'Pessoa Física') {
        $('#cpf_cnpj').mask('000.000.000-00');
    } else {
        $('#cpf_cnpj').mask('00.000.000/0000-00');
    }
});

$('.cep').mask('00000-000');
$('.tel').mask('(00) 0000-0000');
$('.cel').mask('(00) 00000-0000');