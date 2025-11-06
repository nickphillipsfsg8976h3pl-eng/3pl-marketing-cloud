SELECT
ContactKey,
bpw.AccountId,
[AccountName],
[Renewal Close Date],
Email,
FirstName,
LastName,
AccountSite,
a.BillingState as BILLINGSTATE,
[Renewal Link],
[Renewal Product]

FROM APAC_BPW_RO_FEB_20240215_RENEWED bpw
JOIN ENT.Account_Salesforce a
        ON  bpw.AccountID = a.Id
JOIN _open o on bpw.ContactKey = o.SubscriberKey
WHERE a.BillingState='Western Australia' AND
o.JobID ='1142306' AND
o.IsUnique = 1
UNION
SELECT
ContactKey,
bpw.AccountId,
[AccountName],
[Renewal Close Date],
Email,
FirstName,
LastName,
AccountSite,
a.BillingState as BILLINGSTATE,
[Renewal Link],
[Renewal Product]

FROM APAC_BPM_RO_FEB_20240215_RENEWED bpw
JOIN ENT.Account_Salesforce a
        ON  bpw.AccountID = a.Id
JOIN _open o on bpw.ContactKey = o.SubscriberKey
WHERE a.BillingState='Western Australia' AND
o.JobID ='1142306' AND
o.IsUnique = 1