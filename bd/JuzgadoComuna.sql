USE [sistemadv]

CREATE TABLE [dbo].[JuzgadoComuna](
	[id_juzgado_comuna] [int] IDENTITY(1,1) NOT NULL,
	[descripcion] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[activo] [char](1) COLLATE Modern_Spanish_CI_AS NULL
) ON [PRIMARY];


INSERT INTO [sistemadv].[dbo].[JuzgadoComuna] ([descripcion]) VALUES ('La moneda','S'); 
INSERT INTO [sistemadv].[dbo].[JuzgadoComuna] ([descripcion]) VALUES ('Providencia','S'); 
