USE [sistemadv]
GO
CREATE TABLE [dbo].[OpcionPermisoTmp](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[id_opcionmenu] [int] NULL,
	[id_sesion] [varchar](150) COLLATE Modern_Spanish_CI_AS NULL
) ON [PRIMARY]

