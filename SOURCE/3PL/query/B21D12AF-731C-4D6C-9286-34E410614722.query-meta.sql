SELECT 
    cws.ContactKey as [Contact ID],
   
    cws.ContactTitle AS Title,
    cws.ContactFirstName AS [First Name],
    cws.ContactLastName AS [Last Name],
    cws.ContactEmail AS EMAIL,
    'Customer' as Status,
    cws.AccountBillingState AS State,
    cws.AccountBillingCountry AS Country
FROM [APAC_B2B_ALL_Full&Ext_ACTIVE_Subscribers] cws

WHERE     
    (cws.ActiveFullSubscriptions LIKE '%Mathletics%' OR cws.ActiveFullSubscriptions LIKE '%Mathseeds%' OR cws.ActiveFullSubscriptions LIKE '%Reading Eggs%')  AND
    cws.ContactTerritory = 'APAC' AND
    cws.SubscriptionTerritory = 'APAC' AND
    cws.AccountBillingCountryCode IN ('AU','NZ','ZA') 
