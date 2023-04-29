## Installation
Projeto requer Docker e Docker Composer para sua execução em sua máquina linux ou via WSL2 para Windows/Mac.
Inicializando o serviço

```sh
cd testes-e-dto
cp .env.example .env
./vendor/bin/sail up -d 
./vendor/bin/sail artisan migrate
```

Um container será criado para execução da aplicação, o acesso será feito pela porta padrão 80 (localhost)
Caso tenha problemas para executar a aplicação checar a utilização das portas ou executar o comando abaixo. 
```sh
docker system prune
```