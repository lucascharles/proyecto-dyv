USE [sistemadv]

CREATE TABLE [dbo].[Juzgado](
	[id_juzgado] [int] IDENTITY(1,1) NOT NULL,
	[descripcion] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[activo] [char](1) COLLATE Modern_Spanish_CI_AS NULL
) ON [PRIMARY]


INSERT INTO [sistemadv].[dbo].[Juzgado] ([descripcion]) VALUES ('Juzgado Nro 12','S'); 
INSERT INTO [sistemadv].[dbo].[Juzgado] ([descripcion]) VALUES ('Juzgado Nro 26','S'); 
