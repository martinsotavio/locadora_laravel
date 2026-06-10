PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;

CREATE TABLE IF NOT EXISTS "migrations" ("id" integer primary key autoincrement not null, "migration" varchar not null, "batch" integer not null);
CREATE TABLE sqlite_sequence(name,seq);
CREATE TABLE IF NOT EXISTS "password_reset_tokens" ("email" varchar not null, "token" varchar not null, "created_at" datetime, primary key ("email"));
CREATE TABLE IF NOT EXISTS "sessions" ("id" varchar not null, "user_id" integer, "ip_address" varchar, "user_agent" text, "payload" text not null, "last_activity" integer not null, primary key ("id"));
CREATE INDEX IF NOT EXISTS "sessions_user_id_index" on "sessions" ("user_id");
CREATE INDEX IF NOT EXISTS "sessions_last_activity_index" on "sessions" ("last_activity");
CREATE TABLE IF NOT EXISTS "cache" ("key" varchar not null, "value" text not null, "expiration" integer not null, primary key ("key"));
CREATE INDEX IF NOT EXISTS "cache_expiration_index" on "cache" ("expiration");
CREATE TABLE IF NOT EXISTS "cache_locks" ("key" varchar not null, "owner" varchar not null, "expiration" integer not null, primary key ("key"));
CREATE INDEX IF NOT EXISTS "cache_locks_expiration_index" on "cache_locks" ("expiration");
CREATE TABLE IF NOT EXISTS "jobs" ("id" integer primary key autoincrement not null, "queue" varchar not null, "payload" text not null, "attempts" integer not null, "reserved_at" integer, "available_at" integer not null, "created_at" integer not null);
CREATE INDEX IF NOT EXISTS "jobs_queue_index" on "jobs" ("queue");
CREATE TABLE IF NOT EXISTS "job_batches" ("id" varchar not null, "name" varchar not null, "total_jobs" integer not null, "pending_jobs" integer not null, "failed_jobs" integer not null, "failed_job_ids" text not null, "options" text, "cancelled_at" integer, "created_at" integer not null, "finished_at" integer, primary key ("id"));
CREATE TABLE IF NOT EXISTS "failed_jobs" ("id" integer primary key autoincrement not null, "uuid" varchar not null, "connection" text not null, "queue" text not null, "payload" text not null, "exception" text not null, "failed_at" datetime not null default CURRENT_TIMESTAMP);
CREATE UNIQUE INDEX IF NOT EXISTS "failed_jobs_uuid_unique" on "failed_jobs" ("uuid");
CREATE TABLE IF NOT EXISTS "teams" ("id" integer primary key autoincrement not null, "name" varchar not null, "slug" varchar not null, "is_personal" tinyint(1) not null default '0', "created_at" datetime, "updated_at" datetime, "deleted_at" datetime);
CREATE UNIQUE INDEX IF NOT EXISTS "teams_slug_unique" on "teams" ("slug");
CREATE TABLE IF NOT EXISTS "team_members" ("id" integer primary key autoincrement not null, "team_id" integer not null, "user_id" integer not null, "role" varchar not null, "created_at" datetime, "updated_at" datetime, foreign key("team_id") references "teams"("id") on delete cascade, foreign key("user_id") references "users"("id") on delete cascade);
CREATE UNIQUE INDEX IF NOT EXISTS "team_members_team_id_user_id_unique" on "team_members" ("team_id", "user_id");
CREATE TABLE IF NOT EXISTS "team_invitations" ("id" integer primary key autoincrement not null, "code" varchar not null, "team_id" integer not null, "email" varchar not null, "role" varchar not null, "invited_by" integer not null, "expires_at" datetime, "accepted_at" datetime, "created_at" datetime, "updated_at" datetime, foreign key("team_id") references "teams"("id") on delete cascade, foreign key("invited_by") references "users"("id") on delete cascade);
CREATE UNIQUE INDEX IF NOT EXISTS "team_invitations_code_unique" on "team_invitations" ("code");
CREATE TABLE IF NOT EXISTS "users" ("id" integer primary key autoincrement not null, "name" varchar not null, "email" varchar not null, "email_verified_at" datetime, "password" varchar not null, "remember_token" varchar, "created_at" datetime, "updated_at" datetime, "two_factor_secret" text, "two_factor_recovery_codes" text, "two_factor_confirmed_at" datetime, "current_team_id" integer, foreign key("current_team_id") references "teams"("id") on delete set null);
CREATE UNIQUE INDEX IF NOT EXISTS "users_email_unique" on "users" ("email");
CREATE TABLE IF NOT EXISTS "clientes" ("id" integer primary key autoincrement not null, "nome" varchar not null, "cpf" varchar not null, "telefone" varchar, "email" varchar, "created_at" datetime, "updated_at" datetime);
CREATE UNIQUE INDEX IF NOT EXISTS "clientes_cpf_unique" on "clientes" ("cpf");
CREATE TABLE IF NOT EXISTS "funcionarios" ("id" integer primary key autoincrement not null, "nome" varchar not null, "cpf" varchar not null, "telefone" varchar, "email" varchar, "cargo" varchar, "created_at" datetime, "updated_at" datetime);
CREATE UNIQUE INDEX IF NOT EXISTS "funcionarios_cpf_unique" on "funcionarios" ("cpf");
CREATE TABLE IF NOT EXISTS "locacoes" ("id" integer primary key autoincrement not null, "cliente_id" integer not null, "funcionario_id" integer not null, "data_inicio" date not null, "data_fim" date not null, "dias" integer not null, "valor_diaria" numeric not null, "valor_total" numeric not null, "comissao_percent" numeric not null default '18', "valor_comissao" numeric not null, "status" varchar not null default 'ativa', "created_at" datetime, "updated_at" datetime, foreign key("cliente_id") references "clientes"("id") on delete cascade, foreign key("funcionario_id") references "funcionarios"("id") on delete cascade);
CREATE TABLE IF NOT EXISTS "comissoes" ("id" integer primary key autoincrement not null, "locacao_id" integer not null, "funcionario_id" integer not null, "valor" numeric not null, "created_at" datetime, "updated_at" datetime, foreign key("locacao_id") references "locacoes"("id") on delete cascade, foreign key("funcionario_id") references "funcionarios"("id") on delete cascade);

-- New table: carros (primary key = placa)
CREATE TABLE IF NOT EXISTS "carros" (
    "placa" varchar NOT NULL,
    "modelo" varchar,
    "marca" varchar,
    "ano" integer,
    "cor" varchar,
    "valor_diaria" numeric,
    "disponivel" tinyint(1) NOT NULL DEFAULT 1,
    "created_at" datetime,
    "updated_at" datetime,
    PRIMARY KEY ("placa")
);

COMMIT;
PRAGMA foreign_keys=ON;
