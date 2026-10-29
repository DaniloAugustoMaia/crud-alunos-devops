# CRUD de Alunos — Deploy Automático em VM

## 1. Identificação do projeto

**Instituição:** UniALFA  
**Curso:** Sistemas para Internet 4º Semestre 
**Atividade:** Trabalho 2 — Deploy Automático em VM

**Integrantes:**
- Danilo Augusto Maia RA:250299
- Hiago Freitas Risatto RA:250535

## 2. Descrição

Este projeto consiste em uma aplicação web CRUD (Create, Read, Update e Delete) para gerenciamento de alunos, desenvolvida em PHP e integrada a um banco de dados MySQL.

O objetivo principal da atividade é implementar um processo de **deploy automático em uma máquina virtual Ubuntu Server**, utilizando Docker Compose e GitHub Actions com um Runner self-hosted.

A cada alteração enviada para a branch `main` do repositório, o GitHub Actions executa automaticamente um workflow responsável por atualizar a aplicação na máquina virtual.

## 3. Tecnologias utilizadas

| Tecnologia | Finalidade |
|---|---|
| PHP 8.2 | Desenvolvimento da aplicação |
| Apache | Servidor web |
| MySQL 8.0 | Banco de dados |
| Docker | Execução dos containers |
| Docker Compose | Orquestração dos serviços |
| Ubuntu Server 24.04 LTS | Sistema operacional da VM |
| Oracle VirtualBox | Virtualização do servidor |
| Git e GitHub | Versionamento e armazenamento do código |
| GitHub Actions | Automação do deploy |
| GitHub Actions Runner self-hosted | Execução do workflow na VM |

## 4. Funcionalidades da aplicação

A aplicação permite:

- Cadastrar alunos.
- Listar alunos cadastrados.
- Editar informações dos alunos.
- Excluir registros.
- Armazenar os dados em um banco MySQL.

A aplicação utiliza PHP com Apache, enquanto o banco de dados é executado em um container MySQL separado.

## 5. Estrutura do projeto

```text
crud-alunos/
├── .github/
│   └── workflows/
│       └── deploy.yml
├── app/
│   ├── Dockerfile
│   └── src/
│       ├── config.php
│       ├── index.php
│       ├── create.php
│       ├── edit.php
│       ├── delete.php
│       ├── form.php
│       └── style.css
├── database/
│   └── init.sql
├── docker-compose.yml
├── .env.example
├── .gitignore
└── README.md
```

O arquivo `docker-compose.yml` define os serviços da aplicação e do banco de dados. O `Dockerfile` configura o ambiente PHP/Apache, e `database/init.sql` contém a estrutura inicial do banco.

## 6. Configuração da máquina virtual

A aplicação foi hospedada em uma máquina virtual criada no Oracle VirtualBox.

**Configuração utilizada:**

| Recurso | Configuração |
|---|---|
| Sistema operacional | Ubuntu Server 24.04 LTS |
| Nome da VM | Ubuntu-DevOps |
| Memória RAM | 4 GB |
| Processadores virtuais | 2 |
| Disco virtual | 30 GB |
| Rede | NAT |
| Usuário do Runner | devops |
| Nome do Runner | ubuntu-devops |

Após a instalação do Ubuntu Server, o sistema foi atualizado e recebeu os componentes necessários para executar a aplicação e o pipeline de deploy.

O Docker e o Docker Compose foram instalados e configurados para permitir a execução dos containers pelo usuário responsável pelo Runner.

## 7. GitHub Actions Runner self-hosted

Foi instalado um Runner self-hosted diretamente no Ubuntu Server.

O Runner foi registrado no repositório GitHub com as seguintes características:

- **Nome:** `ubuntu-devops`
- **Sistema:** Linux
- **Arquitetura:** x64
- **Etiquetas:** `self-hosted`, `linux`, `x64`

O Runner foi configurado como um serviço do sistema, permitindo sua execução contínua enquanto a VM estiver ligada.

Para verificar o serviço, no diretório de instalação do Runner:

```bash
sudo ./svc.sh status
```

Durante os testes, o serviço apresentou o estado `active (running)` e confirmou a conexão com o GitHub.

## 8. Funcionamento do deploy automático

O processo de deploy é definido no arquivo:

```text
.github/workflows/deploy.yml
```

O workflow é acionado automaticamente quando um commit é enviado à branch `main`. Também é possível iniciá-lo manualmente pela interface do GitHub Actions.

O processo segue estas etapas:

