SELECT
      ContactID_18__c,
      FirstName,
      MailingCountry,
      Email,
      COUNT(Email) AS EmailCount
FROM [B2C_MX0001-Lapsed-Purchases]
GROUP BY FirstName, MailingCountry, Email, ContactID_18__c
HAVING COUNT(Email) > 1