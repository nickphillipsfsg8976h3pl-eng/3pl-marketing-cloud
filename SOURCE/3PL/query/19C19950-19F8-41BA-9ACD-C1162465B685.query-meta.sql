SELECT

cws.Id as CmId,
cws.LeadOrContactId as ContactKey,
cws.Email as Email,
cws.CampaignId as CampaignId,
cws.Country as Country,
cws.FirstName as [First Name],
t.Region as Territory

FROM ENT.[CampaignMember_Salesforce] cws
LEFT JOIN [Country_Region_Mapping] t ON cws.Country = t.Country
WHERE 
    cws.CampaignId ='701Mp00000Z5D8aIAF' AND
    cws.CreatedDate >= DATEADD(d,-3,GETDATE()) AND
    t.Region = 'EMEA' 
    
