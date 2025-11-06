SELECT
stg.FirstName, 
stg.Email, 
stg.[Job Title], 
stg.[Account Name], 
contact.Id as [ContactID]
FROM [EMEA_MXNBH2Emails_Source] stg
INNER JOIN ENT.[Contact_Salesforce] contact ON stg.[email]=contact.[Email] 
WHERE stg.FirstName = contact.FirstName
