USE [sistemadv]
GO

CREATE TABLE [dbo].[Usuario_permisoTmp](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[id_permiso] [int] NULL,
	[id_usuario] [nvarchar](50) COLLATE Modern_Spanish_CI_AS NULL,
	[id_sesion] [varchar](150) COLLATE Modern_Spanish_CI_AS NULL
) ON [PRIMARY]