1. Um desenvolvedor altera os arquivos do projeto e envia um commit para a branch `main`.
2. O GitHub Actions identifica a alteração e inicia o workflow.
3. O Runner self-hosted, instalado na VM Ubuntu, recebe o trabalho.
4. A ação `actions/checkout@v4` baixa a versão atualizada do repositório.
5. O workflow cria o arquivo `.env` com as variáveis necessárias, utilizando GitHub Actions Secrets.
6. O Docker Compose reconstrói e atualiza os serviços da aplicação.
7. O workflow verifica o estado dos containers.
8. A nova versão fica disponível no navegador, sem necessidade de executar o deploy manualmente.

O comando principal utilizado para atualizar a aplicação é:

```bash
docker compose up -d --build --remove-orphans
```

Para verificar os containers:

```bash
docker compose ps
```

### Gerenciamento de variáveis de ambiente

O arquivo `.env` não é enviado ao repositório, pois contém configurações sensíveis.

As senhas são armazenadas em **Settings → Secrets and variables → Actions**, utilizando os seguintes nomes:

- `DB_PASSWORD`
- `MYSQL_ROOT_PASSWORD`

Durante o workflow, essas variáveis são utilizadas para gerar o arquivo `.env` necessário à execução do Docker Compose.

## 9. Acesso à aplicação

A aplicação é executada no Ubuntu Server utilizando a porta `8080`.

Como a máquina virtual utiliza rede NAT, foi configurado um redirecionamento de portas no VirtualBox:

| Configuração | Valor |
|---|---|
| Protocolo | TCP |
| Endereço do hospedeiro | 127.0.0.1 |
| Porta do hospedeiro | 8081 |
| Porta do convidado | 8080 |

**Endereço de acesso pelo computador hospedeiro:**

http://localhost:8081

Esse endereço funciona no Windows que hospeda a máquina virtual, desde que a VM e os containers estejam em execução.

**Observação:** `localhost` não representa um endereço público. Portanto, o acesso por esse endereço não está disponível diretamente em computadores externos.

## 10. Teste e validação do deploy

Para validar a automação, foi realizada uma alteração diretamente no código-fonte pelo GitHub.

O teste seguiu estas etapas:

1. A aplicação foi acessada pelo navegador em `http://localhost:8081`.
2. O arquivo `app/src/index.php` foi alterado no repositório GitHub.
3. A alteração foi salva em um novo commit na branch `main`, identificado pela mensagem **"Título novo"**.
4. O GitHub Actions iniciou automaticamente uma nova execução do workflow.
5. O Runner self-hosted recebeu e executou o trabalho.
6. O deploy foi concluído com sucesso em aproximadamente **51 segundos**.
7. Após atualizar o navegador, foi possível confirmar a presença do novo título da página.

O título atualizado, contendo **"VERSÃO 2 MUITO FODA SUPER SAIYAJIN 3"**, foi confirmado por meio da inspeção do HTML exibido no navegador.

Esse teste demonstrou que as alterações realizadas no repositório são implantadas automaticamente na aplicação hospedada na máquina virtual, sem a necessidade de acessar o Ubuntu para executar comandos de atualização.

## 11. Como executar o projeto localmente

Para executar a aplicação em um computador com Docker e Docker Compose instalados:

**1. Clonar o repositório:**

```bash
git clone https://github.com/DaniloAugustoMaia/crud-alunos-devops.git
cd crud-alunos-devops
```

**2. Criar o arquivo de ambiente:**

```bash
cp .env.example .env
```

Editar o arquivo `.env` e definir as variáveis necessárias, incluindo as senhas do banco de dados.

**3. Iniciar os containers:**

```bash
docker compose up -d --build
```

**4. Verificar os serviços:**

```bash
docker compose ps
```

**5. Acessar a aplicação:**

Utilizar `http://localhost:8080` quando `APP_PORT=8080` estiver definido no arquivo `.env`.

Para interromper os containers:

```bash
docker compose down
```

## 12. Considerações finais

A atividade permitiu integrar conceitos de desenvolvimento web, bancos de dados, virtualização, containers, versionamento de código e integração e entrega contínuas (CI/CD).

O resultado foi uma aplicação CRUD funcional, hospedada em uma máquina virtual Ubuntu Server e atualizada automaticamente pelo GitHub Actions.

A validação prática demonstrou que um commit realizado no GitHub foi suficiente para acionar o Runner, reconstruir os containers e disponibilizar a nova versão da aplicação no navegador.

**Resultado:** deploy automático implementado e validado com sucesso.
