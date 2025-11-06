SELECT
      buUnsub.BusinessUnitID
    , buUnsub.SubscriberID
    , buUnsub.SubscriberKey
    , s.EmailAddress
    , buUnsub.UnsubDateUTC
    , buUnsub.UnsubReason
FROM _BusinessUnitUnsubscribes AS buUnsub
JOIN ent._Subscribers s ON buUnsub.SubscriberKey=s.SubscriberKey