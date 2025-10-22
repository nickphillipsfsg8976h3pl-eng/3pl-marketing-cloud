SELECT *
FROM (
    SELECT 
        *,
        ROW_NUMBER() OVER (
            PARTITION BY ContactEmail 
            ORDER BY ContactEmail DESC
        ) AS RowNum
    FROM 
        APAC_3P0073_EdChatCampaign_AU_NZ_CombinedAudience_Deduped
) AS Ranked
WHERE RowNum = 1
