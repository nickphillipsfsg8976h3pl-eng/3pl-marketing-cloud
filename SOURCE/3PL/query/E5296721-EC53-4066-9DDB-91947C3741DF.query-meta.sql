SELECT DISTINCT
    cms.SubscriberKey AS ContactKey,
    l.FirstName,
    cms.EmailAddress as Email
FROM [CampaignMemberExclusion_BAU_Issue_Sent] cms
LEFT JOIN ENT.Lead_Salesforce l 
    ON l.id = cms.SubscriberKey
