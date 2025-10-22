SELECT
    a.*
FROM [MASTER_Ledger_CRM_Ready_Queue_UnProcessed] a
LEFT JOIN [MASTER_Ledger_CRM_Ready_Queue_Processed] c
  ON a.SubmissionID = c.SubmissionID
WHERE 
c.SubmissionId IS NULL