USE [sistemadv]
GO 
					
CREATE TABLE [dbo].[Consignacion_Ficha](
	[id_consignacion] [int] NULL,
	[id_ficha] [int] NULL,
	[consignacion] [int] NULL,
	[abono_1] [decimal](10, 2) NULL,
	[abono_2] [decimal](10, 2) NULL,
	[abono_3] [decimal](10, 2) NULL,
	[abono_4] [decimal](10, 2) NULL,
	[pago_cliente] [decimal](10, 2) NULL,
	[giro_cheque_1] [decimal](10, 2) NULL,
	[giro_cheque_2] [decimal](10, 2) NULL,
	[entrega_cheque] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[costas_procesales] [decimal](10, 2) NULL,
	[pago_costas] [decimal](10, 2) NULL,
	[entrega_cheque_1] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[devolucion_documento] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[entrega_documento] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[monto_consignacion] [decimal](10, 2) NULL,
	[monto_1] [decimal](10, 2) NULL,
	[monto_2] [decimal](10, 2) NULL,
	[monto_3] [decimal](10, 2) NULL,
	[monto_4] [decimal](10, 2) NULL,
	[pago_dyv] [decimal](10, 2) NULL,
	[providencia_1] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[providencia_2] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[providencia_3] [varchar](100) COLLATE Modern_Spanish_CI_AS NULL,
	[rendicion_cliente] [decimal](10, 2) NULL
) ON [PRIMARY]