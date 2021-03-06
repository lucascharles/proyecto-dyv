CREATE TABLE [dbo].[CausalProtesta](
	[id_causal] [numeric](10, 0) NOT NULL,
	[causal] [nvarchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[activo] [char](1) COLLATE Modern_Spanish_CI_AS NULL,
 CONSTRAINT [PK_CausalProtesta] PRIMARY KEY CLUSTERED 
(
	[id_causal] ASC
)WITH (PAD_INDEX  = OFF, IGNORE_DUP_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
