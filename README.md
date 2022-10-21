# Desafio Webjump

## Como utilizar

1. Crie uma pasta para o projeto dentro do seu servidor. No meu caso utilizei o **_XAMPP_**, com a versão do **_PHP 8_**;

2. Clonar o repositório dentro da pasta do seu servidor
> git clone https://github.com/duduzassss/Desafio-Webjump.git .

3. Acessar o mysql e utilizar o arquivo **_createdb.sql_** para criação do banco de dados e das tabelas;

4. Renomear o arquivo **_.env.example_** para **_.env_**;

5. 
    * Dentro do arquivo **_.env_**, atualizar as informações de configurações de banco de dados de acordo com a configuração do seu ambiente local. 
    
    * Também alterar a URL base do projeto caso necessário;

    * Caso você optou por utilizar Virtual Host para alterar a url deste projeto, você também poderá utilizar no parâmetro "URL";

6. Depois de configurado o banco de dados, poderá ser aberto o terminal, e rodar o comando
> composer install

se neste passo obtiver sucesso, irá ser criado um diretório **_vendor_** na raiz do projeto;

7. Após isso você poderá acessar a url que foi configurada no **_.env_** e visualizar a aplicação;