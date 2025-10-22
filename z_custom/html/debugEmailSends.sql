SELECT
    s.SubscriberKey AS SubscriberKey,
    sub.EmailAddress AS EmailAddress,
    sub.Status AS SubscriptionStatus,
    j.JourneyName AS JourneyName,
    j.VersionNumber AS JourneyVersion,
    job.EmailName AS EmailName,
    s.EventDate AS SentDate,
    job.DeliveredTime AS DeliveryDate,
    o.EventDate AS OpenDate,
    c.EventDate AS ClickDate,
    b.EventDate AS BounceDate,
    b.BounceCategory AS BounceCategory,
    b.BounceSubcategory AS BounceSubcategory,
    b.SMTPBounceReason AS BounceReason,
    u.EventDate AS UnsubscribeDate
FROM
    _Sent AS s
    LEFT JOIN _Job AS job ON job.JobID = s.JobID
    LEFT JOIN _Open AS o ON o.JobID = s.JobID
    AND o.ListID = s.ListID
    AND o.BatchID = s.BatchID
    AND o.SubscriberID = s.SubscriberID
    AND o.IsUnique = 1
    LEFT JOIN _Click AS c ON s.JobID = c.JobID
    AND c.ListID = s.ListID
    AND c.BatchID = s.BatchID
    AND c.SubscriberID = s.SubscriberID
    AND c.IsUnique = 1
    LEFT JOIN _Bounce AS b ON s.JobID = b.JobID
    AND b.ListID = s.ListID
    AND b.BatchID = s.BatchID
    AND b.SubscriberID = s.SubscriberID
    AND b.IsUnique = 1
    LEFT JOIN _Unsubscribe AS u ON s.JobID = u.JobID
    AND u.ListID = s.ListID
    AND u.BatchID = s.BatchID
    AND u.SubscriberID = s.SubscriberID
    AND u.IsUnique = 1
    LEFT JOIN _JourneyActivity AS ja ON ja.JourneyActivityObjectID = s.TriggererSendDefinitionObjectID
    LEFT JOIN _Journey AS j ON j.VersionID = ja.VersionID
    LEFT JOIN _Subscribers AS sub ON sub.SubscriberKey = s.SubscriberKey
WHERE
    s.EventDate >= DATEADD (DAY, -1, GETDATE ())