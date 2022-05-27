# API - Planos de Saúde

Esta API retorna um json, contendo os dados para formatar uma proposta de plano de saúde
com beneficiários, tipo de plano e valores. Os arquivos de base para construção são: plans.json e prices.json. 

## Instruções para uso 

Opcão 1: Enviar os dados em formato json ,  via "POST" conforme exemplo:

```json
{
  "codigo": 1,
  "vidas": 3,
  "beneficiarios": [
    {
      "nome": "Santos Silva de Sá",
      "idade": 45
    },
    {
      "nome": "Chiquinho de Sá",
      "idade": 18
    },
    {
      "nome": "Francisca de Sá",
      "idade": 16
    }
  ]
}
```

Opção 2: Utilizar o formulário de front-end index.html

Resposta da API no formato json abaixo:
```json
{
  "codigo": 1,
  "vidas": 3,
  "beneficiarios": [
    {
      "nome": "Santos Silva de Sá",
      "idade": 45,
      "valor": 15
    },
    {
      "nome": "Chiquinho de Sá",
      "idade": 18,
      "valor": 12
    },
    {
      "nome": "Francisca de Sá",
      "idade": 16,
      "valor": 10
    }
  ],
  "plano_escolhido": "Bitix Customer Plano 1",
  "total": 37
}
```


> Nota: Esta API salva também os resultados nos arquivos: 
> proposta.json e beneficiarios.json.


## Erros que serão retornados:

Se o código do plano não existir na tabela plans.json
```json
{
  "erro": "Plano Inválido!"
}
```

Se a quantidade de vidas for diferente do número de beneficiários 
```json
{
  "erro": "Quantidade de Beneficiários Inválida!"
}
```
Se o método usado não for "POST"
```json
{
  "erro" : "Método inválido!"
}
```