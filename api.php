<?php

// Saída de dados da api (json)
header('Content-type: application/json');

// ENTRADA:
// ========

// plans.json p/ array
$plans = file_get_contents('plans.json');
$plans = json_decode($plans, true);//default object, true array

// prices.json p/ array
$prices = file_get_contents('prices.json');
$prices = json_decode($prices, true);//default object, true array

// Capturando o tipo de requisição
$method = $_SERVER['REQUEST_METHOD'];


// VERIFICAÇÕES INICIAIS:
// ======================

// 1 - Tipo de requisíção

if (! $method === "POST"){
	http_response_code(400);// Retornar erro requisição
	echo '{"erro" : "Método inválido!"}';
	exit;
}

$body = file_get_contents('php://input');//php captura  body 

// body p/ array
$dadosBody = json_decode($body, true);//default object, true array

// Limpando os Beneficiarios que vem do front-end como null

foreach ($dadosBody['beneficiarios'] as $chave => $valor){

	if ($valor['nome'] === null or $valor['idade'] === null) {
		unset($dadosBody['beneficiarios'][$chave]);

	}

}

// 2 - Código do plano informado

if($dadosBody['codigo'] < 1 or $dadosBody['codigo'] > 6){
	http_response_code(400);// Retornar erro requisição
	echo '{"erro" : "Plano Inválido!"}';
	exit;
}

// 3 - Vidas   X   Quantidade de beneficiários

// Se a qtd de vidas for diferente do número de beneficiários erro

if ($dadosBody['vidas'] != count($dadosBody['beneficiarios'])){
	http_response_code(400);// Retornar erro requisição
	echo '{"erro" : "Qtd. de Beneficiários Inválida!"}';
	exit;	
}

// ---------------------------------------------------------------------------

// LÓGICAS:
// ========

// 1 - Selecionar Plano  =>  prices.json:

foreach ($prices as $chave => $valor){

	if($valor['codigo'] === $dadosBody['codigo']){
		$arrChavePrices [] = $chave;// Array c/ as chaves do array prices.json = $codigo
	}
}

foreach ($arrChavePrices as $valor){
	$priceEscolhido [] = $prices[$valor];// array com as possibilidades de plano da tabela price.json
}


// 2 - Selecionar pelo no. de vidas,  só entrar se priceEscolhido for > 1 

if (count($priceEscolhido) > 1) {

	foreach ($priceEscolhido as $chave => $valor){
		if($dadosBody['vidas'] >= $valor['minimo_vidas']){
			$priceVidas = $chave;// fica a última possibilidade, pois sobrescreve.
		}
	}

$planoSelecionado = $priceEscolhido [$priceVidas];

}else{

	$planoSelecionado = $priceEscolhido [0];
}

//   --------------------------------------------------------------

// ARQUVIVO beneficiarios.json (item 4)
// =====================================

// 1 - Pegando o nome do plano

foreach ($plans as $chave => $valor){

	if($planoSelecionado['codigo'] === $valor['codigo']){
		$chaveplanoSelecionado = $chave;// chave do array
	}

}

$plano_escolhido = $plans[$chaveplanoSelecionado] ['nome'];

$dadosBody['plano_escolhido'] = $plano_escolhido;


// 2 - Saída proposta.json UTF-8

file_put_contents('beneficiarios.json',json_encode($dadosBody, JSON_UNESCAPED_UNICODE));

//   --------------------------------------------------------------

// ARQUIVO proposta.json (ítem 6) / CÁLCULO DOS VALORES
// ====================================================

// 1 - Pegando valores do plano selecionado:

$valor_faixa1 = $planoSelecionado ['faixa1'];
$valor_faixa2 = $planoSelecionado ['faixa2'];
$valor_faixa3 = $planoSelecionado ['faixa3'];
$a = 0;

// 2 - Lógica para atribuir os valores

foreach ($dadosBody ['beneficiarios'] as $chave => $benef){

	if ($benef['idade'] <= 17) {
		$dadosBody['beneficiarios'][$chave]['valor'] = $valor_faixa1;
	}
	elseif ($benef['idade'] >= 18 && $benef['idade'] <= 40) {
		$dadosBody['beneficiarios'][$chave]['valor'] = $valor_faixa2;
	}
	elseif ($benef['idade'] > 40) {
		$dadosBody['beneficiarios'][$chave]['valor'] = $valor_faixa3;
	}
	$a += $dadosBody['beneficiarios'][$chave]['valor'];
}


$dadosBody['total'] = $a;


// 3 - Saída proposta.json UTF-8

file_put_contents('proposta.json',json_encode($dadosBody, JSON_UNESCAPED_UNICODE));

echo json_encode($dadosBody, JSON_UNESCAPED_UNICODE);

