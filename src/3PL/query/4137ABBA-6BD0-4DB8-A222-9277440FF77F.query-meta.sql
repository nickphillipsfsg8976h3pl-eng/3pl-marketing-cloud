SELECT
   cws.LeadKey as ContactKey,
   cws.JobTitle as ContactTitle,
   cws.FirstName as [First Name],
   cws.Email as ContactEmail,
   cws.LeadJobFunction as ContactJobFunction,
   cws.Territory as ContactTerritory,
   cws.Country as AccountBillingCountry,
   cws.CountryCode as AccountBillingCountryCode,
   cws.StateCode as AccountBillingStateCode,
   'Mathseeds' as ProductName
   
FROM [APAC MS Marketing prospects - Jan 2022 - Present] cws

UNION

SELECT
   cws.LeadKey as ContactKey,
   cws.JobTitle as ContactTitle,
   cws.FirstName as [First Name],
   cws.Email as ContactEmail,
   cws.LeadJobFunction as ContactJobFunction,
   cws.Territory as ContactTerritory,
   cws.Country as AccountBillingCountry,
   cws.CountryCode as AccountBillingCountryCode,
   cws.StateCode as AccountBillingStateCode,
   'Mathseeds' as ProductName
   
FROM [APAC MS Lost leads Last 3Years] cws