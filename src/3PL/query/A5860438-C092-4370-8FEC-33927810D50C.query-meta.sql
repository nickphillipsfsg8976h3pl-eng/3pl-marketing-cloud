SELECT
cm.Id,
cm.FirstName,
cm.Email,
cm.CampaignId,
cm.LeadOrContactId,
c.Name,
cm.CreatedDate,
cm.CreatedById

FROM ENT.CampaignMember_Salesforce cm
INNER JOIN ENT.Campaign_Salesforce c ON c.Id=cm.CampaignId
WHERE cm.CreatedById ='0052y000002getUAAQ'
