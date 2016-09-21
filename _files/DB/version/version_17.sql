/************ Remove Foreign Keys ***************/

ALTER TABLE employee DROP CONSTRAINT fk_employee_person;

ALTER TABLE person DROP CONSTRAINT fk_person_ciudad;

ALTER TABLE sale_control DROP CONSTRAINT fk_customer_person;

ALTER TABLE sale_control DROP CONSTRAINT fk_sale_control_employee;

ALTER TABLE "user" DROP CONSTRAINT fk_user_person;



/************ Update: Tables ***************/

/******************** Add Table: alumno ************************/

/* Build Table Structure */
CREATE TABLE alumno
(
	id NUMERIC(20, 0) NOT NULL,
	id_person NUMERIC(20, 0) NOT NULL,
	registration_date TIMESTAMP NOT NULL,
	estado SMALLINT NOT NULL,
	estado_date TIMESTAMP NOT NULL
);

/* Add Primary Key */
ALTER TABLE alumno ADD CONSTRAINT pkalumno
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "alumno_id_Idx" ON alumno (id);

CREATE INDEX "alumno_id_person_Idx" ON alumno (id_person);


/******************** Rebuild Table: sale_control ************************
Reasons:
Column: update_date
	Data type changed.
	Server Column: update_date, DT=TimeStamp, L=, COM=, N=true, AN=false, DF=, SC=, SI=true, EN=, ARR=false.
	Design Column: estado_date, DT=DateTime, L=, COM=, N=true, AN=false, DF=, SC=, SI=true, EN=, ARR=false.
*****************************************************************************/

/* Rename: sale_control */
ALTER TABLE sale_control RENAME TO sale_control_old;

/* Build Table Structure */
CREATE TABLE control_venta
(
	id NUMERIC(20, 0) NOT NULL,
	id_alumno NUMERIC(20, 0) NOT NULL,
	registration_date TIMESTAMP NOT NULL,
	estado VARCHAR(50) NOT NULL,
	id_employee NUMERIC(20, 0) NOT NULL,
	estado_date TIMESTAMP NULL,
	id_sede NUMERIC(20, 0) NOT NULL,
	id_curso_capacitacion NUMERIC(20, 0) NOT NULL,
	promocion_curso VARCHAR(20) NULL
) WITHOUT OIDS;

/* Repopulate Table Data */
INSERT INTO control_venta
	 (id, registration_date, estado, id_employee, id_alumno, estado_date)
SELECT id, registration_date, estado, id_employee, id_person, update_date
FROM sale_control_old;

/* Remove Temp Table */
DROP TABLE sale_control_old CASCADE;

/* Add Primary Key */
ALTER TABLE control_venta ADD CONSTRAINT pkcontrol_venta
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "control_venta_id_Idx" ON control_venta USING btree (id);

CREATE UNIQUE INDEX "control_venta_id_alumno_Idx" ON control_venta (id_alumno);

CREATE INDEX "control_venta_id_curso_capacitacion_Idx" ON control_venta (id_curso_capacitacion);

CREATE INDEX "control_venta_id_employee_Idx" ON control_venta USING btree (id_employee);


/******************** Add Table: curso_capacitacion ************************/

/* Build Table Structure */
CREATE TABLE curso_capacitacion
(
	id NUMERIC(20, 0) NOT NULL,
	name VARCHAR(100) NOT NULL,
	name_key VARCHAR(50) NOT NULL,
	"isActive" SMALLINT NOT NULL
);

/* Add Primary Key */
ALTER TABLE curso_capacitacion ADD CONSTRAINT pkcurso_capacitacion
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "curso_capacitacion_id_Idx" ON curso_capacitacion (id);

CREATE UNIQUE INDEX "curso_capacitacion_name_Idx" ON curso_capacitacion (name);

CREATE UNIQUE INDEX "curso_capacitacion_name_key_Idx" ON curso_capacitacion (name_key);


/******************** Add Table: curso_capacitacion__sede ************************/

/* Build Table Structure */
CREATE TABLE curso_capacitacion__sede
(
	id NUMERIC(20, 0) NOT NULL,
	id_curso_capacitacion NUMERIC(20, 0) NOT NULL,
	id_sede NUMERIC(20, 0) NOT NULL
);

