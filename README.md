# API - Planos de Saúde

Esta API retorna um json, contendo os dados para formatar uma proposta de plano de saúde
com beneficiários, tipo de plano e valores. Os arquivos de base para construção são: plans.json e prices.json. 

## Instruções para uso 

Enviar os dados em formato json ,  via "POST" conforme exemplo:
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

Os seguintes erros serão retornados:

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

## O que ainda precisa ser implementado

Criar um front-end para consumir essas informações

Esse front-end utiliza o Ajax para as requisições com o servidor,
para esta implementação necessitaria de um pouco mais de tempo para o domínio dela.