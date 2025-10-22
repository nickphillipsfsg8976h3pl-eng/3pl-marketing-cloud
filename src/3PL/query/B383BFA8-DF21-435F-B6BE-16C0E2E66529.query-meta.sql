SELECT 
    v.VoucherID,
    v.VoucherURL,
    CASE 
        WHEN av.VoucherID IS NOT NULL THEN 'true'
        ELSE v.IsAssigned
    END AS IsAssigned
FROM [VoucherDE] v
LEFT JOIN [AssignedVouchersDE] av 
    ON v.VoucherID = av.VoucherID
