SELECT 
    cws.[Contact ID] ,
    cws.Title,
    cws.[First Name] ,
    cws.[Last Name] ,
    cws.EMAIL,
    cws.Status,
    cws.State,
    cws.Country
FROM (
    SELECT 
        [Contact ID],
        Title,
        [First Name],
        [Last Name],
        EMAIL,
        Status,
        State,
        Country,
        ROW_NUMBER() OVER (PARTITION BY EMAIL ORDER BY [Contact ID]) AS RowNum
    FROM [APAC_MX0067_WMD2025_J1_COLD_PROSPECTS]
) AS cws
WHERE cws.RowNum = 1
