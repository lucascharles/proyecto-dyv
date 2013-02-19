USE [sistemadv]
GO 

CREATE TABLE [dbo].[Martillero_Ficha](
	[id_martillero] [int] IDENTITY(1,1) NOT NULL,
	[id_ficha] [int] NULL,
	[aceptacion_cargo] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[nombre] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[rut_martilero] [int] NULL,
	[dv_martillero] [int] NULL,
	[notificacion] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[retirio_especies_fp] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[providencia] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[entrega_receptor] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[retiro_especies] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[oposicion_retiro] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[fecha_remate] [datetime] NULL
) ON [PRIMARY]
