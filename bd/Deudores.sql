USE [sistemadv]
GO

CREATE TABLE [dbo].[Deudores](
	[id_deudor] [int] IDENTITY(1,1) NOT NULL,
	[rut_deudor] [numeric](10, 0) NOT NULL,
	[rut_deudor_s] [varchar](50) COLLATE Modern_Spanish_CI_AS NULL,
	[dv_deudor] [char](1) COLLATE Modern_Spanish_CI_AS NOT NULL,
	[primer_nombre] [varchar](50) COLLATE Modern_Spanish_CI_AS NULL,
	[segundo_nombre] [varchar](50) COLLATE Modern_Spanish_CI_AS NOT NULL,
	[primer_apellido] [varchar](50) COLLATE Modern_Spanish_CI_AS NULL,
	[segundo_apellido] [varchar](50) COLLATE Modern_Spanish_CI_AS NULL,
	[comentario] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[celular] [numeric](15, 0) NULL,
	[telefono_fijo] [numeric](15, 0) NULL,
	[fax] [numeric](15, 0) NULL,
	[id_mandante] [numeric](10, 0) NULL,
	[activo] [char](1) COLLATE Modern_Spanish_CI_AS NULL,
	[tipo] [char](2) COLLATE Modern_Spanish_CI_AS NULL,
	[razonsocial] [varchar](300) COLLATE Modern_Spanish_CI_AS NULL,
	[email] [varchar](300) COLLATE Modern_Spanish_CI_AS NULL,
 CONSTRAINT [PK_Deudores] PRIMARY KEY CLUSTERED 
(
	[id_deudor] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]

