SELECT * FROM [APAC_B2B_RE_Full&Ext_ACTIVE_Subscribers] WHERE AccountBillingCountryCode = 'NZ'
AND ActiveFullSubscriptions NOT LIKE '%Mathletics%'
UNION 
SELECT * FROM [APAC_B2B_MS_Full&Ext_ACTIVE_Subscribers] WHERE AccountBillingCountryCode = 'NZ'
AND ActiveFullSubscriptions NOT LIKE '%Mathletics%'