/* Add Primary Key */
ALTER TABLE curso_capacitacion__sede ADD CONSTRAINT pkcurso_capacitacion__sede
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "curso_capacitacion__sede_id_Idx" ON curso_capacitacion__sede (id);

CREATE INDEX "curso_capacitacion__sede_id_curso_capacitacion_Idx" ON curso_capacitacion__sede (id_curso_capacitacion);

CREATE INDEX "curso_capacitacion__sede_id_sede_Idx" ON curso_capacitacion__sede (id_sede);


/******************** Rebuild Table: person ************************
Reasons:
Column: email
	Data type length changed.
	Server Column: email, DT=VarChar, L=100, COM=, N=false, AN=false, DF=, SC=, SI=true, EN=, ARR=false.
	Design Column: email, DT=VarChar, L=80, COM=, N=true, AN=false, DF=, SC=, SI=true, EN=, ARR=false.
*****************************************************************************/

/* Rename: person */
ALTER TABLE person RENAME TO person_old;

/* Build Table Structure */
CREATE TABLE person
(
	id NUMERIC(20, 0) NOT NULL,
	name VARCHAR(100) NOT NULL,
	surname VARCHAR(100) NOT NULL,
	tipo_documento VARCHAR(50) NOT NULL,
	document VARCHAR(20) NOT NULL,
	birthday DATE NOT NULL,
	gender VARCHAR(50) NOT NULL,
	estado_civil VARCHAR(50) NOT NULL,
	email VARCHAR(80) NULL,
	nivel_academico VARCHAR(50) NULL,
	discapacidad VARCHAR(50) NULL,
	id_ciudad NUMERIC(20, 0) NULL,
	calle_principal VARCHAR(500) NULL,
	calle_secundaria VARCHAR(500) NULL,
	referencia_domicilio VARCHAR(500) NULL,
	num_casa VARCHAR(20) NULL,
	telefono_casa VARCHAR(20) NULL,
	telefono_trabajo VARCHAR(20) NULL,
	telefono_cell_1 VARCHAR(20) NULL,
	telefono_cell_2 VARCHAR(20) NULL,
	email_trabajo VARCHAR(80) NULL,
	email_alterno VARCHAR(80) NULL,
	ref_1_surname_name VARCHAR(200) NULL,
	ref_1_direccion VARCHAR(500) NULL,
	ref_1_tlfo_fijo_cell VARCHAR(50) NULL,
	ref_1_parentesco VARCHAR(100) NULL,
	ref_2_surname_name VARCHAR(200) NULL,
	ref_2_direccion VARCHAR(500) NULL,
	ref_2_tlfo_fijo_cell VARCHAR(50) NULL,
	ref_2_parentesco VARCHAR(100) NULL
) WITHOUT OIDS;

/* Repopulate Table Data */
INSERT INTO person
	 (id, name, surname, tipo_documento, document, birthday, gender, email, estado_civil, id_ciudad)
SELECT id, name, surname, tipo_documento, document, birthday, gender, email, estado_civil, id_ciudad
FROM person_old;

/* Remove Temp Table */
DROP TABLE person_old CASCADE;

/* Add Primary Key */
ALTER TABLE person ADD CONSTRAINT pkperson
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "person_document_Idx" ON person USING btree (document);

CREATE INDEX "person_id_Idx" ON person USING btree (id);

CREATE INDEX "person_surname_Idx" ON person USING btree (surname);


/******************** Add Table: sede ************************/

/* Build Table Structure */
CREATE TABLE sede
(
	id NUMERIC(20, 0) NOT NULL,
	name VARCHAR(100) NOT NULL,
	direccion VARCHAR(250) NULL,
	"isActive" SMALLINT NOT NULL,
	id_departament NUMERIC(20, 0) NOT NULL
);

/* Add Primary Key */
ALTER TABLE sede ADD CONSTRAINT pksede
	PRIMARY KEY (id);

/* Add Comments */
COMMENT ON TABLE sede IS 'sedes a nivel nacional';

/* Add Indexes */
CREATE INDEX "sede_id_Idx" ON sede (id);

CREATE INDEX "sede_id_departament_Idx" ON sede (id_departament);

CREATE INDEX "sede_name_Idx" ON sede (name);





/************ Add Foreign Keys ***************/

