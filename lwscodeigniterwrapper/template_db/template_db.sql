


------------------------
--
-- Berikut adalah template table-table yang digunakan oleh CI wrapper
-- sebelum mengeksekusi SQL query dibawah ini yg harus dilakukan adalah
--		1. Kopi semua script ini ke lembar baru (Anda tidak berhak untuk merubah script dibawah ini)
--		   Karena ketika perubahan script dilakukan akan mempengaruhi struktur kode pada Aplikasi
--
-- 		2. Ganti nama schema sc_fcstprsn, sesuaikan dengan nama schema yang anda gunakan
--		3. Pastikan basis data anda adalah Postgre SQL
--
--
-------------------------

CREATE OR REPLACE FUNCTION sc_fcstprsn.tru_update_date()
  RETURNS trigger AS
$BODY$
    BEGIN
NEW.modified_date := now();
        RETURN NEW;
    END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;


CREATE TABLE sc_fcstprsn.backbone_modul
(
  id_modul serial NOT NULL,
  nama_modul character varying(300),
  deskripsi_modul text,
  turunan_dari text,
  no_urut integer,
  created_date timestamp without time zone DEFAULT now(),
  created_by character varying(200),
  modified_date timestamp without time zone,
  modified_by character varying(200),
  record_active smallint DEFAULT 1,
  show_on_menu smallint DEFAULT 1,
  CONSTRAINT pk_backbone_modul PRIMARY KEY (id_modul)
)
WITH (
  OIDS=FALSE
);

-- Trigger: tru_backbone_modul on sc_fcstprsn.backbone_modul

-- DROP TRIGGER tru_backbone_modul ON sc_fcstprsn.backbone_modul;

CREATE TRIGGER tru_backbone_modul
  BEFORE UPDATE
  ON sc_fcstprsn.backbone_modul
  FOR EACH ROW
  EXECUTE PROCEDURE sc_fcstprsn.tru_update_date();

  
CREATE TABLE sc_fcstprsn.backbone_user
(
  id_user serial NOT NULL,
  username character varying(60),
  password character varying(60),
  last_login timestamp without time zone,
  last_ip character varying(25),
  created_date timestamp without time zone DEFAULT now(),
  created_by character varying(200),
  modified_date timestamp without time zone,
  modified_by character varying(200),
  record_active smallint DEFAULT 1,
  CONSTRAINT pk_backbone_user PRIMARY KEY (id_user)
)
WITH (
  OIDS=FALSE
);

-- Trigger: tru_backbone_user on sc_fcstprsn.backbone_user

-- DROP TRIGGER tru_backbone_user ON sc_fcstprsn.backbone_user;

CREATE TRIGGER tru_backbone_user
  BEFORE UPDATE
  ON sc_fcstprsn.backbone_user
  FOR EACH ROW
  EXECUTE PROCEDURE sc_fcstprsn.tru_update_date();


CREATE TABLE sc_fcstprsn.backbone_role
(
  id_role serial NOT NULL,
  nama_role character varying(100),
  is_public_role smallint,
  created_date timestamp without time zone DEFAULT now(),
  created_by character varying(200),
  modified_date timestamp without time zone,
  modified_by character varying(200),
  record_active smallint DEFAULT 1,
  CONSTRAINT pk_backbone_role PRIMARY KEY (id_role)
)
WITH (
  OIDS=FALSE
);

-- Trigger: tru_backbone_role on sc_fcstprsn.backbone_role

-- DROP TRIGGER tru_backbone_role ON sc_fcstprsn.backbone_role;

CREATE TRIGGER tru_backbone_role
  BEFORE UPDATE
  ON sc_fcstprsn.backbone_role
  FOR EACH ROW
  EXECUTE PROCEDURE sc_fcstprsn.tru_update_date();


CREATE TABLE sc_fcstprsn.backbone_modul_role
(
  id_module_role serial NOT NULL,
  id_role integer,
  id_modul integer,
  is_read smallint,
  is_write smallint,
  is_delete smallint,
  is_update smallint,
  created_date timestamp without time zone DEFAULT now(),
  created_by character varying(200),
  modified_date timestamp without time zone,
  modified_by character varying(200),
  record_active smallint DEFAULT 1,
  CONSTRAINT pk_backbone_module_role PRIMARY KEY (id_module_role),
  CONSTRAINT fk_backbone_modul_role_backbone_modul FOREIGN KEY (id_modul)
      REFERENCES sc_fcstprsn.backbone_modul (id_modul) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_backbone_modul_role_backbone_role FOREIGN KEY (id_role)
      REFERENCES sc_fcstprsn.backbone_role (id_role) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);

-- Trigger: tru_backbone_modul_role on sc_fcstprsn.backbone_modul_role

-- DROP TRIGGER tru_backbone_modul_role ON sc_fcstprsn.backbone_modul_role;

CREATE TRIGGER tru_backbone_modul_role
  BEFORE UPDATE
  ON sc_fcstprsn.backbone_modul_role
  FOR EACH ROW
  EXECUTE PROCEDURE sc_fcstprsn.tru_update_date();


