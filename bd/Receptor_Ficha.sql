USE [sistemadv]
GO 

CREATE TABLE [dbo].[Receptor_Ficha](
	[id_receptor] [int] NULL,
	[id_ficha] [int] NULL,
	[fecha_mandamiento] [datetime] NULL,
	[receptor] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[busqueda] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[notificacion] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[fecha_domicilio] [datetime] NULL,
	[fecha_domicilio_1] [datetime] NULL,
	[entrega_receptor_1] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[entrega_receptor_2] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[entrega_receptor_3] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[entrega_receptor_4] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[notificacion_2] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[notificacion_3] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[fecha_embargo_fp] [datetime] NULL,
	[fecha_oficio] [datetime] NULL,
	[fecha_traba_emb] [datetime] NULL,
	[fono_receptor] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[resultado_busqueda] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[resultado_notificacion_1] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[resultado_notificacion_2] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[resultado_notificacion_3] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[providencia_1] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[providencia_2] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[providencia_3] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[fecha_busqueda_2] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[busqueda_3] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[embargo] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[articulo_431044] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL
) ON [PRIMARY]	