SET session_replication_role = 'replica';

DROP TABLE IF EXISTS "user";
CREATE TABLE "user" (
  "id" SERIAL PRIMARY KEY,
  "name" VARCHAR(32) NOT NULL,
  "password" VARCHAR(32) NOT NULL,
  "created_at" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updated_at" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE UNIQUE INDEX "unique_name" ON "user" ("name");
CREATE INDEX "name_idx" ON "user" ("name", "password");

DROP TABLE IF EXISTS "page";
CREATE TABLE "page" (
  "id" SERIAL PRIMARY KEY,
  "titel" VARCHAR(127) NOT NULL,
  "description" VARCHAR(255) NOT NULL,
  "content" TEXT NOT NULL,
  "author" VARCHAR(127) NOT NULL,
  "created" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updated" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS "todo";
CREATE TABLE "todo" (
  "id" SERIAL PRIMARY KEY,
  "user_id" INT NOT NULL,
  "type_id" INT NOT NULL,
  "title" VARCHAR(64) NOT NULL,
  "description" VARCHAR(255) DEFAULT '',
  "completed" BOOLEAN DEFAULT FALSE,
  "created_at" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updated_at" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY ("user_id") REFERENCES "user" ("id") ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY ("type_id") REFERENCES "todo_type" ("id") ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE INDEX "fk_todo_user_idx" ON "todo" ("user_id");
CREATE INDEX "fk_todo_type_idx" ON "todo" ("type_id");

DROP TABLE IF EXISTS "todo_type";
CREATE TABLE "todo_type" (
  "id" SERIAL PRIMARY KEY,
  "name" VARCHAR(64) NOT NULL,
  "created_at" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updated_at" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

SET session_replication_role = 'origin';
