USE [sistemadv]
GO 

CREATE TABLE [dbo].[Documento_Ficha](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[id_ficha] [int] NULL,
	[id_documento] [int] NULL
) ON [PRIMARY]