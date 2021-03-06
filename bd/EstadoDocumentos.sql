
CREATE TABLE [dbo].[EstadoDocumentos](
	[id_estado_doc] [numeric](10, 0) NOT NULL,
	[estado] [nvarchar](50) COLLATE Modern_Spanish_CI_AS NULL,
	[activo] [char](1) COLLATE Modern_Spanish_CI_AS NULL,
 CONSTRAINT [PK_EstadoDocumentos] PRIMARY KEY CLUSTERED 
(
	[id_estado_doc] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]

