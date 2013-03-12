USE [sistemadv]
GO

CREATE TABLE [dbo].[Ficha](
	[id_ficha] [int] IDENTITY(1,1) NOT NULL,
	[id_deudor] [int] NULL,
	[id_mandante] [int] NULL,
	[id_documento] [int] NULL,
	[monto] [decimal](10, 2) NULL,
	[abogado] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[firma] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[ingreso] [datetime] NULL,
	[providencia] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[distribucion_corte] [datetime] NULL,
	[rol] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[id_juzgado] [int] NULL,
	[id_juzgado_comuna] [int] NULL
) ON [PRIMARY]
