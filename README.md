Passo a Passo para Rodar a Aplicação
1. Pré-requisitos
PHP: Verifique se você tem o PHP (versão 8.1 ou superior) instalado.
Composer: Certifique-se de que o Composer está instalado.
Node.js e NPM: Você precisará do Node.js (versão 14 ou superior) e do NPM instalados para gerenciar pacotes do front-end.
MySQL: Instale e configure o MySQL no seu sistema.
2. Clonar o Repositório
Se você ainda não fez isso, clone o repositório da sua aplicação:

bash
Copiar código
git clone <URL_DO_REPOSITORIO>
cd <NOME_DA_PASTA>
3. Configuração do Back-end (Laravel)
Instalar Dependências do Laravel: Navegue até a pasta do back-end e instale as dependências do Laravel com o Composer:

bash
Copiar código
cd back-end
composer install
Configuração do Banco de Dados:

Renomeie o arquivo .env.example para .env.
Abra o arquivo .env e configure as variáveis do banco de dados:
env
Copiar código
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seu_banco_de_dados
DB_USERNAME=root
DB_PASSWORD=sua_senha
Gerar a Chave da Aplicação: Execute o seguinte comando para gerar uma chave para sua aplicação:

bash
Copiar código
php artisan key:generate
Migrar o Banco de Dados: Se você tiver migrations, execute o comando para criar as tabelas no banco de dados:

bash
Copiar código
php artisan migrate
Rodar o Servidor: Inicie o servidor embutido do Laravel:

bash
Copiar código
php artisan serve
O Laravel estará disponível em http://127.0.0.1:8000.

4. Configuração do Front-end (Vue.js)
Navegar até a Pasta do Front-end: Volte para a pasta principal da sua aplicação e depois para a pasta do front-end:

bash
Copiar código
cd ../front-end
Instalar Dependências do Vue.js: Instale as dependências usando o NPM:

bash
Copiar código
npm install
Rodar o Servidor de Desenvolvimento: Inicie o servidor de desenvolvimento do Vue.js:

bash
Copiar código
npm run serve
O Vue.js estará disponível em http://localhost:8080.

5. Testar a Aplicação
Abra seu navegador e acesse http://localhost:8080 para ver a aplicação Vue.js em execução.
