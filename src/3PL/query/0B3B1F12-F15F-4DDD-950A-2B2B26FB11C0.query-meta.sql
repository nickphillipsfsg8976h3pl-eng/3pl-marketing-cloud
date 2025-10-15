SELECT
	lead.Id as [Contact ID],
    LEFT(lead.FirstName,40) AS [First Name],
    LEFT(lead.LastName,80) AS [Last Name],
    LEFT(lead.Email,254) AS Email,

    LEFT(lead.Title,126) AS Title,
    lead.State,
    lead.Country AS Country,
    'Marketing Prospect' as Status
FROM
    ENT.Lead_Salesforce lead LEFT JOIN  
    ENT.User_Salesforce own  ON lead.OwnerId = own.Id 
WHERE
	lead.OwnerId != '00G2y000000YaqF' AND                     /*Parent Lead Queue ID*/
	lead.Product_Interest__c LIKE '%Mathletics%' AND
	lead.IsConverted = 0 AND
	lead.HasOptedOutOfEmail = 0 AND
	lead.Email is NOT NULL AND
	lead.FirstName is NOT NULL AND
	lead.CountryCode IN ('AU','NZ','ZA') AND
	(lead.Title NOT LIKE '%Parent%' AND lead.Title NOT LIKE '%Student%')
	AND NOT EXISTS (Select c.Email from Contacts_With_Open_Opportunities c Where c.Email=lead.Email )

