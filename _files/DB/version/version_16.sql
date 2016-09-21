/************ Remove Foreign Keys ***************/

ALTER TABLE class_registration DROP CONSTRAINT fk_class_registration_customer;

ALTER TABLE class_registration DROP CONSTRAINT fk_class_registration_employee;

ALTER TABLE class_registration DROP CONSTRAINT fk_class_registration_schedule;

ALTER TABLE control_imc DROP CONSTRAINT fk_control_imc_customer;

ALTER TABLE control_monthly DROP CONSTRAINT fk_control_monthly_customer;

ALTER TABLE detail_invoce DROP CONSTRAINT fk_detail_invoce_head_invoce;

ALTER TABLE detail_invoce DROP CONSTRAINT fk_detail_invoce_product;

ALTER TABLE employee DROP CONSTRAINT fk_employee_person;

ALTER TABLE head_invoce DROP CONSTRAINT fk_head_invoce_customer;

ALTER TABLE head_invoce DROP CONSTRAINT fk_head_invoce_employee;



/************ Update: Tables ***************/

/******************** Remove Table: class_registration ************************/
DROP TABLE class_registration;

/******************** Remove Table: control_imc ************************/
DROP TABLE control_imc;

/******************** Remove Table: control_monthly ************************/
DROP TABLE control_monthly;

/******************** Remove Table: detail_invoce ************************/
DROP TABLE detail_invoce;

/******************** Remove Table: employee ************************/
DROP TABLE employee;

/******************** Remove Table: head_invoce ************************/
DROP TABLE head_invoce;

/******************** Remove Table: product ************************/
DROP TABLE product;

/******************** Remove Table: schedule ************************/
DROP TABLE schedule;


UPDATE "public"."configuration_system"
SET "id" = '1',
 "name_system" = 'Sistema WEB EPUNEMI',
 "logo" = 'resources/uploads/system/logo/1/logo.png',
 "session_time_limit_min" = '600',
 "session_time_limit_max" = '1200',
 "isSaveBinnacle" = '0',
 "name_key_system" = 'EPUNEMI | WebAppEpunemi'
WHERE
	("id" = '1');

/************ Update: Tables ***************/

/******************** Update Table: company_branch ************************/

ALTER TABLE company_branch DROP COLUMN monthly_price;

ALTER TABLE company_branch DROP COLUMN daily_price;








/************ Remove Foreign Keys ***************/

ALTER TABLE customer DROP CONSTRAINT fk_customer_person;



/************ Update: Tables ***************/

/******************** Add Table: departament ************************/

/* Build Table Structure */
CREATE TABLE departament
(
	id NUMERIC(20, 0) NOT NULL,
	description VARCHAR(100) NOT NULL,
	"isActive" SMALLINT NOT NULL,
	director VARCHAR(150) NOT NULL
);

/* Add Primary Key */
ALTER TABLE departament ADD CONSTRAINT pkdepartament
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "departament_id_Idx" ON departament (id);


/******************** Add Table: employee ************************/

/* Build Table Structure */
CREATE TABLE employee
(
	id NUMERIC(20, 0) NOT NULL,
	id_person NUMERIC(20, 0) NOT NULL,
	id_departament NUMERIC(20, 0) NOT NULL,
	"isActive" SMALLINT NOT NULL
);

/* Add Primary Key */
ALTER TABLE employee ADD CONSTRAINT pkemployee
	PRIMARY KEY (id);

/* Add Indexes */
CREATE INDEX "employee_id_Idx" ON employee (id);

CREATE INDEX "employee_id_departament_Idx" ON employee (id_departament);

CREATE INDEX "employee_id_person_Idx" ON employee (id_person);


/******************** Update Table: sale_control ************************/

/* Remove Indexes */
DROP INDEX "customer_code_Idx";

/* Rename: customer */
ALTER TABLE customer RENAME TO sale_control;

ALTER TABLE sale_control DROP COLUMN "code";

/* PostgreSQL does not support adding NOT NULL columns in a single command line. */
ALTER TABLE sale_control ADD COLUMN estado VARCHAR(50);
ALTER TABLE sale_control ALTER COLUMN estado SET NOT NULL;

/* PostgreSQL does not support adding NOT NULL columns in a single command line. */
ALTER TABLE sale_control ADD COLUMN id_employee NUMERIC(20, 0);
ALTER TABLE sale_control ALTER COLUMN id_employee SET NOT NULL;

/* Add Indexes */
CREATE INDEX "sale_control_id_employee_Idx" ON sale_control (id_employee);





/************ Add Foreign Keys ***************/

/* Add Foreign Key: fk_employee_departament */
ALTER TABLE employee ADD CONSTRAINT fk_employee_departament
	FOREIGN KEY (id_departament) REFERENCES departament (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_employee_person */
ALTER TABLE employee ADD CONSTRAINT fk_employee_person
	FOREIGN KEY (id_person) REFERENCES person (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_customer_person */
ALTER TABLE sale_control ADD CONSTRAINT fk_customer_person
	FOREIGN KEY (id_person) REFERENCES person (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;

/* Add Foreign Key: fk_sale_control_employee */
ALTER TABLE sale_control ADD CONSTRAINT fk_sale_control_employee
	FOREIGN KEY (id_employee) REFERENCES employee (id)
	ON UPDATE NO ACTION ON DELETE NO ACTION;
	
	
	
	
/************ Update: Tables ***************/

/******************** Update Table: departament ************************/

/* PostgreSQL does not support adding NOT NULL columns in a single command line. */
ALTER TABLE departament ADD COLUMN description_key VARCHAR(50);
ALTER TABLE departament ALTER COLUMN description_key SET NOT NULL; 














INSERT INTO "public"."departament" ("id", "description", "isActive", "director", "description_key") VALUES ('1', 'Centro de Fortalecimiento de Areas Estrategicas Norte', '1', 'Lcda. Martha Tandazo', 'CFAE NORTE');
INSERT INTO "public"."departament" ("id", "description", "isActive", "director", "description_key") VALUES ('2', 'Centro de Fortalecimiento de Areas Estrategicas SUR', '1', 'Lcda. Patricia Campoverde', 'CFAE SUR');
INSERT INTO "public"."departament" ("id", "description", "isActive", "director", "description_key") VALUES ('3', 'Centro de Fortalecimiento de Areas Estrategicas GUAYAQUIL', '1', 'Lcda.', 'CFAE GUAYAQUIL');



INSERT INTO "public"."employee" ("id", "id_person", "id_departament", "isActive") VALUES ('1', '2', '1', '1');







/************ Update: Tables ***************/

/******************** Update Table: sale_control ************************/

ALTER TABLE sale_control ADD update_date TIMESTAMP NULL;
