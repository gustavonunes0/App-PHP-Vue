<h2>Passo a Passo para Rodar a Aplicação</h2>

<h3>1. Pré-requisitos</h3>
<ul>
    <li><strong>PHP</strong>: Verifique se você tem o PHP (versão 8.1 ou superior) instalado.</li>
    <li><strong>Composer</strong>: Certifique-se de que o Composer está instalado.</li>
    <li><strong>Node.js e NPM</strong>: Você precisará do Node.js (versão 14 ou superior) e do NPM instalados para gerenciar pacotes do front-end.</li>
    <li><strong>MySQL</strong>: Instale e configure o MySQL no seu sistema.</li>
</ul>

<h3>2. Clonar o Repositório</h3>
<p>Se você ainda não fez isso, clone o repositório da sua aplicação:</p>
<pre><code>git clone &lt;URL_DO_REPOSITORIO&gt;
cd &lt;NOME_DA_PASTA&gt;</code></pre>

<h3>3. Configuração do Back-end (Laravel)</h3>

<ol>
    <li><strong>Instalar Dependências do Laravel</strong>: Navegue até a pasta do back-end e instale as dependências do Laravel com o Composer:
        <pre><code>cd back-end
composer install</code></pre>
    </li>

    <li><strong>Configuração do Banco de Dados</strong>:
        <ul>
            <li>Renomeie o arquivo <code>.env.example</code> para <code>.env</code>.</li>
            <li>Abra o arquivo <code>.env</code> e configure as variáveis do banco de dados:
                <pre><code>DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seu_banco_de_dados
DB_USERNAME=root
DB_PASSWORD=sua_senha</code></pre>
            </li>
        </ul>
    </li>

    <li><strong>Gerar a Chave da Aplicação</strong>: Execute o seguinte comando para gerar uma chave para sua aplicação:
        <pre><code>php artisan key:generate</code></pre>
    </li>

    <li><strong>Migrar o Banco de Dados</strong>: Se você tiver migrations, execute o comando para criar as tabelas no banco de dados:
        <pre><code>php artisan migrate</code></pre>
    </li>

    <li><strong>Rodar o Servidor</strong>: Inicie o servidor embutido do Laravel:
        <pre><code>php artisan serve</code></pre>
        O Laravel estará disponível em <code>http://127.0.0.1:8000</code>.
    </li>
</ol>

<h3>4. Configuração do Front-end (Vue.js)</h3>

<ol>
    <li><strong>Navegar até a Pasta do Front-end</strong>: Volte para a pasta principal da sua aplicação e depois para a pasta do front-end:
        <pre><code>cd ../front-end</code></pre>
    </li>

    <li><strong>Instalar Dependências do Vue.js</strong>: Instale as dependências usando o NPM:
        <pre><code>npm install</code></pre>
    </li>

    <li><strong>Rodar o Servidor de Desenvolvimento</strong>: Inicie o servidor de desenvolvimento do Vue.js:
        <pre><code>npm run serve</code></pre>
        O Vue.js estará disponível em <code>http://localhost:8080</code>.
    </li>
</ol>

<h3>5. Testar a Aplicação</h3>
<ul>
    <li>Abra seu navegador e acesse <code>http://localhost:8080</code> para ver a aplicação Vue.js em execução.</li>
</ul>

<p>Com esses passos, sua aplicação deve estar pronta para uso. Sinta-se à vontade para ajustar ou adicionar qualquer informação que você considere relevante na documentação!</p>
