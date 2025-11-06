SELECT

cws.LeadOrContactId as ContactKey,
cws.FirstName as [ContactFirstName],
cws.Email as Email,
cws.CampaignId as CampaignId,
cws.Id as CampaignMemberId,
cws.Country as [CampaignMember:Lead:Country],
Lead.CountryCode as [CampaignMember:Lead:CountryCode],
cws.Title as ContactTitle,
Lead.Create_Sandbox__c,
Lead.Product_Code__c,
Lead.Company as [School Name],
Lead.School__c as [3P School],
cmp.Region,
Lead.Existing_Customer__c as [ExistingCustomer]

FROM ENT.[CampaignMember_Salesforce] cws
INNER JOIN ENT.[Lead_Salesforce] lead ON lead.id = cws.LeadOrContactId
INNER JOIN Country_Region_Mapping cmp ON cmp.Country= cws.Country 

WHERE 

cmp.Region = 'EMEA' AND
cws.CampaignId ='701Mp00000V66grIAB' AND
(cws.Title NOT IN ('Student','Parent','Other','Home schooling parent') OR cws.Title IS NULL)