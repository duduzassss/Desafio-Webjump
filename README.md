# Desafio Webjump

## Documentação sobre tecnologias, versões e soluções adotadas

Este projeto foi desenvolvido utilizando o **_PHP_** na versão **8** para a parte do backend, utilizando
também o composer para instalação de dependências. Neste caso o composer também foi utilizado para
configurar o **_autoload PSR-4_**.

Neste projeto separei o backend do frontend, utilizando o diretório *app* para o backend e o **_public_** para os arquivos de frontend.
A parte dos templates **_Views_** do frontend foi criado utilizando a classe **_Utils\View_**, onde é definido o tipo de extensão dos arquivos de views junto com o formato de variáveis que será usado nos arquivos, o formato que adotei foi **_{{variable}}_**

Para o banco de dados utilizei o **_MySQL__**, para persistência dos dados da aplicação. Você pode encontrar o script para importar o banco no diretório root do projeto, chamado **_createdb.sql_**.

Quanto a parte de **_libraries/componentes_** utilizados, foi apenas um componente do PHP, chamado **_Monolog_**, para facilitar a geração dos logs das ações. Estes logs gerador pelas ações do CRUD, ficam localizados na raiz do projeto em **_logs/logs.txt_**.

Utilizado **_MVC_** para estabelecer a responsabilidade de cada parte do código (Model, View, Controller), assim foi arquitetado este desafio, separando a parte backend do CRUD, nos **_Models e Controllers_**, criando as classes e métodos necessários para serem **_renderizados nas Views_**.
Foi criado o CRUD de **_Categorias e Produtos_**, onde as categorias exigem o preenchimento dos campos nome e código para criar/editar. Já para a parte de exclusão de uma categoria, irá depender se ela não se encontra em um registro de produto, caso ela estiver registrada em um produto, irá apenas retornar a página de categorias e um novo log será gerado. 

Já o cadastro/edição de Produtos, é necessário o preenchimento de todos os campos do formulário, com excessão da feature opcional, o cadastro de imagens, que na criação de um produto é requerido, mas ao editar, poderá ser enviado vazio o input file, caso seja de interesse manter a mesma imagem do produto.
Ao excluir um produto, a mesma ação será realizada na tabela de relacionamentos (products_has_categories), identificando o id do produto a ser deletado, após isso, o produto será deletado de sua tabela (products).  





## Como utilizar

1. Crie uma pasta para o projeto dentro do seu servidor. No meu caso utilizei o **_XAMPP_**, com a versão do **_PHP 8_**;

2. Clonar o repositório dentro da pasta do seu servidor, que você acabou de criar.
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