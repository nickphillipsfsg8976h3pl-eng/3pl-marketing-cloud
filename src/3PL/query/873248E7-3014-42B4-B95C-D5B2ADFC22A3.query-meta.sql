SELECT 
    [Contact ID 18], 
    firstname, 
    lastname, 
    email, 
    teacher_crmid, 
    schoolname, 
    licence_type, 
    class_year_levels, 
    salesforce_id, 
    account_manager_full_name,
    Country,
    Province
FROM [ML_CAN_w_o_AB] stg
WHERE
Province LIKE '%Ontario%'