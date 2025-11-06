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
   'Mathletics' as ProductName
   
FROM [APAC MX Marketing prospects - Jan 2022 - Present] cws

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
   'Mathletics' as ProductName
   
FROM [APAC MX Lost leads Last 3Years] cws