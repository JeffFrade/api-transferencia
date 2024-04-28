# API de transferência de valores
---

Esse projeto foi desenvolvido para executar em um ambiente com `docker`, mas caso queria rodar no seu ambiente, sem problemas, só copiar `.env.example` para `.env` e alterar as variáveis com os valores correspondentes ao seu ambiente.

### Documentação
---

Caso seu ambiente já tenha o `docker` instalado e deseja fazer uma instalação mais tranquila do projeto, eu deixei um arquivo chamado `config.sh` na raiz do projeto, caso seu ambiente no momento seja um `linux`, basta executar `sh config.sh` e toda a infra será construída.

Sobre os endpoints e o que a `API` espera receber estã dentro do arquivo `Trasferencia_API.postman_collection.json` na raiz do projeto e pode ser facilmente importado em seu `Postman`.

### Observações
---

Durante o processo do `config.sh` o banco é alimentado com dados fakes somente para teste/desenvolvimento da aplicação.

### Melhorias
---

- Para as versões posteriores, utilizar o processo de `fila/menssageria` para efetuar as transações com o menor impacto possível para a aplicação.
