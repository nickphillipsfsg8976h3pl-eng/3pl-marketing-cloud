SELECT *
FROM (
    SELECT 
        *,
        ROW_NUMBER() OVER (PARTITION BY ContactEmail ORDER BY ContactEmail) AS RowNum
    FROM [APAC_MX_NB_Campaign_AU_NZ]
) AS ranked
WHERE RowNum = 1
