USE [sistemadv]
GO 
					
CREATE TABLE [dbo].[Gastos_Ficha](
	[id_ficha] [int] NULL,
	[id_gasto] [int] NULL,
	[importe] [decimal](10, 2) NULL
) ON [PRIMARY]