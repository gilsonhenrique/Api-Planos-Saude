
// ----------------------------------------------------------------

// Ações c/ id="form1"

$('#form1').submit(function(e){
	
	e.preventDefault();//Não recarregue a página com submit

// Capturar somente benficiários preenchidos (total 5)

if ($('#nome1').val() === "" || $('#idade1').val() === null){
	var nome1 = false;
	var idade1 = false;
}else{
	var nome1 = $('#nome1').val();
	var idade1 = parseInt($('#idade1').val());
}


if ($('#nome2').val() === "" || $('#idade2').val() === null){
	var nome2 = false;
	var idade2 = false;
}else{
	var nome2 = $('#nome2').val();
	var idade2 = parseInt($('#idade2').val());
}


if ($('#nome3').val() === "" || $('#idade3').val() === null){
	var nome3 = false;
	var idade3 = false;
}else{
	var nome3 = $('#nome3').val();
	var idade3 = parseInt($('#idade3').val());
}


if ($('#nome4').val() === "" || $('#idade4').val() === null){
	var nome4 = false;
	var idade4 = false;
}else{
	var nome4 = $('#nome4').val();
	var idade4 = parseInt($('#idade4').val());
}


if ($('#nome5').val() === "" || $('#idade5').val() === null){
	var nome5 = false;
	var idade5 = false;

}else{
	var nome5 = $('#nome5').val();
	var idade5 = parseInt($('#idade5').val());
}

//--------------------------------------------------------------------
	// Montar objeto com dados formulario

	var dadosForm = {
		codigo: parseInt($('input:radio[name=codigo]:checked').val()),
		vidas: parseInt($('#vidas').val()),
		beneficiarios: [
		{
			nome: nome1,
			idade: idade1
		},
		{
			nome: nome2,
			idade: idade2
		},
		{
			nome: nome3,
			idade: idade3
		},
		{
			nome: nome4,
			idade: idade4
		},
		{
			nome: nome5,
			idade: idade5
		}		
		]
	};

	//console.log(dadosForm);DEBUG

	//Instruções Ajax
	$.ajax({
		url: 'http://meus-projetos/api_planos_saude/api.php',
		method: 'POST',
		data: JSON.stringify(dadosForm),
		contentType: 'application/json; charset=utf-8',
		dataType: 'json'
	}).done(function(result){// Resusltado da requisição
		$('#codigo').val('');
		$('#vidas').val('');
		$('#nome1').val('');
		$('#idade1').val('');
		$('#nome2').val('');
		$('#idade2').val('');		
		$('#nome3').val('');
		$('#idade3').val('');
		$('#nome4').val('');
		$('#idade4').val('');
		$('#nome5').val('');
		$('#idade5').val('');		
		alert(JSON.stringify(result));
		//console.log(result);// DEBUG

	}).fail(function (jqXhr) {
  // Falha
  var a = JSON.parse(jqXhr.responseText);
  alert(a.erro)
});

});
