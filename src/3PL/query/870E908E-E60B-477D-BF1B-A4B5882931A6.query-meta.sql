SELECT 
 SubmissionId,
 IsProcessed,
 LeadIdCreated,
 LeadIdUpdated
FROM [MASTER_Ledger_CRM_Ready_Queue_UnProcessed_REQUEUE]
WHERE
 IsProcessed      = 1
