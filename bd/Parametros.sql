use sistemadv

CREATE TABLE [dbo].[Parametros](
	[id_parametro] [int] NOT NULL,
	[nombre_parametro] [varchar](50) NOT NULL,
	[valor_parametro] [varchar](50) NOT NULL
) ON [PRIMARY]


INSERT INTO Parametros (id_parametro,nombre_parametro,valor_parametro)VALUES(1,'interes_diario_normal','2,5');
INSERT INTO Parametros (id_parametro,nombre_parametro,valor_parametro)VALUES(2,'interes_diario_dyv','3,2');
INSERT INTO Parametros (id_parametro,nombre_parametro,valor_parametro)VALUES(3,'valor_uf','22370');