SELECT
    cs.SubscriberKey,
    cs.Email_Status,
    cs.Subscriber_Type,
    cs.receive_re_emails,
    cs.IsMstUser,
    cs.IsValidEmailSyntax,
    cs.HasChannelAddress,
    cs.activated_at,
    cs.created_at,
    cs.emailable_status,
    1 AS IsConvertedLead
FROM
    ENT.Contact_Summary cs INNER JOIN
    ENT.Lead_Salesforce l
        ON  cs.SubscriberKey = l.Id
WHERE
    cs.Subscriber_Type = 'Salesforce Lead' AND
    l._ContactKey LIKE ('003_______________')