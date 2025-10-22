## A6DC87CF-8ABB-4A4F-8F8A-9C7F0AFADBF0

**Name** (not equal to External Key)**:** MXBU reset test 2 - 2019-01-22T2315244981651297796952

**Description:** n/a

**Folder:** Data Extensions/02_B2C/

**Fields in table:** 5

**Sendable:** Yes (`CampaignMember:Common:Id` to `Subscriber Key`)

**Testable:** No

**Retention Policy:** none

| Name | FieldType | MaxLength | IsPrimaryKey | IsNullable | DefaultValue |
| --- | --- | --- | --- | --- | --- |
| CampaignMember:Id | Text | 18 | - | - |  |
| CampaignMember:Common:Id | Text | 256 | - | - |  |
| CampaignMember:Common:Email | EmailAddress | 80 | - | + |  |
| CampaignMember:Common:HasOptedOutOfEmail | Boolean |  | - | + | False |
| MemberRecordType | Text | 20 | - | - |  |
