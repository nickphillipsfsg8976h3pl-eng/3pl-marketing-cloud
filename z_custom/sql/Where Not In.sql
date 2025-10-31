SELECT
    *
FROM
    Data_Extension_With_Email_Example l
WHERE
    NOT EXISTS (
        SELECT
            1
        FROM
            ContactsWithSubscriptions_v1 c
        WHERE
            l.Email = c.ContactEmail
    )