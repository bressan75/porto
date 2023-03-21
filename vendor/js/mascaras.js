$(document).ready(function(){
	$('#cpf').mask('000.000.000-00');
	$('#cnpj').mask('00.000.000/0000-00');
	$('#telefone').mask('(00) 00000-0000');
	$('#telefone-perfil').mask('(00) 00000-0000');
	$('#numero').mask('AAAA0000000');
	$('.money').mask('#.##0,00', {reverse: true});
});