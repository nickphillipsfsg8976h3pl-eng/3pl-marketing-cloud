SELECT 
    contact.id as [Contact ID 18], 
    contact.firstname, 
    contact.lastname, 
    contact.email as [Teacher Email], 
    [Teacher ID],
    [Teacher Name],
    [School Code],
    [School Name],
    [School Country],
    [Clever Managed],
    [Account Manager],
    [Last MS Rollover At],
    contact.BillingCountryCode__c as Country
FROM [MS_CAN_STAGING] stg
INNER JOIN ENT.[Contact_Salesforce] contact ON stg.[Teacher Email]=contact.[Email]
WHERE contact.HasOptedOutOfEmail = 0 AND
contact.email not LIKE '%@ecsd.net%'