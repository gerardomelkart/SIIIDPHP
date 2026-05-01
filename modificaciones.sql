ALTER TABLE tbl_admin_config
ADD COLUMN hab_modulo_desaparecidos TINYINT(1) NOT NULL DEFAULT 1
COMMENT 'Habilita módulo de desaparecidos';

ALTER TABLE tbl_admin_config
ADD COLUMN hab_modulo_actualizacion_desaparecidos TINYINT(1) NOT NULL DEFAULT 1
COMMENT 'Habilita módulo de Actualizacion de desaparecidos';