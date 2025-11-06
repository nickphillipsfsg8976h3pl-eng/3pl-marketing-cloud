
SELECT
stg.FirstName, 
stg.Email, 
stg.[Job Title], 
stg.[Account Name], 
stg.Email as [ContactID]
FROM [EMEA_MXNBH2Emails_Source] stg
WHERE NOT EXISTS (SELECT a.Email FROM [EMEA_MXNBH2Emails] a where a.[email]= stg.[email])