# Desafio Webjump

###### Como utilizar

1. Crie uma pasta para o projeto dentro do seu servidor. No meu caso utilizei o XAMPP, com a versão do PHP 8;

2. Clonar o repositório dentro da pasta do seu servidor;

3. Acessar o mysql e utilizar o arquivo createdb.sql para criação do banco de dados e das tabelas;

4. Renomear o arquivo .env.example para .env;

5. 
    * Dentro do arquivo .env, atualizar as informações de configurações de banco de dados de acordo com a configuração do seu ambiente local. 
    
    * Também alterar a URL base do projeto caso necessário;

    * Caso você optou por utilizar Virtual Host para alterar a url deste projeto, você também poderá utilizar no parâmetro "URL";

6. Depois de configurado o banco de dados, poderá ser aberto o terminal, e rodar o comando "composer install", se neste passo obtiver sucesso, irá ser criado um diretório "vendor" na raiz do projeto;

7. Após isso você poderá acessar a url que foi configurada no .env e visualizar a aplicação;