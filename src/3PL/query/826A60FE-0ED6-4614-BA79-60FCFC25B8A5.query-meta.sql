SELECT
   buUnsub.SubscriberKey 
    , s.EmailAddress AS [Email Address]
   
FROM _BusinessUnitUnsubscribes AS buUnsub
JOIN ent._Subscribers s ON buUnsub.SubscriberKey=s.SubscriberKey

UNION

SELECT c.Email AS [Email Address],
       c.Id AS [SubscriberKey]
FROM ENT.Contact_Salesforce c
WHERE 
(c.Is_Active__c    = 'false' OR
c.Status__c       = 'Inactive' OR
c.HasOptedOutOfEmail = 1) AND
c.Email is not null