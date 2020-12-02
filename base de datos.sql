-- Database: money

-- DROP DATABASE money;

CREATE DATABASE money
    WITH 
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'Spanish_Latin America.1252'
    LC_CTYPE = 'Spanish_Latin America.1252'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1;						
-- Table: public.categoria

-- DROP TABLE public.categoria;

CREATE TABLE public.categoria
(
    id bigint NOT NULL DEFAULT nextval('categoria_id_seq'::regclass),
    categoria_padre character varying(255) COLLATE pg_catalog."default" NOT NULL,
    tipo integer NOT NULL,
    descripcion character varying(255) COLLATE pg_catalog."default" NOT NULL,
    presupuesto double precision NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    usuario_id integer,
    CONSTRAINT categoria_pkey PRIMARY KEY (id),
    CONSTRAINT fk_categoria_usuario FOREIGN KEY (usuario_id)
        REFERENCES public.users (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_tipo_categoria FOREIGN KEY (tipo)
        REFERENCES public.tipo_categoria (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.categoria
    OWNER to postgres;
-- Table: public.cuenta

-- DROP TABLE public.cuenta;

CREATE TABLE public.cuenta
(
    id bigint NOT NULL DEFAULT nextval('cuenta_id_seq'::regclass),
    moneda integer NOT NULL,
    nombre_corto character varying(255) COLLATE pg_catalog."default" NOT NULL,
    descripcion character varying(255) COLLATE pg_catalog."default" NOT NULL,
    saldo_inicial double precision NOT NULL,
    usuario_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT cuenta_pkey PRIMARY KEY (id),
    CONSTRAINT fk_cuenta_moneda FOREIGN KEY (moneda)
        REFERENCES public.moneda (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_cuenta_usuario FOREIGN KEY (usuario_id)
        REFERENCES public.users (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.cuenta
    OWNER to postgres;

-- Table: public.cuentas

-- DROP TABLE public.cuentas;

CREATE TABLE public.cuentas
(
    id bigint NOT NULL DEFAULT nextval('cuentas_id_seq'::regclass),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT cuentas_pkey PRIMARY KEY (id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.cuentas
    OWNER to postgres;

-- Table: public.cuentas_compartidas

-- DROP TABLE public.cuentas_compartidas;

CREATE TABLE public.cuentas_compartidas
(
    id bigint NOT NULL DEFAULT nextval('cuentas_compartidas_id_seq'::regclass),
    cuenta_id integer NOT NULL,
    usuario_a_compartir_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT cuentas_compartidas_pkey PRIMARY KEY (id),
    CONSTRAINT fk_cuentas_compartidas_usuario FOREIGN KEY (cuenta_id)
        REFERENCES public.cuenta (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_usuario_compartidas_usuario FOREIGN KEY (usuario_a_compartir_id)
        REFERENCES public.users (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.cuentas_compartidas
    OWNER to postgres;

-- Table: public.moneda

-- DROP TABLE public.moneda;

CREATE TABLE public.moneda
(
    id bigint NOT NULL DEFAULT nextval('moneda_id_seq'::regclass),
    nombre_corto character varying(255) COLLATE pg_catalog."default" NOT NULL,
    simbolo character varying(255) COLLATE pg_catalog."default" NOT NULL,
    descripcion character varying(255) COLLATE pg_catalog."default" NOT NULL,
    tasa double precision NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    usuario_id bigint NOT NULL,
    nacional boolean DEFAULT false,
    CONSTRAINT moneda_pkey PRIMARY KEY (id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.moneda
    OWNER to postgres;

-- Table: public.subcategoria

-- DROP TABLE public.subcategoria;

CREATE TABLE public.subcategoria
(
    id bigint NOT NULL DEFAULT nextval('subcategoria_id_seq'::regclass),
    categoria_id integer NOT NULL,
    detalle character varying(255) COLLATE pg_catalog."default" NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    nombre character varying COLLATE pg_catalog."default",
    presupuesto numeric(8,2),
    CONSTRAINT subcategoria_pkey PRIMARY KEY (id),
    CONSTRAINT fk_subcategoria FOREIGN KEY (categoria_id)
        REFERENCES public.categoria (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.subcategoria
    OWNER to postgres;

-- Table: public.tasa

-- DROP TABLE public.tasa;

CREATE TABLE public.tasa
(
    id bigint NOT NULL DEFAULT nextval('tasa_id_seq'::regclass),
    moneda_local integer NOT NULL,
    monto_local double precision NOT NULL,
    moneda_equivalente integer NOT NULL,
    monto_equivalente double precision NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT tasa_pkey PRIMARY KEY (id),
    CONSTRAINT fk_moneda_equivalente FOREIGN KEY (moneda_equivalente)
        REFERENCES public.moneda (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_moneda_local FOREIGN KEY (moneda_local)
        REFERENCES public.moneda (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.tasa
    OWNER to postgres;

-- Table: public.tipo_categoria

-- DROP TABLE public.tipo_categoria;

CREATE TABLE public.tipo_categoria
(
    id bigint NOT NULL DEFAULT nextval('tipo_categoria_id_seq'::regclass),
    tipo character varying(255) COLLATE pg_catalog."default" NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT tipo_categoria_pkey PRIMARY KEY (id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.tipo_categoria
    OWNER to postgres;
-- Table: public.tipo_transaccion

-- DROP TABLE public.tipo_transaccion;

CREATE TABLE public.tipo_transaccion
(
    id bigint NOT NULL DEFAULT nextval('tipo_transaccion_id_seq'::regclass),
    tipo character varying(255) COLLATE pg_catalog."default" NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT tipo_transaccion_pkey PRIMARY KEY (id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.tipo_transaccion
    OWNER to postgres;

-- Table: public.transaccion

-- DROP TABLE public.transaccion;

CREATE TABLE public.transaccion
(
    id integer NOT NULL DEFAULT nextval('transaccion_id_seq'::regclass),
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    cuenta integer,
    monto numeric(8,2),
    detalle text COLLATE pg_catalog."default",
    categoria integer,
    CONSTRAINT transaccion_pkey PRIMARY KEY (id),
    CONSTRAINT fk_transaccion_categoria FOREIGN KEY (categoria)
        REFERENCES public.categoria (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_transaccion_cuenta FOREIGN KEY (cuenta)
        REFERENCES public.cuenta (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.transaccion
    OWNER to postgres;

-- Table: public.traslado

-- DROP TABLE public.traslado;

CREATE TABLE public.traslado
(
    id bigint NOT NULL DEFAULT nextval('traslado_id_seq'::regclass),
    cuenta_debito integer NOT NULL,
    monto_debitado double precision NOT NULL,
    cuenta_credito integer NOT NULL,
    monto_acreditado double precision NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    transaccion integer,
    CONSTRAINT traslado_pkey PRIMARY KEY (id),
    CONSTRAINT fk_tran FOREIGN KEY (transaccion)
        REFERENCES public.transaccion (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_traslado_cuenta FOREIGN KEY (cuenta_credito)
        REFERENCES public.cuenta (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.traslado
    OWNER to postgres;

-- Table: public.users

-- DROP TABLE public.users;

CREATE TABLE public.users
(
    id bigint NOT NULL DEFAULT nextval('users_id_seq'::regclass),
    name character varying(255) COLLATE pg_catalog."default" NOT NULL,
    email character varying(255) COLLATE pg_catalog."default" NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) COLLATE pg_catalog."default" NOT NULL,
    remember_token character varying(100) COLLATE pg_catalog."default",
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT users_pkey PRIMARY KEY (id),
    CONSTRAINT users_email_unique UNIQUE (email)

)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.users
    OWNER to postgres;

INSERT INTO moneda(nombre_corto, simbolo, descripcion, tasa, usuario_id)
VALUES ('Colón','₡','Moneda local de Costa Rica',10,1);
INSERT INTO moneda(nombre_corto, simbolo, descripcion, tasa, usuario_id)
VALUES ('Dolar estadounidense','$','Moneda estadounidense',611,1);

INSERT INTO users(name,email,password)
VALUES ('Alexamith','samir@gmail.com','123');

INSERT INTO cuenta(moneda, nombre_corto,descripcion,saldo_inicial,usuario_id)
VALUES (1,'Cuenta BCR ahorros','Guardo todas las propinas',1000000,1);
INSERT INTO cuenta(moneda, nombre_corto,descripcion,saldo_inicial,usuario_id)
VALUES (2,'Cuenta BAC trabajo','Guardo el salario',570932,1);

INSERT INTO tipo_categoria(tipo)
VALUES ('Gastos');
INSERT INTO tipo_categoria(tipo)
VALUES ('Ingresos');

INSERT INTO categoria(categoria_padre, tipo,descripcion,presupuesto)
VALUES ('Alimentacion',1,'Comprar comida al mes',55000);
INSERT INTO categoria(categoria_padre, tipo,descripcion,presupuesto)
VALUES ('Trabajo',2,'Sueldo',830500);

INSERT INTO tipo_transaccion(tipo)
VALUES ('Gastos');
INSERT INTO tipo_transaccion(tipo)
VALUES ('Ingresos');
INSERT INTO tipo_transaccion(tipo)
VALUES ('Traslados');

INSERT INTO transaccion(tipo, created_at,cuenta,monto)
VALUES (1,current_date,1,5000);
alter table cuenta
add constraint fk_cuenta_moneda
foreign key (moneda)
references moneda (id)
on update cascade
on delete cascade;

alter table cuenta
add constraint fk_cuenta_usuario
foreign key (usuario_id)
references users (id);

Categoria
alter table categoria
add constraint fk_tipo_categoria
foreign key (tipo)
references tipo_categoria (id);

alter table categoria
add constraint fk_categoria_usuario
foreign key (usuario_id)
references users (id)
on update cascade
on delete cascade;


Transaccion
alter table transaccion
add constraint fk_tipo_transaccion
foreign key (tipo)
references tipo_transaccion (id);

alter table transaccion
add constraint fk_transaccion_cuenta
foreign key (cuenta)
references cuenta (id)
on update cascade
on delete cascade;

alter table transaccion
add constraint fk_transaccion_categoria
foreign key (categoria)
references categoria (id)
on update cascade
on delete cascade;

alter table cuentas_compartidas
add constraint fk_usuario_compartidas_usuario
foreign key (usuario_a_compartir_id)
references users (id)
on update cascade
on delete cascade;


alter table cuentas_compartidas
add constraint fk_cuentas_compartidas_usuario
foreign key (cuenta_id)
references cuenta (id)
on update cascade
on delete cascade;

alter table subcategoria
add constraint fk_subcategoria
foreign key (categoria_id)
references categoria (id)
on update cascade
on delete cascade;


--------------------------------------------------------

alter table tasa
add constraint fk_moneda_local
foreign key (moneda_local)
references moneda (id)
on update cascade
on delete cascade;

alter table tasa
add constraint fk_moneda_equivalente
foreign key (moneda_equivalente)
references moneda (id)
on update cascade
on delete cascade;



























