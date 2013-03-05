USE [sistemadv]
GO

CREATE TABLE [dbo].[Estados_x_Gestion](
	[id_gestion] [int] NULL,
	[id_estado] [int] NULL,
	[fecha_gestion] [datetime] NULL,
	[notas] [varchar](250) COLLATE Modern_Spanish_CI_AS NULL,
	[usuario] [varchar](20) COLLATE Modern_Spanish_CI_AS NULL
) ON [PRIMARY]
