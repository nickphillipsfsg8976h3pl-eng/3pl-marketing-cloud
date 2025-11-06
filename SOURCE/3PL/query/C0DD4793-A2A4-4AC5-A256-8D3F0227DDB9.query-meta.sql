SELECT
   cws.Id as ContactKey,
   cws.Title as ContactTitle,
   cws.FirstName as [First Name],
   cws.Email as ContactEmail,
   cws.Job_Function__c as ContactJobFunction,
   cws.Territory__c as ContactTerritory,
   cws.Country as AccountBillingCountry,
   cws.CountryCode as AccountBillingCountryCode,
   cws.StateCode as AccountBillingStateCode,
   c.CampaignId
FROM
    ENT.Lead_Salesforce cws LEFT JOIN
    ENT.CampaignMember_Salesforce c ON c.LeadId = cws.Id
WHERE
	(cws.Status = 'Marketing Prospect' AND	
	cws.OwnerId != '00G2y000000YaqF' AND                     /*Parent Lead Queue ID*/
	cws.Product_Interest__c LIKE '%ReadingEggs%' AND
	cws.IsConverted = 0 AND
	cws.HasOptedOutOfEmail = 0 AND
	cws.Email is NOT NULL AND
	cws.CountryCode ='ZA' AND
	((cws.Title NOT LIKE '%Parent%' AND cws.Title NOT LIKE '%Student%') or (cws.Title ='' or cws.Title is null)) AND
	cws.createddate >=  DATEADD(month, -24, GETDATE())) OR
	c.CampaignId ='701Mp00000MIG6WIAX'

UNION

SELECT
    cws.Id as ContactKey,
    cws.Title as ContactTitle,
    cws.FirstName as [First Name],
    cws.Email as ContactEmail,
    cws.Job_Function__c as ContactJobFunction,
    cws.Territory__c as ContactTerritory,
    cws.MailingCountry as AccountBillingCountry,
    cws.MailingCountryCode as AccountBillingCountryCode,
    cws.MailingPostalCode as AccountBillingStateCode,
    c.CampaignId
FROM ENT.[Contact_Salesforce] cws INNER JOIN
     ENT.[CampaignMember_Salesforce] c ON c.ContactId = cws.Id
WHERE c.CampaignId ='701Mp00000MIG6WIAX'

