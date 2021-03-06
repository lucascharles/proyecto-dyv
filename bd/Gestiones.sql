USE [sistemadv]
GO

CREATE TABLE Gestiones (
  [id_gestion] [int] NOT NULL,
  [id_deudor] [int] NOT NULL,
  [id_mandante] [int] NOT NULL,
  [fecha_gestion] [datetime] NOT NULL,
  [nota_gestion] [varchar](200) COLLATE Modern_Spanish_CI_AS NOT NULL,
  [fecha_prox_gestion] [datetime] NOT NULL,
  [activo] [varchar](1) NOT NULL,
  [usuario_modificacion] [varchar](50) COLLATE Modern_Spanish_CI_AS NOT NULL,
  [fecha_modificacion] [datetime] NOT NULL,
  [usuario_creacion] [varchar](50) COLLATE Modern_Spanish_CI_AS NOT NULL,
  [fecha_creacion] [datetime] NOT NULL,
  [estado] [varchar](1) NOT NULL
) 