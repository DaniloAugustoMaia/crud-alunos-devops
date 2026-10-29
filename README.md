# CRUD de Alunos — Deploy automático

## Integrantes
- [NOME COMPLETO DO INTEGRANTE 1]
- [NOME COMPLETO DO INTEGRANTE 2]

## Descrição
CRUD de alunos com cadastro, listagem, edição e exclusão. Tecnologias: PHP 8.2, Apache, MySQL 8, Docker Compose, Ubuntu Server e GitHub Actions.

## Executar
1. Instale Docker Engine e o plugin Docker Compose.
2. Copie `.env.example` para `.env` e defina senhas fortes.
3. Execute `docker compose up -d --build` na pasta do projeto.
4. Acesse `http://localhost:8080` (ou `http://IP_DA_VM:8080`).

O banco usa volume persistente. O script `database/init.sql` é executado apenas na primeira inicialização do volume.

## Runner e deploy
O Runner self-hosted é instalado na VM Ubuntu e registrado em **Settings → Actions → Runners** do repositório. Ele recebe trabalhos do GitHub Actions. Quando ocorre um push na branch `main`, o workflow `.github/workflows/deploy.yml` faz checkout da versão mais recente e executa `docker compose up -d --build --remove-orphans` na VM. O usuário do Runner precisa de acesso ao Docker e o diretório de trabalho precisa conter um `.env` válido. O arquivo `.env` não deve ser enviado ao GitHub.

**Importante:** não use Runner self-hosted para executar código de contribuidores não confiáveis. Para o laboratório, use repositório privado e limite quem pode enviar alterações.

## Acesso no laboratório
- IP da VM: [PREENCHER]
- Porta: 8080 (TCP)
- Endereço: `http://[IP_DA_VM]:8080`

## Demonstração
1. Abra a aplicação no navegador.
2. Mostre o Runner online no GitHub.
3. Altere o título da página `app/src/index.php`.
4. Faça commit e push na branch main.
5. Mostre a Action concluída e recarregue o navegador para confirmar a alteração.