/* Add Foreign Key: fk_alumno_person */
ALTER TABLE alumno ADD CONSTRAINT fk_alumno_person
	FOREIGN KEY (id_person) REFERENCES person (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_control_venta_alumno */
ALTER TABLE control_venta ADD CONSTRAINT fk_control_venta_alumno
	FOREIGN KEY (id_alumno) REFERENCES alumno (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_control_venta_curso_capacitacion */
ALTER TABLE control_venta ADD CONSTRAINT fk_control_venta_curso_capacitacion
	FOREIGN KEY (id_curso_capacitacion) REFERENCES curso_capacitacion (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_control_venta_employee */
ALTER TABLE control_venta ADD CONSTRAINT fk_control_venta_employee
	FOREIGN KEY (id_employee) REFERENCES employee (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_curso_capacitacion__sede_curso_capacitacion */
ALTER TABLE curso_capacitacion__sede ADD CONSTRAINT fk_curso_capacitacion__sede_curso_capacitacion
	FOREIGN KEY (id_curso_capacitacion) REFERENCES curso_capacitacion (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_curso_capacitacion__sede_sede */
ALTER TABLE curso_capacitacion__sede ADD CONSTRAINT fk_curso_capacitacion__sede_sede
	FOREIGN KEY (id_sede) REFERENCES sede (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_employee_person */
ALTER TABLE employee ADD CONSTRAINT fk_employee_person
	FOREIGN KEY (id_person) REFERENCES person (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_sede_departament */
ALTER TABLE sede ADD CONSTRAINT fk_sede_departament
	FOREIGN KEY (id_departament) REFERENCES departament (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_user_person */
ALTER TABLE "user" ADD CONSTRAINT fk_user_person
	FOREIGN KEY (id_person) REFERENCES person (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;
	
	
	
	
/************ Update: Tables ***************/

/******************** Update Table: person ************************/

ALTER TABLE person ADD tipo_sangre VARCHAR(50) NULL;




/************ Remove Foreign Keys ***************/

ALTER TABLE alumno DROP CONSTRAINT fk_alumno_person;

ALTER TABLE control_venta DROP CONSTRAINT fk_control_venta_alumno;



/************ Update: Tables ***************/

/******************** Rebuild Table: alumno ************************
Reasons:
Column: estado
	Data type changed.
	Data type length changed.
	Server Column: estado, DT=SmallInt, L=, COM=, N=false, AN=false, DF=, SC=, SI=true, EN=, ARR=false.
	Design Column: estado, DT=VarChar, L=50, COM=, N=false, AN=false, DF=, SC=, SI=true, EN=, ARR=false.
*****************************************************************************/

/* Rename: alumno */
ALTER TABLE alumno RENAME TO alumno_old;

/* Build Table Structure */
CREATE TABLE alumno
(
	id NUMERIC(20, 0) NOT NULL,
	id_person NUMERIC(20, 0) NOT NULL,
	registration_date TIMESTAMP NOT NULL,
	estado VARCHAR(50) NOT NULL,
	estado_date TIMESTAMP NOT NULL
) WITHOUT OIDS;

/* Repopulate Table Data */
INSERT INTO alumno
	 (id, id_person, registration_date, estado, estado_date)
SELECT id, id_person, registration_date, estado, estado_date
FROM alumno_old;

/* Remove Temp Table */
DROP TABLE alumno_old CASCADE;

/* Add Primary Key */
ALTER TABLE alumno ADD CONSTRAINT pkalumno
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "alumno_id_Idx" ON alumno USING btree (id);

CREATE INDEX "alumno_id_person_Idx" ON alumno USING btree (id_person);


/******************** Update Table: control_venta ************************/

/* Add Indexes */
CREATE INDEX "control_venta_id_sede_Idx" ON control_venta (id_sede);





/************ Add Foreign Keys ***************/

/* Add Foreign Key: fk_alumno_person */
ALTER TABLE alumno ADD CONSTRAINT fk_alumno_person
	FOREIGN KEY (id_person) REFERENCES person (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_control_venta_alumno */
ALTER TABLE control_venta ADD CONSTRAINT fk_control_venta_alumno
	FOREIGN KEY (id_alumno) REFERENCES alumno (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_control_venta_sede */
ALTER TABLE control_venta ADD CONSTRAINT fk_control_venta_sede
	FOREIGN KEY (id_sede) REFERENCES sede (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;