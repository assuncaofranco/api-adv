#!/bin/bash

# Passo 1: Limpar o cache (para garantir que o Symfony não use dados antigos)
echo "Limpeza do cache..."
php bin/console cache:clear --env=dev --no-warmup
php bin/console cache:clear --env=prod --no-warmup

# Passo 2: Dropar o banco de dados, se existir
echo "Dropar o banco de dados, se existir..."
php bin/console doctrine:database:drop --if-exists --force --env=dev
php bin/console doctrine:database:drop --if-exists --force --env=prod

# Passo 3: Criar o banco de dados, se não existir
echo "Criar o banco de dados, se não existir..."
php bin/console doctrine:database:create --if-not-exists --env=dev
php bin/console doctrine:database:create --if-not-exists --env=prod

# Passo 4: Atualizar o esquema (criação de tabelas e atualização do banco de dados)
echo "Atualizando esquema (criação de tabelas)..."
php bin/console doctrine:schema:update --force --env=dev
php bin/console doctrine:schema:update --force --env=prod

# # Passo 5: Rodar as migrações (caso esteja usando migrações do Doctrine)
# echo "Rodando migrações..."
# php bin/console doctrine:migrations:migrate --no-interaction --env=dev
# php bin/console doctrine:migrations:migrate --no-interaction --env=prod

# Fim
echo "Instalação completa!"
