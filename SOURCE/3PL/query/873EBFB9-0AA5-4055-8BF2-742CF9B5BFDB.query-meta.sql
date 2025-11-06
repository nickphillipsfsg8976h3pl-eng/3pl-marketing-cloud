SELECT DISTINCT
      C._ContactKey as ContactID
    , C.Email as Email
    , C.FirstName
    , roll.Account__c
    , roll.Type__c
    , Acc.CurrencyIsoCode
    , roll.Product__c as product
    , roll.	Rollover_Date__c AS RollOverDate
FROM Ent.School_Rollover__c_Salesforce AS roll
    JOIN Ent.Contact_Salesforce AS C
        ON C.AccountId = roll.Account__c
    left JOIN Ent.Account_Salesforce AS Acc
        ON Acc.Id = C.AccountId
WHERE (roll.Type__c = 'Manual' OR roll.Type__c = 'Full')
AND (roll.Product__c = 'Mathletics')
AND (Active_Class__c = 'True')
AND (Acc.CurrencyIsoCode = 'AUD' OR Acc.CurrencyIsoCode = 'NZD' OR Acc.CurrencyIsoCode = 'ZAR')
          