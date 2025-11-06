SELECT 
    contact.id as [Contact ID 18], 
    contact.firstname, 
    contact.lastname, 
    contact.email, 
    teacher_crmid, 
    schoolname, 
    licence_type, 
    class_year_levels, 
    salesforce_id, 
    account_manager_full_name,
    contact.BillingCountryCode__c as Country,
    PROVINCE as Province
FROM [ML_CAN_w_o_AB_STAGING] stg
INNER JOIN ENT.[Contact_Salesforce] contact ON stg.[email]=contact.[Email]
WHERE contact.HasOptedOutOfEmail = 0 AND
contact.email not LIKE '%@ecsd.net%'