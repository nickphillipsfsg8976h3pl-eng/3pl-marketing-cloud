select 
      ContactID_18__c,
      FirstName,
      MailingCountry,
      Email
    , COUNT(Email) AS EmailCount
From B2C_parentData AS p
JOIN GLOBAL_B2C_LapsedTRIALISTS AS t
ON p.ContactID_18__c = t.chargebeeapps__CustomerID__c
GROUP BY Email, ContactID_18__c, FirstName, MailingCountry
HAVING COUNT(Email) > 1