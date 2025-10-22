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
    'ReadingEggs' as ProductName
    
FROM [APAC RE Lost customers Last 3Years greater than 3M] cws

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
    'ReadingEggs' as ProductName
    
FROM [APAC RE Lost trialists Last 3Years] cws

