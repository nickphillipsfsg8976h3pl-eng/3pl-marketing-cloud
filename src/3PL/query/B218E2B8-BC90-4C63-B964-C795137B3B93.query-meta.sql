SELECT 
 SubmissionId,
 IsProcessed,
 LeadIdCreated,
 LeadIdUpdated
FROM [001_Lead_Procesing_Queue_CRM_LAST_3DAYS]
WHERE
 IsProcessed      = 1
