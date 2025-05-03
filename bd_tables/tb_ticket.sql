CREATE TABLE tb_tickets(
                           id_ticket               INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                           dni_cliente             VARCHAR (255) NULL,
                           nombre_cliente          VARCHAR (255) NULL,
                           placa_cliente          VARCHAR (255) NULL,
                           cargo_cliente          VARCHAR (255) NULL,
                           marca_cliente          VARCHAR (255) NULL,
                           cuviculo                VARCHAR (255) NULL,
                           fecha_ingreso           VARCHAR (255) NULL,
                           hora_ingreso            VARCHAR (255) NULL,
                           estado_ticket            VARCHAR (255) NULL,
                           user_sesion             VARCHAR (255) NULL,

                           fyh_creacion            DATETIME        NULL,
                           fyh_actualizacion       DATETIME        NULL,
                           fyh_eliminacion         DATETIME        NULL,
                           estado                  VARCHAR (10)
);