CREATE TABLE sc_fcstprsn.backbone_profil
(
  id_profil serial NOT NULL,
  id_user integer, -- backbone_user
  nama_profil character varying(200),
  email_profil character varying(100),
  created_date timestamp without time zone DEFAULT now(),
  created_by character varying(200),
  modified_date timestamp without time zone,
  modified_by character varying(200),
  record_active smallint DEFAULT 1,
  CONSTRAINT pk_backbone_profil PRIMARY KEY (id_profil),
  CONSTRAINT fk_backbone_profil_backbone_user FOREIGN KEY (id_user)
      REFERENCES sc_fcstprsn.backbone_user (id_user) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
COMMENT ON COLUMN sc_fcstprsn.backbone_profil.id_user IS 'backbone_user';


-- Trigger: tru_backbone_profil on sc_fcstprsn.backbone_profil

-- DROP TRIGGER tru_backbone_profil ON sc_fcstprsn.backbone_profil;

CREATE TRIGGER tru_backbone_profil
  BEFORE UPDATE
  ON sc_fcstprsn.backbone_profil
  FOR EACH ROW
  EXECUTE PROCEDURE sc_fcstprsn.tru_update_date();


CREATE TABLE sc_fcstprsn.backbone_user_role
(
  id_user_role serial NOT NULL,
  id_user integer,
  id_role integer,
  created_date timestamp without time zone DEFAULT now(),
  created_by character varying(200),
  modified_date timestamp without time zone,
  modified_by character varying(200),
  record_active smallint DEFAULT 1,
  CONSTRAINT pk_backbone_user_role PRIMARY KEY (id_user_role),
  CONSTRAINT fk_backbone_user_role_backbone_role FOREIGN KEY (id_role)
      REFERENCES sc_fcstprsn.backbone_role (id_role) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_backbone_user_role_backbone_user FOREIGN KEY (id_user)
      REFERENCES sc_fcstprsn.backbone_user (id_user) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);

-- Trigger: tru_backbone_user_role on sc_fcstprsn.backbone_user_role

-- DROP TRIGGER tru_backbone_user_role ON sc_fcstprsn.backbone_user_role;

CREATE TRIGGER tru_backbone_user_role
  BEFORE UPDATE
  ON sc_fcstprsn.backbone_user_role
  FOR EACH ROW
  EXECUTE PROCEDURE sc_fcstprsn.tru_update_date();



----------------------------------------------------
--
--	FUNCTION TEMPLATE, PLEASE DO NOT REWRITE THIS CODE WITHOUT CONFIRMATION
--
----------------------------------------------------
CREATE OR REPLACE FUNCTION sc_fcstprsn.fn_crypt_match(
    i_string_id character varying,
    i_match_string character varying)
  RETURNS boolean AS
$BODY$
DECLARE

 is_match boolean;
 comparison_crypt text;
 comparison_string text;
 make_key text;

BEGIN

is_match = 0;
IF i_match_string != '' THEN

make_key = split_part(i_match_string, '_', 2);
comparison_crypt = split_part(i_match_string, '_', 1);
IF make_key != '' AND comparison_crypt != '' THEN

 comparison_string = md5(make_key || i_string_id);

 IF comparison_string = comparison_crypt THEN
	is_match = 1;
 END IF;
  
END IF;


END IF;

return is_match;
    
END ;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
  
-- Function: sc_fcstprsn.fn_generate_crypt(character varying)

-- DROP FUNCTION sc_fcstprsn.fn_generate_crypt(character varying);

CREATE OR REPLACE FUNCTION sc_fcstprsn.fn_generate_crypt(i_string character varying)
  RETURNS text AS
$BODY$
DECLARE

 input_string text;
 output_string text;
 salt CHARACTER VARYING[61];
 make_key text;

BEGIN

input_string = trim(both ' ' from i_string);
output_string = '';
IF input_string != '' THEN

select fn_generate_key from sc_fcstprsn.fn_generate_key(18) into make_key;
output_string = md5(make_key || input_string) || '_' || make_key;
END IF;

return output_string;
    
END ;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- Function: sc_fcstprsn.fn_generate_crypt(integer)

-- DROP FUNCTION sc_fcstprsn.fn_generate_crypt(integer);

CREATE OR REPLACE FUNCTION sc_fcstprsn.fn_generate_crypt(i_integer integer)
  RETURNS text AS
$BODY$
DECLARE
output_string text;
BEGIN

select fn_generate_crypt from sc_fcstprsn.fn_generate_crypt(coalesce(i_integer, 0)::character varying) into output_string;

return output_string;
    
END ;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- Function: sc_fcstprsn.fn_generate_key(integer)

-- DROP FUNCTION sc_fcstprsn.fn_generate_key(integer);

CREATE OR REPLACE FUNCTION sc_fcstprsn.fn_generate_key(length integer)
  RETURNS text AS
$BODY$
DECLARE

 text_salt text;
 salt CHARACTER VARYING[61];
 make_key text;

BEGIN

salt[0] = 'a';
salt[1] = 'b';
salt[2] = 'c';
salt[3] = 'd';
salt[4] = 'e';
salt[5] = 'f';
salt[6] = 'g';
salt[7] = 'h';
salt[8] = 'i';
salt[9] = 'j';
salt[10] = 'k';
salt[11] = 'l';
salt[12] = 'm';
salt[13] = 'n';
salt[14] = 'o';
salt[15] = 'p';
salt[16] = 'q';
salt[17] = 'r';
salt[18] = 's';
salt[19] = 't';
salt[20] = 'u';
salt[21] = 'v';
salt[22] = 'w';
salt[23] = 'x';
salt[24] = 'y';
salt[25] = 'z';
salt[26] = 'A';
salt[27] = 'B';
salt[28] = 'C';
salt[29] = 'D';
salt[30] = 'E';
salt[31] = 'F';
salt[32] = 'G';
salt[33] = 'H';
salt[34] = 'I';
salt[35] = 'J';
salt[36] = 'K';
salt[37] = 'L';
salt[38] = 'M';
salt[39] = 'N';
salt[40] = 'O';
salt[41] = 'P';
salt[42] = 'Q';
salt[43] = 'R';
salt[44] = 'S';
salt[45] = 'T';
salt[46] = 'U';
salt[47] = 'V';
salt[48] = 'W';
salt[49] = 'X';
salt[50] = 'Y';
salt[51] = 'Z';
salt[52] = '0';
salt[53] = '1';
salt[54] = '2';
salt[55] = '3';
salt[56] = '4';
salt[57] = '5';
salt[58] = '6';
salt[59] = '7';
salt[60] = '8';
salt[61] = '9';

make_key = '';

FOR i in 1..length LOOP

make_key = make_key || salt[floor(random()*(61-0)+0)];

END LOOP;

RETURN make_key;

END ;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

  
-- Function: sc_fcstprsn.fnselectmodulaccessrulebymodulnameandrolename(character varying, integer)

-- DROP FUNCTION sc_fcstprsn.fnselectmodulaccessrulebymodulnameandrolename(character varying, integer);

CREATE OR REPLACE FUNCTION sc_fcstprsn.fnselectmodulaccessrulebymodulnameandrolename(
    IN i_modul_name character varying,
    IN i_id_user integer)
  RETURNS TABLE(id_module_role integer, is_read integer, is_write integer, is_delete integer, is_update integer, nama_modul text, deskripsi_modul text, nama_role text, username text, nama_profil text) AS
$BODY$
DECLARE
BEGIN
  
 -- laksanakan query
 RETURN QUERY
select
		coalesce(sc_fcstprsn.backbone_modul_role.id_module_role,0),
		coalesce(sc_fcstprsn.backbone_modul_role.is_read,0),
		coalesce(sc_fcstprsn.backbone_modul_role.is_write,0),
		coalesce(sc_fcstprsn.backbone_modul_role.is_delete,0),
		coalesce(sc_fcstprsn.backbone_modul_role.is_update,0),
		coalesce(sc_fcstprsn.backbone_modul.nama_modul,'-')::text,
		coalesce(sc_fcstprsn.backbone_modul.deskripsi_modul,'-')::text,
		coalesce(sc_fcstprsn.backbone_role.nama_role,'-')::text,
		coalesce(sc_fcstprsn.backbone_user.username,'-')::text,
		coalesce(sc_fcstprsn.ref_pegawai.nama_sambung,'-')::text as nama_profil
	   from sc_fcstprsn.backbone_modul_role
	   join sc_fcstprsn.backbone_modul on sc_fcstprsn.backbone_modul.id_modul = sc_fcstprsn.backbone_modul_role.id_modul and sc_fcstprsn.backbone_modul.record_active = '1'
	   join sc_fcstprsn.backbone_role on sc_fcstprsn.backbone_role.id_role = sc_fcstprsn.backbone_modul_role.id_role and sc_fcstprsn.backbone_role.record_active = '1'
	   join sc_fcstprsn.backbone_user_role on sc_fcstprsn.backbone_user_role.id_role = sc_fcstprsn.backbone_role.id_role and sc_fcstprsn.backbone_user_role.record_active = '1'
	   join sc_fcstprsn.backbone_user on sc_fcstprsn.backbone_user.id_user = sc_fcstprsn.backbone_user_role.id_user and sc_fcstprsn.backbone_user.id_user = i_id_user
	   join sc_fcstprsn.ref_pegawai on sc_fcstprsn.ref_pegawai.id_user = sc_fcstprsn.backbone_user.id_user and sc_fcstprsn.ref_pegawai.id_user = i_id_user
 where sc_fcstprsn.backbone_modul.nama_modul = i_modul_name and sc_fcstprsn.backbone_modul_role.record_active = '1';
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;


  
CREATE OR REPLACE VIEW sc_fcstprsn.v_user AS 
 SELECT backbone_user.id_user,
    backbone_user.username,
    backbone_user.record_active,
    backbone_profil.id_profil,
    backbone_profil.nama_profil,
    backbone_profil.email_profil
   FROM sc_fcstprsn.backbone_user
     JOIN sc_fcstprsn.backbone_profil ON backbone_profil.id_user = backbone_user.id_user;
