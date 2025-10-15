SELECT
    cws.ContactKey,
    cws.ContactTitle,
    cws.[First Name],
    cws.ContactEmail,
    cws.ContactJobFunction,
    cws.ContactTerritory,
    cws.AccountBillingCountry,
    cws.AccountBillingCountryCode,
    cws.AccountBillingStateCode,
    'Mathletics' as ProductName
    
FROM [APAC MX Lost customers Last 3Years greater than 3M] cws

UNION

SELECT
    cws.ContactKey,
    cws.ContactTitle,
    cws.[First Name],
    cws.ContactEmail,
    cws.ContactJobFunction,
    cws.ContactTerritory,
    cws.AccountBillingCountry,
    cws.AccountBillingCountryCode,
    cws.AccountBillingStateCode,
    'Mathletics' as ProductName
    
FROM [APAC MX Lost trialists Last 3Years] cws

