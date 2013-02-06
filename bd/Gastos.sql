USE [sistemadv]
GO 		
	
CREATE TABLE [dbo].[Gastos](
	[id_gasto] [int] NULL,
	[gasto] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[rep] [int] NULL,
	[orden] [int] NULL
) ON [PRIMARY]

INSERT INTO [sistemadv].[dbo].[Gastos]([id_gasto],[gasto]) VALUES (1,'Mandamiento',1,2);
INSERT INTO [sistemadv].[dbo].[Gastos]([id_gasto],[gasto]) VALUES (2,'Búsqueda 1',1,3);
INSERT INTO [sistemadv].[dbo].[Gastos]([id_gasto],[gasto]) VALUES (3,'Notificación 1',1,4);
INSERT INTO [sistemadv].[dbo].[Gastos]([id_gasto],[gasto]) VALUES (4,'Búsqueda 2',2,5);
INSERT INTO [sistemadv].[dbo].[Gastos]([id_gasto],[gasto]) VALUES (5,'Notificación 2',2,6);
INSERT INTO [sistemadv].[dbo].[Gastos]([id_gasto],[gasto]) VALUES (6,'Búsqueda 3',3,7);
INSERT INTO [sistemadv].[dbo].[Gastos]([id_gasto],[gasto]) VALUES (7,'Notificación 3',3,8);
INSERT INTO [sistemadv].[dbo].[Gastos]([id_gasto],[gasto]) VALUES (8,'Oficio',1,9);
INSERT INTO [sistemadv].[dbo].[Gastos]([id_gasto],[gasto]) VALUES (9,'Embargo',1,10);
INSERT INTO [sistemadv].[dbo].[Gastos]([id_gasto],[gasto]) VALUES (10,'Retiro',1,11);
INSERT INTO [sistemadv].[dbo].[Gastos]([id_gasto],[gasto]) VALUES (11,'Remate',1,12);
INSERT INTO [sistemadv].[dbo].[Gastos]([id_gasto],[gasto]) VALUES (12,'Martillero',1,13);
INSERT INTO [sistemadv].[dbo].[Gastos]([id_gasto],[gasto]) VALUES (13,'Costas',1,14);
INSERT INTO [sistemadv].[dbo].[Gastos]([id_gasto],[gasto]) VALUES (14,'Protesto',1,1);