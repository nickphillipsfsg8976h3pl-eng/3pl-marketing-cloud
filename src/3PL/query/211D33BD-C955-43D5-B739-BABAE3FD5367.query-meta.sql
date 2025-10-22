SELECT 
    contact.id as [Contact ID 18], 
    contact.firstname as [first name], 
    contact.email as [email address]
FROM [APAC_RE_MS_EXISTING_CUSTOMERS_DO_NOT_USE] stg
INNER JOIN ENT.[Contact_Salesforce] contact ON stg.[email address]=contact.[Email]
WHERE contact.HasOptedOutOfEmail = 0