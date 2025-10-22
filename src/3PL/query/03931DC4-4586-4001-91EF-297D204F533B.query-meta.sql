SELECT
    x.SubscriberKey,
    x.EmailAddress,
    x.MobilePhone,
    x.SubscriberType,
    x.ContactSynced,
    x.LeadSynced,
    x.UserSynced,
    x.SubscriberSynced,
    x.SubscriberStatus,
    x.EmailDateUnsubscribed,
    CASE
        WHEN x.HasOptedOutOfMobile = 1
        THEN CONVERT(DATE,'1900-01-01')
    END AS SMSDateUnsubscribed,
    x.HasOptedOutOfEmail,
    x.HasOptedOutOfMobile,
    CASE
        WHEN
            (
                COALESCE(x.EmailAddress,'') NOT LIKE ('%@%.%') OR
                x.SubscriberStatus IN ('held','unsubscribed') OR
                x.HasOptedOutOfEmail = 1
            ) AND (
                x.MobilePhone IS NULL
            )
        THEN 1
        ELSE 0
    END AS Uncontactable,
    CASE
        WHEN
            x.SubscriberType LIKE ('Salesforce %') AND
            x.ContactSynced = 0 AND
            x.LeadSynced = 0 AND
            x.UserSynced = 0
        THEN 1
        ELSE 0
    END AS Orphaned,
    x.CreatedDate,
    x.DeadLead,
    x.AncientLead
FROM
    (
    SELECT 
        ac.SubscriberKey,
        COALESCE(COALESCE(COALESCE(s.EmailAddress,c.Email),l.Email),u.Email) AS EmailAddress,
        CASE
        		WHEN REPLACE(REPLACE(REPLACE(COALESCE(c.MobilePhone,l.MobilePhone),'+',''),' ',''),'-','') LIKE ('614[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]')
        		THEN REPLACE(REPLACE(REPLACE(COALESCE(c.MobilePhone,l.MobilePhone),'+',''),' ',''),'-','')
        		WHEN REPLACE(REPLACE(REPLACE(COALESCE(c.MobilePhone,l.MobilePhone),'+',''),' ',''),'-','') LIKE ('04[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]')
        		THEN '61' + SUBSTRING(REPLACE(REPLACE(REPLACE(COALESCE(c.MobilePhone,l.MobilePhone),'+',''),' ',''),'-',''),2,9)
        		ELSE COALESCE(c.MobilePhone,l.MobilePhone)
        END AS MobilePhone,
        CASE
            WHEN ac.SubscriberKey LIKE '003_______________' THEN 'Salesforce Contact'
            WHEN ac.SubscriberKey LIKE '00Q_______________' THEN 'Salesforce Lead'
            WHEN ac.SubscriberKey LIKE '005_______________' THEN 'Salesforce User'
            WHEN ac.SubscriberKey LIKE '%@%.%' THEN 'Email Contact'
            ELSE 'Other'
        END AS SubscriberType,
        CASE
            WHEN c._ContactKey IS NOT NULL
            THEN 1
            ELSE 0
        END AS ContactSynced,
        CASE
            WHEN l._ContactKey IS NOT NULL
            THEN 1
            ELSE 0
        END AS LeadSynced,
        CASE
            WHEN u._ContactKey IS NOT NULL
            THEN 1
            ELSE 0
        END AS UserSynced,
        CASE
            WHEN s.SubscriberKey IS NOT NULL
            THEN 1
            ELSE 0
        END AS SubscriberSynced,
        CASE
            WHEN s.DateUnsubscribed IS NOT NULL
            THEN s.DateUnsubscribed
            WHEN COALESCE(c.HasOptedOutOfEmail,l.HasOptedOutOfEmail) = 1
            THEN CONVERT(DATE,'1900-01-01')
        END AS EmailDateUnsubscribed,
        CASE
            WHEN COALESCE(c.HasOptedOutOfEmail,l.HasOptedOutOfEmail) = 1
            THEN 'unsubscribed'
            ELSE s.Status
        END AS SubscriberStatus,
        COALESCE(c.HasOptedOutOfEmail,l.HasOptedOutOfEmail) AS HasOptedOutOfEmail,
        COALESCE(c.et4ae5__HasOptedOutOfMobile__c,l.et4ae5__HasOptedOutOfMobile__c) AS HasOptedOutOfMobile,
        COALESCE(COALESCE(l.CreatedDate,c.CreatedDate),s.DateJoined) AS CreatedDate,
        CASE
            WHEN
                ac.SubscriberKey LIKE '00Q_______________' AND
                l.Status IN ('Closed - Lost','Lost')
            THEN 1
            ELSE 0
        END AS DeadLead,
        CASE
            WHEN
                ac.SubscriberKey LIKE '00Q_______________' AND
                DATEDIFF(month,l.CreatedDate,GETDATE()) > 11
            THEN 1
            ELSE 0
        END AS AncientLead
    FROM
        AllContacts ac LEFT JOIN
        ENT.Contact_Salesforce c
            ON  ac.SubscriberKey = c._ContactKey LEFT JOIN
        ENT.Lead_Salesforce l
            ON  ac.SubscriberKey = l._ContactKey LEFT JOIN
        ENT.User_Salesforce u
            ON  ac.SubscriberKey = u._ContactKey LEFT JOIN
        _Subscribers s
            ON  ac.SubscriberKey = s.SubscriberKey
    WHERE
        ac.SubscriberKey LIKE ('003_______________') OR
        ac.SubscriberKey LIKE ('00Q_______________') OR
        ac.SubscriberKey LIKE ('005_______________')
    ) AS x