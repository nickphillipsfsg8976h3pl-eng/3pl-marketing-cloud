SELECT
    cs.*,
    CASE
        WHEN cs.DeadLead = 1 THEN 'Dead Lead'
        WHEN cs.Orphaned = 1 THEN 'Unsynchronised' + cs.SubscriberType
        WHEN cs.Uncontactable = 1 THEN
            CASE
                WHEN cs.SubscriberStatus = 'Unsubscribed' THEN 'Unsubscribed from Email'
                WHEN cs.SubscriberStatus = 'Held' THEN 'Bounced Email Address'
                WHEN cs.SMSDateUnsubscribed IS NOT NULL THEN 'Unsubscribed from SMS'
                ELSE 'Uncontactable ' + cs.SubscriberType
            END
        WHEN cs.DuplicateSubscriber = 1 THEN 'Duplicate Subscriber'
    END AS Reason
FROM
    ContactSummary cs
WHERE
    cs.DeadLead = 1 OR
    cs.Uncontactable = 1 OR
    cs.Orphaned = 1 OR
    cs.SubscriberStatus = 'Unsubscribed' OR
    cs.SubscriberStatus = 'Held'