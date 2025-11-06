SELECT data.*
FROM
(
    SELECT
    ROW_NUMBER() OVER (
        PARTITION BY
            Email
        ORDER BY
            Email DESC
    ) AS Row#,
    *
FROM
    Data_Extension_Name
    ) data
WHERE
    Row# = 1
