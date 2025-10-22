SELECT cws.ContactKey,
    cws.SubscriptionProduct,
    cws.SubscriptionEndDate,
   
    cws.ContactFirstName as [FirstName],
    cws.ContactLastName as [LastName],
    cws.ContactEmail as [Email],
    
    cws.ContactRoles,
    cws.AccountId,
    cws.AccountName,
    cws.ActiveFullSubscriptions,
    cws.AccountBillingCountry as [Country],
    cws.AccountBillingState as [State],
   

    cws.SubscriptionStatus
    FROM (
    SELECT
        cws1.*,
        ROW_NUMBER() OVER(PARTITION BY cws1.ContactEmail ORDER BY cws1.SubscriptionStartDate DESC) AS rn
    FROM
        ContactsWithSubscriptions_V1 cws1
    WHERE
    cws1.SubscriptionProduct LIKE '%WordFlyers%' AND
    cws1.ContactRoles LIKE '%Subscription Coordinator%' AND
    cws1.SubscriptionRecordType IN ('Full','Extension') AND
    cws1.SubscriptionStatus = 'Active' AND
    cws1.HasOptedOutOfEmail = 0 AND
    cws1.SubscriptionStartDate < GETDATE() AND
    cws1.SubscriptionEndDate > GETDATE()
) AS cws
INNER JOIN
    ENT.Contact_Salesforce c
        ON  cws.ContactKey = c.Id
INNER JOIN
    ENT.Account_Salesforce a
        ON  cws.AccountId = a.Id
WHERE      
(c.Is_Active__c    = 'true' OR
c.Status__c       != 'Inactive' OR
c.HasOptedOutOfEmail = 0) AND
c.Email is not null AND
rn = 1 

