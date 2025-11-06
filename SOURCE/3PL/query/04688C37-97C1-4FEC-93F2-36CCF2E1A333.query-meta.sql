SELECT
   cws.LeadKey as ContactKey,
   cws.JobTitle as ContactTitle,
   cws.FirstName as [First Name],
   cws.Email as ContactEmail,
   cws.LeadJobFunction as ContactJobFunction,
   cws.Territory as ContactTerritory,
   cws.Country as AccountBillingCountry,
   cws.CountryCode as AccountBillingCountryCode,
   cws.StateCode as AccountBillingStateCode
   
FROM [MX Marketing prospects - Jan 2022 - Present] cws

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
   cws.StateCode as AccountBillingStateCode
   
FROM [MX lost leads - Jan 2022 - Jan 2025] cws

