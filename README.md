# Locadora de Carros (Laravel)

Sistema web de gerenciamento de uma locadora de carros, desenvolvido em
Laravel. Permite cadastrar clientes, funcionários e carros, registrar
locações e acompanhar comissões dos funcionários.

## Tecnologias

- PHP 8.3+ / Laravel 13
- SQLite (padrão) — configurável via `.env`
- Vite + Tailwind CSS

## Entidades

- **Cliente** — quem aluga o carro.
- **Funcionário** — quem atende a locação (cargos: gerente, locador) e recebe comissão.
- **Carro** — identificado pela placa; possui status `disponivel` ou `locado`.
- **Locação** — vincula cliente, funcionário e carro num período, com cálculo automático de valor total e comissão.
- **Comissão** — gerada automaticamente a cada locação, usada no ranking de funcionários.

## Status

- [x] Paginação nas listagens (clientes, funcionários, carros, locações)
- [x] Comentários em um CRUD completo (Locação: migration, model, controller, views)
- [x] Imagens nos carros (upload, exibição na lista e na edição)
- [x] Regra: carro locado não pode ser locado de novo (carro_id em locações + status disponivel/locado)
- [x] Funcionário com mais comissões recebe bonificação (5%), lista ordenada por comissão decrescente
- [x] Formulário com select estilizado (borda, seta customizada, hover)

## Para rodar depois de puxar essas mudanças

```bash
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan db:seed        # cria o usuário admin e dados de exemplo
php artisan storage:link  # necessário para as imagens dos carros aparecerem
php artisan test          # roda a suíte, incluindo os novos testes de Locação
php artisan serve
```

## Acesso (login de teste)

| Campo  | Valor                |
|--------|-----------------------|
| E-mail | `admin@example.com`  |
| Senha  | `admin`              |

Esse usuário é criado automaticamente pelo `php artisan db:seed`
(ver `database/seeders/DatabaseSeeder.php`).

## Regras de negócio implementadas

- Uma locação está sempre vinculada a um carro (`carro_id`). Enquanto a locação
  estiver **ativa**, o carro fica com status **locado** e não aparece como
  opção para uma nova locação.
- Ao excluir uma locação ativa, ou ao marcá-la como **finalizada** na tela de
  edição, o carro volta a ficar **disponível**.
- Não é possível excluir um carro que já tenha locações associadas.
- O funcionário com maior soma de comissões recebe 5% de bonificação sobre o
  total, exibido na lista de funcionários.
