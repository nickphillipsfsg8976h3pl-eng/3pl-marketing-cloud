SELECT 
    c.ContactEmail,
    COUNT(c.ContactEmail) AS EmailCount
FROM 
    [APAC_B2B_RE_Full&Ext_ACTIVE_Subscribers] c
GROUP BY 
    c.ContactEmail
HAVING 
    COUNT(c.ContactEmail) > 1