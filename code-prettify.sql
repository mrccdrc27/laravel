USE [CS-System]
GO

/****** Object:  Table [dbo].[issuer_information]    Script Date: 1/23/2025 1:50:46 AM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[issuer_information](
	[issuerID] [bigint] IDENTITY(1,1) NOT NULL,
	[firstName] [nvarchar](50) NOT NULL,
	[middleName] [nvarchar](50) NULL,
	[lastName] [nvarchar](50) NOT NULL,
	[issuerSignature] [varbinary](max) NOT NULL,
	[organizationID] [bigint] NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[issuerID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO

ALTER TABLE [dbo].[issuer_information]  WITH CHECK ADD  CONSTRAINT [issuer_information_organizationid_foreign] FOREIGN KEY([organizationID])
REFERENCES [dbo].[organization] ([organizationID])
GO

ALTER TABLE [dbo].[issuer_information] CHECK CONSTRAINT [issuer_information_organizationid_foreign]
GO


