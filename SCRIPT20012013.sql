CREATE TABLE [dbo].[Contacto_Mandantes_Tmp](
	[id_contacto] [int] IDENTITY(1,1) NOT NULL,
	[id_mandante] [int] NULL,
	[contacto] [varchar](300) COLLATE Modern_Spanish_CI_AS NULL,
	[email] [varchar](200) COLLATE Modern_Spanish_CI_AS NULL,
	[celular] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[telefono] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[fax] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[observacion] [varchar](500) COLLATE Modern_Spanish_CI_AS NULL,
	[id_sesion] [varchar](150) COLLATE Modern_Spanish_CI_AS NULL
) ON [PRIMARY]

CREATE TABLE [dbo].[ModoPago](
	[id_modo_pago] [int] NOT NULL,
	[modo_pago] [varchar](150) COLLATE Modern_Spanish_CI_AS NULL,
	[activo] [char](1) COLLATE Modern_Spanish_CI_AS NULL
) ON [PRIMARY]

CREATE TABLE [dbo].[Contacto_Mandantes](
	[id_contacto] [int] IDENTITY(1,1) NOT NULL,
	[id_mandante] [int] NULL,
	[contacto] [varchar](300) COLLATE Modern_Spanish_CI_AS NULL,
	[email] [varchar](200) COLLATE Modern_Spanish_CI_AS NULL,
	[celular] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[telefono] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[fax] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[observacion] [varchar](500) COLLATE Modern_Spanish_CI_AS NULL
) ON [PRIMARY]

CREATE TABLE [dbo].[LogError](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[id_usuario] [varchar](15) COLLATE Modern_Spanish_CI_AS NULL,
	[fecha_hora] [datetime] NULL
) ON [PRIMARY]

CREATE TABLE [dbo].[Det_LogError_CargaMasiva](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[id_logerror] [int] NULL,
	[id_tipo_error] [int] NULL,
	[archivo] [varchar](200) COLLATE Modern_Spanish_CI_AS NULL,
	[fila] [int] NULL
) ON [PRIMARY]

insert into ModoPago (modo_pago, activo) values ('Recuperado','S')
insert into ModoPago (modo_pago, activo) values ('Castigado','S')
insert into ModoPago (modo_pago, activo) values ('Demanda','S')
insert into ModoPago (modo_pago, activo) values ('Demanda recuperado','S')
insert into ModoPago (modo_pago, activo) values ('Demanda castigado','S')
insert into ModoPago (modo_pago, activo) values ('Recuperado por Mandante','S')
insert into ModoPago (modo_pago, activo) values ('Normalizacion','N')