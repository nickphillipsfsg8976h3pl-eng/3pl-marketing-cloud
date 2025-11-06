SELECT

cws.LeadOrContactId as ContactKey,
cws.Email as Email,
cws.CampaignId as CampaignId

FROM ENT.[CampaignMember_Salesforce] cws
WHERE cws.CampaignId ='701Mp00000PxjM6IAJ' OR cws.CampaignId ='701Mp00000SkNI5IAN'