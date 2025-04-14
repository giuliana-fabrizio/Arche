DROP TABLE If EXISTS associe;
DROP TABLE If EXISTS POST;
DROP TABLE If EXISTS SECTION;
DROP TABLE If EXISTS UE;
DROP TABLE If EXISTS POST_TYPE;
DROP TABLE If EXISTS CATEGORY;
DROP TABLE If EXISTS USERS;
DROP TABLE If EXISTS ROLE;


CREATE TABLE ROLE(
   id SERIAL,
   label VARCHAR(20),
   CONSTRAINT pk_role PRIMARY KEY(id)
);

CREATE TABLE USERS(
   id SERIAL,
   address VARCHAR(50),
   avatar VARCHAR(50),
   email VARCHAR(50),
   firstname VARCHAR(15),
   name VARCHAR(30),
   password VARCHAR(50),
   phone VARCHAR(10),
   id_fk_role INT NOT NULL,
   CONSTRAINT pk_user PRIMARY KEY(id),
   CONSTRAINT fk_user_role FOREIGN KEY(id_fk_role) REFERENCES ROLE(id)
);

CREATE TABLE CATEGORY(
   id SERIAL,
   label VARCHAR(50),
   CONSTRAINT pk_category PRIMARY KEY(id)
);

CREATE TABLE POST_TYPE(
   id SERIAL,
   label VARCHAR(20),
   CONSTRAINT pk_type PRIMARY KEY(id)
);

CREATE TABLE UE(
   code VARCHAR(4),
   label VARCHAR(100),
   photo VARCHAR(50),
   id_fk_user INT NOT NULL,
   id_fk_category INT NOT NULL,
   CONSTRAINT pk_ue PRIMARY KEY(code),
   CONSTRAINT fk_ue_user FOREIGN KEY(id_fk_user) REFERENCES USERS(id),
   CONSTRAINT fk_ue_category FOREIGN KEY(id_fk_category) REFERENCES CATEGORY(id)
);

CREATE TABLE SECTION(
   id SERIAL,
   label VARCHAR(50),
   classement VARCHAR(50),
   id_fk_code VARCHAR(4) NOT NULL,
   CONSTRAINT pk_section PRIMARY KEY(id),
   CONSTRAINT fk_section_ue FOREIGN KEY(id_fk_code) REFERENCES UE(code)
);

CREATE TABLE POST(
   id SERIAL,
   datetime TIMESTAMP,
   description TEXT,
   label VARCHAR(50),
   classement INT,
   filename VARCHAR(50),
   filetype VARCHAR(10),
   id_fk_section INT NOT NULL,
   id_fk_user INT NOT NULL,
   id_fk_post_type INT NOT NULL,
   CONSTRAINT pk_post PRIMARY KEY(id),
   CONSTRAINT fk_post_section FOREIGN KEY(id_fk_section) REFERENCES SECTION(id),
   CONSTRAINT fk_post_user FOREIGN KEY(id_fk_user) REFERENCES USERS(id),
   CONSTRAINT fk_post_post_type FOREIGN KEY(id_fk_post_type) REFERENCES POST_TYPE(id)
);

CREATE TABLE associe(
   id_fk_user INT,
   id_fk_code VARCHAR(4),
   CONSTRAINT pk_associe PRIMARY KEY(id_fk_user, id_fk_code),
   CONSTRAINT fk_associe_user FOREIGN KEY(id_fk_user) REFERENCES USERS(id),
   CONSTRAINT fk_associe_ue FOREIGN KEY(id_fk_code) REFERENCES UE(code)
);
