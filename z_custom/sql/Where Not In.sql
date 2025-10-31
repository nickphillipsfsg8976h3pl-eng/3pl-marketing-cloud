SELECT
    ContactEmail
FROM
    AMER_MX_Leads_MarketingProspects_DEDUP
WHERE
    ContactEmail NOT IN (
        SELECT
            ContactEmail
        FROM
            ContactsWithSubscriptions_v1
    )