SELECT

    cm.Id as CmId,
    cm.LeadOrContactId as ContactKey,
    cm.Email as Email,
    cm.CampaignId as CampaignId,
    cm.Country as Country,
    cm.FirstName as [First Name],
    l.CountryCode as [CountryCode]


FROM ENT.[CampaignMember_Salesforce] cm
INNER JOIN ENT.[Lead_Salesforce] l ON cm.LeadOrContactId = l.Id

WHERE 
    cm.CampaignId ='701Mp00000bsboTIAQ' AND
    NOT EXISTS 
        (SELECT Id 
         FROM   ENT.[CampaignMember_Salesforce] excl 
         WHERE  excl.LeadOrContactId = cm.LeadOrContactId AND excl.CampaignId='701Mp00000bXqk6IAC' )

    
    
    

    
