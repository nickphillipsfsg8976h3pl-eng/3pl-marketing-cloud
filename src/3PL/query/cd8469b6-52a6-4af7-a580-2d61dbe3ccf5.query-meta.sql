SELECT 
[CampaignMember:Common:Id] as ContactID,
[CampaignMember:Id] as CBId,
[CampaignMember:Country] as MailingCountry,
[CampaignMember:Common:FirstName] as FirstName,
[CampaignMember:Common:Email] as Email,
[CampaignMember:Common:Title] as JobTitle
FROM [MXB2C_MX0001_GLOBAL-ENTRYSOURCE - 2020-08-20T1850349111651296479056]
WHERE [CampaignMember:Common:Email] IS NOT NULL