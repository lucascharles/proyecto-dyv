USE [sistemadv]
GO 

CREATE TABLE [dbo].[Gastos_Receptor_Ficha](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[id_gasto] [int] NULL,
	[id_receptor] [int] NULL,
	[id_ficha] [int] NULL,
	[importe] [decimal](10, 2) NULL
) ON [PRIMARY]