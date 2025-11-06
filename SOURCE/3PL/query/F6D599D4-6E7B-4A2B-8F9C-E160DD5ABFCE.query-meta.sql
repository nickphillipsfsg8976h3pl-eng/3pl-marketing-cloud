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
   
FROM [MX Marketing prospects - last 24 months] cws

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
   
FROM [MX lost leads - July 2023 - June 2024] cws

