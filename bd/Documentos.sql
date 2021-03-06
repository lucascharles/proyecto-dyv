CREATE TABLE [dbo].[Documentos](
	[id_documento] [int] IDENTITY(1,1) NOT NULL,
	[id_estado_doc] [int] NULL,
	[id_tipo_doc] [int] NULL,
	[id_causa_protesto] [int] NULL,
	[id_banco] [int] NULL,
	[id_mandatario] [int] NULL,
	[id_deudor] [int] NULL,
	[numero_documento] [int] NULL,
	[numero_siniestro] [int] NULL,
	[fecha_protesto] [datetime] NULL,
	[fecha_siniestro] [datetime] NULL,
	[monto] [decimal](10, 2) NULL,
	[cta_cte] [varchar](150) COLLATE Modern_Spanish_CI_AS NULL,
	[gastos_protesto] [int] NULL,
	[ns] [int] NULL,
	[fecha_creacion] [datetime] NULL,
	[usuario_creacion] [varchar](15) COLLATE Modern_Spanish_CI_AS NULL,
	[fecha_modificacion] [datetime] NULL,
	[usuario_modificacion] [varchar](15) COLLATE Modern_Spanish_CI_AS NULL,
	[activo] [char](1) COLLATE Modern_Spanish_CI_AS NULL,
 CONSTRAINT [PK_Documentos] PRIMARY KEY CLUSTERED 
(
	[id_documento] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
